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
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/ingredientes/ingrediente.php';
require_once APPPATH . '/libraries/constantes/Code.php';

class Ingredientes extends REST_Controller {

	const CODE_OK = 200;
	const CODE_KO = 404;
	const CODE_NO_DATA = 400;


	//Campos enviados con JSON
	const JSON_INGREDIENTE = "ingrediente";

	//Datos recibidos
	const FIELD_ID_INGREDIENTE = "idIngrediente";
	const FIELD_DESCRIPCION = "descripcion";
	const FIELD_NOMBRE = "nombre";
	const FIELD_PRECIO = "precio";
	const FIELD_INGREDIENTE = "ingrediente";
	const FIELD_ID_LOCAL = "idLocal";

	//Constantes
	const CONST_SERVICIOS = "servicios";

	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de ingredientes
		$this->load->model('ingredientes/Ingredientes_model');
	}

	function nuevoIngrediente_post() {
		//Se recogen los datos recibidos en formato json
		$datosIngrediente = $this->post();

		$ingrediente = new Ingrediente(0
				,$datosIngrediente[Ingredientes::FIELD_INGREDIENTE][Ingredientes::FIELD_NOMBRE]
				,$datosIngrediente[Ingredientes::FIELD_INGREDIENTE][Ingredientes::FIELD_DESCRIPCION]
				,$datosIngrediente[Ingredientes::FIELD_INGREDIENTE][Ingredientes::FIELD_PRECIO]);

		$idLocal = $datosIngrediente[Ingredientes::FIELD_ID_LOCAL];

		$hayError = false;
		$msg = "Ingrediente añadido correctamente";

		if ($ingrediente->nombre == "") {
			$msg = "Hay que indicar un nombre para el ingrediente";
			$hayError = true;
		}

		if (!is_numeric($ingrediente->precio)) {
			$msg = "El valor del precio tiene que ser numerico";
			$hayError = true;
		}

		if (!($ingrediente->precio >= 0)) {
			$msg = "El valor del precio no puede ser menor que 0";
			$hayError = true;
		}

		if (!$hayError){
			$idIngrediente =
			$this->Ingredientes_model->insertIngredienteObject($ingrediente, $idLocal);

			$ingrediente = Ingrediente::withID($idIngrediente);

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Ingredientes::JSON_INGREDIENTE => $ingrediente);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function modificarIngrediente_post() {
		//Se recogen los datos recibidos en formato json
		$datosIngrediente = $this->post();

		$ingrediente = new Ingrediente(
				$datosIngrediente[Ingredientes::FIELD_INGREDIENTE][Ingredientes::FIELD_ID_INGREDIENTE]
				,$datosIngrediente[Ingredientes::FIELD_INGREDIENTE][Ingredientes::FIELD_NOMBRE]
				,$datosIngrediente[Ingredientes::FIELD_INGREDIENTE][Ingredientes::FIELD_DESCRIPCION]
				,$datosIngrediente[Ingredientes::FIELD_INGREDIENTE][Ingredientes::FIELD_PRECIO]);

		$idLocal = $datosIngrediente[Ingredientes::FIELD_ID_LOCAL];

		$hayError = false;
		$msg = "Ingrediente modificado correctamente";

		if ($ingrediente->nombre == "") {
			$msg = "Hay que indicar un nombre para el ingrediente";
			$hayError = true;
		}

		if (!is_numeric($ingrediente->precio)) {
			$msg = "El valor del precio tiene que ser numerico";
			$hayError = true;
		}

		if (!($ingrediente->precio >= 0)) {
			$msg = "El valor del precio no puede ser menor que 0";
			$hayError = true;
		}

		if (!$hayError){
			$idIngrediente =
			$this->Ingredientes_model->modificarIngredienteObject($ingrediente);

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Ingredientes::JSON_INGREDIENTE => $ingrediente);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarIngrediente_get() {
		if (!$this->get(Ingredientes::FIELD_ID_INGREDIENTE)) {
			$msg = "Error borrando ingrediente";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idIngrediente = $this->get(Ingredientes::FIELD_ID_INGREDIENTE);

		$msg = "Ingrediente borrada correctamente";

		//Se carga el modelo de articulos
		$this->load->model('articulos/Articulos_model');

		//Se comprueba si existe el ingrediente en algun articulo
		$hayIngredienteArticulo =
		$this->Articulos_model->obtenerArticulosIngrediente($idIngrediente)->num_rows();

		if ($hayIngredienteArticulo == 0) {
			$this->Ingredientes_model->borrarIngrediente($idIngrediente);
			$msg = "Ingrediente borrado correctamente";
			$resOperacion = Code::RES_OPERACION_OK;
		} else {
			$msg = "No se puede borrar el ingrediente, existe en algún articulo";
			$resOperacion = Code::RES_OPERACION_KO;
		}

		$datosRespuesta = array(Code::JSON_OPERACION_OK => $resOperacion,
					Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

}