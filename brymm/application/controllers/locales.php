<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Locales extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		//Se carga el modelo de locales
		$this->load->model('locales/Locales_model');
		//Se carga el modelo de sessiones
		$this->load->model('sesiones/Sesiones_model');
	}

	public function alta() {
		//Se obtienen los tipos de comida
		$var['tiposComida'] = $this->Locales_model->obtenerTiposComida()->result();

		$this->load->view('base/cabecera');
		$this->load->view('base/page_top');
		$this->load->view('locales/alta', $var);
		$this->load->view('base/page_bottom');
	}

	public function nuevoLocal() {
		//Se comprueba si existe el local
		$result = $this->Locales_model->comprobarLocal($_POST['nombre']);

		$existeLocal = $result->num_rows();
		if ($existeLocal > 0) {
			$msg = "El local indicado ya existe!";
			$this->load->view('base/cabecera');
			$this->load->view('base/page_top', $msg);
			$this->load->view('locales/alta');
			$this->load->view('base/page_bottom');
		} else {
			$msg = "Alta Ok!";

			//Se llama a la función que inserta el local
			$idLocal = $this->Locales_model->insertLocal($_POST);

			//Se inicia la session con el local creado
			$this->Sesiones_model->iniciarSesionLocal($idLocal);

			$header['javascript'] = array('miajaxlib', '/jquery/jquery', 'horarios');

			//Se carga el siguiente paso del alta
			$this->load->view('base/cabecera', $header);
			$this->load->view('base/page_top', $msg);
			$this->load->view('locales/panelControl');
			//$this->load->view('locales/altaHorario');
			$this->load->view('base/page_bottom');
		}
	}

	public function login() {

		//Se comprueba si existe el local
		$result =
		$this->Locales_model->comprobarLocalLogin($_POST['nombre']
				, md5($_POST['password']));

		$msg = "Usuario o pass incorrectos!";
		$vistaCargar = "home";
		//Se comprueba si existe el usuario
		if ($result->num_rows() > 0) {

			$lineaLocal = $result->row();

			$msg = "Login Ok!";
			$this->Sesiones_model->iniciarSesionLocal($lineaLocal->id_local);
			$vistaCargar = 'locales/panelControl';
		}

		$header['javascript'] = array('miajaxlib', 'jquery/jquery', 'horarios');
		$header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css','general.css');

		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top', $msg);
		$this->load->view($vistaCargar);
		$this->load->view('base/page_bottom');
	}

	public function logout() {

		//Se elimina la sesión
		$this->Sesiones_model->destruirSesion();

		$msg = "Session cerrada!";

		$this->load->view('base/cabecera');
		$this->load->view('base/page_top', $msg);
		$this->load->view('home');
		$this->load->view('base/page_bottom');
	}

	public function anadirHorarioLocal() {

		$this->Locales_model->insertHorarioLocal($_SESSION['idLocal'], $_POST['idDia']
				, $_POST['horaInicio'] . ":" . $_POST['minutoInicio']
				, $_POST['horaFin'] . ":" . $_POST['minutoFin']);

		$msg = "Horario añadido correctamente";

		$this->listaHorarioLocal($msg);
	}

	private function listaHorarioLocal($mensaje = '') {
		//Se obtienen los horarios de pedido del local
		$horarioLocal = $this->Locales_model->obtenerHorarioLocal($_SESSION['idLocal'])->result();

		$params = array('etiqueta' => 'horarioLocal', 'mensaje' => $mensaje);
		$this->load->library('objectandxml', $params);
		$var['xml'] = $this->objectandxml->objToXML($horarioLocal);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	function anadirHorarioPedido() {
		//Se recogen los parametros enviados por el formulario
		$idDia = $_POST["dia"];
		$horaInicio = $_POST["horaInicio"] . ":" . $_POST["minutoInicio"];
		$horaFin = $_POST['horaFin'] . ":" . $_POST["minutoFin"];


		//Se inserta la linea en la tabla
		$this->Locales_model->insertHorarioPedido($_SESSION['idLocal'], $idDia, $horaInicio, $horaFin);

		$msg = 'Horario añadido correctamente.';

		//Se obtienen los datos del local
		/*$datosLocal = $this->Locales_model->obtenerDatosLocal($_SESSION['idLocal'])->row();

		if ($datosLocal->estado_local == 2) {
		//Se actualiza el estado del local
		$this->Locales_model->modificarEstadoLocal(9, $_SESSION['idLocal']);
		}*/

		$this->listaHorarioPedido($msg);
	}

	private function listaHorarioPedido($mensaje = '') {
		//Se obtienen los horarios de pedido del local
		$horarioPedido = $this->Locales_model->obtenerHorarioPedidos($_SESSION['idLocal'])->result();

		$params = array('etiqueta' => 'horarioPedido', 'mensaje' => $mensaje);
		$this->load->library('objectandxml', $params);
		$var['xml'] = $this->objectandxml->objToXML($horarioPedido);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function panelControl() {
		$msg = "";

		$this->load->view('base/cabecera');
		$this->load->view('base/page_top', $msg);
		$this->load->view('locales/panelControl');
		$this->load->view('base/page_bottom');
	}

	public function gestionHorarios() {
		//Se obtienen los dias de la semana
		//Se carga el modelo de varios
		$this->load->model('varios/Varios_model');
		$var['dias'] = $this->Varios_model->obtenerDiasSemana()->result();
		$var2['dias'] = $var['dias'];

		//Se obtienen los horarios de pedido del local
		$var['horarioLocal'] = $this->Locales_model->obtenerHorarioLocal($_SESSION['idLocal'])->result();

		//Se obtienen los dias especiales que cierra el local.
		$var['diasCierreLocal'] = $this->Locales_model->obtenerDiasCierreLocal($_SESSION['idLocal'])->result();

		//Se obtienen los horarios de pedido del local
		$var2['horarioPedido'] = $this->Locales_model->obtenerHorarioPedidos($_SESSION['idLocal'])->result();

		$header['javascript'] = array('miajaxlib', 'jquery/jquery'
				, 'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min'
				, 'horarios', 'mensajes', 'js/bootstrap.min');

		$header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css','buscador.css'
				,'general.css');

		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top');
		$this->load->view('locales/altaHorario', $var);
		$this->load->view('locales/altaHorarioPedido', $var2);
		$this->load->view('base/page_bottom');
	}

	public function borrarHorarioLocal() {
		//Se borra el horario del local
		$this->Locales_model->borrarHorarioLocal($_POST['idHorarioLocal']);

		$mensaje = 'Horario borrado correctamente';

		$this->listaHorarioLocal($mensaje);
	}

	public function borrarHorarioPedido() {
		//Se borra el horario del local
		$this->Locales_model->borrarHorarioPedido($_POST['idHorarioPedido']);

		$mensaje = 'Horario borrado correctamente';

		$this->listaHorarioPedido($mensaje);
	}

	public function buscarLocal() {
		//Se obtienen los tipos de comida
		$var['tiposComida'] = $this->Locales_model->obtenerTiposComida()->result();

		//Se carga el modelo de servicios
		$this->load->model('servicios/Servicios_model');

		//Se obtienen los servicios del local
		$var['servicios'] = $this->Servicios_model->obtenerServicios()->result();

		//Se obtienen los locales buscados.
		$locales = $this->Locales_model->buscarLocales($_POST);

		$var2['locales'] = $locales->result();

		$var2['numLocalesEncontrados'] = $locales->num_rows();

		$header['javascript'] = array('miajaxlib', 'jquery/jquery', 'horarios');

		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top');
		$this->load->view('locales/buscadorLocales', $var);
		$this->load->view('locales/listaLocales', $var2);
		$this->load->view('base/page_bottom');
	}

	public function mostrarLocal($idLocal, $idTipoServicio = '0', $mensaje = '') {
		$this->load->library('cart');

		//Se obtienen los tipos de comida
		$var['tiposComida'] = $this->Locales_model->obtenerTiposComida()->result();

		//Se carga el modelo de servicios
		$this->load->model('servicios/Servicios_model');

		//Se obtienen los servicios del local
		$var['servicios'] = $this->Servicios_model->obtenerServicios()->result();

		//Se obtienen los servicios del local
		$var2['serviciosLocal'] = $this->Servicios_model->obtenerServiciosLocal($idLocal)->result();

		//Se comprueba si el local es favorito
		if ($_SESSION){
			$var2['esFavorito'] = false;
			if (
			$this->Locales_model->obtenerLocalFavoritos($idLocal, $_SESSION['idUsuario'])
			->num_rows()>0){
				$var2['esFavorito'] = true;
			}
		}

		//Se comprueban los servicios del local
		$var4['envioPedidos'] = false;
		foreach ($var2['serviciosLocal'] as $linea) {

			if ($linea->id_tipo_servicio_local == 2) {//Envio pedidos
				$var4['envioPedidos'] = true;
			}
		}

		//Se carga el modelo de articulos
		$this->load->model('articulos/Articulos_model');

		//Se obtienen los datos del local
		$var2['datosLocal'] = $this->Locales_model->obtenerDatosLocal($idLocal)->row();
		$datosMensaje['mensaje'] = $mensaje;

		//Se carga el modelo de valoraciones
		$this->load->model('valoraciones/Valoraciones_model');

		//Se obtienen las valoraciones
		$datosValoraciones['valoraciones'] =
		$this->Valoraciones_model->obtenerValoracionLocal($idLocal)->result();
		$datosValoraciones['idLocal'] = $idLocal;

		//Se añaden los archivos js utilizados
		$header['javascript'] = array('miajaxlib', 'jquery/jquery'
				, 'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min'
				, 'pedidos', 'menus', 'reservas', 'usuarios', 'locales', 'mensajes',
				'js/bootstrap.min'
		);

		$header['estilos'] = array('buscador.css','general.css', 'locales.css','pedidosLocal.css');

		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top', $datosMensaje);
		$this->load->view('locales/buscadorLocales', $var);
		$this->load->view('locales/mostrarLocal', $var2);

		switch ($idTipoServicio) {
			case 1:
				//Se carga el modelo de usuarios
				$this->load->model('usuarios/Usuarios_model');

				if ($_SESSION){
					//Se obtienen las direcciones del usuario
					$var4['direccionesEnvio'] = $this->Usuarios_model->obtenerDirecciones($_SESSION['idUsuario'])->result();
				}

				//Se obtienen los articulos del local
				$var3['articulosLocal'] = $this->Articulos_model->obtenerArticulosLocal($idLocal);

				//Se obtienen los articulos del local
				$var3['tiposArticuloLocal'] = $this->Articulos_model->obtenerTiposArticuloLocal($idLocal)->result();

				//Se comprueba si hay articulos personalizables en el local
				$var3['hayArticuloPersonalizable'] =
				$this->Articulos_model->comprobarArticuloPersonalizadoLocal
				($idLocal, 1)->num_rows();

				//Se carga el modelo de usuarios
				$this->load->model('ingredientes/Ingredientes_model');

				$var3['ingredientesLocal'] = $this->Ingredientes_model->obtenerIngredientes($idLocal)->result();

				if ($var4['envioPedidos']) {

					//Se comprueba si el local realiza envio de pedidos
					$servicioEnvioPedidos = $this->Servicios_model->existeServicioLocal($idLocal, 2);

					//Se guardan los datos del servicio de envio de pedidos
					$datosServicioEnvioPedidos = $servicioEnvioPedidos->row();

					//Se obtiene el precio del envio del pedido
					$var3['precioEnvioPedido'] =
					$this->Servicios_model->obtenerPrecioServicio
					($datosServicioEnvioPedidos->id_servicio_local)->row();

					$var4['precioEnvioPedido'] = $var3['precioEnvioPedido'];
				}

				$mismoLocal = false;
				foreach ($this->cart->contents() as $item) {
					if ($item['options']['idLocal'] == $idLocal) {
						$mismoLocal = true;
					}
				}

				/*
				 * Si no es el mismo local se destruye el carro
				*/
				if (!$mismoLocal) {
					$this->cart->destroy();
				}

				//Se obtiene el contenido del carro
				$var4['pedido'] = $this->cart->contents();
				$var4['precioTotal'] = $this->cart->total();

				$var3['idLocal'] = $idLocal;
				$var4['idLocal'] = $idLocal;

				$this->load->view('pedidos/realizarPedido', $var3);
				$this->load->view('pedidos/mostrarPedido', $var4);
				$this->load->view('usuarios/formularioDireccionEnvio');
				break;
			case 3:
				$this->reservasUsuario($idLocal);
				break;
			case 4:
				//Se carga el modelo de usuarios
				$this->load->model('menus/Menus_model');
				$datosCalendarioMenu['calendarioMenu'] = $this->Menus_model->generarCalendarioUsuario($idLocal);
				$this->load->view('menus/menusUsuario', $datosCalendarioMenu);
				break;
		}
		$this->load->view('locales/valoraciones', $datosValoraciones);
		$this->load->view('base/page_bottom');
	}

	function anadirLocalFavorito() {
		//Se comprueba si el local ya está en favoritos para el usuario
		$existeFavorito = $this->Locales_model->obtenerLocalFavoritos
		($_POST['idLocal'], $_SESSION['idUsuario'])->num_rows();

		if ($existeFavorito == 0) {
			//Se inserta el local en favoritos.
			$this->Locales_model->insertLocalFavoritos($_POST['idLocal'], $_SESSION['idUsuario']);
		}

		//Se carga la vista que genera el xml
		//$this->load->view('xml/cabecera');
		//$this->load->view('locales/xml/horarioLocal', $var);
		//$this->load->view('xml/final');
	}

	function quitarLocalFavorito() {
		//Se elimina el local de favoitos.
		$this->Locales_model->deleteLocalFavoritos
		($_POST['idLocal'], $_SESSION['idUsuario']);

		$var['idLocal'] = $_POST['idLocal'];
		$params = array('etiqueta' => 'local');
		$this->load->library('arraytoxml', $params);

		$var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');


		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	private function reservasUsuario($idLocal) {
		//Se carga el modelo de servicios
		$this->load->model('reservas/Reservas_model');
		$this->load->model('menus/Menus_model');

		$var3['idLocal'] = $idLocal;

		//Se obtienen los horarios del local
		$var3['horarioLocal'] = $this->Locales_model->obtenerHorarioLocal
		($idLocal)->result();

		if ($_SESSION){
			//Se obtienen las reservas que tiene realizadas el usuario
			$var3['reservasUsuario'] = $this->Reservas_model->obtenerActualesReservasUsuario
			($_SESSION['idUsuario'])->result();
		}

		//Se obtienen los tipos de menu
		$var3['tiposMenu'] = $this->Menus_model->obtenerTiposMenu()->result();

		$this->load->view('reservas/reservasUsuarioLocal', $var3);
		//$this->load->view('reservas/listaReservasUsuario', $var4);
	}

	public function anadirDiaCierreLocal() {
		//Se recogen los parametros enviados por el formulario
		$fecha = $_POST["fecha"];

		//Se comprueba si el formato del campo fecha es correcto
		if (DateTime::createFromFormat('Y-m-d', $fecha)) {

			//Se comprueba si ya existe la fecha
			$existeFecha = $this->Locales_model->comprobarDiaCierreLocal($fecha, $_SESSION['idLocal'])->num_rows();

			if ($existeFecha == 0) {
				//Se inserta la fecha
				$this->Locales_model->insertarDiaCierreLocal($fecha, $_SESSION['idLocal']);
				$msg = "Fecha añadida correctamente";
			} else {
				$msg = "La fecha indicada ya existe.";
			}
		} else {
			$msg = "Valor de fecha incorrecto";
		}

		$this->listaDiasCierreLocal($msg);
	}

	public function borrarDiaCierreLocal() {
		//Se recogen los parametros enviados por el formulario
		$idDiaCierreLocal = $_POST["idDiaCierreLocal"];

		$this->Locales_model->borrarDiaCierreLocal($idDiaCierreLocal);

		$mensaje = "Fecha borrada correctamente";

		$this->listaDiasCierreLocal($mensaje);
	}

	private function listaDiasCierreLocal($mensaje = '') {
		//Se obtienen los horarios de pedido del local
		$diasCierreLocal = $this->Locales_model->obtenerDiasCierreLocal($_SESSION['idLocal'])->result();

		$params = array('etiqueta' => 'diaCierreLocal', 'mensaje' => $mensaje);
		$this->load->library('objectandxml', $params);
		$var['xml'] = $this->objectandxml->objToXML($diasCierreLocal);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

}

