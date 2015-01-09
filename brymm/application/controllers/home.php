<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        
        //Se carga el modelo de sessiones
        $this->load->model('sesiones/Sesiones_model');
    }

    public function index() {
        
        //Se carga el modelo de locales
        $this->load->model('locales/Locales_model');
        
        //Se obtienen los tipos de comida
        $var['tiposComida'] = $this->Locales_model->obtenerTiposComida()->result();
        
        //Se carga el modelo de servicios
        $this->load->model('servicios/Servicios_model');
        
        //Se obtienen los servicios del local
        $var['servicios'] = $this->Servicios_model->obtenerServicios()->result();        
        $header['javascript'] = array('miajaxlib', 'jquery/jquery','js/bootstrap.min');
        $header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css',
        		'buscador.css','general.css');        

        $this->load->view('base/cabecera', $header);
        $this->load->view('base/page_top');
        $this->load->view('locales/buscadorLocales',$var);
        $this->load->view('home');
        $this->load->view('base/page_bottom');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */