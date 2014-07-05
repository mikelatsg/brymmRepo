<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Camareros extends CI_Controller {

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

    public function camarerosLocal() {

        //Se obtienen los camareros activos del local
        $var['camarerosLocal'] = $this->Camareros_model->obtenerCamarerosLocal
                        ($_SESSION['idLocal'], 1)->result();

        //Si hay algún camarero con sesion iniciada se envian sus datos
        if (isset($_SESSION['idCamarero'])) {
            $var['camareroSesion'] = $this->Camareros_model->obtenerDatosCamarero
                            ($_SESSION['idCamarero'], 1)->row();
        }

        //Se carga el modelo de reservas
        $this->load->model('reservas/Reservas_model');

        //Se carga el modelo de servicios
        $this->load->model('servicios/Servicios_model');

        //Se comprueban los servicios del local (Comanda)
        $existeServicio = $this->Servicios_model->servicioLocalActivo
                        ($_SESSION['idLocal'], 5)->num_rows();

        $hayComanda = false;
        if ($existeServicio) {
            $hayComanda = true;
        }

        //Se comprueban los servicios del local
        $existeServicio = $this->Servicios_model->servicioLocalActivo
                        ($_SESSION['idLocal'], 1)->num_rows();

        //Se comprueban los pedidos
        $hayPedido = false;
        if ($existeServicio || $hayComanda) {
            $hayPedido = true;
            //Se carga el modelo de articulos
            $this->load->model('articulos/Articulos_model');
            //Se obtienen los articulos del local
            $var2['articulosLocal'] =
                    $this->Articulos_model->obtenerArticulosLocal($_SESSION['idLocal']);

            $var2['hayPersonalizado'] = false;

            //Se comprueba si hay articulos personalizados.    
            $hayPersonalizado =
                    $this->Articulos_model->comprobarArticuloPersonalizadoLocal
                            ($_SESSION['idLocal'], true)->num_rows();

            if ($hayPersonalizado > 0) {
                $var2['hayPersonalizado'] = true;
                //Se obtienen los tipos de articulo del local
                $var2['tiposArticuloPerLocal'] =
                        $this->Articulos_model->obtenerTiposArticuloPerLocal
                                ($_SESSION['idLocal'], true)->result();

                //Se carga el modelo de usuarios
                $this->load->model('ingredientes/Ingredientes_model');

                $var2['ingredientesLocal'] =
                        $this->Ingredientes_model->obtenerIngredientes($_SESSION['idLocal'])->result();
            }

            $var2['mesasLocal'] =
                    $this->Reservas_model->obtenerMesasLocal($_SESSION['idLocal'])->result();
        }

        //Se comprueban los servicios del local
        $existeServicio =
                $this->Servicios_model->servicioLocalActivo($_SESSION['idLocal'], 4)->num_rows();

        //Se comprueban los menus
        $hayMenus = false;
        if ($existeServicio) {
            $hayMenus = true;
            //Se carga el modelo de menus            
            $this->load->model('menus/Menus_model');

            $var3['menusDia'] =
                    $this->Menus_model->obtenerMenuDia($_SESSION['idLocal']
                    , DateTime::createFromFormat('Y-m-d', date('Y-m-d')));

            $var3['mesasLocal'] =
                    $this->Reservas_model->obtenerMesasLocal($_SESSION['idLocal'])->result();
        }

        $this->load->library('cart');
        //Se obtiene el contenido del carro
        $var4['comanda'] = $this->cart->contents();
        $var4['precioTotalComanda'] = $this->cart->total();

        //Se obtienen las comandas activas
        $var4['comandasActivas'] = $this->Comandas_model->obtenerComandasEstadoDiferente
                        ($_SESSION['idLocal'], 'CC')->result();

        //Se obtienen las comandas cerradas
        $var4['comandasCerradas'] = $this->Comandas_model->obtenerComandasCerradas
                        ($_SESSION['idLocal'])->result();

        $msg = "";

        $header['javascript'] = array('miajaxlib', '/jquery/jquery'
            , 'jquery/jquery-ui-1.10.3.custom', 'jquery/jquery-ui-1.10.3.custom.min'
            , 'camareros', 'comandas', 'mensajes');

        //Se carga el siguiente paso del alta
        $this->load->view('base/cabecera', $header);
        $this->load->view('base/page_top', $msg);
        $this->load->view('camareros/gestionCamareros', $var);
        if ($hayPedido || $hayComanda) {
            $this->load->view('camareros/articulosCamarero', $var2);
        }
        if ($hayMenus) {
            $this->load->view('camareros/menusCamarero', $var3);
        }
        $this->load->view('camareros/mostrarComanda', $var4);
        //$this->load->view('camareros/mostrarComandasRealizadas', $var5);
        $this->load->view('base/page_bottom');
    }

    public function anadirCamarero() {
        //Se recogen los datos del formulario
        $nombreCamarero = $_POST['nombreCamarero'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        if (isset($_POST['controlTotal'])) {
            $controlTotal = true;
        } else {
            $controlTotal = false;
        }

        //Se comprueba si existe algun camarero con ese nombre en el local 
        $existeCamarero = $this->Camareros_model->comprobarCamareroLocal
                        ($_SESSION['idLocal'], $nombreCamarero, 1)->num_rows();


        if (!$nombreCamarero == "") {
            if (!$password == "") {
                if (!$existeCamarero > 0) {
                    //Si el password es correcto se inserta el camarero
                    if ($password == $password2) {
                        //Se encripta el pass
                        $encryptedPass = md5($password);

                        //Se inserta el camarero
                        $this->Camareros_model->insertarCamarero($_SESSION['idLocal'], $nombreCamarero
                                , $encryptedPass, $controlTotal, 1);

                        $mensaje = "Camarero añadido correctamente";
                    } else {
                        $mensaje = "Password incorrecto";
                    }
                } else {
                    $mensaje = "Ya existe un camarero con este nombre";
                }
            } else {
                $mensaje = "El campo password no puede estar vacio";
            }
        } else {
            $mensaje = "El campo nombre no puede estar vacio";
        }

        $this->listaCamareros($mensaje);
    }

    public function modificarCamarero() {

        $hayError = false;
        //Se recogen los datos del formulario
        $nombreCamarero = $_POST['nombreCamarero'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $idCamarero = $_POST['idCamarero'];
        if (isset($_POST['controlTotal'])) {
            $controlTotal = true;
        } else {
            $controlTotal = false;
        }

        if ($nombreCamarero == "" && !$hayError) {
            $mensaje = "El campo nombre no puede estar vacio";
            $hayError = true;
        }

        if ($password == "" && !$hayError) {
            $mensaje = "El campo password no puede estar vacio";
            $hayError = true;
        }
        //Si el password es correcto se inserta el camarero
        if (!$password == $password2 && !$hayError) {
            $mensaje = "Password incorrecto";
            $hayError = true;
        }

        //Se comprueba si existe algun camarero con ese nombre en el local 
        $existeCamarero = $this->Camareros_model->comprobarCamareroLocal
                ($_SESSION['idLocal'], $nombreCamarero, 1);

        if ($existeCamarero->num_rows() > 0 && !$hayError) {
            if ($existeCamarero->row()->id_camarero != $idCamarero) {
                $hayError = true;
                $mensaje = "Ya existe un camarero con este nombre";
            }
        }

        if (!$hayError) {
            //Se encripta el pass
            $encryptedPass = md5($password);

            //Se inserta el camarero
            $this->Camareros_model->modificarCamarero(
                    $idCamarero, $nombreCamarero
                    , $encryptedPass, $controlTotal);

            $mensaje = "Camarero modificado correctamente";
        }

        $this->listaCamareros($mensaje);
    }

    public function borrarCamarero() {
        //Se recogen los datos del formulario
        $idCamarero = $_POST['idCamarero'];

        $this->Camareros_model->borrarCamareroLocal($idCamarero);

        $mensaje = "Camarero borrado correctamente";

        $this->listaCamareros($mensaje);
    }

    private function listaCamareros($mensaje = '') {
        //Se obtienen los camareros activos del local
        $camarerosLocal = $this->Camareros_model->obtenerCamarerosLocal
                        ($_SESSION['idLocal'], 1)->result();

        $params = array('etiqueta' => 'camareroLocal', 'mensaje' => $mensaje);
        $this->load->library('objectandxml', $params);
        $var['xml'] = $this->objectandxml->objToXML($camarerosLocal);

        //Se carga la vista que genera el xml
        $this->load->view('xml/generarXML', $var);
    }

    public function login() {

        //Se comprueba si existe el camarero en el local
        $result =
                $this->Camareros_model->comprobarCamareroNombreLocal
                ($_POST['nombreCamarero']
                , md5($_POST['password'])
                , $_POST['nombreLocal']
                , 1);

        $msg = "Datos incorrectos!";
        $vistaCargar = "home";
        //Se comprueba si existe el usuario
        if ($result->num_rows() > 0) {
            $msg = "Login Ok!";
            $this->Sesiones_model->iniciarSesionCamarero
                    ($result->row()->id_camarero
                    , $result->row()->id_local
                    , $result->row()->control_total);
            $vistaCargar = 'locales/panelControl';
        }

        $header['javascript'] = array('miajaxlib', 'jquery/jquery', 'horarios');
        $this->load->view('base/cabecera', $header);
        $this->load->view('base/page_top', $msg);
        $this->load->view($vistaCargar);
        $this->load->view('base/page_bottom');
    }

    public function iniciarSesionCamarero() {
        //Se recogen los datos del formulario
        $idCamarero = $_POST['idCamarero'];

        //Se comprueba si el camarero tiene control_total
        $controlTotal = $this->Camareros_model->obtenerDatosCamarero
                        ($idCamarero, 1)->row()->control_total;

        $this->Sesiones_model->iniciarSesionCamarero($idCamarero
                , $_SESSION['idLocal'], $controlTotal);

        $mensaje = "Sesion iniciada correctamente";

        $this->mostrarSesionCamarero($mensaje);
    }

    public function cerrarSesionCamarero() {

        $this->Sesiones_model->cerrarSesionCamarero();

        $mensaje = "Sesion cerrada correctamente";

        /* if (isset($_SESSION['idLocal'])) {
          $this->mostrarSesionCamarero($mensaje);
          } else{ */
        redirect('home', 'location');
    }

    private function mostrarSesionCamarero($mensaje = '') {

        //Se obtienen los datos del camarero
        if (isset($_SESSION['idCamarero'])) {
            $camareroSesion = $this->Camareros_model->obtenerDatosCamarero
                            ($_SESSION['idCamarero'], 1)->row();

            $params = array('etiqueta' => 'camareroSesion', 'mensaje' => $mensaje);
            $this->load->library('objectandxml', $params);
            $var['xml'] = $this->objectandxml->objToXML($camareroSesion);

            //Se carga la vista que genera el xml
            $this->load->view('xml/generarXML', $var);
        } else {
            $camareroSesion = array('mensaje' => $mensaje);

            $params = array('etiqueta' => 'camareroSesion');
            $this->load->library('arraytoxml', $params);

            $var['xml'] = $this->arraytoxml->convertArrayToXml($camareroSesion, 'xml');

            //Se carga la vista que genera el xml
            $this->load->view('xml/generarXML', $var);
        }
    }

    /*
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

      foreach ($_POST['ingrediente'] as $ingrediente) {
      $datosIngrediente = $this->Ingredientes_model->obtenerIngrediente($ingrediente)->row();
      $precio = $precio + $datosIngrediente->precio;
      $ingredienteComanda[$i] = array('idIngrediente' => $datosIngrediente->id_ingrediente,
      'ingrediente' => $datosIngrediente->ingrediente,
      'precioIngrediente' => $datosIngrediente->precio);
      $i += 1;
      }

      if ($i == 0) {
      $msg = "No se ha seleccionado ningún ingrediente";
      } else {
      if ($_POST['cantidadArticuloPersonalizado'] > 0) {
      $this->Comandas_model->anadirArticuloPerComanda($articuloPersonalizado, $_POST['cantidadArticuloPersonalizado']
      , $precio, $datosTipoArticulo, $ingredienteComanda);

      $msg = "Articulo personalizado añadido correctamente";
      } else {
      $msg = "La cantidad tiene que ser mayor que 0";
      }
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

      //Se muestra la comanda
      $this->mostrarComanda();
      }

      public function cancelarComanda() {
      //Borro el pedido
      $this->my_cart->destroy();

      //Se muestra el pedido
      $this->mostrarComanda();
      }

      public function aceptarComanda() {

      $vaciarDivComanda = 1;
      $datosComanda = $this->my_cart->contents();
      $precioComanda = $this->my_cart->total();


      //Se comprueba si hay algun camarero dado de alta
      if (isset($_SESSION['idCamarero'])) {

      //Se comprueba si existe algo
      if ($this->my_cart->total() > 0) {
      //Local
      if ($_POST['localLlevar'] == 1) {
      $pedidoOk = $this->Comandas_model->insertarComandaLocal($datosComanda, $_POST['idMesaLocal']
      , $_POST['observaciones'], $_SESSION['idLocal'], $_SESSION['idCamarero']
      , $precioComanda);
      } else {
      //Para llevar
      $pedidoOk = $this->Comandas_model->insertarComandaLlevar($datosComanda, $_POST['aNombre']
      , $_POST['observaciones'], $_SESSION['idLocal'], $_SESSION['idCamarero']
      , $precioComanda);
      }

      //Si se ha insertado bien la comanda se borra el carro.
      if ($pedidoOk) {
      $this->my_cart->destroy();
      $msg = "Comanda enviada correctamente";
      } else {
      $msg = "Error enviando comanda";
      $vaciarDivComanda = 0;
      }
      } else {
      $msg = "No hay comanda pendiente de enviar";
      }
      } else {
      $msg = "No hay ningun camarero activo";
      $vaciarDivComanda = 0;
      }

      $this->listaComandasCamarero($msg, $vaciarDivComanda);
      }

      public function anadirComanda() {
      $datosComanda = $this->my_cart->contents();
      $precioComanda = $this->my_cart->total();
      $vaciarDivComanda = 1;

      //Se comprueba si hay algun camarero dado de alta
      if (isset($_SESSION['idCamarero'])) {
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
      $msg = "No hay ningun camarero activo";
      $vaciarDivComanda = 0;
      }

      $this->listaComandasCamarero($msg, $vaciarDivComanda);
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

      $this->listaComandasCamarero($msg);
      }

      public function cancelarComandaCamarero() {

      $this->Comandas_model->cambiarEstadoComanda($_POST['idComanda'], 'CW');

      $msg = 'Comanda cancelada correctamente';

      $this->listaComandasCamarero($msg);
      }

      private function listaComandasCamarero($mensaje = '', $vaciarDivComanda = 1) {

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

      public function verComandaCamarero() {
      //Se borra el pedido que pueda haber en memoria
      $this->my_cart->destroy();

      //Se obtienen los datos de la comanda
      $comanda = $this->Comandas_model->obtenerComanda($_POST['idComanda']);

      $params = array('etiqueta' => 'comanda');
      $this->load->library('arraytoxml', $params);
      $var['xml'] = $this->arraytoxml->convertArrayToXml($comanda, 'xml');

      //Se carga la vista que genera el xml
      $this->load->view('xml/generarXML', $var);
      }
     */
}

