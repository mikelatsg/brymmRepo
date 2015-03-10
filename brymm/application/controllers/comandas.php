<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . '/libraries/alertas/alerta.php';
require_once APPPATH . '/libraries/comandas/comanda.php';
require_once APPPATH . '/libraries/comandas/detalleComanda.php';
require_once APPPATH . '/libraries/comandas/tipoComanda.php';
require_once APPPATH . '/libraries/comandas/menuComanda.php';
require_once APPPATH . '/libraries/menus/menu.php';
require_once APPPATH . '/libraries/menus/plato.php';
require_once APPPATH . '/libraries/reservas/mesa.php';
require_once APPPATH . '/libraries/menus/tipoPlato.php';
require_once APPPATH . '/libraries/comandas/comanda.php';
require_once APPPATH . '/libraries/comandas/camarero.php';
require_once APPPATH . '/libraries/ingredientes/ingrediente.php';

class Comandas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        //Se carga el modelo de camareros
        $this->load->model('camareros/Camareros_model');
        //Se carga el modelo de comandas
        $this->load->model('comandas/Comandas_model');
        //Se carga el modelo de sessiones
        $this->load->model('sesiones/Sesiones_model');
        //Se carga la libreria cart
        $this->load->library('my_cart');
    }

    public function anadirArticuloComanda() {

        $msg = "Articulo añadido correctamente";

        if ($_POST['cantidad'] > 0) {
            //Se añade el articulo a la comanda
            $this->Comandas_model->anadirArticuloComanda($_POST['idArticuloLocal'], $_POST['cantidad']
                    , $_POST['precio'], $_POST['articulo'], $_POST['idTipoArticulo']);
        } else {
            $msg = "La cantidad tiene que ser mayor que 0";
        }
        //Se muestra la comanda
        $this->mostrarComanda($msg);
    }

    public function anadirArticuloPerComanda() {

        srand(time());
        $articuloPersonalizado = rand(1, 100000);

        //Se carga el modelo de articulos
        $this->load->model('articulos/Articulos_model');

        //Se obtiene el precio del articulo
        $datosTipoArticulo = $this->Articulos_model->obtenerTipoArticuloLocal($_POST['idTipoArticuloLocal'])->row();
        $precio = $datosTipoArticulo->precio;

        //Se carga el modelo de ingredientes
        $this->load->model('ingredientes/Ingredientes_model');

        $i = 0;

        if (isset($_POST['ingrediente'])) {
            foreach ($_POST['ingrediente'] as $ingrediente) {
                $datosIngrediente = $this->Ingredientes_model->obtenerIngrediente($ingrediente)->row();
                $precio = $precio + $datosIngrediente->precio;
                $ingredienteComanda[$i] = array('idIngrediente' => $datosIngrediente->id_ingrediente,
                    'ingrediente' => $datosIngrediente->ingrediente,
                    'precioIngrediente' => $datosIngrediente->precio);
                $i += 1;
            }
            if ($_POST['cantidadArticuloPersonalizado'] > 0) {
                $this->Comandas_model->anadirArticuloPerComanda($articuloPersonalizado, $_POST['cantidadArticuloPersonalizado']
                        , $precio, $datosTipoArticulo, $ingredienteComanda);

                $msg = "Articulo personalizado añadido correctamente";
            } else {
                $msg = "La cantidad tiene que ser mayor que 0";
            }
        } else {
            $msg = "No se ha seleccionado ningún ingrediente";
        }

        $this->mostrarComanda($msg);
    }

    public function anadirMenuComanda() {

        $msg = "Menu añadido correctamente";

        //Se carga el modelo de menus
        $this->load->model('menus/Menus_model');

        $cantidadMenu = $_POST['menuCantidad'];
        $plato = array();
        $platos = array();
        foreach (array_keys($_POST) as $value) {
            //Si es una cantidad de plato y es mayor que cero la guardo en el array
            if (stristr($value, 'platoCantidad') && $_POST[$value] > 0) {

                $idPlatoLocal = substr($value, strpos($value, '_') + 1);
                //Se obtiene el nombre del plato
                $datosPlato = $this->Menus_model->obtenerPlatoLocal($idPlatoLocal)->row();

                $plato = array(
                    'idPlatoLocal' => $idPlatoLocal,
                    'nombrePlato' => $datosPlato->nombre,
                    'platoCantidad' => $_POST[$value]
                );
                $platos[] = $plato;
            }
        }

        if (count($platos) > 0) {
            //Se añade el menu a la comanda
            $this->Comandas_model->anadirMenuComanda($cantidadMenu
                    , $_POST['idTipoMenuLocal'], $platos);
        } else {
            $msg = "No se ha añadido ningún menu, revisa que las cantidades sean mayor que 0";
        }

        $this->mostrarComanda($msg);
    }

    public function anadirPlatoComanda() {

        $msg = "Plato añadido correctamente";

        if ($_POST['cantidad'] > 0) {
            //Se añade el plato a la comanda
            $this->Comandas_model->anadirPlatoComanda($_POST['idPlatoLocal'], $_POST['cantidad']
                    , $_POST['precioPlato'], $_POST['nombrePlato']);
        } else {
            $msg = "La cantidad tiene que ser mayor que 0";
        }

        $this->mostrarComanda($msg);
    }

    private function mostrarComanda($mensaje = '') {
        $var['pedido'] = $this->my_cart->contents();
        $var['pedido']['total'] = $this->my_cart->total();
        $var['mensaje'] = $mensaje;

        $params = array('etiqueta' => 'lineaPedido');
        $this->load->library('arraytoxml', $params);
        $var['xml'] = $this->arraytoxml->convertArrayToXml($var, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    public function borrarArticuloComanda() {

        $data = $this->my_cart->contents();

        //Se borra el articulo indicado
        unset($data[$_POST['rowid']]);

        //Machaco el pedido
        $this->my_cart->destroy();
        $this->my_cart->insert($data);
        
        $msg = "Articulo borrado de la comanda";
        
        //Se muestra la comanda
        $this->mostrarComanda($msg);
    }

    public function cancelarComanda() {
        //Borro el pedido
        $this->my_cart->destroy();

        $msg = "Comanda cancelada correctamente";
        
        //Se muestra el pedido
        $this->mostrarComanda($msg);
    }

    public function aceptarComanda() {

        $vaciarDivComanda = 1;
        $datosComanda = $this->my_cart->contents();
        $precioComanda = $this->my_cart->total();

        $msg = "Comanda enviada correctamente";
        $pedidoOk = false;
        //Se comprueba si hay algun camarero dado de alta
        if (isset($_SESSION['idCamarero'])) {

            //Se comprueba si existe algo 
            if ($this->my_cart->total() > 0) {
                //Local
                if ($_POST['localLlevar'] == 1) {
                    /*
                     * Se comprueba si el campo mesa tiene valor
                     */
                    if (!$_POST['idMesaLocal'] == "") {
                        $pedidoOk = $this->Comandas_model->insertarComandaLocal($datosComanda, $_POST['idMesaLocal']
                                , $_POST['observaciones'], $_SESSION['idLocal'], $_SESSION['idCamarero']
                                , $precioComanda);
                    } else {
                        $msg = "El campo \"mesa\" tiene que estar informado";
                    }
                } else {
                    //Para llevar
                    //Se comprueba si el campo aNombre tiene contenido
                    if (!$_POST['aNombre'] == "") {
                        $pedidoOk = $this->Comandas_model->insertarComandaLlevar($datosComanda, $_POST['aNombre']
                                , $_POST['observaciones'], $_SESSION['idLocal'], $_SESSION['idCamarero']
                                , $precioComanda);
                    } else {
                        $msg = "El campo \"a nombre de\" tiene que estar informado";
                    }
                }

                //Si se ha insertado bien la comanda se borra el carro.
                if ($pedidoOk) {
                    $this->my_cart->destroy();
                } else {
                    $vaciarDivComanda = 0;
                }
            } else {
                $msg = "No hay comanda pendiente de enviar";
            }
        } else {
            $msg = "No hay ningun camarero activo";
            $vaciarDivComanda = 0;
        }

        $this->listaComandas($msg, $vaciarDivComanda);
    }

    public function anadirComanda() {
        $datosComanda = $this->my_cart->contents();
        $precioComanda = $this->my_cart->total();
        $vaciarDivComanda = 1;

        //Se comprueba si hay algun camarero dado de alta
        if (isset($_SESSION['idCamarero'])) {
            //Se comprueba si se ha seleccionado una comanda
            if (!$_POST['idComandaAbierta'] == "") {
                //Se comprueba si existe algo 
                if ($this->my_cart->total_items() > 0) {

                    //Para llevar
                    $pedidoOk = $this->Comandas_model->anadirComanda($datosComanda
                            , $_POST['observaciones']
                            , $precioComanda, $_POST['idComandaAbierta']);

                    //Si se ha insertado bien la comanda se borra el carro.
                    if ($pedidoOk['noError']) {
                        $this->my_cart->destroy();
                        $msg = "Comanda añadida correctamente";
                    } else {
                        $msg = $pedidoOk['mensaje'];
                        $vaciarDivComanda = 0;
                    }
                } else {
                    $msg = "No hay comanda pendiente de enviar";
                }
            } else {
                $msg = "No hay comanda selleccionada";
                $vaciarDivComanda = 0;
            }
        } else {
            $msg = "No hay ningun camarero activo";
            $vaciarDivComanda = 0;
        }

        $this->listaComandas($msg, $vaciarDivComanda);
    }

    public function anadirPlatoMenuComanda() {
        $msg = "";

        //Se carga el modelo de menus
        $this->load->model('menus/Menus_model');

        $cantidadPlato = $_POST['cantidad'];
        $idPlatoLocal = $_POST['idPlatoLocal'];
        $idTipoMenuLocal = $_POST['idTipoMenuLocal'];
        $plato = array();

        //Si es una cantidad de plato y es mayor que cero la guardo en el array
        if ($cantidadPlato > 0) {

            //Se obtiene el nombre del plato
            $datosPlato =
                    $this->Menus_model->obtenerPlatoLocal($idPlatoLocal)->row();

            $plato[0] = array(
                'idPlatoLocal' => $idPlatoLocal,
                'nombrePlato' => $datosPlato->nombre,
                'platoCantidad' => $cantidadPlato
            );
        } else {
            $msg = "La cantidad tiene que ser mayor que 0";
        }

        //Se añade el plato a la comanda
        $this->Comandas_model->anadirPlatoMenuComanda($cantidadPlato
                , $idTipoMenuLocal, $plato);

        $this->mostrarComanda($msg);
    }

    public function cerrarComandaCamarero() {

        $this->Comandas_model->cambiarEstadoComanda($_POST['idComanda'], 'CC');

        $msg = 'Comanda cerrada correctamente';

        $this->listaComandas($msg);
    }

    public function cancelarComandaCamarero() {

        $this->Comandas_model->cambiarEstadoComanda($_POST['idComanda'], 'CW');

        $msg = 'Comanda cancelada correctamente';

        $this->listaComandas($msg);
    }

    private function listaComandas($mensaje = '', $vaciarDivComanda = 1) {

        //Se obtienen las comandas activas
        $comandasActivas = $this->Comandas_model->obtenerComandasEstadoDiferente
                        ($_SESSION['idLocal'], 'CC')->result_array();

        //Se obtienen las comandas cerradas
        $comandasCerradas = $this->Comandas_model->obtenerComandasCerradas
                        ($_SESSION['idLocal'])->result_array();

        $comandas = array('mensaje' => $mensaje
            , 'vaciarDivComanda' => $vaciarDivComanda
            , 'comandaActiva' => $comandasActivas
            , 'comandaCerrada' => $comandasCerradas);

        $params = array('etiqueta' => 'comanda');
        $this->load->library('arraytoxml', $params);
        $var['xml'] = $this->arraytoxml->convertArrayToXml($comandas, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    public function verComandaCamarero($mensaje = '') {
        //Se borra el pedido que pueda haber en memoria
        $this->my_cart->destroy();

        //Se obtienen los datos de la comanda
        $datosComanda = $this->Comandas_model->obtenerComanda($_POST['idComanda']);

        $comanda = array('mensaje' => $mensaje,
            'comanda' => $datosComanda);

        $params = array('etiqueta' => 'comanda');
        $this->load->library('arraytoxml', $params);
        $var['xml'] = $this->arraytoxml->convertArrayToXml($comanda, 'xml');

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    public function terminarComandaCocina() {
        $this->Comandas_model->cambiarEstadoComanda($_POST['idComanda'], 'TC');

        $msg = 'Comanda terminada correctamente';

        $this->listaComandas($msg);
    }

    public function terminarDetalleComanda() {
        $this->Comandas_model->cambiarEstadoDetalleComanda($_POST['idDetalleComanda'], 'TC');

        //Si el detalle de comanda es un menu se terminan todos sus platos.
        $detalleComanda =
                $this->Comandas_model->obtenerDetalleComanda($_POST['idDetalleComanda'])->row();
        if ($detalleComanda->id_tipo_comanda == 3) {
            $this->Comandas_model->cambiarEstadoComandaMenu($_POST['idDetalleComanda'], 'TC');
        }

        $msg = 'Articulo terminado correctamente';

        $this->verComandaCamarero($msg);
    }

    public function terminarPlatoMenu() {
        $this->Comandas_model->cambiarEstadoPlatoMenu($_POST['idComandaMenu'], 'TC');

        $msg = 'Plato terminado correctamente';

        $this->verComandaCamarero($msg);
    }
    
    public function comprobarAlertaComanda() {
    
    	$this->load->model('alertas/Alertas_model');
    
    	$fecha = $_POST['fecha'];
    
    	$fechaAlertas = DateTime::createFromFormat('Y-m-d H:i:s', $fecha);
    
    	$fechaAlertas->modify("-2 minutes");
    
    	$hayComanda = $this->Alertas_model->hayTipoAlertaNuevaLocal($_SESSION['idLocal'], $fechaAlertas->format('Y-m-d H:i:s'), 4);
    
    	$datos = array("hayAlertaComanda" =>$hayComanda);
    
    	//Se genera el json
    	echo json_encode($datos);
    }
    
    public function obtenerComandasActivas(){
    	$comandas =  $this->Comandas_model->obtenerComandasActivasObject($_SESSION['idLocal']);
    
    	$datos = array("comandasActivas" =>$comandas);
    
    	//Se genera el json
    	echo json_encode($datos);
    }

}

