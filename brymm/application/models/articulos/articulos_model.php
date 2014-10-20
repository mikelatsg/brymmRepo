<?php

require_once APPPATH . '/libraries/articulos/articulo.php';
require_once APPPATH . '/libraries/articulos/tipoArticulo.php';
require_once APPPATH . '/libraries/articulos/tipoArticuloLocal.php';
require_once APPPATH . '/libraries/ingredientes/ingrediente.php';

class Articulos_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function obtenerTiposArticulo() {
		// Consulta en la tabla tipos_articulo
		$sql = "SELECT * FROM tipos_articulo ";
		$result = $this->db->query($sql);

		return $result;
	}

	function obtenerTiposArticuloObject() {
		// Consulta en la tabla tipos_articulo
		$sql = "SELECT * FROM tipos_articulo ";
		$result = $this->db->query($sql)->result();

		$tiposArticulo = array();

		foreach($result as $row){
			$tiposArticulo [] = new TipoArticulo($row->id_tipo_articulo
					,$row->tipo_articulo
					,$row->descripcion);
		}

		return $tiposArticulo;
	}

	//Funcion que inserta los articulos en la BBDD
	function insertArticuloLocal($datos, $idLocal) {

		//Se comprueba si esta marcada la casilla valido pedidos
		if (isset($datos['validoPedidos'])) {
			$validoPedidos = true;
		} else {
			$validoPedidos = false;
		}

		$sql = "INSERT INTO articulos_local (id_articulo_local,id_local,articulo
				,descripcion,disponible,precio,fecha_alta,id_tipo_articulo
				, valido_pedidos)
				VALUES ('',?,?,?,?,?,?,?,?)";

		$this->db->query($sql, array($idLocal, $datos['articulo'], $datos['descripcion']
				, 1, $datos['precio'], date('Y-m-d'), $datos['tipoArticulo'], $validoPedidos));

		$idArticuloLocal = $this->db->insert_id();

		/*
		 * Se comprueba si hay ingredientes seleccionados para introducirlos
		*/
		if (isset($datos['ingrediente'])) {
			//Se insertan el detalle del articulo
			foreach ($datos['ingrediente'] as $ingrediente) {
				$sql = "INSERT INTO det_articulo (id_det_articulo,id_articulo_local,id_ingrediente)"
						. " VALUES ('',?,?)";

				$this->db->query($sql, array($idArticuloLocal, $ingrediente));
			}
		}
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(15, $idLocal, $idArticuloLocal);
	}

	//Funcion que inserta los articulos en la BBDD
	function insertArticuloLocalObject($articulo, $idLocal) {

		$sql = "INSERT INTO articulos_local (id_articulo_local,id_local,articulo
				,descripcion,disponible,precio,fecha_alta,id_tipo_articulo
				, valido_pedidos)
				VALUES ('',?,?,?,?,?,?,?,?)";

		$this->db->query($sql, array($idLocal
				, $articulo->nombre
				, $articulo->descripcion
				, 1
				, $articulo->precio
				, date('Y-m-d')
				, $articulo->tipoArticulo->idTipoArticulo
				, $articulo->validoPedidos));

		$idArticuloLocal = $this->db->insert_id();

		//Se insertan el detalle del articulo
		foreach ($articulo->ingredientes as $ingrediente) {
			$sql = "INSERT INTO det_articulo (id_det_articulo,id_articulo_local,id_ingrediente)"
					. " VALUES ('',?,?)";

			$this->db->query($sql, array($idArticuloLocal, $ingrediente->idIngrediente));
		}
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(15, $idLocal, $idArticuloLocal);

		return $idArticuloLocal;

	}

	function comprobarExisteArticuloLocal($idLocal) {
		$sql = "SELECT al.* FROM articulos_local al,tipos_articulo ta "
				. "WHERE al.id_tipo_articulo = ta.id_tipo_articulo "
						. "AND al.id_local = ?"
								. " ORDER BY al.id_tipo_articulo, al.id_articulo_local";
		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function comprobarHayArticuloTipoArticulo($idLocal, $idTipoArticulo) {
		$sql = "SELECT * FROM articulos_local
				WHERE id_local = ?
				AND id_tipo_articulo = ?";

		$result = $this->db->query($sql, array($idLocal, $idTipoArticulo));

		return $result;
	}

	function comprobarExisteTipoArticuloLocal($idLocal) {
		$sql = "SELECT * FROM tipos_articulo_local
				WHERE id_local = ?";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerArticulosLocal($idLocal) {
		$sql = "SELECT al.*,ta.tipo_articulo FROM articulos_local al,tipos_articulo ta "
				. "WHERE al.id_tipo_articulo = ta.id_tipo_articulo "
						. "AND al.id_local = ?"
								. " ORDER BY al.id_tipo_articulo, al.id_articulo_local";
		$result = $this->db->query($sql, array($idLocal))->result();

		$j = 0;
		$articulos = array();
		foreach ($result as $linea) {
			$sql = "SELECT dart.*,ing.ingrediente FROM det_articulo dart,ingredientes ing
					WHERE ing.id_ingrediente = dart.id_ingrediente
					AND id_articulo_local = ?";

			$ingredientesArticulo = $this->db->query($sql, array($linea->id_articulo_local))->result();
			$i = 0;
			$ingredientes = array();
			foreach ($ingredientesArticulo as $ingrediente) {
				$ingredientes[$i] = array(
						"id_det_articulo" => $ingrediente->id_det_articulo,
						"id_ingrediente" => $ingrediente->id_ingrediente,
						"ingrediente" => $ingrediente->ingrediente
				);
				$i = $i + 1;
			}

			$articulos[$j] = array(
					"id_articulo_local" => $linea->id_articulo_local,
					"id_local" => $linea->id_local,
					"id_tipo_articulo" => $linea->id_tipo_articulo,
					"articulo" => $linea->articulo,
					"descripcion" => $linea->descripcion,
					"disponible" => $linea->disponible,
					"precio" => $linea->precio,
					"tipo_articulo" => $linea->tipo_articulo,
					"validoPedidos" => $linea->valido_pedidos,
					"ingredientes" => $ingredientes);
			$j = $j + 1;
		}

		return $articulos;
	}

	function obtenerArticulosLocalObject($idLocal) {
		$sql = "SELECT al.*,ta.tipo_articulo, ta.descripcion descripcionTipoArticulo
				, tal.id_tipo_articulo_local
				FROM articulos_local al,tipos_articulo ta
				, tipos_articulo_local tal "
				. "WHERE al.id_tipo_articulo = ta.id_tipo_articulo
						AND ta.id_tipo_articulo = tal.id_tipo_articulo
						AND al.id_local = tal.id_local "
						. "AND al.id_local = ?"
								. " ORDER BY al.id_tipo_articulo, al.id_articulo_local";
		$result = $this->db->query($sql, array($idLocal))->result();

		$articulos = array();
		foreach ($result as $linea) {
			$sql = "SELECT dart.*,ing.ingrediente, ing.precio, ing.descripcion
					FROM det_articulo dart,ingredientes ing
					WHERE ing.id_ingrediente = dart.id_ingrediente
					AND id_articulo_local = ?";

			$ingredientesArticulo = $this->db->query($sql, array($linea->id_articulo_local))->result();
			$ingredientes = array();
			foreach ($ingredientesArticulo as $row) {
					
				$ingrediente = new Ingrediente($row->id_ingrediente
						,$row->ingrediente
						,$row->descripcion
						,$row->precio);
					
				$ingredientes[] = $ingrediente;
			}

			$tipoArticulo = TipoArticuloLocal::withID($linea->id_tipo_articulo_local);

			$articulos[] = new Articulo($linea->id_articulo_local,
					$tipoArticulo,
					$linea->articulo,
					$linea->descripcion,
					$linea->precio,
					$linea->valido_pedidos,
					$ingredientes);

			unset($ingredientes);
		}

		return $articulos;
	}

	function obtenerArticuloLocalObject($idArticuloLocal) {
		$sql = "SELECT al.*,ta.tipo_articulo, ta.descripcion descripcionTipoArticulo
				, tal.id_tipo_articulo_local
				FROM articulos_local al,tipos_articulo ta
				, tipos_articulo_local tal "
				. "WHERE al.id_tipo_articulo = ta.id_tipo_articulo
						AND ta.id_tipo_articulo = tal.id_tipo_articulo
						AND al.id_local = tal.id_local "
						. "AND al.id_articulo_local = ?"
								. " ORDER BY al.id_tipo_articulo, al.id_articulo_local";
		$row = $this->db->query($sql, array($idArticuloLocal))->row();


		$sql = "SELECT dart.*,ing.ingrediente, ing.precio, ing.descripcion
				FROM det_articulo dart,ingredientes ing
				WHERE ing.id_ingrediente = dart.id_ingrediente
				AND id_articulo_local = ?";

		$ingredientesArticulo = $this->db->query($sql, array($row->id_articulo_local))->result();
		$ingredientes = array();
		foreach ($ingredientesArticulo as $ingrediente) {

			$ingrediente = new Ingrediente($ingrediente->id_ingrediente
					,$ingrediente->ingrediente
					,$ingrediente->descripcion
					,$ingrediente->precio);

			$ingredientes[] = $ingrediente;
		}

		$tipoArticulo = TipoArticuloLocal::withID($row->id_tipo_articulo_local);

		$articulo = new Articulo($row->id_articulo_local,
				$tipoArticulo,
				$row->articulo,
				$row->descripcion,
				$row->precio,
				$row->valido_pedidos,
				$ingredientes);

		return $articulo;
	}

	function obtenerArticulosPedidoLocal($idLocal, $validoPedidos = 1, $disponible = 1) {
		$sql = "SELECT al.*,ta.tipo_articulo FROM articulos_local al,tipos_articulo ta "
				. "WHERE al.id_tipo_articulo = ta.id_tipo_articulo "
						. "AND al.id_local = ? "
								. "AND al.disponible = ? "
										. "AND al.valido_pedidos = ? "
												. "ORDER BY al.id_tipo_articulo, al.id_articulo_local";
		$result = $this->db->query($sql, array($idLocal, $validoPedidos = 1
				, $disponible = 1))->result();

		$j = 0;
		$articulos = array();
		foreach ($result as $linea) {
			$sql = "SELECT dart.*,ing.ingrediente FROM det_articulo dart,ingredientes ing
					WHERE ing.id_ingrediente = dart.id_ingrediente
					AND id_articulo_local = ?";

			$ingredientesArticulo = $this->db->query($sql, array($linea->id_articulo_local))->result();
			$i = 0;
			$ingredientes = array();
			foreach ($ingredientesArticulo as $ingrediente) {
				$ingredientes[$i] = array(
						"id_det_articulo" => $ingrediente->id_det_articulo,
						"id_ingrediente" => $ingrediente->id_ingrediente,
						"ingrediente" => $ingrediente->ingrediente
				);
				$i = $i + 1;
			}

			$articulos[$j] = array(
					"id_articulo_local" => $linea->id_articulo_local,
					"id_local" => $linea->id_local,
					"id_tipo_articulo" => $linea->id_tipo_articulo,
					"articulo" => $linea->articulo,
					"descripcion" => $linea->descripcion,
					"disponible" => $linea->disponible,
					"precio" => $linea->precio,
					"tipo_articulo" => $linea->tipo_articulo,
					"validoPedidos" => $linea->valido_pedidos,
					"ingredientes" => $ingredientes);
			$j = $j + 1;
		}

		return $articulos;
	}

	function modificarArticuloLocal($datos) {
		//Se comprueba si esta marcada la casilla valido pedidos
		if (isset($datos['validoPedidos'])) {
			$validoPedidos = true;
		} else {
			$validoPedidos = false;
		}

		$sql = "UPDATE articulos_local SET articulo = ?"
				. ",descripcion = ?,precio = ?,id_tipo_articulo = ?,valido_pedidos = ?"
						. " WHERE id_articulo_local = ?";

		$this->db->query($sql, array($datos['articulo'], $datos['descripcion']
				, $datos['precio'], $datos['tipoArticulo'], $validoPedidos
				, $datos['idArticuloLocal']));


		//Se borra el detalle del articulo para insertarlo con los nuevos valores
		$sql = "DELETE FROM det_articulo WHERE id_articulo_local = ?";

		$this->db->query($sql, array($datos['idArticuloLocal']));

		if (isset($datos['ingrediente'])) {
			foreach ($datos['ingrediente'] as $ingrediente) {
				$sql = "INSERT INTO  det_articulo (id_articulo_local,id_ingrediente)
						VALUES (?,?)";

				$this->db->query($sql, array($datos['idArticuloLocal'], $ingrediente));
			}
		}
		
		$idLocal = $this->obtenerArticuloLocal($datos['idArticuloLocal'])->row()->id_local;
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(15, $idLocal,  $datos['idArticuloLocal']);
	}

	function modificarArticuloLocalObject(Articulo $articulo) {

		$sql = "UPDATE articulos_local SET articulo = ?"
				. ",descripcion = ?,precio = ?,id_tipo_articulo = ?,valido_pedidos = ?"
						. " WHERE id_articulo_local = ?";

		$this->db->query($sql, array($articulo->nombre, $articulo->descripcion
				, $articulo->precio, $articulo->tipoArticulo->idTipoArticulo
				, $articulo->validoPedidos
				, $articulo->idArticulo));


		//Se borra el detalle del articulo para insertarlo con los nuevos valores
		$sql = "DELETE FROM det_articulo WHERE id_articulo_local = ?";

		$this->db->query($sql, array($articulo->idArticulo));


		foreach ($articulo->ingredientes as $ingrediente) {
			$sql = "INSERT INTO  det_articulo (id_articulo_local,id_ingrediente)
					VALUES (?,?)";

			$this->db->query($sql, array($articulo->idArticulo, $ingrediente->idIngrediente));
		}
		
		$idLocal = $this->obtenerArticuloLocal($articulo->idArticulo)->row()->id_local;
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(15, $idLocal,  $articulo->idArticulo);

	}

	//Funcion que borra un articulo de la BBDD
	function borrarArticuloLocal($idArticuloLocal) {
		
		//Obtengo el local antes de borrar
		$idLocal = $this->obtenerArticuloLocal($idArticuloLocal)->row()->id_local;
		
		//Se borra el articulo
		$sql = "DELETE FROM articulos_local WHERE id_articulo_local = ?";

		$this->db->query($sql, array($idArticuloLocal));

		//Se borra el detalle del articulo
		$sql = "DELETE FROM det_articulo WHERE id_articulo_local = ?";

		$this->db->query($sql, array($idArticuloLocal));				
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(16, $idLocal,  $idArticuloLocal);
	}

	function obtenerIngedientesArticulo($idArticuloLocal) {
		$sql = "SELECT * FROM det_articulo WHERE id_articulo_local = ?";

		$result = $this->db->query($sql, array($idArticuloLocal));

		return $result;
	}

	function obtenerArticulosIngrediente($idIngrediente) {
		$sql = "SELECT * FROM det_articulo WHERE  id_ingrediente = ?";

		$result = $this->db->query($sql, array($idIngrediente));

		return $result;
	}

	function insertTipoArticuloLocal($idTipoArticulo, $idLocal, $personalizar, $precioBase) {
		$sql = "INSERT INTO  tipos_articulo_local (id_tipo_articulo
				,id_local,personalizar,precio)
				VALUES (?,?,?,?)";

		$this->db->query($sql, array($idTipoArticulo, $idLocal, $personalizar, $precioBase));
		
		$idTipoArticuloLocal = $this->db->insert_id();
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(19, $idLocal,  $idTipoArticuloLocal);
	}

	function insertTipoArticuloLocalObject(TipoArticuloLocal $tipoArticuloLocal,$idLocal) {
		$sql = "INSERT INTO  tipos_articulo_local (id_tipo_articulo
				,id_local,personalizar,precio)
				VALUES (?,?,?,?)";

		$this->db->query($sql, array($tipoArticuloLocal->idTipoArticulo
				, $idLocal
				, $tipoArticuloLocal->personalizar
				, $tipoArticuloLocal->precio));
		
		$idTipoArticuloLocal = $this->db->insert_id(); 
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(19, $idLocal,  $idTipoArticuloLocal);

		return $idTipoArticuloLocal;
	}

	function modificarTipoArticuloLocal($idTipoArticuloLocal, $personalizar, $precioBase) {
		$sql = "UPDATE  tipos_articulo_local
				SET personalizar = ? , precio = ?
				WHERE id_tipo_articulo_local = ?";

		$this->db->query($sql, array($personalizar, $precioBase, $idTipoArticuloLocal));
		
		//Obtengo el local 
		$idLocal = $this->obtenerTipoArticuloLocal($idTipoArticuloLocal)->row()->id_local;
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(19, $idLocal,  $idTipoArticuloLocal);
	}

	function modificarTipoArticuloLocalObject(TipoArticuloLocal $tipoArticuloLocal) {
		$sql = "UPDATE  tipos_articulo_local
				SET personalizar = ? , precio = ?
				WHERE id_tipo_articulo_local = ?";

		$this->db->query($sql, array($tipoArticuloLocal->personalizar
				, $tipoArticuloLocal->precio
				, $tipoArticuloLocal->idTipoArticuloLocal));
		
		//Obtengo el local
		$idLocal = $this->obtenerTipoArticuloLocal($tipoArticuloLocal->idTipoArticuloLocal)->row()->id_local;
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(19, $idLocal,  $tipoArticuloLocal->idTipoArticuloLocal);
	}

	function obtenerTiposArticuloLocal($idLocal) {
		$sql = "SELECT ta.*,tal.personalizar,tal.id_tipo_articulo_local ,tal.precio
				FROM tipos_articulo_local tal,tipos_articulo ta
				WHERE ta.id_tipo_articulo = tal.id_tipo_articulo
				AND id_local = ?";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerTiposArticuloLocalObject($idLocal) {
		$sql = "SELECT ta.*,tal.personalizar,tal.id_tipo_articulo_local ,tal.precio
				FROM tipos_articulo_local tal,tipos_articulo ta
				WHERE ta.id_tipo_articulo = tal.id_tipo_articulo
				AND id_local = ?";

		$result = $this->db->query($sql, array($idLocal))->result();

		$tiposArticulo = array();
		foreach ($result as $row){
			$tiposArticulo [] = new TipoArticuloLocal( $row->id_tipo_articulo,
					$row->tipo_articulo,
					$row->descripcion,
					$row->precio,
					$row->personalizar,
					$row->id_tipo_articulo_local);
		}

		return $tiposArticulo;
	}

	function obtenerTiposArticuloPerLocal($idLocal, $personalizar) {
		$sql = "SELECT ta.*,tal.personalizar,tal.id_tipo_articulo_local ,tal.precio
				FROM tipos_articulo_local tal,tipos_articulo ta
				WHERE ta.id_tipo_articulo = tal.id_tipo_articulo
				AND id_local = ?
				AND personalizar = ?";

		$result = $this->db->query($sql, array($idLocal, $personalizar));

		return $result;
	}

	function comprobarArticuloPersonalizadoLocal($idLocal, $personalizar) {
		$sql = "SELECT *
				FROM tipos_articulo_local
				WHERE id_local = ?
				AND personalizar = ?";

		$result = $this->db->query($sql, array($idLocal, $personalizar));

		return $result;
	}

	function borrarTipoArticuloLocal($idTipoArticuloLocal) {
		
		//Obtengo el local antes de borrar
		$idLocal = $this->obtenerTipoArticuloLocal($idTipoArticuloLocal)->row()->id_local;
		
		//Borra un tipo de articulo de un local
		$sql = "DELETE FROM tipos_articulo_local WHERE id_tipo_articulo_local = ?";

		$this->db->query($sql, array($idTipoArticuloLocal));
		
		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
		
		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(20, $idLocal,  $idTipoArticuloLocal);
	}

	function comprobarTipoArticuloLocal($idTipoArticulo, $idLocal) {
		//Borra un tipo de articulo de un local
		$sql = "SELECT * FROM tipos_articulo_local
				WHERE id_tipo_articulo = ?
				AND id_local = ?";

		return $this->db->query($sql, array($idTipoArticulo, $idLocal));
	}

	function obtenerTipoArticuloLocal($idTipoArticuloLocal) {
		//Borra un tipo de articulo de un local
		$sql = "SELECT tal.*,ta.tipo_articulo, ta.descripcion
				FROM tipos_articulo_local tal,tipos_articulo ta
				WHERE ta.id_tipo_articulo = tal.id_tipo_articulo
				AND id_tipo_articulo_local = ?";

		return $this->db->query($sql, array($idTipoArticuloLocal));
	}

	function obtenerTipoArticuloLocal2($idTipoArticulo) {
		//Borra un tipo de articulo de un local
		$sql = "SELECT tal.*,ta.tipo_articulo FROM tipos_articulo_local tal,tipos_articulo ta
				WHERE ta.id_tipo_articulo = tal.id_tipo_articulo
				AND ta.id_tipo_articulo = ?";

		return $this->db->query($sql, array($idTipoArticulo));
	}

	function obtenerDetalleArticulo($idArticuloLocal) {

		$sql = "SELECT dart.*,ing.ingrediente, ing.descripcion,ing.precio
				FROM det_articulo dart,ingredientes ing
				WHERE ing.id_ingrediente = dart.id_ingrediente
				AND id_articulo_local = ?";

		$result = $this->db->query($sql, array($idArticuloLocal));

		return $result;
	}

	function obtenerTipoArticulo($idTipoArticulo) {
		$sql = "SELECT * FROM tipos_articulo
				WHERE id_tipo_articulo = ?";

		$result = $this->db->query($sql, array($idTipoArticulo));

		return $result;
	}

	function obtenerArticuloLocal($idArticuloLocal) {

		$sql = "SELECT al.*,ta.tipo_articulo
				FROM articulos_local al, tipos_articulo ta
				WHERE al.id_tipo_articulo = ta.id_tipo_articulo
				AND al.id_articulo_local = ?";

		$result = $this->db->query($sql, array($idArticuloLocal));

		return $result;
	}

	function obtenerTipoArticuloLocal3($idTipoArticulo,$idLocal) {
		//Borra un tipo de articulo de un local
		$sql = "SELECT tal.*,ta.tipo_articulo, ta.descripcion
				FROM tipos_articulo_local tal,tipos_articulo ta
				WHERE ta.id_tipo_articulo = tal.id_tipo_articulo
				AND tal.id_tipo_articulo = ?
				AND tal.id_local = ?";

		return $this->db->query($sql, array($idTipoArticulo,$idLocal));
	}

}
