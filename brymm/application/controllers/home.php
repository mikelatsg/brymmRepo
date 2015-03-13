<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/local/localServicios.php';
require_once APPPATH . '/libraries/local/tipoComida.php';
require_once APPPATH . '/libraries/servicios/servicioLocal.php';
require_once APPPATH . '/libraries/servicios/tipoServicio.php';

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));

		//Se carga el modelo de sessiones
		$this->load->model('sesiones/Sesiones_model');
	}

	public function index() {

		$this->load->library('session');
		$varTop['msg'] = $this->session->flashdata('msg');
		
		//Se carga el modelo de locales
		$this->load->model('locales/Locales_model');

		//Se obtienen los tipos de comida
		$var['tiposComida'] = $this->Locales_model->obtenerTiposComida()->result();

		//Se carga el modelo de servicios
		$this->load->model('servicios/Servicios_model');

		//Obtengo los ultimos locales que se han dado de alta
		$var2['ultimosLocales'] = $this->Locales_model->obtenerUltimosLocalesObject();

		//Se obtienen los servicios del local
		$var['servicios'] = $this->Servicios_model->obtenerServicios()->result();
		$header['javascript'] = array('miajaxlib', 'jquery/jquery','js/bootstrap.min'
				, 'home','jquery/jquery-ui-1.10.3.custom.min','jquerySlider/jquery.bxslider.min',
				'mensajes'
		);
		$header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css',
				'buscador.css','general.css', 'home.css', 'jquerySlider/jquery.bxslider.css');

		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top',$varTop);
		$this->load->view('locales/buscadorLocales',$var);
		$this->load->view('home',$var2);
		$this->load->view('base/page_bottom');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */