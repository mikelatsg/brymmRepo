<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Reservas extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		//Se carga el modelo de reservas
		$this->load->model('reservas/Reservas_model');
		//Se carga el modelo de sessiones
		$this->load->model('sesiones/Sesiones_model');
	}

	public function reservasLocal() {
		//Se obtienen las mesas del local
		$var2['mesasLocal'] = $this->Reservas_model->obtenerMesasLocal
		($_SESSION['idLocal'])->result();

		//Se obtienen las reservas pendientes del local
		$var['reservasLocal'] = $this->Reservas_model->obtenerReservasLocal
		($_SESSION['idLocal'], 'P')->result();

		//Se obtienen las reservas aceptadas del local
		$var['reservasAceptadasLocal'] =
		$this->Reservas_model->obtenerReservasLocal
		($_SESSION['idLocal'], 'AL')->result();

		//Se obtienen las reservas rechazadas del local
		$var['reservasRechazadasLocal'] =
		$this->Reservas_model->obtenerReservas2EstadosLocal
		($_SESSION['idLocal'], 'AU', 'RL')->result();

		//Se obtiene el calendario
		$var['calendarioReservas'] =
		$this->Reservas_model->generarCalendarioReservas($_SESSION['idLocal']);

		//Se carga el modelo de menus
		$this->load->model('menus/Menus_model');

		//Se obtienen los tipos de menu
		$var['tiposMenu'] = $this->Menus_model->obtenerTiposMenu()->result();

		$header['javascript'] = array('miajaxlib', 'jquery/jquery',
				'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min',
				'reservas', 'mensajes','js/bootstrap.min');

		$header['estilos'] = array('bootstrap-3.2.0-dist/css/bootstrap.min.css','buscador.css',
		'general.css','reservas.css');

		$this->load->view('base/cabecera', $header);
		$this->load->view('base/page_top');
		$this->load->view('reservas/mesasLocal', $var2);
		$this->load->view('reservas/reservasLocal', $var);
		$this->load->view('base/page_bottom');
	}

	public function anadirMesaLocal() {
		//Se recogen los parametros enviados por el formulario
		$nombreMesa = $_POST["nombreMesa"];
		$capacidad = $_POST['capacidad'];

		//Se comprueba que el nombre no está vacio
		if ($nombreMesa == '') {
			$mensaje = 'Falta por rellenar el nombre de la mesa!';
		} else {
			//Se comprueba si la capacidad es un numerico
			if (!is_numeric($capacidad) || $capacidad == 0) {
				$mensaje = 'Valor de capacidad incorrecto!';
			} else {
				//Comprobar existe mesa con este nombre
				$existeMesa = $this->Reservas_model->comprobarNombreMesaLocal
				($_SESSION['idLocal'], $nombreMesa)->num_rows();


				if ($existeMesa > 0) {
					$mensaje = 'Ya existe una mesa con este nombre';
				} else {
					//Se inserta la linea en la tabla
					$this->Reservas_model->insertarMesaLocal($nombreMesa, $capacidad
							, $_SESSION['idLocal']);
					$mensaje = 'Mesa creada correctamente.';
				}
			}
		}
		$this->listaMesasLocal($mensaje);
	}

	public function borrarMesaLocal() {
		//Se recogen los parametros enviados por el formulario
		$idMesaLocal = $_POST["idMesaLocal"];

		//Se borra la linea en la tabla
		$this->Reservas_model->borrarMesaLocal($idMesaLocal);

		$this->listaMesasLocal();
	}

	private function listaMesasLocal($mensaje = '') {
		//Se obtienen los platos del local
		$mesasLocal =
		$this->Reservas_model->obtenerMesasLocal($_SESSION['idLocal'])->result();

		$params = array('etiqueta' => 'mesaLocal', 'mensaje' => $mensaje);
		$this->load->library('objectandxml', $params);

		$var['xml'] = $this->objectandxml->objToXML($mesasLocal);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function anadirReservaUsuario() {
		//Se recogen los parametros enviados por el formulario
		$fecha = $_POST["fecha"];
		$hora = $_POST['hora'];
		$minuto = $_POST['minuto'];
		$idTipoMenu = $_POST['idTipoMenu'];
		$numeroPersonas = $_POST['numeroPersonas'];
		$idLocal = $_POST['idLocal'];
		$observaciones = $_POST['observaciones'];

		//Se comprueba si el numero de personas es numerico
		if (is_numeric($numeroPersonas) && $numeroPersonas > 0) {

			if (DateTime::createFromFormat('Y-m-d', $fecha)) {

				//Se carga el modelo de locales
				$this->load->model('locales/Locales_model');

				//Se comprueba si el local está abierto
				$localAbierto =
				$this->Locales_model->comprobarLocalAbierto($idLocal
						, DateTime::createFromFormat('Y-m-d', $fecha));

				if ($localAbierto) {

					//Se comprueba si las reservas están cerradas el día indicado
					$comprobarReservasCerradas =
					$this->Reservas_model->comprobarReservaCerrada($idLocal, $fecha
							, $idTipoMenu)->num_rows();

					if ($comprobarReservasCerradas > 0) {
						$mensaje = 'No se admiten mas reservas en la fecha indicada.';
					} else {
						$this->Reservas_model->insertarReservaUsuario($_SESSION['idUsuario'], $idLocal
								, $numeroPersonas, DateTime::createFromFormat('Y-m-d', $fecha)
								, $idTipoMenu, $hora . ":" . $minuto, '', $observaciones);

						$mensaje = 'Petición realizada correctamente';
					}
				} else {
					$mensaje = 'El local está cerrado el día indicado';
				}
			} else {
				$mensaje = 'El formato de la fecha es incorrecto';
			}
		} else {
			$mensaje = "El campo numero de personas tiene un valor incorrecto";
		}


		$this->listaReservasUsuario($mensaje);
	}

	public function anadirReservaLocal() {
		//Se recogen los parametros enviados por el formulario
		$fecha = $_POST['fecha'];
		$hora = $_POST['hora'];
		$minuto = $_POST['minuto'];
		$idTipoMenu = $_POST['idTipoMenu'];
		$numeroPersonas = $_POST['numeroPersonas'];
		$observaciones = $_POST['observaciones'];
		$nombreEmisor = $_POST['nombreEmisor'];
		if (isset($_POST['mesas'])) {
			$mesas = $_POST['mesas'];
		} else {
			$mesas = false;
		}

		//Se comprueban los campos del formulario
		if (DateTime::createFromFormat('Y-m-d', $fecha)) {
			if (is_numeric($numeroPersonas) && $numeroPersonas > 0) {

				if (!$nombreEmisor == '') {
					//Se carga el modelo de locales
					$this->load->model('locales/Locales_model');

					//Se comprueba si el local está abierto
					$localAbierto =
					$this->Locales_model->comprobarLocalAbierto($_SESSION['idLocal']
							, DateTime::createFromFormat('Y-m-d', $fecha));

					if ($localAbierto) {

						//Se comprueba si las reservas están cerradas el día indicado
						$comprobarReservasCerradas =
						$this->Reservas_model->comprobarReservaCerrada($_SESSION['idLocal']
								, $fecha
								, $idTipoMenu)->num_rows();

						if ($comprobarReservasCerradas > 0) {
							$mensaje = 'No se admiten mas reservas en la fecha indicada.';
						} else {
							$transOk = $this->Reservas_model->insertarReservaLocal(0, $_SESSION['idLocal']
									, $numeroPersonas, DateTime::createFromFormat('Y-m-d', $fecha)
									, $idTipoMenu, $hora . ":" . $minuto, '', $observaciones
									, $nombreEmisor, $mesas);

							/*
							 * Si el valor de idReserva es negativo ha habido algún error insertando
							la reserva */
							if ($transOk) {
								$mensaje = 'Reserva insertada correctamente';
							} else {
								$mensaje = 'Error insertando reserva';
							}
						}
					} else {
						$mensaje = 'El local está cerrado el día indicado';
					}
				} else {
					$mensaje = 'El campo a nombre de no puede estar vacio';
				}
			} else {
				$mensaje = 'El valor del campo numero personas es incorrecto';
			}
		} else {
			$mensaje = 'El valor del campo fecha es incorrecto';
		}
		$this->listaReservasAceptadasLocal($mensaje);
	}

	public function anularReservaUsuario() {
		//Se recogen los parametros enviados por el formulario
		$idReserva = $_POST["idReserva"];

		//Se modifica el estado de la reserva a anulada usuario (AU)
		$this->Reservas_model->modificarEstadoReserva($idReserva, 'AU');

		//Se borran las posibles mesas asignadas a la reserva para dejarlas libres
		$this->Reservas_model->borrarMesasReserva($idReserva);

		//Si las reservas están cerradas para ese dia se vuelven a abrir.
		$datosReserva = $this->Reservas_model->obtenerDatosReservaLocal($idReserva)->row();

		$this->Reservas_model->borrarReservaCerrada($datosReserva->id_local
				, $datosReserva->fecha, $datosReserva->id_tipo_menu);

		$mensaje = 'Reserva anulada correctamente';

		$this->listaReservasUsuario($mensaje);
	}

	public function anularReservaLocal() {
		//Se recogen los parametros enviados por el formulario
		$idReserva = $_POST["idReserva"];
		$motivo = $_POST["motivo"];

		//Se modifica el estado de la reserva a rechazado local (RL)
		$this->Reservas_model->modificarEstadoReserva($idReserva, 'RL', $motivo);

		//Se borran las posibles mesas asignadas a la reserva para dejarlas libres
		$this->Reservas_model->borrarMesasReserva($idReserva);

		//Si las reservas están cerradas para ese dia se vuelven a abrir.
		$datosReserva = $this->Reservas_model->obtenerDatosReservaLocal($idReserva)->row();

		$this->Reservas_model->borrarReservaCerrada($datosReserva->id_local
				, $datosReserva->fecha, $datosReserva->id_tipo_menu);

		$mensaje = 'Reserva anulada correctamente';

		$this->listaReservasAceptadasLocal($mensaje);
	}

	private function listaReservasUsuario($mensaje = '') {
		//Se obtienen los platos del local
		$reservasUsuario =
		$this->Reservas_model->obtenerActualesReservasUsuario($_SESSION['idUsuario'])->result();

		$params = array('etiqueta' => 'reservaUsuario', 'mensaje' => $mensaje);
		$this->load->library('objectandxml', $params);

		$var['xml'] = $this->objectandxml->objToXML($reservasUsuario);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function mostrarReservaLocal($idReserva = '', $mensaje = '') {
		//Si no se pasa parametro se recoge de $_POST
		if ($idReserva == '') {
			//Se recogen los parametros enviados por el formulario
			$idReserva = $_POST["idReserva"];
		}

		$datosReserva =
		$this->Reservas_model->obtenerDatosReservaLocal($idReserva)->row();

		$mesasLibres =
		$this->Reservas_model->obtenerMesasLibresLocal($_SESSION['idLocal']
				, $datosReserva->fecha, $datosReserva->id_tipo_menu)->result();

		$mesasReserva = $this->Reservas_model->obtenerMesasReserva($idReserva)->result();

		$detalleMesasLibres = array();
		foreach ($mesasLibres as $mesaLibre) {
			$detalleMesasLibres [] = array(
					"idMesaLibre" => $mesaLibre->id_mesa_local,
					"nombreMesaLibre" => $mesaLibre->nombre_mesa,
					"capacidadMesaLibre" => $mesaLibre->capacidad
			);
		}


		$detalleMesasReserva = array();
		foreach ($mesasReserva as $mesaReserva) {
			$detalleMesasReserva [] = array(
					"idReservaMesa" => $mesaReserva->id_reserva_mesa,
					"idMesaLocal" => $mesaReserva->id_mesa_local,
					"nombreMesaReserva" => $mesaReserva->nombre_mesa,
					"capacidadMesaReserva" => $mesaReserva->capacidad
			);
		}

		$var['reserva'] = array(
				"mensaje" => $mensaje,
				"idReserva" => $idReserva,
				"idUsuario" => $datosReserva->id_usuario,
				"nombreUsuario" => $datosReserva->nombreUsuario,
				"nick" => $datosReserva->nick,
				"nombreEmisor" => $datosReserva->nombre_emisor,
				"numeroPersonas" => $datosReserva->numero_personas,
				"fecha" => $datosReserva->fecha,
				"idTipoMenu" => $datosReserva->id_tipo_menu,
				"tipoMenu" => $datosReserva->tipo_menu,
				"horaInicio" => $datosReserva->hora_inicio,
				"estado" => $datosReserva->estado,
				"observaciones" => $datosReserva->observaciones,
				"motivo" => $datosReserva->motivo,
				"detalleMesasLibres" => $detalleMesasLibres,
				"detalleMesasReserva" => $detalleMesasReserva
		);

		$params = array('etiqueta' => 'reserva');
		$this->load->library('arraytoxml', $params);
		$var['xml'] = $this->arraytoxml->convertArrayToXml($var['reserva'], 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function mostrarReservaUsuario() {

		$idReserva = $_POST["idReserva"];


		$datosReserva =
		$this->Reservas_model->obtenerDatosReservaUsuario($idReserva)->row();

		$var['reserva'] = array(
				"idReserva" => $idReserva,
				"idLocal" => $datosReserva->id_local,
				"nombreLocal" => $datosReserva->nombreLocal,
				"numeroPersonas" => $datosReserva->numero_personas,
				"fecha" => $datosReserva->fecha,
				"idTipoMenu" => $datosReserva->id_tipo_menu,
				"tipoMenu" => $datosReserva->tipo_menu,
				"horaInicio" => $datosReserva->hora_inicio,
				"estado" => $datosReserva->estado,
				"observaciones" => $datosReserva->observaciones,
				"motivo" => $datosReserva->motivo,
		);

		$params = array('etiqueta' => 'reserva');
		$this->load->library('arraytoxml', $params);
		$var['xml'] = $this->arraytoxml->convertArrayToXml($var['reserva'], 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function asignarMesaReserva() {
		//Se recogen los parametros enviados por el formulario
		$idReserva = $_POST["idReserva"];
		$idMesaLocal = $_POST["idMesaLocal"];

		//Se inserta la mesa
		$this->Reservas_model->insertarMesaReserva($idMesaLocal, $idReserva);

		$mensaje = 'Mesa asignada correctamente';

		//Se muestran los datos actualizados
		$this->mostrarReservaLocal($idReserva, $mensaje);
	}

	public function borrarMesaReserva() {
		//Se recogen los parametros enviados por el formulario
		$idReserva = $_POST["idReserva"];
		$idReservaMesa = $_POST["idReservaMesa"];

		//Se borra la mesa
		$this->Reservas_model->borrarMesaReserva($idReservaMesa);

		$mensaje = 'Mesa borrada de la reserva correctamente';

		//Se muestran los datos actualizados
		$this->mostrarReservaLocal($idReserva, $mensaje);
	}

	public function aceptarReservaLocal() {
		//Se recogen los parametros enviados por el formulario
		$idReserva = $_POST["idReserva"];

		$this->Reservas_model->modificarEstadoReserva($idReserva, 'AL');

		$mensaje = 'Reserva aceptada';

		$this->listaReservasPendientesLocal($mensaje);
	}

	public function rechazarReservaLocal() {
		//Se recogen los parametros enviados por el formulario
		$idReserva = $_POST["idReserva"];
		$motivo = $_POST["motivo"];

		$this->Reservas_model->modificarEstadoReserva($idReserva, 'RL', $motivo);

		//Se borran las posibles mesas asignadas a la reserva para dejarlas libres
		$this->Reservas_model->borrarMesasReserva($idReserva);

		$mensaje = 'Reserva rechazada';

		$this->listaReservasPendientesLocal($mensaje);
	}

	private function listaReservasPendientesLocal($mensaje = '') {
		//Se obtienen las reservas pendientes del local
		$reservasLocal = $this->Reservas_model->obtenerReservasLocal
		($_SESSION['idLocal'], 'P')->result();



		$params = array('etiqueta' => 'reservaUsuario', 'mensaje' => $mensaje);
		$this->load->library('objectandxml', $params);

		$var['xml'] = $this->objectandxml->objToXML($reservasLocal);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function listaReservasAceptadasLocal($mensaje = '') {
		//Se obtienen las reservas NO pendientes del local
		$reservasAceptadasLocal =
		$this->Reservas_model->obtenerReservasLocal
		($_SESSION['idLocal'], 'AL')->result();

		$params = array('etiqueta' => 'reservaUsuario', 'mensaje' => $mensaje);
		$this->load->library('objectandxml', $params);

		$var['xml'] = $this->objectandxml->objToXML($reservasAceptadasLocal);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function listaReservasRechazadasLocal($mensaje = '') {
		//Se obtienen las reservas rechazadas del local
		$reservasRechazadasLocal =
		$this->Reservas_model->obtenerReservas2EstadosLocal
		($_SESSION['idLocal'], 'AU', 'RL')->result();

		$params = array('etiqueta' => 'reservaUsuario');
		$this->load->library('objectandxml', $params);

		$var['xml'] = $this->objectandxml->objToXML($reservasRechazadasLocal);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function obtenerReservasDia() {
		//Se recogen los parametros enviados por el formulario
		$dia = $_POST["dia"];
		$mes = $_POST["mes"];
		$ano = $_POST["ano"];
		$idTipoMenu = $_POST["idTipoMenu"];

		$fechaReserva = $ano . "-" . $mes . "-" . $dia;

		//Se obtienen las reservas del dia del local
		$reservasDiaLocal =
		$this->Reservas_model->obtenerReservasDiaTipoMenu($_SESSION['idLocal']
				, DateTime::createFromFormat('Y-m-d', $fechaReserva)
				, $idTipoMenu, 'AL')->result();

		$hayReservas = false;
		$detalleReservasDia = array();
		foreach ($reservasDiaLocal as $reservaDia) {
			$detalleReservasDia [] = array(
					"horaInicio" => $reservaDia->hora_inicio,
					"nombreUsuario" => $reservaDia->nombreUsuario,
					"nick" => $reservaDia->nick,
					"idUsuario" => $reservaDia->id_usuario,
					"idReserva" => $reservaDia->id_reserva,
					"nombreEmisor" => $reservaDia->nombre_emisor
			);

			$hayReservas = true;
			$tipoMenu = $reservaDia->tipo_menu;
		}

		if (!$hayReservas) {
			//Se obtiene el tipo menu
			$this->load->model('menus/Menus_model');
			$tipoMenu = $this->Menus_model->obtenerTipoMenu($idTipoMenu)->row()->descripcion;
		}

		//Se comprueba el estado de las reservas
		$reservasCerradas = $this->Reservas_model->comprobarReservaCerrada($_SESSION['idLocal']
				, $fechaReserva, $idTipoMenu)->num_rows();

		if ($reservasCerradas > 0) {
			$reservasAbiertas = false;
		} else {
			$reservasAbiertas = true;
		}

		$var['reservasDiaLocal'] = array(
				"fecha" => $fechaReserva,
				"tipoMenu" => $tipoMenu,
				"idTipoMenu" => $idTipoMenu,
				"reservasAbiertas" => $reservasAbiertas,
				"detalleReservasDia" => $detalleReservasDia
		);

		$params = array('etiqueta' => 'reservaDiaLocal');
		$this->load->library('arraytoxml', $params);
		$var['xml'] = $this->arraytoxml->convertArrayToXml($var['reservasDiaLocal'], 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function cerrarReservaDia() {
		//Se recogen los parametros enviados por el formulario
		$fecha = $_POST["fecha"];
		$idTipoMenu = $_POST["idTipoMenu"];

		$comprobarReservasCerradas =
		$this->Reservas_model->comprobarReservaCerrada($_SESSION['idLocal'], $fecha, $idTipoMenu)->num_rows();

		if ($comprobarReservasCerradas > 0) {
			$mensaje = "Las reservas ya están cerradas para la fecha indicada";
		} else {
			$this->Reservas_model->insertarCerrarReserva($_SESSION['idLocal'], $fecha, $idTipoMenu);
			$mensaje = "Operación realizada correctamente";
		}

		$params = array('etiqueta' => 'mensaje');
		$this->load->library('arraytoxml', $params);
		$var['xml'] = $this->arraytoxml->convertArrayToXml($mensaje, 'mensaje');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	function mostrarCalendarioReservas() {
		$ano = $_POST['ano'];
		$mes = $_POST['mes'];

		//Se obtiene el calendario
		$var['calendarioReservas'] =
		htmlentities($this->Reservas_model->generarCalendarioReservas
				($_SESSION['idLocal'], $mes, $ano));

		$params = array('etiqueta' => 'calendarioReservas');
		$this->load->library('arraytoxml', $params);

		$var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	function actualizarCalendarioReservas() {
		//Se obtiene el calendario
		$var['calendarioReservas'] =
		htmlentities($this->Reservas_model->generarCalendarioReservas
				($_SESSION['idLocal']));

		$params = array('etiqueta' => 'calendarioReservas');
		$this->load->library('arraytoxml', $params);

		$var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function abrirReservaDia() {
		//Se recogen los parametros enviados por el formulario
		$fecha = $_POST["fecha"];
		$idTipoMenu = $_POST["idTipoMenu"];


		$this->Reservas_model->borrarReservaCerrada($_SESSION['idLocal'], $fecha, $idTipoMenu);
		$mensaje = "Operación realizada correctamente";

		$params = array('etiqueta' => 'mensaje');
		$this->load->library('arraytoxml', $params);
		$var['xml'] = $this->arraytoxml->convertArrayToXml($mensaje, 'mensaje');

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

	public function obtenerMesasLibres() {

		$fecha = $_POST["fecha"];

		$mesasLibres =
		$this->Reservas_model->obtenerMesasLibresLocal($_SESSION['idLocal']
				, DateTime::createFromFormat('Y-m-d', $fecha)->format('Y-m-d')
				, $_POST["idTipoMenu"]
		)->result();

		$params = array('etiqueta' => 'mesaLibre');
		$this->load->library('objectandxml', $params);

		$var['xml'] = $this->objectandxml->objToXML($mesasLibres);

		//Se carga la vista que genera el xml
		$this->load->view('xml/generarXML', $var);
	}

}

