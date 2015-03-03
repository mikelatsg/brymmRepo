<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
        //Se carga el modelo de locales
        $this->load->model('locales/Locales_model');
        //Se carga el modelo de menus
        $this->load->model('menus/Menus_model');
        //Se carga el modelo de sessiones
        $this->load->model('sesiones/Sesiones_model');
    }

    function menusLocal() {
    	
    	//Compruebo si esta activas las comandas
    	$this->load->model('servicios/Servicios_model');
    	
    	$servicios = $this->Servicios_model->obtenerServiciosLocalObject($_SESSION['idLocal']);
    	
    	$existeMenus = false;
    	$menusActivos = false;
    	foreach ($servicios as $servicio){
    		if ($servicio->tipoServicio->idTipoServicio == 4){
    			$existeMenus = true;
    			if ($servicio->activo){
    				$menusActivos = true;
    			}
    		}
    	}
    	
    	if (!$existeMenus){
    		$this->load->library('session');
    		$this->session->set_flashdata('servicio', 'menus');
    		redirect('/locales/servicioNoActivo', 'localtion');
    	}
    	
    	$var['menusActivos'] = $menusActivos;

        //Se obtienen los tipos de platos 
        $var['tiposPlato'] = $this->Menus_model->obtenerTiposPlatosLocal()->result();

        //Se obtienen los platos del local
        $var['platosLocal'] = $this->Menus_model->obtenerPlatosLocal($_SESSION['idLocal'])->result();

        //Se obtienen los tipos de menu
        $var['tiposMenu'] = $this->Menus_model->obtenerTiposMenu()->result();

        //Se obtienen los tipos de menu
        $var['tiposMenuLocal'] = $this->Menus_model->obtenerTiposMenuLocal($_SESSION['idLocal'])->result();

        $var['calendario'] = $this->Menus_model->generarCalendario($_SESSION['idLocal']);

        $header['javascript'] = array('miajaxlib', 'jquery/jquery'
            , 'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min'
            , 'menus', 'mensajes','js/bootstrap.min');
        
        $header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css','buscador.css'
        		, 'general.css','menus.css','calendario.css','pedidosLocal.css'
        );

        $this->load->view('base/cabecera', $header);
        $this->load->view('base/page_top');
        $this->load->view('menus/menusLocal', $var);
        $this->load->view('base/page_bottom');
    }    

    function anadirPlatoLocal() {

        //Se recogen los parametros enviados por el formulario
        $nombre = $_POST["nombre"];
        $idTipoPlato = $_POST["idTipoPlato"];
        $precio = $_POST['precio'];

        $msg = "Plato añadido correctamente";

        if (!$nombre == "") {

            if (is_numeric($precio) && $precio > 0) {

                //Se comprueba si existe un plato con este nombre
                $existePlato = $this->Menus_model->comprobarNombrePlato($_SESSION['idLocal']
                                , $nombre)->num_rows();

                if (!$existePlato) {

                    //Se inserta la linea en la tabla
                    $this->Menus_model->insertPlatoLocal($_SESSION['idLocal'], $nombre
                            , $idTipoPlato, $precio);
                } else {
                    $msg = "Ya existe un plato con este nombre";
                }
            } else {
                $msg = "El valor del precio es incorrecto";
            }
        } else {
            $msg = "Hay que indicar un nombre para el plato";
        }

        $this->listaPlatosMenu($msg);
    }

    function modificarPlatoLocal() {
        //Se recogen los parametros enviados por el formulario
        $nombre = $_POST["nombre"];
        $idTipoPlato = $_POST["idTipoPlato"];
        $precio = $_POST['precio'];
        $idPlatoLocal = $_POST['idPlatoLocal'];

        $msg = "Plato modificado correctamente";

        if (!$nombre == "") {

            if (is_numeric($precio) && $precio > 0) {

                //Se comprueba si existe un plato con este nombre
                $datosPlato = $this->Menus_model->comprobarNombrePlato($_SESSION['idLocal']
                        , $nombre);

                if ($datosPlato->num_rows() > 1) {
                    $msg = "Ya existe un plato con este nombre";
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
                        }
                    }
                }
            } else {
                $msg = "El valor del precio es incorrecto";
            }
        } else {
            $msg = "Hay que indicar un nombre para el plato";
        }

        $this->listaPlatosMenu($msg);
    }

    function borrarPlatoLocal() {

        //Se recogen los parametros enviados por el formulario
        $idPlatoLocal = $_POST["idPlatoLocal"];

        //Se borra el plato del local
        $this->Menus_model->borrarPlatoLocal($_SESSION['idLocal']
                , $idPlatoLocal);

        $this->listaPlatosMenu();
    }

    private function listaPlatosMenu($mensaje = '') {
        //Se obtienen los platos del local
        $platosLocal = $this->Menus_model->obtenerPlatosLocal($_SESSION['idLocal'])->result();

        $params = array('etiqueta' => 'platoLocal', 'mensaje' => $mensaje);
        $this->load->library('objectandxml', $params);

        $var['xml'] = $this->objectandxml->objToXML($platosLocal);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    /*
     * Funcion que inserta un tipo de menu del local
     */

    public function anadirTipoMenuLocal() {
        $idLocal = $_SESSION['idLocal'];
        $precioMenu = $_POST["precioMenu"];
        $idTipoMenu = $_POST['idTipoMenu'];
        $nombreMenu = $_POST['nombreMenu'];
        $esCarta = $_POST['esCarta'];

        $mensaje = "El nombre del menu no puede estar vacio";
        //El nombre tiene que estar informado
        if (!$nombreMenu == "") {
            // Si es un menu el precio tiene que estar informado             
            if (!$precioMenu == "" || $esCarta == true) {
                //Se comprueba si el valor del precio es numerico
                if (is_numeric($precioMenu)) {
                    /*
                     * Se comprueba si el nombre existe en otro menu 
                     */
                    $existeMenu = $this->Menus_model->comprobarNombreTipoMenu($_SESSION['idLocal']
                                    , $nombreMenu)->num_rows();
                    if ($existeMenu) {
                        $mensaje = "Existe otro menu con el mismo nombre";
                    } else {

                        $this->Menus_model->insertTipoMenuLocal($idLocal, $idTipoMenu
                                , $nombreMenu, $precioMenu, $esCarta);

                        $mensaje = "Menu insertado correctamente";
                    }
                } else {
                    $mensaje = "El valor del precio es incorrecto";
                }
            } else {
                $mensaje = "Hay que indicar el precio para los menus";
            }
        }
        $this->listaTiposMenuLocal($mensaje);
    }

    public function modificarTipoMenuLocal() {
        $precioMenu = $_POST["precioMenuModificar"];
        $idTipoMenu = $_POST['idTipoMenuModificar'];
        $nombreMenu = $_POST['nombreMenuModificar'];
        $idTipoMenuLocal = $_POST['idTipoMenuLocalModificar'];
        $esCarta = $_POST['esCarta'];

        $mensaje = "El nombre del menu no puede estar vacio";
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
                    $existeMenu = $this->Menus_model->comprobarNombreTipoMenuId($_SESSION['idLocal']
                                    , $nombreMenu, $idTipoMenuLocal)->num_rows();
                    if ($existeMenu) {
                        $mensaje = "Existe otro menu con el mismo nombre";
                    } else {

                        $this->Menus_model->modificarTipoMenuLocal($idTipoMenuLocal, $idTipoMenu
                                , $nombreMenu, $precioMenu, $esCarta);

                        $mensaje = "Menu modificado correctamente";
                    }
                } else {
                    $mensaje = "El valor del precio es incorrecto";
                }
            } else {
                $mensaje = "Hay que indicar el precio para los menus";
            }
        }

        $this->listaTiposMenuLocal($mensaje);
    }

    private function listaTiposMenuLocal($mensaje = '') {
        //Se obtienen los tipos de menu
        $tiposMenuLocal = $this->Menus_model->obtenerTiposMenuLocal($_SESSION['idLocal'])->result();

        $params = array('etiqueta' => 'tipoMenuLocal', 'mensaje' => $mensaje);
        $this->load->library('objectandxml', $params);
        $var['xml'] = $this->objectandxml->objToXML($tiposMenuLocal);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    public function cargarTipoMenuLocal() {
        //Se recogen los datos enviados     
        $idTipoMenuLocal = $_POST['idTipoMenuLocal'];

        //Se obtienen los tipos de menu
        $tipoMenuLocal = $this->Menus_model->obtenerTipoMenuLocal($idTipoMenuLocal)->result();

        $params = array('etiqueta' => 'tipoMenuLocal');
        $this->load->library('objectandxml', $params);
        $var['xml'] = $this->objectandxml->objToXML($tipoMenuLocal);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    /*
     * Funcion que borra un tipo de menu del local
     */

    public function borrarTipoMenuLocal() {

        //Se recogen los datos enviados     
        $idTipoMenuLocal = $_POST['idTipoMenuLocal'];

        //Se borra el plato del menu
        $this->Menus_model->borrarTipoMenuLocal($idTipoMenuLocal);

        //Se obtienen los tipos de menu
        $tiposMenuLocal = $this->Menus_model->obtenerTiposMenuLocal($_SESSION['idLocal'])->result();

        $params = array('etiqueta' => 'tipoMenuLocal');
        $this->load->library('objectandxml', $params);
        $var['xml'] = $this->objectandxml->objToXML($tiposMenuLocal);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    /*
     * Funcion que añade un plato al un menu
     */

    public function anadirPlatoMenu() {

        //Se recogen los parametros enviados por el formulario
        $idLocal = $_SESSION['idLocal'];
        $fechaMenu = $_POST["fechaMenu"];
        $disponible = "S";
        $idTipoMenuLocal = $_POST['tipoMenuLocal'];
        $idPlatoLocal = $_POST['idPlatoLocal'];
        $idTipoMenu = "";

        $msg = "Plato añadido correctamente al menu";

        /*
         * Se comprueba que se ha informado la fecha, si no está informada no
         * se guarda el plato en ningún menu
         */

        if (!$fechaMenu == "") {
            if (!$idTipoMenuLocal == "") {

                //Se compureba si existe el menu para esa fecha,idTipoMenuLocal
                $datosMenu = $this->Menus_model->obtenerDatosMenu($idLocal, $fechaMenu
                        , $idTipoMenuLocal);

                //Si no existe el menu se inserta la cabecera
                if ($datosMenu->num_rows() == 0) {
                    $idMenuLocal = $this->Menus_model->insertMenu($idLocal
                            , DateTime::createFromFormat('Y-m-d', $fechaMenu)
                            , $disponible, $idTipoMenuLocal);
                } else {

                    $idMenuLocal = $datosMenu->row()->id_menu_local;
                }

                //Se comprueba si ya existe el plato en el menu
                $existePlatoMenu = $this->Menus_model->comprobarPlatoMenu($idMenuLocal
                                , $idPlatoLocal)->num_rows();

                if (!$existePlatoMenu > 0) {
                    //Se inserta el plato en el menu
                    $this->Menus_model->insertPlatoMenu($idMenuLocal, $idPlatoLocal
                            , $disponible);
                } else {
                    $msg = "El plato ya existe en el menu";
                }

                //Se obtiene el idTipoMenu
                $idTipoMenu = $this->Menus_model->
                                obtenerTipoMenuLocal($idTipoMenuLocal)->row()->id_tipo_menu;
            } else {
                $msg = "Tienes que indicar un menu al cual añadir los platos";
            }
        } else {
            $msg = "El campo fecha no puede estar vacio";
        }


        $this->obtenerMenuTipoDiaNoPost($idLocal
                , DateTime::createFromFormat('Y-m-d', $fechaMenu), $idTipoMenu, $msg);
    }

    public function borrarPlatoMenu() {

        //Se recogen los datos enviados     
        $idDetalleMenuLocal = $_POST['idDetalleMenuLocal'];
        $idTipoMenu = $_POST['idTipoMenu'];
        $idLocal = $_SESSION['idLocal'];
        $fechaMenu = $_POST["fechaMenu"];

        //Se borra el plato del menu
        $this->Menus_model->borrarPlatoMenu($idDetalleMenuLocal);

        $msg = "Plato borrado correctamente de menu";

        $this->obtenerMenuTipoDiaNoPost($idLocal
                , DateTime::createFromFormat('Y-m-d', $fechaMenu), $idTipoMenu, $msg);
    }

    function actualizarCalendario() {
        $var['calendario'] = htmlentities($this->Menus_model->generarCalendario($_SESSION['idLocal']));

        $params = array('etiqueta' => 'calendario');
        $this->load->library('arraytoxml', $params);

        $var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    function obtenerMenuDia() {
        if (isset($_POST['idLocal'])) {
            $idLocal = $_POST['idLocal'];
        } else {
            $idLocal = $_SESSION['idLocal'];
        }

        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];

        $fechaMenu = $ano . "-" . $mes . "-" . $dia;


        $var['menuDia'] = $this->Menus_model->obtenerMenuDia($idLocal, $fechaMenu);

        $params = array('etiqueta' => 'menuDia');
        $this->load->library('arraytoxml', $params);

        $var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    function obtenerMenuTipoDia() {
        if (isset($_POST['idLocal'])) {
            $idLocal = $_POST['idLocal'];
        } else {
            $idLocal = $_SESSION['idLocal'];
        }

        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];

        $fechaMenu = $ano . "-" . $mes . "-" . $dia;

        //Si no se envia el tipoMenu se muestra la carta
        if (isset($_POST['tipoMenu'])) {
            $tipoMenu = $_POST['tipoMenu'];
            $mostrarCarta = false;
        } else {
            $mostrarCarta = true;
        }



        //Si la fecha no está informada no se muestra ningun menu
        if ($_POST['dia'] == "") {
            $var['menuDia'] = "";
        } else {
            if (!$mostrarCarta) {
                $var['menuDia'] = $this->Menus_model->obtenerMenuTipoDia($idLocal
                        , DateTime::createFromFormat('Y-m-d', $fechaMenu), $tipoMenu);
            } else {
                $var['menuDia'] = $this->Menus_model->obtenerCartaDia($idLocal
                        , DateTime::createFromFormat('Y-m-d', $fechaMenu));
            }
        }


        $params = array('etiqueta' => 'menuDia');
        $this->load->library('arraytoxml', $params);

        $var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    private function obtenerMenuTipoDiaNoPost($idLocal, $fechaMenu, $tipoMenu, $mensaje = '') {

        //Si la fecha no está informada no se muestra ningun menu
        if ($fechaMenu == "" || $tipoMenu == "") {
            $var['menuDia'] = "";
        } else {
            $var['menuDia'] = $this->Menus_model->obtenerMenuTipoDia($idLocal, $fechaMenu
                    , $tipoMenu);
        }

        $var['mensaje'] = $mensaje;
        $params = array('etiqueta' => 'menuDia');
        $this->load->library('arraytoxml', $params);

        $var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    function mostrarCalendarioMenu() {
        $ano = $_POST['ano'];
        $mes = $_POST['mes'];

        $var['calendario'] = htmlentities($this->Menus_model->generarCalendario($_SESSION['idLocal'], $mes, $ano));

        $params = array('etiqueta' => 'calendario');
        $this->load->library('arraytoxml', $params);

        $var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    function mostrarCalendarioMenuUsuario() {
        $ano = $_POST['ano'];
        $mes = $_POST['mes'];
        $idLocal = $_POST['idLocal'];

        $var['calendario'] =
                htmlentities($this->Menus_model->generarCalendarioUsuario($idLocal, $mes, $ano));

        $params = array('etiqueta' => 'calendario');
        $this->load->library('arraytoxml', $params);

        $var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

}

