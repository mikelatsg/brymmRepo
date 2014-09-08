<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/constantes/Code.php';
require_once APPPATH . '/libraries/menus/plato.php';
require_once APPPATH . '/libraries/menus/tipoPlato.php';
require_once APPPATH . '/libraries/menus/menu.php';
require_once APPPATH . '/libraries/menus/menuDia.php';

class Menus extends REST_Controller {

	//Datos recibidos
	const FIELD_FECHA = "fecha";
	const FIELD_ID_LOCAL = "idLocal";
	const FIELD_ID_TIPO_MENU = "idTipoMenu";
	const JSON_MENUS = "menus";

	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de usuarios
		$this->load->model('menus/Menus_model');
	}

	function obtenerMenu_get() {

		if (!$this->get(Menus::FIELD_FECHA) ||
		!$this->get(Menus::FIELD_ID_LOCAL) ||
		!$this->get(Menus::FIELD_ID_TIPO_MENU)) {
			$msg = "Error obteniendo menus";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_KO);
		}

		$idLocal = $this->get(Menus::FIELD_ID_LOCAL);
		$fecha = $this->get(Menus::FIELD_FECHA);
		$idTipoMenu = $this->get(Menus::FIELD_ID_TIPO_MENU);

		if ($fecha == Code::NO_DATA) {
			$msg = "El campo fecha no puede estar vacio";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		list($dia, $mes, $ano) = explode('-', $fecha);
		$fechaMenu = $ano . '-'
				. $mes . '-' . $dia;

		$menus = $this->Menus_model->obtenerMenuTipoDia($idLocal
				, DateTime::createFromFormat('Y-m-d', $fechaMenu), $idTipoMenu);

		$msg = "Datos recogidos correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK
				, Code::JSON_MENSAJE => $msg
				, Menus::JSON_MENUS => $menus);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function asignarPlatoMenu_post(){
		//Se recogen los datos recibidos en formato json
		$datosPlato = $this->post();

		if (!isset($datosPlato[MenuDia::FIELD_ID_MENU_DIA]) ||
		!isset($datosPlato[Plato::FIELD_ID_PLATO])) {
			$msg = "Error aÃ±adiendo plato a menu";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados por el formulario
		$idMenuDia = $datosPlato[MenuDia::FIELD_ID_MENU_DIA];
		$idPlato = $datosPlato[Plato::FIELD_ID_PLATO];

		$hayError = false;
		$msg = "Plato aÃ±adido correctamente";

		//Se comprueba si ya existe el plato en el menu
		$existePlatoMenu = $this->Menus_model->comprobarPlatoMenu($idMenuDia
				, $idPlato)->num_rows();

		if (!$existePlatoMenu > 0) {
			//Se inserta el plato en el menu
			$this->Menus_model->insertPlatoMenu($idMenuDia, $idPlato
					, "S");

			$menuDia = MenuDia::withID($idMenuDia);

		} else {
			$msg = "El plato ya existe en el menu";
			$hayError = true;
		}

		if ($hayError){
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					MenuDia::FIELD_MENU_DIA=> $menuDia);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function desasignarPlatoMenu_post(){
		//Se recogen los datos recibidos en formato json
		$datosPlato = $this->post();

		if (!isset($datosPlato[MenuDia::FIELD_ID_MENU_DIA]) ||
		!isset($datosPlato[Plato::FIELD_ID_PLATO])) {
			$msg = "Error aÃ±adiendo plato a menu";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados por el formulario
		$idMenuDia = $datosPlato[MenuDia::FIELD_ID_MENU_DIA];
		$idPlato = $datosPlato[Plato::FIELD_ID_PLATO];

		$hayError = false;
		$msg = "Plato borrado correctamente";

		//Se borra el plato del menu ( si es el ultimo plato se borra el menu del dia)
		$menuDiaBorrado = $this->Menus_model->borrarPlatoMenu2($idMenuDia,$idPlato);

		if (!$menuDiaBorrado){
			$menuDia = MenuDia::withID($idMenuDia);
		}else{
			$menuDia = null;
		}

		if ($hayError){
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					MenuDia::FIELD_MENU_DIA=> $menuDia);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function modificarPlato_post() {
		//Se recogen los datos recibidos en formato json
		$datosPlato = $this->post();

		//Se recogen los parametros enviados por el formulario
		$nombre = $datosPlato[Plato::FIELD_PLATO][Plato::FIELD_NOMBRE];
		$idTipoPlato = $datosPlato[Plato::FIELD_PLATO][TipoPlato::FIELD_TIPO_PLATO][TipoPlato::FIELD_ID_TIPO_PLATO];
		$precio = $datosPlato[Plato::FIELD_PLATO][Plato::FIELD_PRECIO];
		$idPlatoLocal = $datosPlato[Plato::FIELD_PLATO][Plato::FIELD_ID_PLATO];
		$idLocal = $datosPlato[Code::FIELD_ID_LOCAL];
		$hayError = false;

		$msg = "Plato modificado correctamente";

		if (!$nombre == "") {

			if (is_numeric($precio) && $precio > 0) {

				//Se comprueba si existe un plato con este nombre
				$datosPlato = $this->Menus_model->comprobarNombrePlato($idLocal
						, $nombre);

				if ($datosPlato->num_rows() > 1) {
					$msg = "Ya existe un plato con este nombre";
					$hayError = true;
				} else {
					if (!$datosPlato->num_rows()) {
						//Se modifica la linea en la tabla
						$this->Menus_model->modificarPlatoLocal($nombre
								, $precio, $idTipoPlato, $idPlatoLocal);
					} else {
						if ($datosPlato->row()->id_plato_local == $idPlatoLocal) {
							//Se modifica la linea en la tabla
							$this->Menus_model->modificarPlatoLocal($nombre
									, $precio, $idTipoPlato, $idPlatoLocal);
						} else {
							$msg = "Ya existe un plato con este nombre";
							$hayError = true;
						}
					}
				}
			} else {
				$msg = "El valor del precio es incorrecto";
				$hayError = true;
			}
		} else {
			$msg = "Hay que indicar un nombre para el plato";
			$hayError = true;
		}

		if ($hayError){
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}else{
			$plato = Plato::withID($idPlatoLocal);

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Plato::FIELD_PLATO => $plato);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarPlato_post() {

		//Se recogen los datos recibidos en formato json
		$datosPlato = $this->post();

		if (!isset($datosPlato[Plato::FIELD_ID_PLATO]) ) {
			$msg = "Error borrando plato";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados por el formulario
		$idPlatoLocal = $datosPlato[Plato::FIELD_ID_PLATO];
		$idLocal = $datosPlato[Code::FIELD_ID_LOCAL];

		//Se borra el plato del local
		$this->Menus_model->borrarPlatoLocal($idLocal
				, $idPlatoLocal);

		$msg = "Plato borrado correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg);

		$this->response($datosRespuesta, Code::CODE_OK);

	}

	public function nuevoMenu_post() {
		//Se recogen los datos recibidos en formato json
		$datosMenu = $this->post();

		//Se recogen los parametros enviados por el formulario
		$nombreMenu = $datosMenu[Menu::FIELD_MENU][Menu::FIELD_NOMBRE];
		$idTipoMenu = $datosMenu[Menu::FIELD_MENU][TipoMenu::FIELD_TIPO_MENU][TipoMenu::FIELD_ID_TIPO_MENU];
		$precioMenu = $datosMenu[Menu::FIELD_MENU][Menu::FIELD_PRECIO];
		$esCarta = $datosMenu[Menu::FIELD_MENU][Menu::FIELD_CARTA];
		$idLocal = $datosMenu[Code::FIELD_ID_LOCAL];
		$hayError = false;


		//El nombre tiene que estar informado
		if (!$nombreMenu == "") {
			// Si es un menu el precio tiene que estar informado
			if (!$precioMenu == "" || $esCarta == true) {
				//Se comprueba si el valor del precio es numerico
				if (is_numeric($precioMenu)) {
					/*
					 * Se comprueba si el nombre existe en otro menu
					*/
					$existeMenu = $this->Menus_model->comprobarNombreTipoMenu($idLocal
							, $nombreMenu)->num_rows();
					if ($existeMenu) {
						$msg = "Existe otro menu con el mismo nombre";
						$hayError = true;
					} else {

						$idMenu = $this->Menus_model->insertTipoMenuLocal($idLocal, $idTipoMenu
								, $nombreMenu, $precioMenu, $esCarta);

						$msg = "Menu insertado correctamente";
					}
				} else {
					$msg = "El valor del precio es incorrecto";
					$hayError = true;
				}
			} else {
				$msg = "Hay que indicar el precio para los menus";
				$hayError = true;
			}
		}else{
			$msg = "El nombre del menu no puede estar vacio";
			$hayError = true;
		}

		if ($hayError){
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}else{
			$menu = Menu::withID($idMenu);

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Menu::FIELD_MENU => $menu);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	public function modificarMenu_post() {
		//Se recogen los datos recibidos en formato json
		$datosMenu = $this->post();

		//Se recogen los parametros enviados por el formulario
		$nombreMenu = $datosMenu[Menu::FIELD_MENU][Menu::FIELD_NOMBRE];
		$idTipoMenu = $datosMenu[Menu::FIELD_MENU][TipoMenu::FIELD_TIPO_MENU][TipoMenu::FIELD_ID_TIPO_MENU];
		$precioMenu = $datosMenu[Menu::FIELD_MENU][Menu::FIELD_PRECIO];
		$esCarta = $datosMenu[Menu::FIELD_MENU][Menu::FIELD_CARTA];
		$idLocal = $datosMenu[Code::FIELD_ID_LOCAL];
		$idMenu = $datosMenu[Menu::FIELD_MENU][Menu::FIELD_ID_MENU];
		$hayError = false;
			
		//El nombre tiene que estar informado
		if (!$nombreMenu == "") {
			// Si es un menu el precio tiene que estar informado
			if (!$precioMenu == "" || $esCarta == true) {
				//Se comprueba si el valor del precio es numerico
				if (is_numeric($precioMenu)) {
					/*
					 * Se comprueba si al cambiar el nombre existe otro menu con el
					* nuevo nombre
					*/
					$existeMenu = $this->Menus_model->comprobarNombreTipoMenuId($idLocal
							, $nombreMenu, $idMenu)->num_rows();
					if ($existeMenu) {
						$msg = "Existe otro menu con el mismo nombre";
						$hayError = true;
					} else {

						$this->Menus_model->modificarTipoMenuLocal($idMenu, $idTipoMenu
								, $nombreMenu, $precioMenu, $esCarta);

						$msg = "Menu modificado correctamente";
					}
				} else {
					$msg = "El valor del precio es incorrecto";
					$hayError = true;
				}
			} else {
				$msg = "Hay que indicar el precio para los menus";
				$hayError = true;
			}
		}else{
			$msg = "El nombre del menu no puede estar vacio";
			$hayError = true;
		}

		if ($hayError){
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}else{
			$menu = Menu::withID($idMenu);

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Menu::FIELD_MENU => $menu);
		}

		$this->response($datosRespuesta, Code::CODE_OK);

	}

	public function borrarMenu_post() {

		//Se recogen los datos recibidos en formato json
		$datosMenu = $this->post();

		if (!isset($datosMenu[Menu::FIELD_ID_MENU]) ) {
			$msg = "Error borrando menu";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		//Se recogen los parametros enviados por el formulario
		$idMenu = $datosMenu[Menu::FIELD_ID_MENU];
		$idLocal = $datosMenu[Code::FIELD_ID_LOCAL];

		//Se borra el plato del menu
		$this->Menus_model->borrarTipoMenuLocal($idMenu);

		$msg = "Menu borrado correctamente";

		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg);

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function anadirMenuDia_post(){
		//Se recogen los datos recibidos en formato json		
		$datosMenu = $this->post();					
		
		if (!isset($datosMenu[Menu::FIELD_ID_MENU]) ||
		!isset($datosMenu[MenuDia::FIELD_FECHA]) || !isset($datosMenu[Code::FIELD_ID_LOCAL])) {			
			$msg = "Error añadiendo el menu al dia";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}	
		
		//Se recogen los parametros enviados
		$idMenu = $datosMenu[Menu::FIELD_ID_MENU];
		$fechaMenu = $datosMenu[MenuDia::FIELD_FECHA];
		$idLocal = $datosMenu[Code::FIELD_ID_LOCAL];			

		$hayError = false;
		$msg = "Menu añadido correctamente";

		//Se comprueba si ya existe el menu en el dia
		$existeMenuEnDia = $this->Menus_model->comprobarMenuEnDia($idLocal, $idMenu, 
				 $fechaMenu)->num_rows();

		if (!$existeMenuEnDia > 0) {
			//Se inserta el plato en el menu
			$idMenuDia = $this->Menus_model->insertMenu($idLocal, DateTime::createFromFormat('Y-m-d', $fechaMenu)
					, "S", $idMenu);

			$menuDia = MenuDia::withID($idMenuDia);

		} else {
			$msg = "El menu ya existe el dia indicado";
			$hayError = true;
		}

		if ($hayError){
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}else{
			$msg = "Menu anadido correctamente";
			
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					MenuDia::FIELD_MENU_DIA=> $menuDia);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	public function borrarMenuDia_post() {
	
		//Se recogen los datos recibidos en formato json
		$datosMenu = $this->post();
	
		if (!isset($datosMenu[MenuDia::FIELD_ID_MENU_DIA]) ) {
			$msg = "Error borrando menu del dia";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO
					, Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}
	
		//Se recogen los parametros 
		$idMenuDia = $datosMenu[MenuDia::FIELD_ID_MENU_DIA];
		$idLocal = $datosMenu[Code::FIELD_ID_LOCAL];
	
		//Se borra el menu del dia indicado
		$this->Menus_model->borrarMenuLocalDia($idMenuDia);
	
		$msg = "Menu borrado del dia correctamente";
	
		$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
				Code::JSON_MENSAJE => $msg);
	
		$this->response($datosRespuesta, Code::CODE_OK);
	}
}
