<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        //Se carga el modelo de usuarios
        $this->load->model('usuarios/Usuarios_model');
        //Se carga el modelo de sessiones
        $this->load->model('sesiones/Sesiones_model');
    }

    public function alta() {
        $this->load->view('base/cabecera');
        $this->load->view('base/page_top');
        $this->load->view('usuarios/alta');
        $this->load->view('base/page_bottom');
    }

    public function nuevoUsuario() {
        //Se comprueba si existe el usuario
        $existeNick = $this->Usuarios_model->comprobarUsuarioNick($_POST['nick'])->num_rows();

        if ($existeNick > 0) {
            $msg = "El nick indicado ya existe!";
            $this->load->view('base/cabecera');
            $this->load->view('base/page_top', $msg);
            $this->load->view('usuarios/alta');
            $this->load->view('base/page_bottom');
        } else {
            $msg = "Alta Ok!";
            //Se encripta el password
            //$password = $_POST['password']; //$this->encrypt->encode($_POST['password']);
            $password = md5($_POST['password']);
            //Se llama a la función que inserta el usuario
            $this->Usuarios_model->insertUsuario($_POST, $password);

            $this->load->view('base/cabecera');
            $this->load->view('base/page_top', $msg);
            $this->load->view('home');
            $this->load->view('base/page_bottom');
        }
    }

    public function login() {

        //Se carga el modelo de usuarios
        $this->load->model('sesiones/Sesiones_model');

        //Se comprueba si existe el usuario
        $result =
                $this->Usuarios_model->comprobarUsuarioLogin($_POST['nick'], md5($_POST['password']));

        $msg = "Usuario o pass incorrectos!";

        //Se comprueba si existe el usuario
        if ($result->num_rows() > 0) {

            $lineaUsuario = $result->row();

            $msg = "Login Ok!";
            $this->Sesiones_model->iniciarSesion($lineaUsuario->nick, $lineaUsuario->id_usuario);

            redirect('usuarios/home', 'location');
        }

        redirect('home', 'location');
    }

    public function logout() {
        //Se carga el modelo de usuarios
        $this->load->model('sesiones/Sesiones_model');

        //Se elimina la sesión
        $this->Sesiones_model->destruirSesion();

        $msg = "Session cerrada!";

        $this->load->view('base/cabecera');
        $this->load->view('base/page_top', $msg);
        $this->load->view('home');
        $this->load->view('base/page_bottom');
    }

    public function gestionDireccionEnvio() {

        $var['direccionesEnvio'] = $this->Usuarios_model->obtenerDirecciones($_SESSION['idUsuario'])->result();

        $header['javascript'] = array('miajaxlib', 'jquery/jquery', 'usuarios');

        $this->load->view('base/cabecera', $header);
        $this->load->view('base/page_top');
        $this->load->view('usuarios/gestionDireccionEnvio', $var);
        $this->load->view('base/page_bottom');
    }

    public function anadirDireccionEnvio() {

        $hayError = false;

        //Se comprueban los campos del formulario
        if ($_POST['nombre'] == "") {
            $msg = "El campo nombre no puede estar vacio";
            $hayError = true;
        }

        if ($_POST['direccion'] == "" && !$hayError) {
            $msg = "El campo direccion no puede estar vacio";
            $hayError = true;
        }

        if ($_POST['poblacion'] == "" && !$hayError) {
            $msg = "El campo poblacion no puede estar vacio";
            $hayError = true;
        }

        if ($_POST['provincia'] == "" && !$hayError) {
            $msg = "El campo provincia no puede estar vacio";
            $hayError = true;
        }


        if (!$hayError) {
            //Se comprueba si existe la direccion
            $existeDireccion = $this->Usuarios_model->comprobarDireccion($_SESSION['idUsuario'], $_POST['nombre'])->num_rows();

            if ($existeDireccion > 0) {
                $msg = "Ya existe una direccion con ese nombre";
            } else {
                //Se inserta la direccion envio
                $this->Usuarios_model->insertDireccionEnvio($_POST['nombre']
                        , $_SESSION['idUsuario'], $_POST['direccion']
                        , $_POST['poblacion'], $_POST['provincia']);
                
                $msg = "Direccion creada correctamente";
            }
        }

        $this->listaDireccionesEnvio($msg);
    }

    private function listaDireccionesEnvio($msg = '') {
        //Se obtienen las direcciones del usuario
        $direccionesEnvio = $this->Usuarios_model->obtenerDirecciones($_SESSION['idUsuario'])->result();

        $params = array('etiqueta' => 'direccionEnvio', 'mensaje' => $msg);
        $this->load->library('objectandxml', $params);
        $var['xml'] = $this->objectandxml->objToXML($direccionesEnvio);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    public function home() {
        //Se cargan los modelos de pedidos, locales, servicios
        $this->load->model('pedidos/Pedidos_model');
        $this->load->model('locales/Locales_model');
        $this->load->model('servicios/Servicios_model');
        $this->load->model('reservas/Reservas_model');

        $var['pedidosUsuario'] =
                $this->Pedidos_model->obtenerUltimosPedidosUsuario($_SESSION['idUsuario']);

        $var['localesFavoritos'] =
                $this->Locales_model->obtenerLocalesFavoritos($_SESSION['idUsuario'])->result();

        $var['ultimasReservas'] =
                $this->Reservas_model->obtenerUltimasReservasUsuario($_SESSION['idUsuario'])->result();

        //Se obtienen los tipos de comida
        $buscador['tiposComida'] = $this->Locales_model->obtenerTiposComida()->result();

        //Se obtienen los servicios del local
        $buscador['servicios'] = $this->Servicios_model->obtenerServicios()->result();

        //Se obtienen las direcciones de envio
        $var2['direccionesEnvio'] =
                $this->Usuarios_model->obtenerDirecciones($_SESSION['idUsuario'])->result();

        $header['javascript'] = array('miajaxlib', 'jquery/jquery'
            , 'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min'
            , 'usuarios', 'js/bootstrap.min');
        
        $header['estilos'] = array('buscador.css');

        $this->load->view('base/cabecera', $header);
        $this->load->view('base/page_top');
        $this->load->view('locales/buscadorLocales', $buscador);
        $this->load->view('usuarios/home', $var);
        $this->load->view('usuarios/gestionDireccionEnvio', $var2);
        $this->load->view('usuarios/formularioDireccionEnvio');
        $this->load->view('base/page_bottom');
    }

    public function borrarDireccionEnvio() {

        $idDireccion = $_POST['idDireccionEnvio'];

        $msg = "Direccion borrada correctamente";
        //Se comprueba si la direccion se ha usado para anularla o borrarla
        $direccionActiva =
                $this->Usuarios_model->comprobarDireccionPedidos($idDireccion)->num_rows();

        if ($direccionActiva) {
            //Se anula la direccion
            $this->Usuarios_model->anularDireccionEnvio($idDireccion);
        } else {
            //se borra la direccion
            $this->Usuarios_model->borrarDireccionEnvio($idDireccion);
        }

        $this->listaDireccionesEnvio($msg);
    }

}

