<?php

class Comandas_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	//Funcion que a�ade un articulo a la comanda
	public function anadirArticuloComanda($idArticuloLocal, $cantidad, $precio, $articulo, $idTipoArticulo) {

		//Se añade una aleatorio para no machacar los articulos ya insertados
		srand(time());
		$aleatorio = rand(1, 100000);

		//Se obtiene la descripcion del tipo de comanda
		$tipoComanda = $this->obtenerTipoComanda(1)->row()->tipo_comanda;

		$data = array(
				//'id' => $idArticuloLocal . "." . $aleatorio . ".1",
				'id' => $idArticuloLocal . "." . str_pad($aleatorio, 6, "0", STR_PAD_LEFT),
				'qty' => $cantidad,
				'price' => $precio,
				'name' => $articulo,
				'options' => array('idTipoArticulo' => $idTipoArticulo,
						'idTipoComanda' => 1,
						'tipoComanda' => $tipoComanda)
		);

		$this->my_cart->insert($data);
	}

	//Función que añade un articulo personalizado a la comanda
	public function anadirArticuloPerComanda($idArticuloPersonalizado, $cantidadArticuloPersonalizado
			, $precio, $datosTipoArticulo, $ingredientePedido) {
		//Se carga el modelo de usuarios
		//$this->load->library('cart');
		$this->load->library('my_cart');

		//Se obtiene la descripcion del tipo de comanda
		$tipoComanda = $this->obtenerTipoComanda(2)->row()->tipo_comanda;

		$data = array(
				'id' => $idArticuloPersonalizado,
				'qty' => $cantidadArticuloPersonalizado,
				'price' => $precio,
				'name' => 'articulo personalizado',
				'options' => array('idTipoArticulo' => $datosTipoArticulo->id_tipo_articulo,
						'personalizado' => 1, 'tipoArticulo' => $datosTipoArticulo->tipo_articulo,
						'idTipoComanda' => 2,
						'tipoComanda' => $tipoComanda,
						'ingredientes' => $ingredientePedido)
		);

		$this->my_cart->insert($data);
	}

	public function anadirMenuComanda($cantidad, $idTipoMenuLocal, $platos) {

		$this->load->model('menus/Menus_model');
		//Se obtiene el precio del menu
		$tipoMenuLocal = $this->Menus_model->obtenerTipoMenuLocal($idTipoMenuLocal)->row();

		//Se obtiene la descripcion del tipo de comanda
		$tipoComanda = $this->obtenerTipoComanda(3)->row()->tipo_comanda;

		//Se añade una aleatorio para no machacar los menus ya insertados
		srand(time());
		$aleatorio = rand(1, 100000);

		$data = array(
				//'id' => $idTipoMenuLocal . "." . $aleatorio . ".3",
				'id' => $idTipoMenuLocal . "." . str_pad($aleatorio, 6, "0", STR_PAD_LEFT),
				'qty' => $cantidad,
				'price' => $tipoMenuLocal->precio_menu,
				'name' => $tipoMenuLocal->nombre_menu,
				'options' => array(
						'platosMenu' => $platos,
						'idTipoComanda' => 3,
						'tipoComanda' => $tipoComanda,
						'anadirMenuIncompleto' => false)
		);

		$this->my_cart->insert($data);
	}

	public function anadirPlatoMenuComanda($cantidad, $idTipoMenuLocal, $plato) {

		$this->load->model('menus/Menus_model');
		//Se obtiene el precio del menu
		$tipoMenuLocal = $this->Menus_model->obtenerTipoMenuLocal($idTipoMenuLocal)->row();

		//Se obtiene la descripcion del tipo de comanda
		$tipoComanda = $this->obtenerTipoComanda(3)->row()->tipo_comanda;

		//Se añade una aleatorio para no machacar los menus ya insertados
		srand(time());
		$aleatorio = rand(1, 100000);

		$data = array(
				'id' => $idTipoMenuLocal . "." . str_pad($aleatorio, 6, "0", STR_PAD_LEFT),
				'qty' => $cantidad,
				'price' => 0,
				'name' => $tipoMenuLocal->nombre_menu,
				'options' => array(
						'platosMenu' => $plato,
						'idTipoComanda' => 3,
						'tipoComanda' => $tipoComanda,
						'anadirMenuIncompleto' => true)
		);

		$this->my_cart->insert($data);
	}

	public function anadirPlatoComanda($idPlatoLocal, $cantidad, $precio, $nombrePlato) {

		//Se carga el modelo de menus
		$this->load->model('menus/Menus_model');

		//Se obtiene el tipo de plato
		$idTipoPlato = $this->Menus_model->obtenerPlatoLocal($idPlatoLocal)
		->row()->id_tipo_plato;

		//Se obtiene la descripcion del tipo de plato
		$tipoPlato = $this->Menus_model->obtenerTipoPlato($idTipoPlato)
		->row()->descripcion;

		//Se obtiene la descripcion del tipo de comanda
		$tipoComanda = $this->obtenerTipoComanda(4)->row()->tipo_comanda;

		//Se añade una aleatorio para no machacar los menus ya insertados
		srand(time());
		$aleatorio = rand(1, 100000);

		$data = array(
				//'id' => $idPlatoLocal . "." . $aleatorio . ".4",
				'id' => $idPlatoLocal . "." . str_pad($aleatorio, 6, "0", STR_PAD_LEFT),
				'qty' => $cantidad,
				'price' => $precio,
				'name' => $nombrePlato,
				'options' => array(
						'idTipoPlato' => $idTipoPlato, //primero,segundo...
						'tipoPlato' => $tipoPlato,
						'idTipoComanda' => 4,
						'tipoComanda' => $tipoComanda)
		);

		$this->my_cart->insert($data);
	}

	public function obtenerTipoComanda($idTipoComanda) {
		$sql = "SELECT * FROM tipos_comanda
				WHERE id_tipo_comanda = ?";

		$result = $this->db->query($sql, array($idTipoComanda));

		return $result;
	}

	function obtenerTiposComandaObject() {
		//Se obtienen los tipos de menu
		$sql = "SELECT * FROM tipos_comanda tc
				ORDER BY id_tipo_comanda";

		$result = $this->db->query($sql)->result();

		$tiposComanda = array();

		foreach($result as $row){
			$tiposComanda[] = new TipoComanda($row->id_tipo_comanda,$row->tipo_comanda);
		}

		return $tiposComanda;
	}

	public function insertarComandaLocal($datosComanda, $idMesaLocal
			, $observaciones, $idLocal, $idCamarero, $precioComanda) {

		$transOk = true;

		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			//Se crea una nueva comanda
			//Se insertan los datos en la tabla comanda
			$sql = "INSERT INTO comanda (destino, observaciones, id_local
					, id_camarero, precio, id_mesa, estado, fecha_alta)
					VALUES (?,?,?,?,?,?,?,?)";

			$this->db->query($sql, array("mesa", $observaciones, $idLocal
					, $idCamarero, $precioComanda, $idMesaLocal, "EC", date('Y-m-d H:i:s')));

			$idComanda = $this->db->insert_id();


			foreach ($datosComanda as $lineaComanda) {

				/*
				 * Si se trata de un articulo personalizado se inserta
				* el idTipoArticulo en el campo id_articulo
				*/

				if ($lineaComanda['options']['idTipoComanda'] == 2) {
					$id = $lineaComanda['options']['idTipoArticulo'];
				} else {
					$id = strstr($lineaComanda['id'], '.', true);
				}

				//Se inserta el detalle de la comanda
				$idDetalleComanda =
				$this->insertarDetalleComanda($lineaComanda['options']['idTipoComanda']
						, $lineaComanda['qty'], $lineaComanda['price'], $idComanda
						, $id);

				/*
				 * Si el idDetalleComanda es menor que cero ha habido error
				* rollback y se sale con false
				*/

				if ($idDetalleComanda < 0) {
					//Se finaliza la transaccion
					$this->db->trans_complete();
					$this->db->trans_rollback();
					return false;
				}

				switch ($lineaComanda['options']['idTipoComanda']) {
					case 2:
						$insertOk = true;
						foreach ($lineaComanda['options']['ingredientes'] as $ingrediente) {
							//Se inserta el detalle del articulo personalizado
							$insertOk = $this->insertarComandaArticuloPer($idDetalleComanda
									, $ingrediente['idIngrediente']
									, $ingrediente['precioIngrediente']);

							if (!$insertOk) {
								$transOk = false;
							}
						}

						break;
					case 3:
						$insertOk = true;
						foreach ($lineaComanda['options']['platosMenu'] as $plato) {
							//Se inserta el detalle del articulo personalizado
							$insertOk = $this->insertarComandaMenu($idDetalleComanda
									, $plato['idPlatoLocal']
									, $plato['platoCantidad']);

							if (!$insertOk) {
								$transOk = false;
							}
						}

						break;
				}
			}
			//Se finaliza la transaccion
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return false;
		}

		if ($this->db->trans_status() === FALSE || !$transOk) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(4, $idLocal, $idComanda);

		return true;
	}

	public function insertarComandaLlevar($datosComanda, $aNombre, $observaciones
			, $idLocal, $idCamarero, $precioComanda) {

		$transOk = true;
		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			//Se crea una nueva comanda
			//Se insertan los datos en la tabla comanda
			$sql = "INSERT INTO comanda (destino, observaciones, id_local
					, id_camarero, precio, id_mesa, estado, fecha_alta)
					VALUES (?,?,?,?,?,?,?,?)";

			$this->db->query($sql, array($aNombre, $observaciones, $idLocal
					, $idCamarero, $precioComanda, 0, "EC", date('Y-m-d H:i:s')));

			$idComanda = $this->db->insert_id();


			foreach ($datosComanda as $lineaComanda) {

				/*
				 * Si se trata de un articulo personalizado se inserta
				* el idTipoArticulo en el campo id_articulo
				*/

				if ($lineaComanda['options']['idTipoComanda'] == 2) {
					$id = $lineaComanda['options']['idTipoArticulo'];
				} else {
					$id = strstr($lineaComanda['id'], '.', true);
				}

				//Se inserta el detalle de la comanda
				$idDetalleComanda =
				$this->insertarDetalleComanda($lineaComanda['options']['idTipoComanda']
						, $lineaComanda['qty'], $lineaComanda['price'], $idComanda
						, $id);

				/*
				 * Si el idDetalleComanda es menor que cero ha habido error
				* rollback y se sale con false
				*/

				if ($idDetalleComanda < 0) {
					//Se finaliza la transaccion
					$this->db->trans_complete();
					$this->db->trans_rollback();
					return false;
				}

				switch ($lineaComanda['options']['idTipoComanda']) {
					case 2:
						$insertOk = true;
						foreach ($lineaComanda['options']['ingredientes'] as $ingrediente) {
							//Se inserta el detalle del articulo personalizado
							$insertOk = $this->insertarComandaArticuloPer($idDetalleComanda
									, $ingrediente['idIngrediente']
									, $ingrediente['precioIngrediente']);

							if (!$insertOk) {
								$transOk = false;
							}
						}

						break;
					case 3:
						$insertOk = true;
						foreach ($lineaComanda['options']['platosMenu'] as $plato) {
							//Se inserta el detalle del articulo personalizado
							$insertOk = $this->insertarComandaMenu($idDetalleComanda
									, $plato['idPlatoLocal']
									, $plato['platoCantidad']);

							if (!$insertOk) {
								$transOk = false;
							}
						}

						break;
				}
			}
			//Se finaliza la transaccion
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return false;
		}

		if ($this->db->trans_status() === FALSE || !$transOk) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(4, $idLocal, $idComanda);

		return true;
	}

	private function insertarDetalleComanda($idTipoComanda, $cantidad, $precio, $idComanda, $id) {

		$this->db->trans_begin();
		//Se inserta el detalle de la comanda
		$sqlInsertDetalle = "INSERT INTO detalle_comanda (id_tipo_comanda, cantidad, precio,
				id_comanda, id_articulo, estado) VALUES (?,?,?,?,?,?)";

		$this->db->query($sqlInsertDetalle, array($idTipoComanda, $cantidad
				, $precio, $idComanda, $id, "EC"));

		$idDetalleComanda = $this->db->insert_id();

		//Se finaliza la transaccion
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return -1;
		}
		return $idDetalleComanda;
	}

	private function insertarComandaArticuloPer($idDetalleComanda
			, $idIngrediente, $precio) {
		//Se inicia la transaccion
		$this->db->trans_begin();
		$sql = "INSERT INTO comanda_articulo_per (id_detalle_comanda,
				id_ingrediente, precio)
				VALUES (?,?,?)";

		$this->db->query($sql, array($idDetalleComanda
				, $idIngrediente, $precio));

		//Se finaliza la transaccion
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
		return true;
	}

	private function insertarComandaMenu($idDetalleComanda
			, $idPlatoLocal, $cantidad) {
		//Se inicia la transaccion
		$this->db->trans_begin();
		$sql = "INSERT INTO comanda_menu (id_detalle_comanda,
				id_plato, cantidad, estado)
				VALUES (?,?,?,?)";

		$this->db->query($sql, array($idDetalleComanda
				, $idPlatoLocal, $cantidad, "EC"));

		//Se finaliza la transaccion
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
		return true;
	}

	function obtenerComandasEstadoDiferente($idLocal, $estado) {
		$sql = "SELECT c.*,ml.nombre_mesa nombreMesa, w.nombre nombreCamarero
				FROM comanda c LEFT JOIN mesas_local ml
				ON (c.id_mesa = ml.id_mesa_local),camareros w
				WHERE c.id_camarero = w.id_camarero
				AND c.id_local = ?
				AND estado <> ?
				AND estado <> ?
				ORDER BY c.fecha_alta ";

		$result = $this->db->query($sql, array($idLocal, $estado, 'CW'));

		return $result;
	}

	function obtenerComandasCerradas($idLocal) {
		$sql = "SELECT c.*,ml.nombre_mesa nombreMesa, w.nombre nombreCamarero
				FROM comanda c LEFT JOIN mesas_local ml
				ON (c.id_mesa = ml.id_mesa_local),camareros w
				WHERE c.id_camarero = w.id_camarero
				AND c.id_local = ?
				AND (estado = ? OR estado = ?)
				AND c.fecha_alta >= SYSDATE() - INTERVAL 1 DAY
				ORDER BY c.fecha_alta DESC";

		$result = $this->db->query($sql, array($idLocal, 'CC', 'CW'));

		return $result;
	}

	function cambiarEstadoComanda($idComanda, $estado) {
		//Se cambia el estado de la comanda
		$sql = "UPDATE comanda SET  estado = ?
				WHERE id_comanda = ?";

		$this->db->query($sql, array($estado, $idComanda));

		/*
		 * Si el estado es TC (terminado cocina se inserta una alerta
		 		* al camarero que ha insertado la comanda
		 		*/

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		if ($estado == "TC") {

			//Se obtienen los datos de la comanda
			$datosComanda = $this->obtenerLocalComanda($idComanda)->row();

			//Se inserta la alerta
			$this->Alertas_model->insertAlertaCamarero
			(10, $datosComanda->id_local, $idComanda
					, $datosComanda->id_camarero);
		} elseif ($estado == "CW"){
			//Se obtienen los datos de la comanda
			$datosComanda = $this->obtenerLocalComanda($idComanda)->row();

			//Se inserta la alerta
			$this->Alertas_model->insertAlertaCamarero
			(10, $datosComanda->id_local, $idComanda
					, $datosComanda->id_camarero);
		}
	}

	function cambiarEstadoComandaMenu($idDetalleComanda, $estado) {
		//Se cambia el estado de la comanda
		$sql = "UPDATE comanda_menu SET  estado = ?
				WHERE id_detalle_comanda = ?";

		$this->db->query($sql, array($estado, $idDetalleComanda));
	}

	function cambiarEstadoPlatoMenu($idComandaMenu, $estado) {
		//Se cambia el estado de la comanda
		$sql = "UPDATE comanda_menu SET  estado = ?
				WHERE id_comanda_menu = ?";

		$this->db->query($sql, array($estado, $idComandaMenu));

		$idComanda = $this->obtenerIdComanda($idComandaMenu);

		//Se obtienen los datos de la comanda
		$datosComanda =
		$this->obtenerLocalComanda($idComanda)->row();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaCamarero
		(14, $datosComanda->id_local, $idComanda
				, $datosComanda->id_camarero);
	}

	function obtenerLocalComanda($idComanda) {
		//Se obtienen los datos de la comanda
		$sql = "SELECT l.*,c.id_camarero
				FROM comanda c , locales l
				WHERE c.id_local = l.id_local
				AND c.id_comanda = ?";

		$result = $this->db->query($sql, array($idComanda));

		return $result;
	}

	function obtenerComanda($idComanda) {

		//Se obtienen los datos de la comanda
		$sql = "SELECT c.*,ml.nombre_mesa nombreMesa, w.nombre nombreCamarero
				FROM comanda c LEFT JOIN mesas_local ml
				ON (c.id_mesa = ml.id_mesa_local),camareros w
				WHERE c.id_camarero = w.id_camarero
				AND c.id_comanda = ?";

		$datosComanda = $this->db->query($sql, array($idComanda))->row_array();

		$sql = "SELECT * FROM detalle_comanda WHERE id_comanda = ?";

		$detalleComanda = $this->db->query($sql, array($idComanda))->result_array();

		$detComanda = array();

		foreach ($detalleComanda as $detalle) {
			$art = array();

			//Se obtiene el tipo de comanda
			$tipoComanda =
			$this->obtenerTipoComanda($detalle['id_tipo_comanda'])->row()->tipo_comanda;
			//Articulos
			switch ($detalle['id_tipo_comanda']) {
				//Articulo
				case 1:
					//Se carga el modelo de articulos para obtener el detalle
					$this->load->model('articulos/Articulos_model');

					//Se obtiene el articulo
					$articulo =
					$this->Articulos_model->obtenerArticuloLocal
					($detalle['id_articulo'])->row_array();

					//Se obtienen los ingredientes del articulo
					$ingredientesArticulo =
					$this->Articulos_model->obtenerDetalleArticulo
					($detalle['id_articulo'])->result_array();

					$art = array('detalleComandaArticulo' => $detalle
							, 'datosArticulo' => $articulo
							, 'tipoComanda' => $tipoComanda
							, 'detalleArticulo' => $ingredientesArticulo);

					break;
				case 2:
					//Articulo personalizado
					//Se carga el modelo de articulos para obtener el tipo articulo
					$this->load->model('articulos/Articulos_model');

					//Se obtiene el tipo articulo
					$tipoArticulo =
					$this->Articulos_model->obtenerTipoArticulo
					($detalle['id_articulo'])->row();

					//Se obtienen los ingredientes del articulo per
					$ingredientesArticulo = $this->obtenerDetalleComandaPer
					($detalle['id_detalle_comanda'])->result_array();
					$art = array('detalleComandaArticulo' => $detalle
							, 'tipoArticulo' => $tipoArticulo->tipo_articulo
							, 'tipoComanda' => $tipoComanda
							, 'detalleArticuloPer' => $ingredientesArticulo);
					break;
				case 3:
					//Menu
					$platosMenu =
					$this->obtenerDetalleComandaMenu
					($detalle['id_detalle_comanda'])->result_array();

					$art = array('detalleComandaArticulo' => $detalle
							, 'tipoComanda' => $tipoComanda
							, 'detalleMenu' => $platosMenu);
					break;
				case 4:
					//Carta
					//Se carga el modelo de menus para obtener el detalle del plato
					$this->load->model('menus/Menus_model');

					//Se obtiene el articulo
					$platoLocal =
					$this->Menus_model->obtenerPlatoLocal
					($detalle['id_articulo'])->row_array();

					$art = array('detalleComandaArticulo' => $detalle
							, 'tipoComanda' => $tipoComanda
							, 'datosPlato' => $platoLocal);
					break;
			}

			$detComanda[] = $art;
		}

		//Se genera el array con los datos
		$comanda = array('datosComanda' => $datosComanda,
				'detalleComanda' => $detComanda);

		return $comanda;
	}

	function obtenerDetalleComandaPer($idDetalleComanda) {
		$sql = "SELECT cap.*,i.ingrediente
				FROM comanda_articulo_per cap, ingredientes i
				WHERE cap.id_ingrediente = i.id_ingrediente
				AND id_detalle_comanda = ?";

		$result = $this->db->query($sql, array($idDetalleComanda));

		return $result;
	}

	function obtenerDetallesComandaArticulo($idComanda, $idArticulo) {
		$sql = "SELECT * FROM detalle_comanda
				WHERE id_comanda = ?
				AND id_articulo = ?";

		$result = $this->db->query($sql, array($idComanda, $idArticulo));

		return $result;
	}

	function obtenerDetalleComandaMenu($idDetalleComanda) {
		$sql = "SELECT cm.*,pl.nombre nombrePlato, pl.precio precioPlato,
				tp.descripcion tipoPlato, tp.id_tipo_plato idTipoPlato
				FROM comanda_menu cm,platos_local pl, tipos_plato tp
				WHERE cm.id_plato = pl.id_plato_local
				AND pl.id_tipo_plato = tp.id_tipo_plato
				AND cm.id_detalle_comanda = ?
				ORDER BY tp.id_tipo_plato";

		$result = $this->db->query($sql, array($idDetalleComanda));

		return $result;
	}

	function obtenerDetalleComanda($idDetalleComanda) {
		$sql = "SELECT *
				FROM detalle_comanda
				WHERE id_detalle_comanda = ?";

		$result = $this->db->query($sql, array($idDetalleComanda));

		return $result;
	}

	public function anadirComanda($datosComanda, $observaciones
			, $precioComanda, $idComanda) {

		$transOk = true;
		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			//Se añade los datos a la comanda ya existente.
			$sql = "UPDATE comanda SET observaciones = observaciones + ?,
					precio = precio + ?,  estado = ?
					WHERE id_comanda = ?";

			$this->db->query($sql, array($observaciones
					, $precioComanda, "EC", $idComanda));

			foreach ($datosComanda as $lineaComanda) {

				/*
				 * Si se trata de un articulo personalizado se inserta
				* el idTipoArticulo en el campo id_articulo
				*/

				if ($lineaComanda['options']['idTipoComanda'] == 2) {
					$id = $lineaComanda['options']['idTipoArticulo'];
				} else {
					$id = strstr($lineaComanda['id'], '.', true);
				}

				/*
				 * Si se trata de un menu se comprueba si se esta
				* añadiendo un plato a un menu existente para no insertar de
				* nuevo el detalle de la comanda
				*/

				if ($lineaComanda['options']['idTipoComanda'] == 3) {
					if ($lineaComanda['options']['anadirMenuIncompleto']) {
						//Se busca un menu incompleto
						$idTipoMenuLocal = strstr($lineaComanda['id'], '.', true);
						$detalleMenu = $this->obtenerDetallesComandaArticulo($idComanda, $idTipoMenuLocal);

						if ($detalleMenu->num_rows() == 0) {
							$msg = "No existe el menu en la comanda";

							//Se finaliza la transaccion
							$this->db->trans_complete();
							$this->db->trans_rollback();
							return array('noError' => false, 'mensaje' => $msg);
						} else {
							$idDetalleComanda = $detalleMenu->first_row()->id_detalle_comanda;
						}
					} else {
						//Se inserta el detalle de la comanda
						$idDetalleComanda =
						$this->insertarDetalleComanda($lineaComanda['options']['idTipoComanda']
								, $lineaComanda['qty'], $lineaComanda['price'], $idComanda
								, $id);
					}
				} else {
					//Se inserta el detalle de la comanda
					$idDetalleComanda =
					$this->insertarDetalleComanda($lineaComanda['options']['idTipoComanda']
							, $lineaComanda['qty'], $lineaComanda['price'], $idComanda
							, $id);
				}

				/*
				 * Si el idDetalleComanda es menor que cero ha habido error
				* rollback y se sale con false
				*/

				if ($idDetalleComanda < 0) {
					//Se finaliza la transaccion
					$this->db->trans_complete();
					$this->db->trans_rollback();
					$msg = "Error insertando el detalle de la comanda";
					return array('noError' => false, 'mensaje' => $msg);
				}

				switch ($lineaComanda['options']['idTipoComanda']) {
					case 2:
						$insertOk = true;
						foreach ($lineaComanda['options']['ingredientes'] as $ingrediente) {
							//Se inserta el detalle del articulo personalizado
							$insertOk = $this->insertarComandaArticuloPer($idDetalleComanda
									, $ingrediente['idIngrediente']
									, $ingrediente['precioIngrediente']);

							if (!$insertOk) {
								$transOk = false;
							}
						}

						break;
					case 3:
						$insertOk = true;
						foreach ($lineaComanda['options']['platosMenu'] as $plato) {
							//Se inserta el detalle del menu
							$insertOk = $this->insertarComandaMenu($idDetalleComanda
									, $plato['idPlatoLocal']
									, $plato['platoCantidad']);

							if (!$insertOk) {
								$transOk = false;
							}
						}

						break;
				}
			}
			//Se finaliza la transaccion
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$msg = "Error añadiendo datos a la comanda";
			return array('noError' => false, 'mensaje' => $msg);
		}

		if ($this->db->trans_status() === FALSE || !$transOk) {
			$this->db->trans_rollback();
			$msg = "Error a�adiendo datos a la comanda";
			return array('noError' => false, 'mensaje' => $msg);
		}
		$this->db->trans_commit();
		$msg = "Datos añadidos correctamente";

		$idLocal = $this->obtenerLocalComanda($idComanda)->row()->id_local;

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(12, $idLocal, $idComanda);

		return array('noError' => true, 'mensaje' => $msg);
	}

	public function cambiarEstadoDetalleComanda($idDetalleComanda, $estado) {

		//Se cambia el estado de la comanda
		$sql = "UPDATE detalle_comanda SET  estado = ?
				WHERE id_detalle_comanda = ?";

		if ($estado == "TC") {

			//Se obtienen los datos del detalle de la comanda
			$datosDetalleComanda = $this->obtenerDetalleComanda($idDetalleComanda)->row();

			//Se obtienen los datos de la comanda
			$datosComanda =
			$this->obtenerLocalComanda($datosDetalleComanda->id_comanda)->row();

			//Se carga el modelo de alertas
			$this->load->model('alertas/Alertas_model');

			//Se inserta la alerta
			$this->Alertas_model->insertAlertaCamarero
			(13, $datosComanda->id_local, $datosDetalleComanda->id_comanda
					, $datosComanda->id_camarero);
		}

		$this->db->query($sql, array($estado, $idDetalleComanda));
	}

	function obtenerPlatoComanda($idComandaMenu) {
		$sql = "SELECT cm.*
				FROM comanda_menu cm
				WHERE cm.id_comanda_menu = ?";

		$row = $this->db->query($sql, array($idComandaMenu));

		return $row;
	}

	function obtenerPlatosComandaObject($idDetalleComanda) {
		$sql = "SELECT cm.*
				FROM comanda_menu cm
				WHERE cm.id_detalle_comanda = ?";

		$result = $this->db->query($sql, array($idDetalleComanda))->result();
			
		$platosComanda = array();
			
		foreach ($result as $row){
			$platosComanda[] = PlatoComanda::withID($row->id_comanda_menu);
		}

		return $platosComanda;
	}

	function obtenerMenuComanda($idDetalleComanda) {
		$sql = "SELECT cm.*
				FROM comanda_menu cm
				WHERE cm.id_detalle_comanda = ?";

		$result = $this->db->query($sql, array($idDetalleComanda));

		return $result;
	}

	function obtenerListaIngredientesComandaPerObject($idDetalleComanda) {
		$sql = "SELECT cap.*
				FROM comanda_articulo_per cap
				WHERE cap.id_detalle_comanda = ?";

		$result = $this->db->query($sql, array($idDetalleComanda))->result();
			
		$ingredientes = array();
			
		foreach ($result as $row){
			$ingredientes[] = Ingrediente::withID($row->id_ingrediente);
		}

		return $ingredientes;
	}

	function obtenerDetallesComandaObject($idComanda) {
		$sql = "SELECT dc.*
				FROM detalle_comanda dc
				WHERE dc.id_comanda = ?";

		$result = $this->db->query($sql, array($idComanda))->result();

		$detallesComanda = array();

		foreach ($result as $row){
			$detallesComanda[] = DetalleComanda::withID($row->id_detalle_comanda);
		}

		return $detallesComanda;
	}

	function obtenerDatosComanda($idComanda) {
		$sql = "SELECT cm.*
				FROM comanda cm
				WHERE cm.id_comanda = ?";

		$result = $this->db->query($sql, array($idComanda));

		return $result;
	}

	function obtenerIdComanda($idComandaMenu) {
		$sql = "SELECT *
				FROM comanda_menu
				WHERE id_comanda_menu = ?";

		$rowComandaMenu = $this->db->query($sql, array($idComandaMenu))->row();

		$sql = "SELECT *
				FROM detalle_comanda
				WHERE id_detalle_comanda = ?";

		$rowDetalleComanda = $this->db->query($sql, array($rowComandaMenu->id_detalle_comanda))->row();

		return $rowDetalleComanda->id_comanda;
	}


	function obtenerComandasActivasObject($idLocal){
		$sql = "SELECT cm.*
				FROM comanda cm
				WHERE cm.id_local = ?
				AND cm.estado NOT IN ('CC','CW')";
			
		$result = $this->db->query($sql, array($idLocal))->result();
			
		$comandas = array();
			
		foreach ($result as $row){
			$comandas[] = Comanda::withID($row->id_comanda);
		}
			
		return $comandas;
	}

	function obtenerComandasCerradasObject($idLocal) {
		$sql = "SELECT c.*
				FROM comanda c
				WHERE c.id_local = ?
				AND (estado = ? OR estado = ?)
				AND c.fecha_alta >= SYSDATE() - INTERVAL 1 DAY
				ORDER BY c.fecha_alta DESC";

		$result = $this->db->query($sql, array($idLocal, 'CC', 'CW'))->result();

		$comandas = array();
			
		foreach ($result as $row){
			$comandas[] = Comanda::withID($row->id_comanda);
		}
			
		return $comandas;
	}



	public function insertarComandaLlevarApi($datosComanda
			, $idLocal) {

		$transOk = true;
		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			//Se crea una nueva comanda
			//Se insertan los datos en la tabla comanda
			$sql = "INSERT INTO comanda (destino, observaciones, id_local
					, id_camarero, precio, id_mesa, estado, fecha_alta)
					VALUES (?,?,?,?,?,?,?,?)";

			$this->db->query($sql, array($datosComanda[Comanda::FIELD_DESTINO],
					$datosComanda[Comanda::FIELD_OBSERVACIONES], $idLocal
					, $datosComanda[Camarero::FIELD_CAMARERO][Camarero::FIELD_ID_CAMARERO]
					, $datosComanda[Comanda::FIELD_PRECIO], 0, "EC",
					date('Y-m-d H:i:s')));

			$idComanda = $this->db->insert_id();


			foreach ($datosComanda[DetalleComanda::FIELD_DETALLES_COMANDA] as $lineaComanda) {

				switch ($lineaComanda[TipoComanda::FIELD_TIPO_COMANDA]
						[TipoComanda::FIELD_ID_TIPO_COMANDA]) {
							case 1:
								//Si articulo  se guarda el id en el campo id_articulo
								$id = $lineaComanda[Articulo::FIELD_ARTICULO]
								[Articulo::FIELD_ID_ARTICULO];

								//Se inserta el detalle de la comanda
								$idDetalleComanda =
								$this->insertarDetalleComanda(1
										, $lineaComanda[DetalleComanda::FIELD_CANTIDAD],
										$lineaComanda[DetalleComanda::FIELD_PRECIO], $idComanda
										, $id);

								/*
								 * Si el idDetalleComanda es menor que cero ha habido error
								* rollback y se sale con false
								*/

								if ($idDetalleComanda < 0) {
									//Se finaliza la transaccion
									$this->db->trans_complete();
									$this->db->trans_rollback();
									return -1;
								}
								break;
							case 2:
								//Si articulo personalizado se guarda el tipo de articulo en el campo id_articulo
								$id = $lineaComanda[Articulo::FIELD_ARTICULO]
								[TipoArticulo::FIELD_TIPO_ARTICULO][TipoArticulo::FIELD_ID_TIPO_ARTICULO];

								//Se inserta el detalle de la comanda
								$idDetalleComanda =
								$this->insertarDetalleComanda(2
										, $lineaComanda[DetalleComanda::FIELD_CANTIDAD],
										$lineaComanda[DetalleComanda::FIELD_PRECIO], $idComanda
										, $id);

								/*
								 * Si el idDetalleComanda es menor que cero ha habido error
								* rollback y se sale con false
								*/

								if ($idDetalleComanda < 0) {
									//Se finaliza la transaccion
									$this->db->trans_complete();
									$this->db->trans_rollback();
									return -1;
								}

								$insertOk = true;
								foreach ($lineaComanda[Articulo::FIELD_ARTICULO]
										[Ingrediente::FIELD_INGREDIENTES] as $ingrediente) {
									//Se inserta el detalle del articulo personalizado
									$insertOk = $this->insertarComandaArticuloPer($idDetalleComanda
											, $ingrediente[Ingrediente::FIELD_ID_INGREDIENTE]
											, $ingrediente[Ingrediente::FIELD_PRECIO]);

									if (!$insertOk) {
										$transOk = false;
									}
								}

								break;
							case 3:

								//Si menu se guarda el tipo de articulo en el campo id_articulo
								$id = $lineaComanda[MenuComanda::FIELD_MENU_COMANDA]
								[Menu::FIELD_MENU][Menu::FIELD_ID_MENU];

								//Se inserta el detalle de la comanda
								$idDetalleComanda =
								$this->insertarDetalleComanda(3
										, $lineaComanda[DetalleComanda::FIELD_CANTIDAD],
										$lineaComanda[DetalleComanda::FIELD_PRECIO], $idComanda
										, $id);

								/*
								 * Si el idDetalleComanda es menor que cero ha habido error
								* rollback y se sale con false
								*/

								if ($idDetalleComanda < 0) {
									//Se finaliza la transaccion
									$this->db->trans_complete();
									$this->db->trans_rollback();
									return -1;
								}

								$insertOk = true;
								foreach ($lineaComanda[MenuComanda::FIELD_MENU_COMANDA]
										[MenuComanda::FIELD_PLATOS_COMANDA] as $plato) {
									//Se inserta el detalle del articulo personalizado
									$insertOk = $this->insertarComandaMenu($idDetalleComanda
											, $plato[Plato::FIELD_ID_PLATO]
											, $plato[PlatoComanda::FIELD_CANTIDAD]);

									if (!$insertOk) {
										$transOk = false;
									}
								}

								break;
				}
			}
			//Se finaliza la transaccion
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return -1;
		}

		if ($this->db->trans_status() === FALSE || !$transOk) {
			$this->db->trans_rollback();
			return -1;
		}
		$this->db->trans_commit();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(4, $idLocal, $idComanda);

		return $idComanda;
	}

	public function insertarComandaLocalApi($datosComanda
			, $idLocal) {

		$transOk = true;

		try {
			//Se inicia la transaccion
			$this->db->trans_begin();

			//Se crea una nueva comanda
			//Se insertan los datos en la tabla comanda
			$sql = "INSERT INTO comanda (destino, observaciones, id_local
					, id_camarero, precio, id_mesa, estado, fecha_alta)
					VALUES (?,?,?,?,?,?,?,?)";

			$this->db->query($sql, array("mesa", $datosComanda[Comanda::FIELD_OBSERVACIONES]
					, $idLocal
					, $datosComanda[Camarero::FIELD_CAMARERO][Camarero::FIELD_ID_CAMARERO]
					, $datosComanda[Comanda::FIELD_PRECIO]
					, $datosComanda[Mesa::FIELD_MESA][Mesa::FIELD_ID_MESA]
					, "EC", date('Y-m-d H:i:s')));

			$idComanda = $this->db->insert_id();


			foreach ($datosComanda[DetalleComanda::FIELD_DETALLES_COMANDA] as $lineaComanda) {

				switch ($lineaComanda[TipoComanda::FIELD_TIPO_COMANDA]
						[TipoComanda::FIELD_ID_TIPO_COMANDA]) {
							case 1:
								//Si articulo  se guarda el id en el campo id_articulo
								$id = $lineaComanda[Articulo::FIELD_ARTICULO]
								[Articulo::FIELD_ID_ARTICULO];
									
								//Se inserta el detalle de la comanda
								$idDetalleComanda =
								$this->insertarDetalleComanda(1
										, $lineaComanda[DetalleComanda::FIELD_CANTIDAD],
										$lineaComanda[DetalleComanda::FIELD_PRECIO], $idComanda
										, $id);
									
								/*
								 * Si el idDetalleComanda es menor que cero ha habido error
								* rollback y se sale con false
								*/
									
								if ($idDetalleComanda < 0) {
									//Se finaliza la transaccion
									$this->db->trans_complete();
									$this->db->trans_rollback();
									return -1;
								}
								break;
							case 2:
								//Si articulo personalizado se guarda el tipo de articulo en el campo id_articulo
								$id = $lineaComanda[Articulo::FIELD_ARTICULO]
								[TipoArticulo::FIELD_TIPO_ARTICULO]
								[TipoArticulo::FIELD_ID_TIPO_ARTICULO];

								//Se inserta el detalle de la comanda
								$idDetalleComanda =
								$this->insertarDetalleComanda(2
										, $lineaComanda[DetalleComanda::FIELD_CANTIDAD],
										$lineaComanda[DetalleComanda::FIELD_PRECIO], $idComanda
										, $id);

								/*
								 * Si el idDetalleComanda es menor que cero ha habido error
								* rollback y se sale con false
								*/

								if ($idDetalleComanda < 0) {
									//Se finaliza la transaccion
									$this->db->trans_complete();
									$this->db->trans_rollback();
									return -1;
								}

								$insertOk = true;
								foreach ($lineaComanda[Articulo::FIELD_ARTICULO]
										[Ingrediente::FIELD_INGREDIENTES] as $ingrediente) {
									//Se inserta el detalle del articulo personalizado
									$insertOk = $this->insertarComandaArticuloPer($idDetalleComanda
											, $ingrediente[Ingrediente::FIELD_ID_INGREDIENTE]
											, $ingrediente[Ingrediente::FIELD_PRECIO]);

									if (!$insertOk) {
										$transOk = false;
									}
								}

								break;
							case 3:
								//Si menu se guarda el tipo de articulo en el campo id_articulo
								$id = $lineaComanda[MenuComanda::FIELD_MENU_COMANDA]
								[Menu::FIELD_MENU][Menu::FIELD_ID_MENU];;

								//Se inserta el detalle de la comanda
								$idDetalleComanda =
								$this->insertarDetalleComanda(3
										, $lineaComanda[DetalleComanda::FIELD_CANTIDAD],
										$lineaComanda[DetalleComanda::FIELD_PRECIO], $idComanda
										, $id);

								/*
								 * Si el idDetalleComanda es menor que cero ha habido error
								* rollback y se sale con false
								*/

								if ($idDetalleComanda < 0) {
									//Se finaliza la transaccion
									$this->db->trans_complete();
									$this->db->trans_rollback();
									return -1;
								}

								$insertOk = true;
								foreach ($lineaComanda[MenuComanda::FIELD_MENU_COMANDA]
										[MenuComanda::FIELD_PLATOS_COMANDA] as $plato) {
									//Se inserta el detalle del articulo personalizado
									$insertOk = $this->insertarComandaMenu($idDetalleComanda
											, $plato[Plato::FIELD_ID_PLATO]
											, $plato[PlatoComanda::FIELD_CANTIDAD]);

									if (!$insertOk) {
										$transOk = false;
									}
								}

								break;
				}
			}
			//Se finaliza la transaccion
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return -1;
		}

		if ($this->db->trans_status() === FALSE || !$transOk) {
			$this->db->trans_rollback();
			return -1;
		}
		$this->db->trans_commit();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(4, $idLocal, $idComanda);

		return $idComanda;
	}
}

