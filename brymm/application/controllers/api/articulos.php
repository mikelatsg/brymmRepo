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
require_once APPPATH . '/libraries/articulos/tipoArticuloLocal.php';
require_once APPPATH . '/libraries/articulos/tipoArticulo.php';
require_once APPPATH . '/libraries/articulos/articulo.php';
require_once APPPATH . '/libraries/ingredientes/ingrediente.php';
require_once APPPATH . '/libraries/constantes/Code.php';

class Articulos extends REST_Controller {

	//Datos recibidos
	const FIELD_ID_TIPO_ARTICULO = "idTipoArticulo";
	const FIELD_ID_TIPO_ARTICULO_LOCAL = "idTipoArticuloLocal";
	const FIELD_TIPO_ARTICULO = "tipoArticulo";
	const FIELD_TIPO_ARTICULO_LOCAL = "tipoArticuloLocal";
	const FIELD_DESCRIPCION = "descripcion";
	const FIELD_PRECIO = "precio";
	const FIELD_PERSONALIZAR = "personalizar";
	const FIELD_ID_LOCAL = "idLocal";


	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de articulos
		$this->load->model('articulos/Articulos_model');
	}

	function nuevoTipoArticulo_post() {
		//Se recogen los datos recibidos en formato json
		$datosTipoArticuloLocal = $this->post();

		$tipoArticuloLocal = new TipoArticuloLocal(
				$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_ID_TIPO_ARTICULO]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_TIPO_ARTICULO]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_DESCRIPCION]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_PRECIO]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_PERSONALIZAR]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_ID_TIPO_ARTICULO_LOCAL]);

		$idLocal = $datosTipoArticuloLocal[Articulos::FIELD_ID_LOCAL];

		$hayError = false;
		$msg = "Tipo articulo añadido correctamente";

		//Se comprueba si el local tiene el tipo articulo
		$existe =
		$this->Articulos_model->comprobarTipoArticuloLocal
		($tipoArticuloLocal->idTipoArticulo, $idLocal)->num_rows();

		if (!$existe) {
			//Se comprueba si el precio tiene el valor correcto
			if (is_numeric($tipoArticuloLocal->precio) && $tipoArticuloLocal->precio >= 0) {
				//Se inserta el nuevo tipo de articulo para el local
				$idTipoArticuloLocal = $this->Articulos_model->insertTipoArticuloLocalObject
				($tipoArticuloLocal,$idLocal);

				//Se obtiene el tipo articulo insertado
				$tipoArticuloLocal = TipoArticuloLocal::withID($idTipoArticuloLocal);

			} else {
				$msg = "El valor del precio no es correcto";
				$hayError = true;
			}
		} else {
			$msg = "Ya existe el tipo de articulo";
			$hayError = true;
		}

		if (!$hayError){

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Articulos::FIELD_TIPO_ARTICULO_LOCAL => $tipoArticuloLocal);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function modificarTipoArticulo_post() {
		//Se recogen los datos recibidos en formato json
		$datosTipoArticuloLocal = $this->post();

		$tipoArticuloLocal = new TipoArticuloLocal(
				$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_ID_TIPO_ARTICULO]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_TIPO_ARTICULO]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_DESCRIPCION]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_PRECIO]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_PERSONALIZAR]
				,$datosTipoArticuloLocal[Articulos::FIELD_TIPO_ARTICULO_LOCAL][Articulos::FIELD_ID_TIPO_ARTICULO_LOCAL]);

		$hayError = false;
		$msg = "Tipo articulo modificado correctamente";

		//Se comprueba si el precio tiene el valor correcto
		if (is_numeric($tipoArticuloLocal->precio) && $tipoArticuloLocal->precio >= 0) {
			//Se modifica el tipo de articulo para el local
			$this->Articulos_model->modificarTipoArticuloLocalObject
			($tipoArticuloLocal);

			//Se transforma el valor de personalizar a numerico para que no de error en la app
			if ($tipoArticuloLocal->personalizar == "true"){
				$tipoArticuloLocal->personalizar = 1;
			}else{
				$tipoArticuloLocal->personalizar = 0;
			}


		} else {
			$msg = "El valor del precio no es correcto";
			$hayError = true;
		}


		if (!$hayError){

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Articulos::FIELD_TIPO_ARTICULO_LOCAL => $tipoArticuloLocal);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarTipoArticuloLocal_get() {
		if (!$this->get(Articulos::FIELD_ID_TIPO_ARTICULO_LOCAL)) {
			$msg = "Error borrando tipo articulo";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}

		$idTipoArticuloLocal = $this->get(Articulos::FIELD_ID_TIPO_ARTICULO_LOCAL);

		$msg = "Tipo articulo borrado correctamente";

		/*
		 * Se comprueba si hay algun articulo para el tipo articulo, de haberlo
		* no se borra
		*/
		$datosTipoArticuloLocal =
		$this->Articulos_model->obtenerTipoArticuloLocal
		($idTipoArticuloLocal)->row();

		$idTipoArticulo = $datosTipoArticuloLocal->id_tipo_articulo;
		$idLocal =  $datosTipoArticuloLocal->id_local;

		$hayArticulo =
		$this->Articulos_model->comprobarHayArticuloTipoArticulo
		($idLocal, $idTipoArticulo)->num_rows();

		if ($hayArticulo) {
			$msg = 'No se puede borrar el tipo de articulo, existen '
					. 'articulos asociados al mismo';

			$resOperacion = Code::RES_OPERACION_KO;
		} else {
			$this->Articulos_model->borrarTipoArticuloLocal($idTipoArticuloLocal);
			$resOperacion = Code::RES_OPERACION_OK;
		}

		$datosRespuesta = array(Code::JSON_OPERACION_OK => $resOperacion,
				Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function nuevoArticulo_post() {
		//Se recogen los datos recibidos en formato json
		$datosArticulo = $this->post();

		$tipoArticulo = new TipoArticulo( $datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulos::FIELD_TIPO_ARTICULO][Articulos::FIELD_ID_TIPO_ARTICULO]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulos::FIELD_TIPO_ARTICULO][Articulos::FIELD_TIPO_ARTICULO]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulos::FIELD_TIPO_ARTICULO][Articulos::FIELD_DESCRIPCION]);

		$ingredientes = array();



		foreach ($datosArticulo[Articulo::FIELD_ARTICULO][Articulo::FIELD_INGREDIENTES] as $datosIngrediente){
			$ingredientes[] = new Ingrediente($datosIngrediente[Ingrediente::FIELD_ID_INGREDIENTE]
					,$datosIngrediente[Ingrediente::FIELD_NOMBRE]
					,$datosIngrediente[Ingrediente::FIELD_DESCRIPCION]
					,$datosIngrediente[Ingrediente::FIELD_PRECIO]);

		}

		$articulo = new Articulo($datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_ID_ARTICULO]
				,$tipoArticulo
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_NOMBRE]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_DESCRIPCION]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_PRECIO]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_VALIDO_PEDIDOS]
				,$ingredientes);

		$idLocal = $datosArticulo[Articulos::FIELD_ID_LOCAL];

		$hayError = false;
		$msg = "Articulo añadido correctamente";

		if ($articulo->nombre == "") {
			$msg = "Hay que indicar un nombre para el articulo";
			$hayError = true;
		}

		if (is_numeric($articulo->precio) && $articulo->precio >= 0) {

			$idArticuloLocal = $this->Articulos_model->insertArticuloLocalObject($articulo, $idLocal);

			$articulo = $this->Articulos_model->obtenerArticuloLocalObject($idArticuloLocal);
		} else {
			$msg = "El valor del precio es incorrecto";
			$hayError = true;
		}

		if (!$hayError){

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Articulo::FIELD_ARTICULO => $articulo);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function modificarArticulo_post() {
		//Se recogen los datos recibidos en formato json
		$datosArticulo = $this->post();

		$tipoArticulo = new TipoArticulo( $datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulos::FIELD_TIPO_ARTICULO][Articulos::FIELD_ID_TIPO_ARTICULO]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulos::FIELD_TIPO_ARTICULO][Articulos::FIELD_TIPO_ARTICULO]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulos::FIELD_TIPO_ARTICULO][Articulos::FIELD_DESCRIPCION]);

		$ingredientes = array();



		foreach ($datosArticulo[Articulo::FIELD_ARTICULO][Articulo::FIELD_INGREDIENTES] as $datosIngrediente){
			$ingredientes[] = new Ingrediente($datosIngrediente[Ingrediente::FIELD_ID_INGREDIENTE]
					,$datosIngrediente[Ingrediente::FIELD_NOMBRE]
					,$datosIngrediente[Ingrediente::FIELD_DESCRIPCION]
					,$datosIngrediente[Ingrediente::FIELD_PRECIO]);

		}

		$articulo = new Articulo($datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_ID_ARTICULO]
				,$tipoArticulo
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_NOMBRE]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_DESCRIPCION]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_PRECIO]
				,$datosArticulo[Articulo::FIELD_ARTICULO]
				[Articulo::FIELD_VALIDO_PEDIDOS]
				,$ingredientes);

		$idLocal = $datosArticulo[Articulos::FIELD_ID_LOCAL];

		$hayError = false;
		$msg = "Articulo modificado correctamente";

		if ($articulo->nombre == "") {
			$msg = "Hay que indicar un nombre para el articulo";
			$hayError = true;
		}

		if (is_numeric($articulo->precio) && $articulo->precio >= 0) {

			$this->Articulos_model->modificarArticuloLocalObject($articulo, $idLocal);
				
			//Se envia un entero para que no de error
			if ($articulo->validoPedidos){
				$articulo->validoPedidos =1;
			}else{
				$articulo->validoPedidos = 0;
			}

		} else {
			$msg = "El valor del precio es incorrecto";
			$hayError = true;
		}

		if (!$hayError){

			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_OK,
					Code::JSON_MENSAJE => $msg,
					Articulo::FIELD_ARTICULO => $articulo);
		}else{
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
		}

		$this->response($datosRespuesta, Code::CODE_OK);
	}

	function borrarArticulo_get() {
		if (!$this->get(Articulo::FIELD_ID_ARTICULO) ||!$this->get(Articulos::FIELD_ID_LOCAL) ) {
			$msg = "Error borrando tipo articulo";
			$datosRespuesta = array(Code::JSON_OPERACION_OK => Code::RES_OPERACION_KO,
					Code::JSON_MENSAJE => $msg);
			$this->response($datosRespuesta, Code::CODE_OK);
		}
	
		$idArticulo = $this->get(Articulo::FIELD_ID_ARTICULO);
		$idLocal = $this->get(Articulos::FIELD_ID_LOCAL);
		
		//Se carga el modelo de pedidos
		$this->load->model('pedidos/Pedidos_model');
		
		//Se comprueba si el articulo esta activo en algun pedido
		$existeArticuloPedidoPendiente = $this->Pedidos_model->obtenerPedidosArticuloEstado
		($idLocal, $idArticulo, 'P')->num_rows();
		
		if (!$existeArticuloPedidoPendiente) {
			
			$existeArticuloPedidoAceptado = $this->Pedidos_model->obtenerPedidosArticuloEstado
			($idLocal, $idArticulo, 'A')->num_rows();
			
			if (!$existeArticuloPedidoAceptado) {
				//Se borra el articulo
				$this->Articulos_model->borrarArticuloLocal($idArticulo);
		
				$msg = "Articulo borrado correctamente";
				$resOperacion = Code::RES_OPERACION_OK;
			}
		}else{
			
			$msg = "El articulo esta siendo utilizado en pedidos activos";
			$resOperacion = Code::RES_OPERACION_KO;
		}
	
		$datosRespuesta = array(Code::JSON_OPERACION_OK => $resOperacion,
				Code::JSON_MENSAJE => $msg);
		$this->response($datosRespuesta, Code::CODE_OK);
	}
}