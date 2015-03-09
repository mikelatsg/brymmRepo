<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/libraries/alertas/alerta.php';

class Pedidos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
		//Se carga el modelo de usuarios
		$this->load->library('my_cart');
		//Se carga el modelo de pedidos
		$this->load->model('pedidos/Pedidos_model');
		//Se carga el modelo de sessiones
		$this->load->model('sesiones/Sesiones_model');
	}

	public function anadirArticuloPedido() {
		$this->Pedidos_model->anadirArticuloCart($_POST['idArticuloLocal'], $_POST['cantidad']
				, $_POST['precio'], $_POST['articulo'], $_POST['idTipoArticulo']
				, $_POST['idLocal']);

		$msg = "Articulo añadido al pedido";

		//Se muestra el pedido
		$this->mostrarPedido($msg);
	}

	public function anadirArticuloPersonalizadoPedido() {

		srand(time());
		$articuloPersonalizado = rand(1, 100000);

		$msg = "Articulo añadido correctamente";

		if (isset($_POST['ingrediente'])) {

			//Se carga el modelo de articulos
			$this->load->model('articulos/Articulos_model');

			//Se obtiene el precio del articulo
			$datosTipoArticulo = $this->Articulos_model->obtenerTipoArticuloLocal($_POST['idTipoArticuloLocal'])->row();
			$precio = $datosTipoArticulo->precio;

			//Se carga el modelo de ingredientes
			$this->load->model('ingredientes/Ingredientes_model');

			$i = 0;

			foreach ($_POST['ingrediente'] as $ingrediente) {
				$datosIngrediente = $this->Ingredientes_model->obtenerIngrediente($ingrediente)->row();
				$precio = $precio + $datosIngrediente->precio;
				$ingredientePedido[$i] = array('idIngrediente' => $datosIngrediente->id_ingrediente,
						'ingrediente' => $datosIngrediente->ingrediente);
				$i += 1;
			}

			$this->Pedidos_model->anadirArticuloPersonalizadoCart
			($articuloPersonalizado, $_POST['cantidadArticuloPersonalizado']
					, $precio, $datosTipoArticulo, $ingredientePedido, $_POST['idLocal']);
		} else {
			$msg = "No se ha seleccionado ningún ingrediente";
		}

		//Se muestra el pedido
		$this->mostrarPedido($msg);
	}

	public function generarPedidoAntiguo($idPedido) {
		//Se carga el controlado de locales
		//$this->load->controller('locales');

		srand(time());
		$idArticuloPersonalizado = rand(1, 100000);

		//Borro el pedido si existe
		$this->my_cart->destroy();

		$pedido = $this->Pedidos_model->obtenerPedido($idPedido);

		foreach ($pedido['detallePedido'] as $articulo) {
			if ($articulo['personalizado'] == 1) {

				$idArticuloPersonalizado = $idArticuloPersonalizado + 1;

				//Se carga el modelo de articulos
				$this->load->model('articulos/Articulos_model');

				//Se obtiene el precio del articulo
				$datosTipoArticulo = $this->Articulos_model->obtenerTipoArticuloLocal2
				($articulo['idTipoArticulo'])->row();

				$this->Pedidos_model->anadirArticuloPersonalizadoCart(
						$idArticuloPersonalizado, $articulo['cantidad']
						, $articulo['precioArticulo']
						, $datosTipoArticulo, $articulo['detalleArticulo']);
			} else {
				$this->Pedidos_model->anadirArticuloCart($articulo['idArticuloLocal'], $articulo['cantidad']
						, $articulo['precioArticulo'], $articulo['articulo'], $articulo['idTipoArticulo'],$pedido['idLocal']);
			}
		}

		redirect('locales/mostrarLocal/' . $pedido['idLocal'] . '/1', 'location');
	}

	public function borrarArticulo() {
		$data = $this->my_cart->contents();

		//Se borra el articulo indicado
		unset($data[$_POST['rowid']]);

		//Machaco el pedido
		$this->my_cart->destroy();
		$this->my_cart->insert($data);

		$msg = "Articulo eliminado del pedido";

		//Se muestra el pedido
		$this->mostrarPedido($msg);
	}

	private function mostrarPedido($mensaje = '') {
		$var['pedido'] = $this->my_cart->contents();
		$var['total'] = $this->my_cart->total();
		$var['mensaje'] = $mensaje;

		$params = array('etiqueta' => 'lineaPedido');
		$this->load->library('arraytoxml', $params);
		$var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function cancelarPedido() {
		//Borro el pedido
		$this->my_cart->destroy();

		$msg = "Pedido cancelado";

		//Se muestra el pedido
		$this->mostrarPedido($msg);
	}

	public function confirmarPedido() {

		//Se recoge la fecha de recogida del pedido
		if (!isset($_POST['retrasarPedido'])) {
			$fechaPedido = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
		} else {

			$fecha = $_POST['fechaRecogida'];
			$hora = $_POST['horaRecogida'];
			$minuto = $_POST['minutoRecogida'];

			//Se comprueban la fecha
			if (!DateTime::createFromFormat('Y-m-d', $fecha)) {
				$mensaje = "Fecha de recogida incorrecta";
				redirect('/locales/mostrarLocal/' . $_POST['idLocal'] . '/1/' . $mensaje);
			} else {
				$fechaPedido = DateTime::createFromFormat('Y-m-d H:i:s', $fecha
						. ' ' . $hora . ':' . $minuto . ':00');
			}
		}

		//Se carga el modelo de locales
		$this->load->model('locales/Locales_model');

		//Se comprueba si el local está abierto
		$localAbierto =
		$this->Locales_model->comprobarLocalAbierto($_POST['idLocal']
				, $fechaPedido);

		if (!$localAbierto) {
			$mensaje = 'El local esta cerrado el dia indicado';
			redirect('/locales/mostrarLocal/' . $_POST['idLocal'] . '/1/' . $mensaje);
		}

		if (isset($_POST['envioPedido'])) {
			$envioPedido = 1;
			//Se comprueba si se ha indicado una dirección de envio
			if ($_POST['direccionEnvio'] == "") {
				$mensaje = "El campo dirección no puede estar vacio";
				redirect('/locales/mostrarLocal/' . $_POST['idLocal'] . '/1/' . $mensaje);
			}
		} else {
			$envioPedido = 0;
		}

		//Se comprueba si existe algo
		if ($this->my_cart->total() == 0) {
			if (isset($_SESSION['idPedido'])) {
				$idPedido = $_SESSION['idPedido'];
			} else {
				redirect('/locales/mostrarLocal/' . $_POST['idLocal'] . '/1');
			}
		} else {

			/*
			 * Si hay que enviar el pedido se suma el precio al total despues
			* de comprobar si se ha llegado al minimo
			*/
			if ($envioPedido) {
				//Se carga el modelo de servicios
				$this->load->model('servicios/Servicios_model');

				$servicioLocal = $this->Servicios_model->obtenerServicioLocal($_POST['idLocal'], 2)->row();


				//Se comprueba si se ha llegado al importe minimo
				if ($servicioLocal->importe_minimo > $this->my_cart->total() && $envioPedido == 1) {
					$mensaje = "No has llegado al importe minimo";
					redirect('/locales/mostrarLocal/' . $_POST['idLocal'] . '/1/' . $mensaje);
				}

				$precioTotal = $this->my_cart->total() + $servicioLocal->precio;
			} else {
				$precioTotal = $this->my_cart->total();
			}

			$idPedido = $this->Pedidos_model->insertPedido
			($this->my_cart->contents(), $_POST['observaciones']
					, $_POST['direccionEnvio'], $_POST['idLocal']
					, $precioTotal, $envioPedido, $fechaPedido);


			//Se comprueba si se ha insertado ok el pedido
			if ($idPedido < 0) {
				$mensaje = "Error generando el pedido";
				redirect('/locales/mostrarLocal/' . $_POST['idLocal'] . '/1/' . $mensaje);
			}

			//Se guarda el pedido en la session para poder consultar su estado.
			$this->Sesiones_model->guardarPedidoSesion($idPedido);

			$this->my_cart->destroy();
		}
		//Se muestra el pedido
		$this->mostrarEstadoPedido($idPedido);
	}

	function mostrarEstadoPedido($idPedido = '') {
		$var['pedido'] = $this->Pedidos_model->obtenerPedido($idPedido);
		//Si hay que enviar el pedido se obtiene el precio del envio
		if ($var['pedido']['envioPedido'] == 1) {
			//Se carga el modelo de servicios
			$this->load->model('servicios/Servicios_model');
			$servicioLocal = $this->Servicios_model->
			obtenerServicioLocal($var['pedido']['idLocal'], 2)->row();
			$var['gastosEnvio'] = $servicioLocal->precio;
		}


		$header['javascript'] = array('miajaxlib', 'jquery/jquery'
				, 'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min'
				, 'pedidos');

		$header['estilos'] = array('general.css','pedidosLocal.css');

		//Se carga la vista que genera el xml
		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top');
		$this->load->view('pedidos/estadoPedido', $var);
		$this->load->view('base/page_bottom');
	}

	public function verPedidosLocal() {
		//Se carga el modelo de usuarios
		$this->load->model('pedidos/Pedidos_model');

		//Se obtienen los pedidos pendientes del local
		$var['pedidosPendientesLocal'] = $this->Pedidos_model->obtenerPedidosLocal($_SESSION['idLocal'], 'P')->result();

		//Se obtienen los pedidos aceptados del local
		$var['pedidosAceptadosLocal'] = $this->Pedidos_model->obtenerPedidosLocal($_SESSION['idLocal'], 'A')->result();

		//Se obtienen los pedidos terminados del local
		$var['pedidosTerminadosLocal'] =
		$this->Pedidos_model->obtenerPedidosLocal($_SESSION['idLocal'], 'T')->result();

		//Se obtienen los pedidos rechazados del local
		$var['pedidosRechazadosLocal'] =
		$this->Pedidos_model->obtenerPedidosLocal($_SESSION['idLocal'], 'R')->result();

		//Compruebo si esta activas las comandas
		$this->load->model('servicios/Servicios_model');

		$servicios = $this->Servicios_model->obtenerServiciosLocalObject($_SESSION['idLocal']);

		$comandasActivas = false;
		$pedidosActivos = false;
		$existePedidos = false;
		$existeComandas = false;
		foreach ($servicios as $servicio){
			if ($servicio->tipoServicio->idTipoServicio == 5){
				$existeComandas = true;
				if ($servicio->activo){
					$comandasActivas = true;
				}
			}
			if ($servicio->tipoServicio->idTipoServicio == 1){
				$existePedidos = true;
				if ($servicio->activo){
					$pedidosActivos = true;
				}
			}
		}

		if (!$existePedidos && !$existeComandas){
			$this->load->library('session');
			$this->session->set_flashdata('servicio', 'pedidos/comandas');
			redirect('/locales/servicioNoActivo', 'location');
		}

		if ($comandasActivas){

			//Se carga el modelo de comandas
			$this->load->model('comandas/Comandas_model');

			//Se obtienen las comandas activas
			$var2['comandasActivas'] = $this->Comandas_model->obtenerComandasEstadoDiferente
			($_SESSION['idLocal'], 'CC')->result();

			//Se obtienen las comandas cerradas
			$var2['comandasCerradas'] = $this->Comandas_model->obtenerComandasCerradas
			($_SESSION['idLocal'])->result();
		}

		$header['javascript'] = array('miajaxlib', 'jquery/jquery',
				'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min',
				'pedidos', 'comandas', 'mensajes','js/bootstrap.min');

		$header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css','buscador.css'
				, 'general.css','pedidosLocal.css'
		);

		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top');
		if ($existePedidos){
			//Envio si el servicio esta activo para mostrar un mensaje
			$var['servicioPedidoActivo'] = $pedidosActivos;
			$this->load->view('locales/pedidosLocal', $var);
		}
		if ($existeComandas){
			$var2['servicioComandasActivo'] = $comandasActivas;
			$this->load->view('pedidos/mostrarComanda', $var2);
		}
		$this->load->view('base/page_bottom');
	}

	function obtenerEstadoPedido($idPedido = -1, $mensaje = '') {
		if ($idPedido < 0) {
			$idPedido = $_POST['idPedido'];
		}

		$estadoPedido = $this->Pedidos_model->obtenerEstadoPedido($idPedido)->row();


		if ($estadoPedido->estado == 'P') {
			//$var['estadoPedido'] = array('estado' => 'Pendiente');
			$var = array('estado' => 'Pendiente',
					'idPedido' => $idPedido,
					'estadoAbrv' => 'P');
		} elseif ($estadoPedido->estado == 'A') {
			//$var['estadoPedido'] = array('estado' => 'Aceptado');
			$var = array('estado' => 'Aceptado',
					'idPedido' => $idPedido,
					'estadoAbrv' => 'A');
		} elseif ($estadoPedido->estado == 'R') {
			//$var['estadoPedido'] = array('estado' => 'Rechazado');
			$var = array('estado' => 'Rechazado',
					'idPedido' => $idPedido,
					'estadoAbrv' => 'R',
					'motivoRechazo' => $estadoPedido->motivo_rechazo
			);
		} elseif ($estadoPedido->estado == 'T') {
			//$var['estadoPedido'] = array('estado' => 'Terminado');
			$var = array('estado' => 'Terminado',
					'idPedido' => $idPedido,
					'estadoAbrv' => 'T');
		}

		$var['mensaje'] = $mensaje;
		$params = array('etiqueta' => 'pedido');
		$this->load->library('arraytoxml', $params);

		$var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	function actualizarEstadoPedido() {

		$msg = "El estado del pedido se ha modificado correctamente";

		if (isset($_POST['fechaEntrega'])) {
			if (DateTime::createFromFormat('Y-m-d', $_POST['fechaEntrega'])) {
				/*
				 * En el caso de existir,se genera la fecha entrega
				* para modificarla en el pedido
				*/
				$fecha = $_POST['fechaEntrega'];
				$hora = $_POST['horaEntrega'];
				$minuto = $_POST['minutoEntrega'];

				$fechaEntrega = DateTime::createFromFormat('Y-m-d H:i:s', $fecha
						. ' ' . $hora . ':' . $minuto . ':00');

				//Se actualiza el estado del pedido
				$this->Pedidos_model->actualizarEstadoPedido($_POST['idPedido']
						, $_POST['estado'], $fechaEntrega);
			} else {
				$msg = "El valor del campo fecha es incorrecto";
			}
		} elseif (isset($_POST['motivoRechazo'])) {
			/*
			 * Hay motivo rechazo (rechazo pedido)
			*/

			//Se actualiza el estado del pedido
			$this->Pedidos_model->actualizarEstadoPedido($_POST['idPedido']
					, $_POST['estado'], '', $_POST['motivoRechazo']);
		} else {
			//Se actualiza el estado del pedido
			$this->Pedidos_model->actualizarEstadoPedido($_POST['idPedido'], $_POST['estado']);
		}

		$this->obtenerEstadoPedido($_POST['idPedido'], $msg);
	}

	public function verPedido() {

		$pedido = $this->Pedidos_model->obtenerPedido($_POST['idPedido']);

		$params = array('etiqueta' => 'pedido');
		$this->load->library('arraytoxml', $params);

		$var['xml'] = $this->arraytoxml->convertArrayToXml($pedido, 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function mostrarTodosPedidosUsuario(){
		$pedidosUsuario =
		$this->Pedidos_model->obtenerUltimosPedidosUsuario($_SESSION['idUsuario'],500);

		$params = array('etiqueta' => 'pedido');
		$this->load->library('arraytoxml', $params);

		$var['xml'] = $this->arraytoxml->convertArrayToXml($pedidosUsuario, 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function comprobarAlertaPedido() {

		$this->load->model('alertas/Alertas_model');

		$fecha = $_POST['fecha'];

		$fechaAlertas = DateTime::createFromFormat('Y-m-d H:i:s', $fecha);

		$fechaAlertas->modify("-3 minutes");

		$hayPedido = $this->Alertas_model->hayTipoAlertaNuevaLocal($_SESSION['idLocal'], $fechaAlertas->format('Y-m-d H:i:s'), 1);

		$datos = array("hayAlertaPedido" =>$hayPedido);

		//Se genera el json
		echo json_encode($datos);
	}

	public function obtenerPedidosPendientes(){
		$pedidos =  $this->Pedidos_model->obtenerPedidosLocalObject($_SESSION['idLocal'], 'P');

		$datos = array("pedidosPendientes" =>$pedidos);

		//Se genera el json
		echo json_encode($datos);
	}

}

