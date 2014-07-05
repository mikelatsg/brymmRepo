<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
	 * Funcion que comprueba si el local tiene todo lo necesario para poder
	* dar el servicio de pedidos.
	*/

	function comprobarServicioPedidos($idLocal) {
		
		$CI = get_instance();		
		$CI->load->model('articulos/Articulos_model');

		//Se carga el modelo de articulos
		$CI->load->model('articulos/Articulos_model');

		$existenArticulos =
		$CI->Articulos_model->comprobarExisteArticuloLocal
		($idLocal)->num_rows();

		if ($existenArticulos) {
			return true;
		} else {
			return false;
		}
	}

	function comprobarServicioPedidoPersonalizado($idLocal) {

		$CI = get_instance();
		$CI->load->model('articulos/Articulos_model');	

		$existeTipoArticulo =
		$CI->Articulos_model->comprobarExisteTipoArticuloLocal
		($idLocal)->num_rows();

		//Se carga el modelo de ingredientes
		$CI->load->model('ingredientes/Ingredientes_model');

		$existenIngredientes =
		$CI->Ingredientes_model->obtenerIngredientes
		($idLocal)->num_rows();


		if ($existeTipoArticulo && $existenIngredientes) {
			return true;
		} else {
			return false;
		}
	}

	function comprobarServicioReservas($idLocal) {

		//Se carga el modelo de reservas
		$CI = get_instance();
		$CI->load->model('reservas/Reservas_model');

		$existenMesas =
		$CI->Reservas_model->obtenerMesasLocal
		($idLocal)->num_rows();

		if ($existenMesas) {
			return true;
		} else {
			return false;
		}
	}

	function comprobarServicioMenu($idLocal) {

		//Se carga el modelo de articulos
		$CI->load->model('menus/Menus_model');

		$existenPlatosLocal =
		$CI->Menus_model->obtenerPlatosLocal
		($idLocal)->num_rows();

		$existenMenusLocal =
		$CI->Menus_model->comprobarTipoMenuLocal
		($idLocal)->num_rows();


		if ($existenPlatosLocal && $existenMenusLocal) {
			return true;
		} else {
			return false;
		}
	}
