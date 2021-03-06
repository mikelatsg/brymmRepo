<?php

require_once APPPATH . '/libraries/menus/tipoMenu.php';

class Menus_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
		$this->load->library('encrypt');
	}

	function insertPlatoLocal($idLocal, $nombre, $idTipoPlato, $precio) {

		// Guardar usuario en BD -- $this->encrypt->encode()
		$sql = "INSERT INTO platos_local (id_plato_local,id_local,nombre
				,id_tipo_plato,precio,fecha_alta)"
				. "VALUES('',?,?,?,?,?)";
		$this->db->query($sql, array($idLocal, $nombre, $idTipoPlato,
				$precio, date('Y-m-d H:i:s')));

		$idPlato = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(33, $idLocal, $idPlato);

		return $idPlato;
	}

	function obtenerPlatosLocal($idLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT pl.*,tp.descripcion FROM platos_local pl,tipos_plato tp
				WHERE pl.id_tipo_plato = tp.id_tipo_plato
				AND id_local = ?
				ORDER BY id_tipo_plato,id_plato_local";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerPlatosLocalObject($idLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT * FROM platos_local
				WHERE id_local = ?
				ORDER BY id_tipo_plato,id_plato_local";

		$result = $this->db->query($sql, array($idLocal))->result();

		$platos = array();

		foreach ($result as $row){
			$platos[] = Plato::withID($row->id_plato_local);
		}

		return $platos;
	}

	function obtenerTiposPlatosLocal() {
		//Se obtienen los platos del local
		$sql = "SELECT * FROM tipos_plato tp
				ORDER BY id_tipo_plato";

		$result = $this->db->query($sql);

		return $result;
	}

	function obtenerTiposPlatosLocalObject() {
		//Se obtienen los platos del local
		$sql = "SELECT * FROM tipos_plato tp
				ORDER BY id_tipo_plato";

		$result = $this->db->query($sql)->result();

		$tiposPlato = array();

		foreach($result as $row){
			$tiposPlato[] = TipoPlato::withID($row->id_tipo_plato);
		}

		return $tiposPlato;
	}

	//Funcion que devuelve el detalle del tipo de plato generico
	function obtenerTipoPlato($idTipoPlato) {
		//Se obtienen los platos del local
		$sql = "SELECT * FROM tipos_plato tp
				WHERE tp.id_tipo_plato = ?";

		$result = $this->db->query($sql, array($idTipoPlato));

		return $result;
	}

	function borrarPlatoLocal($idLocal, $idPlatoLocal) {
		//Se borra el plato del detalle de los menus
		$sql = "DELETE FROM detalle_menu_local
				WHERE id_plato_local = ?";

		$this->db->query($sql, array($idPlatoLocal));

		//Se borra el plato del local
		$sql = "DELETE FROM platos_local
				WHERE id_local = ?
				AND id_plato_local = ?";

		$this->db->query($sql, array($idLocal, $idPlatoLocal));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(34, $idLocal, $idPlatoLocal);
	}

	function insertMenu($idLocal, $fechaMenu, $disponible, $idTipoMenuLocal) {

		// Guardar usuario en BD -- $this->encrypt->encode()
		$sql = "INSERT INTO menu_local (id_menu_local, id_local, fecha_menu, "
				. "disponible,  id_tipo_menu_local,fecha_alta)"
						. "VALUES('',?,?,?,?,?)";
		$this->db->query($sql, array($idLocal
				, $fechaMenu->format('Y-m-d'), $disponible, $idTipoMenuLocal
				, date('Y-m-d')));

		$idMenu = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(31, $idLocal, $idMenu);

		return $idMenu;
	}

	function insertPlatoMenu($idMenuLocal, $idPlatoLocal, $disponible) {

		//Obtengo el local
		$idLocal = $this->obtenerDatosMenuDia($idMenuLocal)->row()->id_local;

		// Guardar usuario en BD -- $this->encrypt->encode()
		$sql = "INSERT INTO detalle_menu_local (id_detalle_menu_local, id_menu_local,"
				. "id_plato_local, disponible, fecha_alta)"
						. "VALUES('',?,?,?,?)";
		$this->db->query($sql, array($idMenuLocal, $idPlatoLocal, $disponible, date('Y-m-d')));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(31, $idLocal, $idMenuLocal);
	}

	function borrarPlatoMenu($idDetalleMenuLocal) {

		//Se obtiene el menu local
		$sql = "SELECT * FROM detalle_menu_local
				WHERE id_detalle_menu_local = ?";

		$datosMenu = $this->db->query($sql, array($idDetalleMenuLocal))
		->row();

		$idMenuLocal = $datosMenu->id_menu_local;
		$idLocal = $this->obtenerDatosMenuDia($idMenuLocal)->row()->id_local;

		// Borrar plato del menu
		$sql = "DELETE FROM detalle_menu_local
				WHERE id_detalle_menu_local = ?";
		$this->db->query($sql, array($idDetalleMenuLocal));

		/*
		 * Se comprueba si existen mas platos en este menu, si no hay mas
		* se borra el menu
		*/

		$sql = "SELECT * FROM detalle_menu_local
				WHERE id_menu_local = ?";

		$borrarMenu = $this->db->query($sql, array($idMenuLocal))
		->num_rows();

		if (!$borrarMenu > 0) {
			// Borrar el menu
			$sql = "DELETE FROM menu_local
					WHERE id_menu_local = ?";
			$this->db->query($sql, array($idMenuLocal));

			//Se carga el modelo de alertas
			$this->load->model('alertas/Alertas_model');

			//Se inserta la alerta de borrado
			$this->Alertas_model->insertAlertaLocal
			(32, $idLocal, $idMenuLocal);
		}else{
			//Se carga el modelo de alertas
			$this->load->model('alertas/Alertas_model');

			//Se inserta la alerta de modificado
			$this->Alertas_model->insertAlertaLocal
			(31, $idLocal, $idMenuLocal);
		}


	}

	function borrarPlatoMenu2($idMenuLocal, $idPlato) {

		//Obtengo el local
		$idLocal = $this->obtenerDatosMenuDia($idMenuLocal)->row()->id_local;

		// Borrar plato del menu
		$sql = "DELETE FROM detalle_menu_local
				WHERE id_menu_local = ?
				AND id_plato_local = ? ";
		$this->db->query($sql, array($idMenuLocal, $idPlato));

		/*
		 * Se comprueba si existen mas platos en este menu, si no hay mas
		* se borra el menu
		*/

		$sql = "SELECT * FROM detalle_menu_local
				WHERE id_menu_local = ?";

		$borrarMenu = $this->db->query($sql, array($idMenuLocal))
		->num_rows();

		if (!$borrarMenu > 0) {
			// Borrar el menu
			$sql = "DELETE FROM menu_local
					WHERE id_menu_local = ?";
			$this->db->query($sql, array($idMenuLocal));

			//Se carga el modelo de alertas
			$this->load->model('alertas/Alertas_model');

			//Se inserta la alerta de borrado
			$this->Alertas_model->insertAlertaLocal
			(32, $idLocal, $idMenuLocal);

			return true;
		}

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');
			
		//Se inserta la alerta de modificado
		$this->Alertas_model->insertAlertaLocal
		(31, $idLocal, $idMenuLocal);

		return false;
	}

	function insertTipoMenuLocal($idLocal, $idTipoMenu, $nombreMenu
			, $precioMenu, $esCarta) {

		// Guardar usuario en BD -- $this->encrypt->encode()
		$sql = "INSERT INTO tipo_menu_local (id_tipo_menu_local, id_local,"
				. "id_tipo_menu, nombre_menu,precio_menu, fecha_alta,es_carta)"
						. "VALUES('',?,?,?,?,?,?)";
		$this->db->query($sql, array($idLocal, $idTipoMenu, $nombreMenu
				, $precioMenu, date('Y-m-d'), $esCarta));

		$idTipoMenuLocal = $this->db->insert_id();

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(29, $idLocal, $idTipoMenuLocal);

		return $idTipoMenuLocal ;
	}

	function obtenerTiposMenuLocal($idLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT tml.*, tm.descripcion FROM tipo_menu_local tml, tipo_menu tm
				WHERE tml.id_tipo_menu = tm.id_tipo_menu
				AND id_local = ?
				ORDER BY id_tipo_menu";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function obtenerTiposMenuLocalObject($idLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT tml.* FROM tipo_menu_local tml
				WHERE id_local = ?
				ORDER BY id_tipo_menu";

		$result = $this->db->query($sql, array($idLocal))->result();

		$menus = array();

		foreach ($result as $row){
			$menus[] = Menu::withID($row->id_tipo_menu_local);
		}

		return $menus;
	}

	function borrarTipoMenuLocal($idTipoMenuLocal) {

		//Obtengo el local
		$idLocal = $this->obtenerTipoMenuLocal($idTipoMenuLocal)->row()->id_local;

		// Borrar los detalles de los menus creados con este tipo
		$sql = "DELETE FROM detalle_menu_local
				WHERE id_menu_local IN(
				SELECT id_menu_local
				FROM menu_local
				WHERE id_tipo_menu_local = ?)";
		$this->db->query($sql, array($idTipoMenuLocal));

		// Borrar los menus creados con este tipo
		$sql = "DELETE FROM menu_local
				WHERE id_tipo_menu_local = ?";
		$this->db->query($sql, array($idTipoMenuLocal));

		// Borrar el tipo de menu
		$sql = "DELETE FROM tipo_menu_local
				WHERE id_tipo_menu_local = ?";
		$this->db->query($sql, array($idTipoMenuLocal));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(30, $idLocal, $idTipoMenuLocal);
	}

	function borrarMenuLocalDia($idMenuDia) {

		//Obtengo el local
		$idLocal = $this->obtenerDatosMenuDia($idMenuDia)->row()->id_local;

		// Borrar los detalles de los menus creados con este tipo
		$sql = "DELETE FROM detalle_menu_local
				WHERE id_menu_local = ?";
		$this->db->query($sql, array($idMenuDia));

		// Borrar los menus creados con este tipo
		$sql = "DELETE FROM menu_local
				WHERE id_menu_local = ?";
		$this->db->query($sql, array($idMenuDia));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(32, $idLocal, $idMenuDia);

	}

	/*
	 * Funcion que modifica un plato de un local
	*/

	function modificarPlatoLocal($nombre, $precio, $idTipoPlato, $idPlatoLocal) {
		//Obtengo el local
		$idLocal = $this->obtenerPlatoLocal($idPlatoLocal)->row()->id_local;

		$sql = "UPDATE platos_local
				SET  nombre = ? , precio = ?, id_tipo_plato = ?
				WHERE id_plato_local = ?";

		$this->db->query($sql, array($nombre, $precio, $idTipoPlato,
				$idPlatoLocal));

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(33, $idLocal, $idPlatoLocal);
	}

	/*
	 * Funcion que modifica un tipo de menu de un local
	*/

	function modificarTipoMenuLocal($idTipoMenuLocal, $idTipoMenu, $nombreMenu
			, $precioMenu, $esCarta) {
		$sql = "UPDATE tipo_menu_local
				SET id_tipo_menu = ?, nombre_menu = ? , precio_menu = ?, es_carta = ?
				WHERE id_tipo_menu_local = ?";

		$this->db->query($sql, array($idTipoMenu, $nombreMenu, $precioMenu, $esCarta
				, $idTipoMenuLocal));

		$idLocal = $this->obtenerTipoMenuLocal($idTipoMenuLocal)->row()->id_local;

		//Se carga el modelo de alertas
		$this->load->model('alertas/Alertas_model');

		//Se inserta la alerta
		$this->Alertas_model->insertAlertaLocal
		(29, $idLocal, $idTipoMenuLocal);
	}

	/*
	 * Funcion que obtiene los datos de la tabla tipo_menu_local para un
	* id_tipo_menu_local
	*/

	function obtenerTipoMenuLocal($idTipoMenuLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT tml.* FROM tipo_menu_local tml
				WHERE id_tipo_menu_local = ?";

		$result = $this->db->query($sql, array($idTipoMenuLocal));

		return $result;
	}

	function obtenerPlatoLocal($idPlatoLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT pl.* FROM platos_local pl
				WHERE pl.id_plato_local = ?";

		$result = $this->db->query($sql, array($idPlatoLocal));

		return $result;
	}

	function comprobarPlatoMenu($idMenuLocal, $idPlatoLocal) {

		// Borrar plato del menu
		$sql = "SELECT * FROM detalle_menu_local
				WHERE id_menu_local = ?
				AND id_plato_local = ?";
		$result = $this->db->query($sql, array($idMenuLocal, $idPlatoLocal));

		return $result;
	}

	function comprobarNombreTipoMenu($idLocal, $nombreMenu) {
		$sql = "SELECT * FROM tipo_menu_local tml
				WHERE tml.id_local = ?
				AND tml.nombre_menu = ?";

		$result = $this->db->query($sql, array($idLocal, $nombreMenu));

		return $result;
	}

	function comprobarNombrePlato($idLocal, $nombrePlato) {
		$sql = "SELECT * FROM platos_local pl
				WHERE pl.id_local = ?
				AND pl.nombre = ?";

		$result = $this->db->query($sql, array($idLocal, $nombrePlato));

		return $result;
	}

	function comprobarTipoMenuLocal($idLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT tml.* FROM tipo_menu_local tml
				WHERE id_local = ?";

		$result = $this->db->query($sql, array($idLocal));

		return $result;
	}

	function comprobarNombreTipoMenuId($idLocal, $nombreMenu, $idTipoMenuLocal) {
		$sql = "SELECT * FROM tipo_menu_local tml
				WHERE tml.id_local = ?
				AND tml.nombre_menu = ?
				AND tml.id_tipo_menu_local <> ?";

		$result = $this->db->query($sql, array($idLocal, $nombreMenu, $idTipoMenuLocal));

		return $result;
	}

	function obtenerDatosMenu($idLocal, $fechaMenu, $idTipoMenuLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT * FROM menu_local ml
				WHERE id_local = ?
				AND fecha_menu = ?
				AND id_tipo_menu_local = ?";

		$result = $this->db->query($sql, array($idLocal, $fechaMenu
				, $idTipoMenuLocal));

		return $result;
	}

	function obtenerDatosMenuDia($idMenuLocal) {
		//Se obtienen los platos del local
		$sql = "SELECT * FROM menu_local ml
				WHERE id_menu_local = ?";

		$result = $this->db->query($sql, array($idMenuLocal));

		return $result;
	}

	function obtenerDatosDetalleMenu($idDetalleMenu) {
		//Se obtienen los platos del local
		$sql = "SELECT * FROM detalle_menu_local ml
				WHERE id_detalle_menu_local = ?";

		$result = $this->db->query($sql, array($idMenuLocal));

		return $result;
	}

	function obtenerDiasMenu($idLocal, $fechaInicio, $fechaFin) {
		//Se obtienen los platos del local
		$sql = "SELECT ml.*,tml.id_tipo_menu FROM menu_local ml, tipo_menu_local tml
				WHERE ml.id_tipo_menu_local = tml.id_tipo_menu_local
				AND ml.id_local = ?
				AND fecha_menu >= ?
				AND fecha_menu <= ?
				ORDER BY fecha_menu";

		$result = $this->db->query($sql, array($idLocal, $fechaInicio, $fechaFin));

		return $result;
	}

	function obtenerTiposMenu() {
		//Se obtienen los tipos de menu
		$sql = "SELECT * FROM tipo_menu tm
				ORDER BY id_tipo_menu";

		$result = $this->db->query($sql);

		return $result;
	}

	function obtenerTiposMenuObject() {
		//Se obtienen los tipos de menu
		$sql = "SELECT * FROM tipo_menu tm
				ORDER BY id_tipo_menu";

		$result = $this->db->query($sql)->result();
			
		$tiposMenu = array();
			
		foreach($result as $row){
			$tiposMenu[] = new TipoMenu($row->id_tipo_menu,$row->descripcion);
		}

		return $tiposMenu;
	}

	function obtenerTipoMenu($idTipoMenu) {
		//Se obtienen los tipos de menu
		$sql = "SELECT * FROM tipo_menu tm
				WHERE tm.id_tipo_menu = ?";

		$result = $this->db->query($sql, array($idTipoMenu));

		return $result;
	}

	function obtenerMenuDia($idLocal, $fechaMenu) {
		//Se obtiene el menu
		$sql = "SELECT ml.*,tm.descripcion, tml.*
				FROM menu_local ml, tipo_menu tm, tipo_menu_local tml
				WHERE tml.id_tipo_menu = tm.id_tipo_menu
				AND ml.id_tipo_menu_local = tml.id_tipo_menu_local
				AND ml.id_local = ?
				AND fecha_menu = ?
				ORDER BY es_carta";

		$result = $this->db->query($sql, array($idLocal
				, $fechaMenu->format('Y-m-d')))->result();

		//Se obtiene el detalle del menu
		$sql = "SELECT dml.*,pl.*, tp.descripcion tipo_plato FROM detalle_menu_local dml
				, platos_local pl,tipos_plato tp
				WHERE dml.id_plato_local = pl.id_plato_local
				AND pl.id_tipo_plato = tp.id_tipo_plato
				AND id_menu_local = ?
				ORDER BY pl.id_tipo_plato, dml.id_detalle_menu_local";

		$menuSalida = array();
		$hayMenu = false;

		foreach ($result as $menu) {

			$detalleMenu = array();
			$menuTipo = array();
			$platosMenu = $this->db->query($sql, array($menu->id_menu_local))->result();

			foreach ($platosMenu as $platoMenu) {
				$detallePlato = array(
						"idDetalleMenuLocal" => $platoMenu->id_detalle_menu_local,
						"idPlatoLocal" => $platoMenu->id_plato_local,
						"disponible" => $platoMenu->disponible,
						"nombrePlato" => $platoMenu->nombre,
						"idTipoPlato" => $platoMenu->id_tipo_plato,
						"tipoPlato" => $platoMenu->tipo_plato,
						"precioPlato" => $platoMenu->precio
				);

				$detalleMenu[] = $detallePlato;
			}

			$menuTipo = array(
					"idMenuLocal" => $menu->id_menu_local,
					"idLocal" => $menu->id_local,
					"fechaMenu" => $menu->fecha_menu,
					"precioMenu" => $menu->precio_menu,
					"idTipoMenu" => $menu->id_tipo_menu,
					"idTipoMenuLocal" => $menu->id_tipo_menu_local,
					"tipo_menu" => $menu->descripcion,
					"nombreMenu" => $menu->nombre_menu,
					"esCarta" => $menu->es_carta,
					"detalleMenu" => $detalleMenu
			);

			$menuSalida[] = $menuTipo;
		}
		return $menuSalida;
	}

	function obtenerMenusDiaLocalObject(){
		//Se obtienen los menus diarios del local (desde hace una semana)
		$sql ="SELECT * FROM menu_local
				WHERE fecha_menu >= SYSDATE() - INTERVAL 7 DAY";

		$result = $this->db->query($sql)->result();

		$menusDia = array();

		foreach ($result as $row){
			$menusDia[] = MenuDia::withID($row->id_menu_local);
		}

		return $menusDia;
	}

	function obtenerPlatosMenuDiaObject($idMenuDia){
		//Se obtiene el detalle del menu
		$sql = "SELECT pl.* FROM detalle_menu_local dml
				, platos_local pl
				WHERE dml.id_plato_local = pl.id_plato_local
				AND id_menu_local = ?
				ORDER BY pl.id_tipo_plato, dml.id_detalle_menu_local";

		$result = $this->db->query($sql, array($idMenuDia))->result();

		$platos = array();

		foreach ($result as $row){
			$platos[] = Plato::withID($row->id_plato_local);
		}

		return $platos;
	}

	function obtenerMenuTipoDia($idLocal, $fechaMenu, $idTipoMenu) {
		//Se obtiene el menu
		$sql = "SELECT ml.*,tm.descripcion, tml.*
				FROM menu_local ml, tipo_menu tm, tipo_menu_local tml
				WHERE tml.id_tipo_menu = tm.id_tipo_menu
				AND ml.id_tipo_menu_local = tml.id_tipo_menu_local
				AND ml.id_local = ?
				AND fecha_menu = ?
				AND tml.id_tipo_menu = ?";

		$result = $this->db->query($sql, array($idLocal
				, $fechaMenu->format('Y-m-d'), $idTipoMenu))->result();

		//Se obtiene el detalle del menu
		$sql = "SELECT dml.*,pl.*, tp.descripcion tipo_plato FROM detalle_menu_local dml
				, platos_local pl,tipos_plato tp
				WHERE dml.id_plato_local = pl.id_plato_local
				AND pl.id_tipo_plato = tp.id_tipo_plato
				AND id_menu_local = ?
				ORDER BY pl.id_tipo_plato, dml.id_detalle_menu_local";

		$menuSalida = array();
		$hayMenu = false;

		foreach ($result as $menu) {
			$hayMenu = true;
			$detalleMenu = array();
			$menuTipo = array();
			$platosMenu = $this->db->query($sql, array($menu->id_menu_local))->result();

			foreach ($platosMenu as $platoMenu) {
				$detallePlato = array(
						"idDetalleMenuLocal" => $platoMenu->id_detalle_menu_local,
						"idPlatoLocal" => $platoMenu->id_plato_local,
						"disponible" => $platoMenu->disponible,
						"nombrePlato" => $platoMenu->nombre,
						"idTipoPlato" => $platoMenu->id_tipo_plato,
						"tipoPlato" => $platoMenu->tipo_plato,
						"precioPlato" => $platoMenu->precio
				);

				$detalleMenu[] = $detallePlato;
			}

			$menuTipo = array(
					"idMenuLocal" => $menu->id_menu_local,
					"idLocal" => $menu->id_local,
					"fechaMenu" => $menu->fecha_menu,
					"precioMenu" => $menu->precio_menu,
					"idTipoMenu" => $menu->id_tipo_menu,
					"tipoMenu" => $menu->descripcion,
					"nombreMenu" => $menu->nombre_menu,
					"esCarta" => $menu->es_carta,
					"detalleMenu" => $detalleMenu
			);

			$menuSalida[] = $menuTipo;
		}

		if (!$hayMenu) {

			//Se obtiene la decripcion del tipo de menu
			$tipoMenu = $this->obtenerTipoMenu($idTipoMenu)->row()->descripcion;

			$menuSalida[] = array("idTipoMenu" => $idTipoMenu
					, "fechaMenu" => $fechaMenu->format('Y-m-d'),
					"tipoMenu" => $tipoMenu);
		}

		return $menuSalida;
	}

	function obtenerCartaDia($idLocal) {
		//Se obtiene el menu
		$sql = "SELECT ml.*,tm.descripcion, tml.*
				FROM menu_local ml, tipo_menu tm, tipo_menu_local tml
				WHERE tml.id_tipo_menu = tm.id_tipo_menu
				AND ml.id_tipo_menu_local = tml.id_tipo_menu_local
				AND ml.id_local = ?
				AND fecha_menu = ?
				AND es_carta = ?";

		$result = $this->db->query($sql, array($idLocal
				, $fechaMenu->format('Y-m-d'), 1))->result();

		//Se obtiene el detalle del menu
		$sql = "SELECT dml.*,pl.*, tp.descripcion tipo_plato FROM detalle_menu_local dml
				, platos_local pl,tipos_plato tp
				WHERE dml.id_plato_local = pl.id_plato_local
				AND pl.id_tipo_plato = tp.id_tipo_plato
				AND id_menu_local = ?
				ORDER BY pl.id_tipo_plato, dml.id_detalle_menu_local";

		$menuSalida = array();
		$hayMenu = false;

		foreach ($result as $menu) {

			$detalleMenu = array();
			$menuTipo = array();
			$platosMenu = $this->db->query($sql, array($menu->id_menu_local))->result();

			foreach ($platosMenu as $platoMenu) {
				$detallePlato = array(
						"idDetalleMenuLocal" => $platoMenu->id_detalle_menu_local,
						"idPlatoLocal" => $platoMenu->id_plato_local,
						"disponible" => $platoMenu->disponible,
						"nombrePlato" => $platoMenu->nombre,
						"idTipoPlato" => $platoMenu->id_tipo_plato,
						"precioPlato" => $platoMenu->precio
				);

				$detalleMenu[] = $detallePlato;
			}

			$menuTipo = array(
					"idMenuLocal" => $menu->id_menu_local,
					"idLocal" => $menu->id_local,
					"fechaMenu" => $menu->fecha_menu,
					"precioMenu" => $menu->precio_menu,
					"idTipoMenu" => $menu->id_tipo_menu,
					"idTipoMenuLocal" => $menu->id_tipo_menu_local,
					"tipo_menu" => $menu->descripcion,
					"nombreMenu" => $menu->nombre_menu,
					"esCarta" => $menu->es_carta,
					"detalleMenu" => $detalleMenu
			);

			$menuSalida[] = $menuTipo;
		}
		return $menuSalida;
	}

	public function generarCalendario($idLocal, $mes = 0, $ano = 0) {

		if ($mes == 0 || $ano == 0) {
			$ano = date("Y");
			$mes = date("m");
		}

		$mesSiguiente = $mes + 1;
		$anoSiguiente = $ano;
		$mesAnterior = $mes - 1;
		$anoAnterior = $ano;

		if ($mes == 12) {
			$mesSiguiente = 1;
			$anoSiguiente = $ano + 1;
		}

		if ($mes == 1) {
			$mesAnterior = 12;
			$anoAnterior = $ano - 1;
		}

		$prefs = array(
				'start_day' => 'monday',
				'month_type' => 'long',
				'day_type' => 'short',
				'show_next_prev' => TRUE,
				'next_url' => "doAjax('" . site_url() . "/menus/mostrarCalendarioMenu','mes=" .
				$mesSiguiente . "&ano=" . $anoSiguiente . "','actualizarCalendarioMenu','post',1)",
				'prev_url' => "doAjax('" . site_url() . "/menus/mostrarCalendarioMenu','mes=" .
				$mesAnterior . "&ano=" . $anoAnterior . "','actualizarCalendarioMenu','post',1)"
		);

		//{cal_cell_content}<a onclick="{content}">{day}</a><a onclick="{enlaceDesayuno}"><img src="{imagenDesayuno}"></a><a onclick="{enlaceComida}"><img src="{imagenComida}"></a><a onclick="{enlaceCena}"><img src="{imagenCena}"></a><a onclick="{enlaceCarta}"><img src="{imagenCarta}"></a>{/cal_cell_content}
		//<a onclick="{enlaceCarta}"><img src="{imagenCarta}"></a>

		$prefs['template'] = '
		{table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

		{heading_row_start}<tr>{/heading_row_start}

		{heading_previous_cell}<th class="mesAno"><a onclick="{previous_url}"><span class="glyphicon glyphicon-arrow-left flechasMes"></span></a></th>{/heading_previous_cell}
		{heading_title_cell}<th colspan="{colspan}" class="mesAno">{heading}</th>{/heading_title_cell}
		{heading_next_cell}<th class="mesAno"><a onclick="{next_url}"><span class="glyphicon glyphicon-arrow-right flechasMes"></span></a></th>{/heading_next_cell}

		{heading_row_end}</tr>{/heading_row_end}

		{week_row_start}<tr>{/week_row_start}
		{week_day_cell}<td class="diaSemana">{week_day}</td>{/week_day_cell}
		{week_row_end}</tr>{/week_row_end}

		{cal_row_start}<tr>{/cal_row_start}
		{cal_cell_start}<td class="col-md-1 cuadroDia">{/cal_cell_start}

		{cal_cell_content}<div class="row numeroDia">{day}</div><div class="row"><div class="col-md-4"><a onclick="{enlaceDesayuno}">{imagenDesayuno}</a></div><div class="col-md-4"><a onclick="{enlaceComida}">{imagenComida}</a></div><div class="col-md-4"><a onclick="{enlaceCena}">{imagenCena}</a></div></div>{/cal_cell_content}
		{cal_cell_content_today}<div class="row numeroDia">{day}</div><div class="row"><div class="col-md-4"><a onclick="{enlaceDesayuno}">{imagenDesayuno}</a></div><div class="col-md-4"><a onclick="{enlaceComida}">{imagenComida}</a></div><div class="col-md-4"><a onclick="{enlaceCena}">{imagenCena}</a></div></div>{/cal_cell_content_today}

		{cal_cell_no_content}{day}{/cal_cell_no_content}
		{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

		{cal_cell_blank}&nbsp;{/cal_cell_blank}

		{cal_cell_end}</td>{/cal_cell_end}
		{cal_row_end}</tr>{/cal_row_end}

		{table_close}</table>{/table_close}
				';

		$this->load->library('calendar', $prefs);

		$this->load->library('gestionfechas');
		$numDiasMes = $this->gestionfechas->ultimoDia($ano, $mes);

		$fechaInicio = $ano . "-" . $mes . "-01";
		$fechaFin = $ano . "-" . $mes . "-" . $numDiasMes;

		$fechasMenu = $this->Menus_model->obtenerDiasMenu($idLocal, $fechaInicio, $fechaFin)->result();

		$dias = array();
		$imagenDesayuno = array();
		$imagenComida = array();
		$imagenCena = array();
		$enlaceDesayuno = array();

		for ($i = 1; $i <= $numDiasMes; $i++) {
			$hayMenuDesayuno = false;
			$hayMenuComida = false;
			$hayMenuCena = false;
			//Se crean los enlaces
			$dias[$i] = "doAjax('" . site_url() . "/menus/obtenerMenuDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "','mostrarMenu','post',1)";
			$enlaceDesayuno[$i] = "doAjax('" . site_url() . "/menus/obtenerMenuTipoDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&tipoMenu=1','mostrarMenu','post',1)";
			$enlaceComida[$i] = "doAjax('" . site_url() . "/menus/obtenerMenuTipoDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&tipoMenu=2','mostrarMenu','post',1)";
			$enlaceCena[$i] = "doAjax('" . site_url() . "/menus/obtenerMenuTipoDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&tipoMenu=3','mostrarMenu','post',1)";
			foreach ($fechasMenu as $datos) {
				$date = DateTime::createFromFormat('Y-m-d', $datos->fecha_menu);
				if ($date->format("d") == $i) {
					/* Se comprueba si el menu es desayuno,comida o cena para
					 asignar la imagen */
					if ($datos->id_tipo_menu == 1) {
						$hayMenuDesayuno = true;
					} else if ($datos->id_tipo_menu == 2) {
						$hayMenuComida = true;
					} else if ($datos->id_tipo_menu == 3) {
						$hayMenuCena = true;
					} else {
						$hayCarta = true;
					}
				}
			}
			$imagenDesayuno[$i] =  "<i class=\"fa fa-coffee fa-fw colorDesactivo\"></i>";//"img/dialogerror.png";
			$imagenComida[$i] = "<i class=\"fa fa-cutlery fa-fw colorDesactivo\"></i>";//"img/dialogerror.png";
			$imagenCena[$i] = "<i class=\"fa fa-moon-o colorDesactivo\"></i>";
			/*
			 * En el caso de haber menu se asigna la imagen
			*/
			if ($hayMenuDesayuno) {
				$imagenDesayuno[$i] = "<i class=\"fa fa-coffee fa-fw colorActivo\"></i>";
			}
			if ($hayMenuComida) {
				$imagenComida[$i] = "<i class=\"fa fa-cutlery fa-fw colorActivo\"></i>";
			}
			if ($hayMenuCena) {
				$imagenCena[$i] = "<i class=\"fa fa-moon-o fa-fw colorActivo\"></i>";
			}
		}

		$data['dias'] = $dias;
		$data['imagenDesayuno'] = $imagenDesayuno;
		$data['imagenComida'] = $imagenComida;
		$data['imagenCena'] = $imagenCena;
		$data['enlaceDesayuno'] = $enlaceDesayuno;
		$data['enlaceComida'] = $enlaceComida;
		$data['enlaceCena'] = $enlaceCena;

		$calendario = $this->calendar->generate($ano, $mes, $data);

		return $calendario;
	}

	public function generarCalendarioUsuario($idLocal, $mes = 0, $ano = 0) {

		if ($mes == 0 || $ano == 0) {
			$ano = date("Y");
			$mes = date("m");
		}

		$mesSiguiente = $mes + 1;
		$anoSiguiente = $ano;
		$mesAnterior = $mes - 1;
		$anoAnterior = $ano;

		if ($mes == 12) {
			$mesSiguiente = 1;
			$anoSiguiente = $ano + 1;
		}

		if ($mes == 1) {
			$mesAnterior = 12;
			$anoAnterior = $ano - 1;
		}

		$prefs = array(
				'start_day' => 'monday',
				'month_type' => 'long',
				'day_type' => 'short',
				'show_next_prev' => TRUE,
				'next_url' => "doAjax('" . site_url() . "/menus/mostrarCalendarioMenuUsuario','mes=" .
				$mesSiguiente . "&ano=" . $anoSiguiente . "&idLocal=" . $idLocal
				. "','actualizarCalendarioMenuUsuario','post',1)",
				'prev_url' => "doAjax('" . site_url() . "/menus/mostrarCalendarioMenuUsuario','mes=" .
				$mesAnterior . "&ano=" . $anoAnterior . "&idLocal=" . $idLocal
				. "','actualizarCalendarioMenuUsuario','post',1)"
		);

		$prefs['template'] = '
		{table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

		{heading_row_start}<tr>{/heading_row_start}

		{heading_previous_cell}<th class="mesAno"><a onclick="{previous_url}"><span class="glyphicon glyphicon-arrow-left flechasMes"></span></a></th>{/heading_previous_cell}
		{heading_title_cell}<th colspan="{colspan}" class="mesAno">{heading}</th>{/heading_title_cell}
		{heading_next_cell}<th class="mesAno"><a onclick="{next_url}"><span class="glyphicon glyphicon-arrow-right flechasMes"></span></a></th>{/heading_next_cell}

		{heading_row_end}</tr>{/heading_row_end}

		{week_row_start}<tr>{/week_row_start}
		{week_day_cell}<td>{week_day}</td>{/week_day_cell}
		{week_row_end}</tr>{/week_row_end}

		{cal_row_start}<tr>{/cal_row_start}
		{cal_cell_start}<td class="col-md-1 cuadroDia">{/cal_cell_start}

		{cal_cell_content}<div class="row numeroDia">{day}</div><div class="row"><div class="col-md-4"><a onclick="{enlaceDesayuno}">{imagenDesayuno}</a></div><div class="col-md-4"><a onclick="{enlaceComida}">{imagenComida}</a></div><div class="col-md-4"><a onclick="{enlaceCena}">{imagenCena}</a></div></div>{/cal_cell_content}
		{cal_cell_content_today}<div class="row numeroDia">{day}</div><div class="row"><div class="col-md-4"><a onclick="{enlaceDesayuno}">{imagenDesayuno}</a></div><div class="col-md-4"><a onclick="{enlaceComida}">{imagenComida}</a></div><div class="col-md-4"><a onclick="{enlaceCena}">{imagenCena}</a></div></div>{/cal_cell_content_today}

		{cal_cell_no_content}{day}{/cal_cell_no_content}
		{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

		{cal_cell_blank}&nbsp;{/cal_cell_blank}

		{cal_cell_end}</td>{/cal_cell_end}
		{cal_row_end}</tr>{/cal_row_end}

		{table_close}</table>{/table_close}
				';

		//Se carga la libreria que genera el calendario de menus para usuarios.
		$this->load->library('usermenucalendar', $prefs);

		$this->load->library('gestionfechas');
		$numDiasMes = $this->gestionfechas->ultimoDia($ano, $mes);

		$fechaInicio = $ano . "-" . $mes . "-01";
		$fechaFin = $ano . "-" . $mes . "-" . $numDiasMes;

		$fechasMenu = $this->Menus_model->obtenerDiasMenu($idLocal, $fechaInicio, $fechaFin)->result();

		$dias = array();
		$imagenDesayuno = array();
		$imagenComida = array();
		$imagenCena = array();
		$enlaceDesayuno = array();

		for ($i = 1; $i <= $numDiasMes; $i++) {
			$hayMenuDesayuno = false;
			$hayMenuComida = false;
			$hayMenuCena = false;
			//Se crean los enlaces
			$dias[$i] = "doAjax('" . site_url() . "/menus/obtenerMenuDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&idLocal=" . $idLocal . "','mostrarMenu','post',1)";
			$enlaceDesayuno[$i] = "doAjax('" . site_url() . "/menus/obtenerMenuTipoDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&tipoMenu=1"
					. "&idLocal=" . $idLocal . "','mostrarMenuUsuario','post',1)";
			$enlaceComida[$i] = "doAjax('" . site_url() . "/menus/obtenerMenuTipoDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&tipoMenu=2"
					. "&idLocal=" . $idLocal . "','mostrarMenuUsuario','post',1)";
			$enlaceCena[$i] = "doAjax('" . site_url() . "/menus/obtenerMenuTipoDia','dia=" . $i
			. "&mes=" . $mes . "&ano=" . $ano . "&tipoMenu=3"
					. "&idLocal=" . $idLocal . "','mostrarMenuUsuario','post',1)";
			foreach ($fechasMenu as $datos) {
				$date = DateTime::createFromFormat('Y-m-d', $datos->fecha_menu);
				if ($date->format("d") == $i) {
					/* Se comprueba si el menu es desayuno,comida o cena para
					 asignar la imagen */
					if ($datos->id_tipo_menu == 1) {
						$hayMenuDesayuno = true;
					} else if ($datos->id_tipo_menu == 2) {
						$hayMenuComida = true;
					} else if ($datos->id_tipo_menu == 3) {
						$hayMenuCena = true;
					}
				}
			}
			$imagenDesayuno[$i] = "<i class=\"fa fa-coffee fa-fw colorDesactivo\"></i>";//"img/dialogerror.png";
			$imagenComida[$i] = "<i class=\"fa fa-cutlery fa-fw colorDesactivo\"></i>";//"img/dialogerror.png";
			$imagenCena[$i] = "<i class=\"fa fa-moon-o fa-fw colorDesactivo\"></i>";//"img/dialogerror.png";
			/*
			 * En el caso de haber menu se asigna la imagen
			*/
			if ($hayMenuDesayuno) {
				$imagenDesayuno[$i] = "<i class=\"fa fa-coffee fa-fw colorActivo\"></i>";
			}
			if ($hayMenuComida) {
				$imagenComida[$i] = "<i class=\"fa fa-cutlery fa-fw colorActivo\"></i>";
			}
			if ($hayMenuCena) {
				$imagenCena[$i] = "<i class=\"fa fa-moon-o fa-fw colorActivo\"></i>";
			}
		}

		$data['dias'] = $dias;
		$data['imagenDesayuno'] = $imagenDesayuno;
		$data['imagenComida'] = $imagenComida;
		$data['imagenCena'] = $imagenCena;
		$data['enlaceDesayuno'] = $enlaceDesayuno;
		$data['enlaceComida'] = $enlaceComida;
		$data['enlaceCena'] = $enlaceCena;

		$calendario = $this->usermenucalendar->generate($ano, $mes, $data);

		return $calendario;
	}

	function comprobarMenuEnDia($idLocal, $idMenu, $fecha) {
		$sql = "SELECT ml.*,tm.descripcion, tml.*
				FROM menu_local ml, tipo_menu tm, tipo_menu_local tml
				WHERE tml.id_tipo_menu = tm.id_tipo_menu
				AND ml.id_tipo_menu_local = tml.id_tipo_menu_local
				AND ml.id_local = ?
				AND ml.fecha_menu = ?
				AND tml.id_tipo_menu_local = ?
				ORDER BY es_carta";

		$result = $this->db->query($sql, array($idLocal, $fecha,$idMenu));

		return $result;
	}

}
