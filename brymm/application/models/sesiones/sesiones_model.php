<?php

class Sesiones_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        session_start();
    }

    function iniciarSesion($nick, $idUsuario) {

        session_unset();
        session_destroy();
        session_start();
        $_SESSION['idUsuario'] = $idUsuario;
        $_SESSION['nick'] = $nick;
        $_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");
    }

    function iniciarSesionLocal($idLocal) {
        
        //Se carga el modelo de usuarios
        $this->load->library('cart');        
        $this->cart->destroy();

        session_unset();
        session_destroy();
        session_start();
        $_SESSION['idLocal'] = $idLocal;
        $_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");
        //Variable para controlar si la session ha sido iniciada por un local
        $_SESSION['sesionLocal'] = true;
        //Variable para controlar los permisos, si es un local todos
        $_SESSION['controlTotal'] = true;
    }

    function iniciarSesionCamarero($idCamarero, $idLocal, $controlTotal) {
        //Se carga el modelo de usuarios
        $this->load->library('cart');        
        $this->cart->destroy();

        $_SESSION['idLocal'] = $idLocal;
        $_SESSION['idCamarero'] = $idCamarero;
        $_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");
        /* Variable para controlar si la session ha sido iniciada por un local o 
          por un camarero */
        if (!isset($_SESSION['sesionLocal'])) {
            $_SESSION['sesionLocal'] = false;
        }
        //Variable para controlar los permisos del camarero
        $_SESSION['controlTotal'] = $controlTotal;
    }

    function cerrarSesionCamarero() {
        //Se carga el modelo de usuarios
        $this->load->library('cart');        
        $this->cart->destroy();
        
        if ($_SESSION['sesionLocal']) {
            unset($_SESSION['idCamarero']);
        } else {
            $this->destruirSesion();
        }
    }

    function guardarPedidoSesion($idPedido) {
        $_SESSION['idPedido'] = $idPedido;
    }

    function borrarPedidoSesion() {
        unset($_SESSION['idPedido']);
    }

    function destruirSesion() {
        //Se carga el modelo de usuarios
        $this->load->library('cart');        
        $this->cart->destroy();
        
        session_destroy();
        redirect('home', 'location');
    }

}
