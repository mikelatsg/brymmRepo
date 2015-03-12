<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/local/local.php';

class LocalServicios{

	public $local;
	public $serviciosLocal;

	public function __construct(  Local $local,
			$serviciosLocal = array()) {

		$this->local = $local;
		$this->serviciosLocal = $serviciosLocal;

	}

	public static function withID($idLocal){

		$instance;
		$CI;
		$CI = & get_instance();
		$CI->load->model('servicios/Servicios_model');
		$datosServicios = $CI->Servicios_model->obtenerServiciosLocal($idLocal)->result();
		$servicios = array();
		foreach($datosServicios as $datosServicio){
			$tipoServicio = TipoServicio::withID($datosServicio->id_tipo_servicio_local);
				
			$servicios[] = new ServicioLocal($datosServicio->id_servicio_local,
					$tipoServicio,
					$datosServicio->activo,
					$datosServicio->importe_minimo, $datosServicio->precio);
				
		}

		$localInt = Local::withID($idLocal);

		$instance = new self($localInt,$servicios);

		return $instance;

			
	}

}