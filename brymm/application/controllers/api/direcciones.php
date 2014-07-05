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
require_once APPPATH . '/libraries/usuario/Direccion.php';

class Direcciones extends REST_Controller {

    const CODE_OK = 200;
    const CODE_KO = 404;
    const CODE_NO_DATA = 400;


    //Campos enviados con JSON
    const JSON_DIRECCION_OK = "direccionOK";
    const JSON_MENSAJE = "mensaje";
    const JSON_DIRECCION = "direccion";

    //Datos recibidos
    const FIELD_ID_DIRECCION = "idDireccion";
    const FIELD_ID_LOCAL = "idLocal";

    //Constantes
    const CONST_SERVICIOS = "servicios";

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        //Se carga el modelo de usuarios
        $this->load->model('usuarios/Usuarios_model');
    }

    function nuevaDireccion_post() {
        //Se recogen los datos recibidos en formato json
        $datosDireccion = $this->post();

        $direccion = Direccion::withData($datosDireccion['direccion']['nombre']
                        , $datosDireccion['direccion']['direccion']
                        , $datosDireccion['direccion']['poblacion']
                        , $datosDireccion['direccion']['provincia']
                        , $datosDireccion['idUsuario']);

        $hayError = false;
        $msg = "";

        //Se comprueban los campos del formulario
        if ($direccion->nombre == "") {
            $msg = "El campo nombre no puede estar vacio";
            $hayError = true;
        }

        if ($direccion->direccion == "" && !$hayError) {
            $msg = "El campo direccion no puede estar vacio";
            $hayError = true;
        }

        if ($direccion->poblacion == "" && !$hayError) {
            $msg = "El campo poblacion no puede estar vacio";
            $hayError = true;
        }

        if ($direccion->provincia == "" && !$hayError) {
            $msg = "El campo provincia no puede estar vacio";
            $hayError = true;
        }

        $datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '0',
            Direcciones::JSON_MENSAJE => $msg);

        if (!$hayError) {
            //Se comprueba si existe la direccion
            $existeDireccion =
                    $this->Usuarios_model->comprobarDireccion($direccion->idUsuario, $direccion->nombre)->num_rows();

            if ($existeDireccion > 0) {
                $msg = "Ya existe una direccion con ese nombre";
                $datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '0',
                    Direcciones::JSON_MENSAJE => $msg);
            } else {
                $direccion->idDireccion =
                        $this->Usuarios_model->insertDireccionEnvioObject($direccion);

                $msg = "Direccion insertada correctamente";
                $datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '1',
                    Direcciones::JSON_MENSAJE => $msg,
                    Direcciones::JSON_DIRECCION => $direccion);
            }
        }

        $this->response($datosRespuesta, Direcciones::CODE_OK);
    }

    function modificarDireccion_post() {
        $datosDireccion = $this->post();

        $direccion = Direccion::withData($datosDireccion['direccion']['nombre']
                        , $datosDireccion['direccion']['direccion']
                        , $datosDireccion['direccion']['poblacion']
                        , $datosDireccion['direccion']['provincia']
                        , $datosDireccion['idUsuario']
                        , $datosDireccion['direccion']['idDireccion']);




        $hayError = false;
        $msg = "";

        //Se comprueban los campos del formulario
        if ($direccion->nombre == "") {
            $msg = "El campo nombre no puede estar vacio";
            $hayError = true;
        }

        if ($direccion->direccion == "" && !$hayError) {
            $msg = "El campo direccion no puede estar vacio";
            $hayError = true;
        }

        if ($direccion->poblacion == "" && !$hayError) {
            $msg = "El campo poblacion no puede estar vacio";
            $hayError = true;
        }

        if ($direccion->provincia == "" && !$hayError) {
            $msg = "El campo provincia no puede estar vacio";
            $hayError = true;
        }

        $datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '0',
            Direcciones::JSON_MENSAJE => $msg);

        if (!$hayError) {
            //Se comprueba si existe la direccion
            $existeDireccion =
                    $this->Usuarios_model->comprobarDireccion($direccion->idUsuario, $direccion->nombre);

            $modificarDireccion = true;

            if ($existeDireccion->num_rows() > 0) {
                if ($existeDireccion->row()->id_direccion_envio != $direccion->id_direccion_envio) {
                    $msg = "Ya existe una direccion con ese nombre";
                    $datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '0',
                        Direcciones::JSON_MENSAJE => $msg);
                    $modificarDireccion = false;
                }
            }

            if ($modificarDireccion) {

                $this->Usuarios_model->modificarDireccionEnvio($direccion);

                $msg = "Direccion modificada correctamente";
                $datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '1',
                    Direcciones::JSON_MENSAJE => $msg,
                    Direcciones::JSON_DIRECCION => $direccion);
            }
        }

        $this->response($datosRespuesta, Direcciones::CODE_OK);
    }

    function borrarDireccion_get() {
        if (!$this->get(Direcciones::FIELD_ID_DIRECCION)) {
            $msg = "Error borrando direccion";
            $datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '0',
                Direcciones::JSON_MENSAJE => $msg);
            $this->response($datosRespuesta, Direcciones::CODE_OK);
        }

        $idDireccion = $this->get(Direcciones::FIELD_ID_DIRECCION);

        $msg = "Direccion borrada correctamente";
        //Se comprueba si la direccion se ha usado para anularla o borrarla
        $direccionActiva =
                $this->Usuarios_model->comprobarDireccionPedidos($idDireccion)->num_rows();

        if ($direccionActiva) {
            //Se anula la direccion
            $this->Usuarios_model->anularDireccionEnvio($idDireccion);
        } else {
            //se borra la direccion
            $this->Usuarios_model->borrarDireccionEnvio($idDireccion);
        }

        $datosRespuesta = array(Direcciones::JSON_DIRECCION_OK => '1',
            Direcciones::JSON_MENSAJE => $msg);
        $this->response($datosRespuesta, Direcciones::CODE_OK);
    }

}