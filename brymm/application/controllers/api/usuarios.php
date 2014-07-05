<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @package	CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author	Mikelats Garcia
 */
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Usuarios extends REST_Controller {

    const CODE_OK = 200;
    const CODE_KO = 404;

    //Datos recibidos
    const FIELD_ID_USUARIO = "idUsuario";
    const FIELD_NICK = "nick";
    const FIELD_PASSWORD = "password";
    const FIELD_ID_LOCAL = "idLocal";

    //Campos enviados con JSON
    const JSON_ID_USUARIO = "idUsuario";
    const JSON_ULTIMOS_PEDIDOS = "ultimosPedidos";
    const JSON_ULTIMAS_RESERVAS = "ultimasReservas";
    const JSON_DIRECCIONES = "direcciones";
    const JSON_LOCALES_FAVORITOS = "localesFavoritos";
    const JSON_TIPOS_SERVICIO = "tiposServicio";
    const JSON_TIPOS_COMIDA = "tiposComida";
    const JSON_MSG = "msg";
    const JSON_OPERACION_OK = "operacionOK";
    const JSON_MENSAJE = "mensaje";
    const JSON_LOCAL_FAVORITO = "localFavorito";

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        //Se carga el modelo de usuarios
        $this->load->model('usuarios/Usuarios_model');
    }

    function loginUsuario_get() {
        if (!$this->get(Usuarios::FIELD_NICK) || !$this->get(Usuarios::FIELD_PASSWORD)) {
            $this->response(NULL, Usuarios::CODE_KO);
        }

        $nick = $this->get(Usuarios::FIELD_NICK);
        $password = $this->get(Usuarios::FIELD_PASSWORD);

        //Se comprueba si existe el usuario
        $result =
                $this->Usuarios_model->comprobarUsuarioLogin($nick, md5($password));

        $datosUsuario = array(Usuarios::JSON_ID_USUARIO => -1
            , Usuarios::JSON_MSG => 'Login KO .Usuario o password incorrecto');
        $codigoRetorno = Usuarios::CODE_KO;

        if ($result->num_rows() > 0) {

            $lineaUsuario = $result->row();

            $datosUsuario = array(Usuarios::JSON_ID_USUARIO => $lineaUsuario->id_usuario
                , Usuarios::JSON_MSG => 'Login OK');

            $codigoRetorno = Usuarios::CODE_OK;
        }

        $this->response($datosUsuario, $codigoRetorno);
    }

    function datosUsuario_get() {
        if (!$this->get(Usuarios::FIELD_ID_USUARIO)) {
            $this->response(NULL, Usuarios::CODE_KO);
        }

        $idUsuario = $this->get(Usuarios::FIELD_ID_USUARIO);

        //Se carga el model de pedidos
        $this->load->model('pedidos/Pedidos_model');

        //Se obtienen los ultimos pedidos
        $ultimosPedidos =
                $this->Pedidos_model->obtenerUltimosPedidosUsuario($idUsuario);

        //Se carga el model de pedidos
        $this->load->model('locales/Locales_model');

        //Locales favoritos
        $localesFavoritos =
                $this->Locales_model->obtenerLocalesFavoritos($idUsuario)->result();

        //Se obtienen los tipos de comida (para el buscador)
        $tiposComida = $this->Locales_model->obtenerTiposComida()->result();

        //Se carga el model de pedidos
        $this->load->model('reservas/Reservas_model');

        //Ultimas reservas
        $ultimasReservas =
                $this->Reservas_model->obtenerUltimasReservasUsuario($idUsuario)->result();

        //Se carga el model de pedidos
        $this->load->model('servicios/Servicios_model');

        //Tipos de servicio
        $servicios = $this->Servicios_model->obtenerServicios()->result();

        //Se carga el model de pedidos
        $this->load->model('usuarios/Usuarios_model');

        //Direcciones
        $direcciones =
                $this->Usuarios_model->obtenerDirecciones($idUsuario)->result();

        $datosUsuario = array(
            Usuarios::JSON_ULTIMOS_PEDIDOS => $ultimosPedidos,
            Usuarios::JSON_LOCALES_FAVORITOS => $localesFavoritos,
            Usuarios::JSON_ULTIMAS_RESERVAS => $ultimasReservas,
            Usuarios::JSON_DIRECCIONES => $direcciones,
            Usuarios::JSON_TIPOS_SERVICIO => $servicios,
            Usuarios::JSON_TIPOS_COMIDA => $tiposComida
        );

        $this->response($datosUsuario, Usuarios::CODE_OK);
    }

    function anadirFavorito_get() {
        if (!$this->get(Usuarios::FIELD_ID_LOCAL) ||
                !$this->get(Usuarios::FIELD_ID_USUARIO)) {
            $this->response(NULL, Usuarios::CODE_KO);
        }

        $idLocal = $this->get(Usuarios::FIELD_ID_LOCAL);
        $idUsuario = $this->get(Usuarios::FIELD_ID_USUARIO);

        $this->load->model('locales/Locales_model');

        $existeFavorito = $this->Locales_model->obtenerLocalFavoritos
                        ($idLocal, $idUsuario)->num_rows();

        $msg = "El local ya está existe en favoritos";
        $datosRespuesta = array(Usuarios::JSON_OPERACION_OK => '0',
            Usuarios::JSON_MENSAJE => $msg);

        if ($existeFavorito == 0) {
            //Se inserta el local en favoritos.
            $this->Locales_model->insertLocalFavoritos($idLocal, $idUsuario);

            $msg = "Local favorito añadido correctamente";

            $localFavorito =
                    $this->Locales_model->obtenerLocalFavoritos($idLocal, $idUsuario)->row();

            $datosRespuesta = array(Usuarios::JSON_OPERACION_OK => '1',
                Usuarios::JSON_MENSAJE => $msg,
                Usuarios::JSON_LOCAL_FAVORITO => $localFavorito);
        }

        $this->response($datosRespuesta, Usuarios::CODE_OK);
    }
    
    function eliminarFavorito_get() {
        if (!$this->get(Usuarios::FIELD_ID_LOCAL) ||
                !$this->get(Usuarios::FIELD_ID_USUARIO)) {
            $this->response(NULL, Usuarios::CODE_KO);
        }

        $idLocal = $this->get(Usuarios::FIELD_ID_LOCAL);
        $idUsuario = $this->get(Usuarios::FIELD_ID_USUARIO);

        $this->load->model('locales/Locales_model');

        $this->Locales_model->deleteLocalFavoritos
                        ($idLocal, $idUsuario);

        $msg = "Local eliminado de favoritos";
        $datosRespuesta = array(Usuarios::JSON_OPERACION_OK => '1',
            Usuarios::JSON_MENSAJE => $msg);

        $this->response($datosRespuesta, Usuarios::CODE_OK);
    }

}