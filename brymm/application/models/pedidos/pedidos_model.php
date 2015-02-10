<?php

require_once APPPATH . '/libraries/pedidos/pedido.php';
require_once APPPATH . '/libraries/articulos/articuloCantidad.php';
require_once APPPATH . '/libraries/ingredientes/ingrediente.php';
require_once APPPATH . '/libraries/usuario/Direccion.php';
require_once APPPATH . '/libraries/articulos/tipoArticulo.php';

class Pedidos_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertPedido($pedido, $observaciones
			, $idDireccion, $idLocal
			, $precioTotal, $envioPedido, $fecha){
		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			//Se inserta la cabecera del pedido
			$sql = "INSERT INTO pedido (id_usuario,fecha,estado,precio,id_local
					,observaciones,id_direccion_envio,envio,fecha_alta)" .
					" VALUES (?,?,?,?,?,?,?,?,?)";

			$this->db->query($sql, array($_SESSION['idUsuario'], $fecha->format(DateTime::W3C), 'P'
					, $precioTotal, $idLocal, $observaciones
					, $idDireccion, $envioPedido, date('Y-m-d H:i:s')
			));

			$idPedido = $this->db->insert_id();


			//Se insertan los articulos del pedido
			$sql = "INSERT INTO det_pedido (id_pedido,id_articulo,precio_articulo" .
					",cantidad,id_tipo_articulo,personalizado)" .
					" VALUES (?,?,?,?,?,?)";

			foreach ($pedido as $lineaPedido) {
				$this->db->query($sql, array($idPedido, $lineaPedido['id'], $lineaPedido['price']
						, $lineaPedido['qty'], $lineaPedido['options']['idTipoArticulo'],
						$lineaPedido['options']['personalizado']));

				$idDetPedido = $this->db->insert_id();

				//Se inserta el detalle de los articulos personalizados
				if ($lineaPedido['options']['personalizado'] == 1) {

					$sqlDetArticulo = "INSERT INTO det_articulo_personalizado
							(id_det_pedido,id_ingrediente)" .
							" VALUES (?,?)";

					foreach ($lineaPedido['options']['ingredientes'] as $detalleArticulo) {
						$this->db->query($sqlDetArticulo, array($idDetPedido, $detalleArticulo['idIngrediente']));
					}
				}
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return -1;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return -1;
		}
		$this->db->trans_commit();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(1, $idLocal, $idPedido);

		return $idPedido;
	}

	function insertPedidoApi($idUsuario, $articulos
			, $observaciones, $idDireccion
			, $idLocal, $precioTotal, $envioPedido, $fecha) {
		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			//Se inserta la cabecera del pedido
			$sql = "INSERT INTO pedido (id_usuario,fecha,estado,precio,id_local
					,observaciones,id_direccion_envio,envio,fecha_alta)" .
					" VALUES (?,?,?,?,?,?,?,?,?)";

			$this->db->query($sql, array($idUsuario, $fecha->format(DateTime::W3C), 'P'
					, $precioTotal, $idLocal, $observaciones, $idDireccion, $envioPedido, date('Y-m-d H:i:s')));

			$idPedido = $this->db->insert_id();

			//Se insertan los articulos del pedido
			$sql = "INSERT INTO det_pedido (id_pedido,id_articulo,precio_articulo" .
					",cantidad,id_tipo_articulo,personalizado)" .
					" VALUES (?,?,?,?,?,?)";

			foreach ($articulos as $articulo) {
				$this->db->query($sql, array($idPedido, $articulo->getIdArticulo(), $articulo->getPrecioArticulo()
						, $articulo->getCantidad(), $articulo->getIdTipoArticulo(),
						$articulo->isPersonalizado()));

				$idDetPedido = $this->db->insert_id();

				//Se inserta el detalle de los articulos personalizados
				if ($articulo->isPersonalizado()) {

					$sqlDetArticulo = "INSERT INTO det_articulo_personalizado
							(id_det_pedido,id_ingrediente)" .
							" VALUES (?,?)";

					foreach ($articulo->getIngredientes() as $idIngrediente) {
						$this->db->query($sqlDetArticulo, array($idDetPedido, $idIngrediente));
					}
				}
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return -1;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return -1;
		}
		$this->db->trans_commit();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(1, $idLocal, $idPedido);

		return $idPedido;
	}

	public function obtenerPedido($idPedido) {

		//Se obtienen los datos del pedido
		$sqlPedido = "SELECT p.*,l.*,u.nick,u.nombre nombreUsuario
				FROM pedido p,locales l,usuarios u
				WHERE p.id_local = l.id_local
				AND p.id_usuario = u.id_usuario
				AND id_pedido = ?";

		$pedidoResult = $this->db->query($sqlPedido, array($idPedido))->row();

		if ($pedidoResult->estado == 'P') {
			$estadoPedido = "Pendiente";
			$idEstado = 'P';
		} elseif ($pedidoResult->estado == 'A') {
			$estadoPedido = "Aceptado";
			$idEstado = 'A';
		} elseif ($pedidoResult->estado == 'R') {
			$estadoPedido = "Rechazado";
			$idEstado = 'R';
		} elseif ($pedidoResult->estado == 'T') {
			$estadoPedido = "Terminado";
			$idEstado = 'T';
		}

		//Se carga el modelo de articulos
		$this->load->model('articulos/Articulos_model');

		$direccion = "";

		//Si se trata de un pedido con envio se obtiene la dirección
		if ($pedidoResult->envio == 1) {

			//Se obtiene la direccion de envio
			$this->load->model('usuarios/Usuarios_model');

			$direccion = $this->Usuarios_model->obtenerDireccionEnvio($pedidoResult->id_direccion_envio)->row();
		}

		//Se obtienen las lineas del pedido
		$detPedido = $this->obtenerDetallePedido($idPedido)->result();
		$i = 0;

		foreach ($detPedido as $lineaPedido) {
			$detalleArticulo = array();
			//Se obtiene el tipo de articulo
			$tipoArticulo =
			$this->Articulos_model->obtenerTipoArticulo($lineaPedido->id_tipo_articulo)->row();

			//Si es un articulo personalizado se obtiene el detalle
			if ($lineaPedido->personalizado == 1) {
				$nombreArticulo = "Articulo personalizado";
				$detalleArticuloPersonalizado =
				$this->obtenerDetalleArticuloPersonalizado($lineaPedido->id_det_pedido)->result();
				$j = 0;
				foreach ($detalleArticuloPersonalizado as $linea) {
					$detalleArticulo[$j] = array("ingrediente" => $linea->ingrediente,
							"idIngrediente" => $linea->id_ingrediente);
					$j += 1;
				}
			} else {
				$nombreArticulo = $lineaPedido->articulo;
				//Se obtiene el detalle del articulo
				$detArticulo =
				$this->Articulos_model->obtenerDetalleArticulo($lineaPedido->id_articulo_local)->result();
				$j = 0;
				foreach ($detArticulo as $linea) {
					$detalleArticulo[$j] = array("ingrediente" => $linea->ingrediente);
					$j += 1;
				}
			}

			$detallePedido[$i] = array("articulo" => $nombreArticulo,
					"precioArticulo" => $lineaPedido->precio_articulo,
					"cantidad" => $lineaPedido->cantidad,
					"tipoArticulo" => $tipoArticulo->tipo_articulo,
					"idTipoArticulo" => $tipoArticulo->id_tipo_articulo,
					"detalleArticulo" => $detalleArticulo,
					"idArticuloLocal" => $lineaPedido->id_articulo_local,
					"personalizado" => $lineaPedido->personalizado);
			unset($detalleArticulo);
			$i += 1;
		}
		$pedido = array(
				"idPedido" => $pedidoResult->id_pedido,
				"estado" => $estadoPedido,
				"idEstado" => $idEstado,
				"precio" => $pedidoResult->precio,
				"fechaPedido" => $pedidoResult->fecha,
				"envioPedido" => $pedidoResult->envio,
				"direccion" => $direccion,
				"observaciones" => $pedidoResult->observaciones,
				"detallePedido" => $detallePedido,
				"idLocal" => $pedidoResult->id_local,
				"nombreLocal" => $pedidoResult->nombre,
				"motivoRechazo" => $pedidoResult->motivo_rechazo,
				"fechaEntrega" => $pedidoResult->fecha_entrega,
				"idUsuario" => $pedidoResult->id_usuario,
				"nick" => $pedidoResult->nick,
				"nombreUsuario" => $pedidoResult->nombreUsuario
		);

		return $pedido;
	}

	public function obtenerPedidoObject($idPedido) {

		//Se obtienen los datos del pedido
		$sqlPedido = "SELECT p.*,l.*,u.nick,u.nombre nombreUsuario,
				u.apellido,u.email,u.localidad,u.provincia,u.cod_postal
				FROM pedido p,locales l,usuarios u
				WHERE p.id_local = l.id_local
				AND p.id_usuario = u.id_usuario
				AND id_pedido = ?";

		$pedidoResult = $this->db->query($sqlPedido, array($idPedido))->row();

		//Se carga el modelo de articulos
		$this->load->model('articulos/Articulos_model');

		$direccion = null;

		//Si se trata de un pedido con envio se obtiene la dirección
		if ($pedidoResult->envio == 1) {

			$direccion = Direccion::withID($pedidoResult->id_direccion_envio);
		}

		//Se obtienen las lineas del pedido
		$detPedido = $this->obtenerDetallePedido($idPedido)->result();
		$articulos = array();
		foreach ($detPedido as $lineaPedido) {
			$ingredientes = array();

			//Si es un articulo personalizado se obtiene el detalle
			if ($lineaPedido->personalizado == 1) {
				//Se da valor a los campos que no tienen valor en los articulos personalizados
				$nombreArticulo = "Articulo personalizado";
				$idArticulo = 0;
				$descripcion = $nombreArticulo;
				$validoPedidos = 0;
				
				$detalleArticuloPersonalizado =
				$this->obtenerDetalleArticuloPersonalizado($lineaPedido->id_det_pedido)->result();
				
				foreach ($detalleArticuloPersonalizado as $linea) {
					$ingredientes[] = new Ingrediente($linea->id_ingrediente
							,$linea->ingrediente
							,$linea->descripcion
							,$linea->precio);
				}
				
				
			} else {
				
				$nombreArticulo = $lineaPedido->articulo;
				$idArticulo = $lineaPedido->id_articulo_local;
				$descripcion = $lineaPedido->descripcion;
				$validoPedidos = $lineaPedido->valido_pedidos;
				
				//Se obtiene el detalle del articulo
				$detArticulo =
				$this->Articulos_model->obtenerDetalleArticulo($lineaPedido->id_articulo_local)->result();

				foreach ($detArticulo as $linea) {
					$ingredientes[] = new Ingrediente($linea->id_ingrediente
							,$linea->ingrediente
							,$linea->descripcion
							,$linea->precio);
				}
			}

			$idTipoArticuloLocal = $this->Articulos_model->obtenerTipoArticuloLocal3(
					$lineaPedido->id_tipo_articulo,
					$pedidoResult->id_local)->row()->id_tipo_articulo_local;

			$tipoArticulo = TipoArticuloLocal::withID($idTipoArticuloLocal);

			$articulos [] = new ArticuloCantidad($idArticulo,
					$tipoArticulo,
					$nombreArticulo,
					$descripcion,
					$lineaPedido->precio_articulo,
					$validoPedidos,
					$lineaPedido->cantidad,
					$ingredientes);

			unset($ingredientes);
		}
			
		$usuario = new Usuario(
				$pedidoResult->id_usuario,
				$pedidoResult->nick,
				$pedidoResult->nombreUsuario,
				$pedidoResult->apellido,
				$pedidoResult->email,
				$pedidoResult->localidad,
				$pedidoResult->provincia,
				$pedidoResult->cod_postal);

		$pedido = new Pedido(  $idPedido,
				$usuario,
				$pedidoResult->fecha,
				$pedidoResult->fecha_entrega,
				$pedidoResult->estado,
				$pedidoResult->precio,
				$pedidoResult->observaciones,
				$direccion,
				$pedidoResult->motivo_rechazo,
				$articulos);

		return $pedido;
	}

	private function obtenerDetallePedido($idPedido) {
		$sql = "SELECT dp.*,al.articulo,al.disponible,al.precio,al.descripcion,
				al.id_articulo_local, al.valido_pedidos
				FROM det_pedido dp left join articulos_local al
				ON (dp.id_articulo = al.id_articulo_local)
				WHERE id_pedido = ?
				ORDER BY id_tipo_articulo";

		$result = $this->db->query($sql, array($idPedido));

		return $result;
	}

	private function obtenerDetalleArticuloPersonalizado($idDetPedido) {
		$sql = "SELECT * FROM det_articulo_personalizado dap,ingredientes i
				WHERE dap.id_ingrediente = i.id_ingrediente
				AND id_det_pedido = ?";

		$result = $this->db->query($sql, array($idDetPedido));

		return $result;
	}

	function obtenerEstadoPedido($idPedido) {
		$sql = "SELECT * FROM pedido
				WHERE  id_pedido = ?";

		$result = $this->db->query($sql, array($idPedido));

		return $result;
	}

	function obtenerPedidosLocal($idLocal, $estado) {
		//Se obtienen los pedidos del local
		$sql = "SELECT * FROM pedido WHERE id_local = ?
				AND estado = ?
				AND fecha >= SYSDATE() - INTERVAL 7 DAY
				ORDER BY fecha";

		$pedidosLocal = $this->db->query($sql, array($idLocal, $estado));

		/* $pedidosLocal = array();

		foreach ($sqlPedidos as $pedido) {
		//Se obtiene el detalle de los pedidos del local
		$pedidosLocal [$i] = $this->obtenerPedido($pedido->id_pedido);
		$i++;
		} */

		return $pedidosLocal;
	}

	function obtenerPedidosLocalObject($idLocal, $estado) {
		//Se obtienen los pedidos del local
		$sql = "SELECT * FROM pedido WHERE id_local = ?
				AND estado = ?
				AND fecha >= SYSDATE() - INTERVAL 7 DAY
				ORDER BY fecha";

		$sqlPedidos = $this->db->query($sql, array($idLocal, $estado))->result();

		$pedidosLocal = array();

		foreach ($sqlPedidos as $linea) {
			//Se obtiene el detalle de los pedidos del local
			$pedidosLocal [] = $this->obtenerPedidoObject($linea->id_pedido);
		}

		return $pedidosLocal;
	}

	function actualizarEstadoPedido($idPedido, $estado, $fechaEntrega = ''
			, $motivo = '') {
		if ($fechaEntrega == '') {
			$sql = "UPDATE pedido SET estado = ?, motivo_rechazo = ?
					WHERE  id_pedido = ?";

			$this->db->query($sql, array($estado, $motivo, $idPedido));
		} else {
			$sql = "UPDATE pedido SET estado = ?,motivo_rechazo = ?
					, fecha_entrega = ?
					WHERE  id_pedido = ?";

			$this->db->query($sql, array($estado, $motivo,
					$fechaEntrega->format(DateTime::W3C), $idPedido));
		}

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se obtiene el usuario
		$idUsuario = $this->obtenerEstadoPedido($idPedido)->row()->id_usuario;

		if ($estado == 'A') {
			//Se inserta la alerta
			$this->Alertas_model->insertAlertaUsuario
			(5, $idUsuario, $idPedido);
		} else if ($estado == 'R') {
			//Se inserta la alerta
			$this->Alertas_model->insertAlertaUsuario
			(6, $idUsuario, $idPedido);
		} else if ($estado == 'T') {
			//Se inserta la alerta
			$this->Alertas_model->insertAlertaUsuario
			(7, $idUsuario, $idPedido);
		}
	}

	function obtenerUltimosPedidosUsuario($idUsuario,$numPedidos = 5) {
		//Se obtienen los pedidos del local
		$sql = "SELECT * FROM pedido WHERE id_usuario = ?
				ORDER BY id_pedido desc LIMIT 0,?";

		$sqlPedidos = $this->db->query($sql, array($idUsuario,$numPedidos))->result();

		$pedidosUsuario = array();

		foreach ($sqlPedidos as $pedido) {
			//Se obtiene el detalle de los pedidos del local
			$pedidosUsuario [] = $this->obtenerPedido($pedido->id_pedido);
		}

		return $pedidosUsuario;
	}

	//Función que añade un articulo al carro
	public function anadirArticuloCart($idArticuloLocal, $cantidad, $precio
			, $articulo, $idTipoArticulo, $idLocal) {

		$data = array(
				'id' => $idArticuloLocal,
				'qty' => $cantidad,
				'price' => $precio,
				'name' => $articulo,
				'options' => array('idTipoArticulo' => $idTipoArticulo,
						'personalizado' => 0,
						'idLocal' => $idLocal)
		);

		$this->my_cart->insert($data);
	}

	//Función que añade un articulo personalizado al carro
	public function anadirArticuloPersonalizadoCart($idArticuloPersonalizado
			, $cantidadArticuloPersonalizado, $precio, $datosTipoArticulo
			, $ingredientePedido, $idLocal) {

		$data = array(
				'id' => $idArticuloPersonalizado,
				'qty' => $cantidadArticuloPersonalizado,
				'price' => $precio,
				'name' => 'articulo personalizado',
				'options' => array('idTipoArticulo' => $datosTipoArticulo->id_tipo_articulo,
						'personalizado' => 1, 'tipoArticulo' => $datosTipoArticulo->tipo_articulo,
						'ingredientes' => $ingredientePedido,
						'idLocal' => $idLocal)
		);

		$this->my_cart->insert($data);
	}

	public function obtenerPedidosArticuloEstado($idLocal, $idArticulo, $estado) {
		$sql = "SELECT *  FROM pedido
				WHERE id_local = ?
				AND id_pedido IN
				(SELECT id_pedido
				FROM det_pedido
				WHERE id_articulo = ?)
				AND fecha > sysdate() - INTERVAL 1 DAY
				AND estado = ?";

		$result = $this->db->query($sql, array($idLocal, $idArticulo, $estado));
		return $result;
	}

}
