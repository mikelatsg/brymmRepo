<?php

class Comandas_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    //Función que añade un articulo a la comanda
    public function anadirArticuloComanda($idArticuloLocal, $cantidad, $precio, $articulo, $idTipoArticulo) {

        //Se añade una aleatorio para no machacar los articulos ya insertados
        srand(time());
        $aleatorio = rand(1, 100000);

        //Se obtiene la descripcion del tipo de comanda
        $tipoComanda = $this->obtenerTipoComanda(1)->row()->tipo_comanda;

        $data = array(
            //'id' => $idArticuloLocal . "." . $aleatorio . ".1",
            'id' => $idArticuloLocal . "." . str_pad($aleatorio, 6, "0", STR_PAD_LEFT),
            'qty' => $cantidad,
            'price' => $precio,
            'name' => $articulo,
            'options' => array('idTipoArticulo' => $idTipoArticulo,
                'idTipoComanda' => 1,
                'tipoComanda' => $tipoComanda)
        );

        $this->my_cart->insert($data);
    }

    //Función que añade un articulo personalizado a la comanda
    public function anadirArticuloPerComanda($idArticuloPersonalizado, $cantidadArticuloPersonalizado
    , $precio, $datosTipoArticulo, $ingredientePedido) {
        //Se carga el modelo de usuarios
        //$this->load->library('cart');
        $this->load->library('my_cart');

        //Se obtiene la descripcion del tipo de comanda
        $tipoComanda = $this->obtenerTipoComanda(2)->row()->tipo_comanda;

        $data = array(
            'id' => $idArticuloPersonalizado,
            'qty' => $cantidadArticuloPersonalizado,
            'price' => $precio,
            'name' => 'articulo personalizado',
            'options' => array('idTipoArticulo' => $datosTipoArticulo->id_tipo_articulo,
                'personalizado' => 1, 'tipoArticulo' => $datosTipoArticulo->tipo_articulo,
                'idTipoComanda' => 2,
                'tipoComanda' => $tipoComanda,
                'ingredientes' => $ingredientePedido)
        );

        $this->my_cart->insert($data);
    }

    public function anadirMenuComanda($cantidad, $idTipoMenuLocal, $platos) {

        $this->load->model('menus/Menus_model');
        //Se obtiene el precio del menu
        $tipoMenuLocal = $this->Menus_model->obtenerTipoMenuLocal($idTipoMenuLocal)->row();

        //Se obtiene la descripcion del tipo de comanda
        $tipoComanda = $this->obtenerTipoComanda(3)->row()->tipo_comanda;

        //Se añade una aleatorio para no machacar los menus ya insertados
        srand(time());
        $aleatorio = rand(1, 100000);

        $data = array(
            //'id' => $idTipoMenuLocal . "." . $aleatorio . ".3",
            'id' => $idTipoMenuLocal . "." . str_pad($aleatorio, 6, "0", STR_PAD_LEFT),
            'qty' => $cantidad,
            'price' => $tipoMenuLocal->precio_menu,
            'name' => $tipoMenuLocal->nombre_menu,
            'options' => array(
                'platosMenu' => $platos,
                'idTipoComanda' => 3,
                'tipoComanda' => $tipoComanda,
                'anadirMenuIncompleto' => false)
        );

        $this->my_cart->insert($data);
    }

    public function anadirPlatoMenuComanda($cantidad, $idTipoMenuLocal, $plato) {

        $this->load->model('menus/Menus_model');
        //Se obtiene el precio del menu
        $tipoMenuLocal = $this->Menus_model->obtenerTipoMenuLocal($idTipoMenuLocal)->row();

        //Se obtiene la descripcion del tipo de comanda
        $tipoComanda = $this->obtenerTipoComanda(3)->row()->tipo_comanda;

        //Se añade una aleatorio para no machacar los menus ya insertados
        srand(time());
        $aleatorio = rand(1, 100000);

        $data = array(
            'id' => $idTipoMenuLocal . "." . str_pad($aleatorio, 6, "0", STR_PAD_LEFT),
            'qty' => $cantidad,
            'price' => 0,
            'name' => $tipoMenuLocal->nombre_menu,
            'options' => array(
                'platosMenu' => $plato,
                'idTipoComanda' => 3,
                'tipoComanda' => $tipoComanda,
                'anadirMenuIncompleto' => true)
        );

        $this->my_cart->insert($data);
    }

    public function anadirPlatoComanda($idPlatoLocal, $cantidad, $precio, $nombrePlato) {

        //Se carga el modelo de menus
        $this->load->model('menus/Menus_model');

        //Se obtiene el tipo de plato        
        $idTipoPlato = $this->Menus_model->obtenerPlatoLocal($idPlatoLocal)
                        ->row()->id_tipo_plato;

        //Se obtiene la descripcion del tipo de plato
        $tipoPlato = $this->Menus_model->obtenerTipoPlato($idTipoPlato)
                        ->row()->descripcion;

        //Se obtiene la descripcion del tipo de comanda
        $tipoComanda = $this->obtenerTipoComanda(4)->row()->tipo_comanda;

        //Se añade una aleatorio para no machacar los menus ya insertados
        srand(time());
        $aleatorio = rand(1, 100000);

        $data = array(
            //'id' => $idPlatoLocal . "." . $aleatorio . ".4",
            'id' => $idPlatoLocal . "." . str_pad($aleatorio, 6, "0", STR_PAD_LEFT),
            'qty' => $cantidad,
            'price' => $precio,
            'name' => $nombrePlato,
            'options' => array(
                'idTipoPlato' => $idTipoPlato, //primero,segundo...
                'tipoPlato' => $tipoPlato,
                'idTipoComanda' => 4,
                'tipoComanda' => $tipoComanda)
        );

        $this->my_cart->insert($data);
    }

    public function obtenerTipoComanda($idTipoComanda) {
        $sql = "SELECT * FROM tipos_comanda 
            WHERE id_tipo_comanda = ?";

        $result = $this->db->query($sql, array($idTipoComanda));

        return $result;
    }
    
    function obtenerTiposComandaObject() {
    	//Se obtienen los tipos de menu
    	$sql = "SELECT * FROM tipos_comanda tc
				ORDER BY id_tipo_comanda";
    
    	$result = $this->db->query($sql)->result();
    		
    	$tiposComanda = array();
    		
    	foreach($result as $row){
    		$tiposComanda[] = new TipoComanda($row->id_tipo_comanda,$row->descripcion);
    	}
    
    	return $tiposComanda;
    }

    public function insertarComandaLocal($datosComanda, $idMesaLocal
    , $observaciones, $idLocal, $idCamarero, $precioComanda) {

        $transOk = true;

        try {
            //Se inicia la transaccion
            $this->db->trans_begin();

            //Se crea una nueva comanda
            //Se insertan los datos en la tabla comanda
            $sql = "INSERT INTO comanda (destino, observaciones, id_local
                       , id_camarero, precio, id_mesa, estado, fecha_alta) 
                       VALUES (?,?,?,?,?,?,?,?)";

            $this->db->query($sql, array("mesa", $observaciones, $idLocal
                , $idCamarero, $precioComanda, $idMesaLocal, "EC", date('Y-m-d H:i:s')));

            $idComanda = $this->db->insert_id();


            foreach ($datosComanda as $lineaComanda) {

                /*
                 * Si se trata de un articulo personalizado se inserta
                 * el idTipoArticulo en el campo id_articulo
                 */

                if ($lineaComanda['options']['idTipoComanda'] == 2) {
                    $id = $lineaComanda['options']['idTipoArticulo'];
                } else {
                    $id = strstr($lineaComanda['id'], '.', true);
                }

                //Se inserta el detalle de la comanda
                $idDetalleComanda =
                        $this->insertarDetalleComanda($lineaComanda['options']['idTipoComanda']
                        , $lineaComanda['qty'], $lineaComanda['price'], $idComanda
                        , $id);

                /*
                 * Si el idDetalleComanda es menor que cero ha habido error
                 * rollback y se sale con false
                 */

                if ($idDetalleComanda < 0) {
                    //Se finaliza la transaccion
                    $this->db->trans_complete();
                    $this->db->trans_rollback();
                    return false;
                }

                switch ($lineaComanda['options']['idTipoComanda']) {
                    case 2:
                        $insertOk = true;
                        foreach ($lineaComanda['options']['ingredientes'] as $ingrediente) {
                            //Se inserta el detalle del articulo personalizado
                            $insertOk = $this->insertarComandaArticuloPer($idDetalleComanda
                                    , $ingrediente['idIngrediente']
                                    , $ingrediente['precioIngrediente']);

                            if (!$insertOk) {
                                $transOk = false;
                            }
                        }

                        break;
                    case 3:
                        $insertOk = true;
                        foreach ($lineaComanda['options']['platosMenu'] as $plato) {
                            //Se inserta el detalle del articulo personalizado
                            $insertOk = $this->insertarComandaMenu($idDetalleComanda
                                    , $plato['idPlatoLocal']
                                    , $plato['platoCantidad']);

                            if (!$insertOk) {
                                $transOk = false;
                            }
                        }

                        break;
                }
            }
            //Se finaliza la transaccion
            $this->db->trans_complete();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }

        if ($this->db->trans_status() === FALSE || !$transOk) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();

        //Se carga el modelo de alertas
        $this->load->model('alertas/Alertas_model');

        //Se inserta la alerta
        $this->Alertas_model->insertAlertaLocal
                (4, $idLocal, $idComanda);

        return true;
    }

    public function insertarComandaLlevar($datosComanda, $aNombre, $observaciones
    , $idLocal, $idCamarero, $precioComanda) {

        $transOk = true;
        try {
            //Se inicia la transaccion
            $this->db->trans_begin();

            //Se crea una nueva comanda
            //Se insertan los datos en la tabla comanda
            $sql = "INSERT INTO comanda (destino, observaciones, id_local
                       , id_camarero, precio, id_mesa, estado, fecha_alta) 
                       VALUES (?,?,?,?,?,?,?,?)";

            $this->db->query($sql, array($aNombre, $observaciones, $idLocal
                , $idCamarero, $precioComanda, 0, "EC", date('Y-m-d H:i:s')));

            $idComanda = $this->db->insert_id();


            foreach ($datosComanda as $lineaComanda) {

                /*
                 * Si se trata de un articulo personalizado se inserta
                 * el idTipoArticulo en el campo id_articulo
                 */

                if ($lineaComanda['options']['idTipoComanda'] == 2) {
                    $id = $lineaComanda['options']['idTipoArticulo'];
                } else {
                    $id = strstr($lineaComanda['id'], '.', true);
                }

                //Se inserta el detalle de la comanda
                $idDetalleComanda =
                        $this->insertarDetalleComanda($lineaComanda['options']['idTipoComanda']
                        , $lineaComanda['qty'], $lineaComanda['price'], $idComanda
                        , $id);

                /*
                 * Si el idDetalleComanda es menor que cero ha habido error
                 * rollback y se sale con false
                 */

                if ($idDetalleComanda < 0) {
                    //Se finaliza la transaccion
                    $this->db->trans_complete();
                    $this->db->trans_rollback();
                    return false;
                }

                switch ($lineaComanda['options']['idTipoComanda']) {
                    case 2:
                        $insertOk = true;
                        foreach ($lineaComanda['options']['ingredientes'] as $ingrediente) {
                            //Se inserta el detalle del articulo personalizado
                            $insertOk = $this->insertarComandaArticuloPer($idDetalleComanda
                                    , $ingrediente['idIngrediente']
                                    , $ingrediente['precioIngrediente']);

                            if (!$insertOk) {
                                $transOk = false;
                            }
                        }

                        break;
                    case 3:
                        $insertOk = true;
                        foreach ($lineaComanda['options']['platosMenu'] as $plato) {
                            //Se inserta el detalle del articulo personalizado
                            $insertOk = $this->insertarComandaMenu($idDetalleComanda
                                    , $plato['idPlatoLocal']
                                    , $plato['platoCantidad']);

                            if (!$insertOk) {
                                $transOk = false;
                            }
                        }

                        break;
                }
            }
            //Se finaliza la transaccion
            $this->db->trans_complete();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }

        if ($this->db->trans_status() === FALSE || !$transOk) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();

        //Se carga el modelo de alertas
        $this->load->model('alertas/Alertas_model');

        //Se inserta la alerta
        $this->Alertas_model->insertAlertaLocal
                (4, $idLocal, $idComanda);

        return true;
    }

    private function insertarDetalleComanda($idTipoComanda, $cantidad, $precio, $idComanda, $id) {

        $this->db->trans_begin();
        //Se inserta el detalle de la comanda
        $sqlInsertDetalle = "INSERT INTO detalle_comanda (id_tipo_comanda, cantidad, precio,
                id_comanda, id_articulo, estado) VALUES (?,?,?,?,?,?)";

        $this->db->query($sqlInsertDetalle, array($idTipoComanda, $cantidad
            , $precio, $idComanda, $id, "EC"));

        $idDetalleComanda = $this->db->insert_id();

        //Se finaliza la transaccion
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return -1;
        }
        return $idDetalleComanda;
    }

    private function insertarComandaArticuloPer($idDetalleComanda
    , $idIngrediente, $precio) {
        //Se inicia la transaccion
        $this->db->trans_begin();
        $sql = "INSERT INTO comanda_articulo_per (id_detalle_comanda, 
            id_ingrediente, precio)
            VALUES (?,?,?)";

        $this->db->query($sql, array($idDetalleComanda
            , $idIngrediente, $precio));

        //Se finaliza la transaccion
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        return true;
    }

    private function insertarComandaMenu($idDetalleComanda
    , $idPlatoLocal, $cantidad) {
        //Se inicia la transaccion
        $this->db->trans_begin();
        $sql = "INSERT INTO comanda_menu (id_detalle_comanda, 
            id_plato, cantidad, estado)
            VALUES (?,?,?,?)";

        $this->db->query($sql, array($idDetalleComanda
            , $idPlatoLocal, $cantidad, "EC"));

        //Se finaliza la transaccion
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        return true;
    }

    function obtenerComandasEstadoDiferente($idLocal, $estado) {
        $sql = "SELECT c.*,ml.nombre_mesa nombreMesa, w.nombre nombreCamarero
            FROM comanda c LEFT JOIN mesas_local ml
            ON (c.id_mesa = ml.id_mesa_local),camareros w
            WHERE c.id_camarero = w.id_camarero
            AND c.id_local = ?
            AND estado <> ? 
            AND estado <> ?
            ORDER BY c.fecha_alta ";

        $result = $this->db->query($sql, array($idLocal, $estado, 'CW'));

        return $result;
    }

    function obtenerComandasCerradas($idLocal) {
        $sql = "SELECT c.*,ml.nombre_mesa nombreMesa, w.nombre nombreCamarero
            FROM comanda c LEFT JOIN mesas_local ml
            ON (c.id_mesa = ml.id_mesa_local),camareros w
            WHERE c.id_camarero = w.id_camarero
            AND c.id_local = ?
            AND (estado = ? OR estado = ?)
            AND c.fecha_alta >= SYSDATE() - INTERVAL 1 DAY
            ORDER BY c.fecha_alta DESC";

        $result = $this->db->query($sql, array($idLocal, 'CC', 'CW'));

        return $result;
    }

    function cambiarEstadoComanda($idComanda, $estado) {
        //Se cambia el estado de la comanda
        $sql = "UPDATE comanda SET  estado = ?
                        WHERE id_comanda = ?";

        $this->db->query($sql, array($estado, $idComanda));

        /*
         * Si el estado es TC (terminado cocina se inserta una alerta 
         * al camarero que ha insertado la comanda
         */
        if ($estado == "TC") {
            //Se carga el modelo de alertas
            $this->load->model('alertas/Alertas_model');

            //Se obtienen los datos de la comanda
            $datosComanda = $this->obtenerLocalComanda($idComanda)->row();

            //Se inserta la alerta
            $this->Alertas_model->insertAlertaCamarero
                    (10, $datosComanda->id_local, $idComanda
                    , $datosComanda->id_camarero);
        }
    }

    function cambiarEstadoComandaMenu($idDetalleComanda, $estado) {
        //Se cambia el estado de la comanda
        $sql = "UPDATE comanda_menu SET  estado = ?
                        WHERE id_detalle_comanda = ?";

        $this->db->query($sql, array($estado, $idDetalleComanda));
    }

    function cambiarEstadoPlatoMenu($idComandaMenu, $estado) {
        //Se cambia el estado de la comanda
        $sql = "UPDATE comanda_menu SET  estado = ?
                        WHERE id_comanda_menu = ?";

        $this->db->query($sql, array($estado, $idComandaMenu));
    }

    function obtenerLocalComanda($idComanda) {
        //Se obtienen los datos de la comanda
        $sql = "SELECT l.*,c.id_camarero
            FROM comanda c , locales l
            WHERE c.id_local = l.id_local
            AND c.id_comanda = ?";

        $result = $this->db->query($sql, array($idComanda));

        return $result;
    }

    function obtenerComanda($idComanda) {

        //Se obtienen los datos de la comanda
        $sql = "SELECT c.*,ml.nombre_mesa nombreMesa, w.nombre nombreCamarero
            FROM comanda c LEFT JOIN mesas_local ml
            ON (c.id_mesa = ml.id_mesa_local),camareros w
            WHERE c.id_camarero = w.id_camarero
            AND c.id_comanda = ?";

        $datosComanda = $this->db->query($sql, array($idComanda))->row_array();

        $sql = "SELECT * FROM detalle_comanda WHERE id_comanda = ?";

        $detalleComanda = $this->db->query($sql, array($idComanda))->result_array();

        $detComanda = array();

        foreach ($detalleComanda as $detalle) {
            $art = array();

            //Se obtiene el tipo de comanda
            $tipoComanda =
                    $this->obtenerTipoComanda($detalle['id_tipo_comanda'])->row()->tipo_comanda;
            //Articulos
            switch ($detalle['id_tipo_comanda']) {
                //Articulo
                case 1:
                    //Se carga el modelo de articulos para obtener el detalle
                    $this->load->model('articulos/Articulos_model');

                    //Se obtiene el articulo
                    $articulo =
                            $this->Articulos_model->obtenerArticuloLocal
                                    ($detalle['id_articulo'])->row_array();

                    //Se obtienen los ingredientes del articulo
                    $ingredientesArticulo =
                            $this->Articulos_model->obtenerDetalleArticulo
                                    ($detalle['id_articulo'])->result_array();

                    $art = array('detalleComandaArticulo' => $detalle
                        , 'datosArticulo' => $articulo
                        , 'tipoComanda' => $tipoComanda
                        , 'detalleArticulo' => $ingredientesArticulo);

                    break;
                case 2:
                    //Articulo personalizado
                    //Se carga el modelo de articulos para obtener el tipo articulo
                    $this->load->model('articulos/Articulos_model');

                    //Se obtiene el tipo articulo
                    $tipoArticulo =
                            $this->Articulos_model->obtenerTipoArticulo
                                    ($detalle['id_articulo'])->row();

                    //Se obtienen los ingredientes del articulo per
                    $ingredientesArticulo = $this->obtenerDetalleComandaPer
                                    ($detalle['id_detalle_comanda'])->result_array();
                    $art = array('detalleComandaArticulo' => $detalle
                        , 'tipoArticulo' => $tipoArticulo->tipo_articulo
                        , 'tipoComanda' => $tipoComanda
                        , 'detalleArticuloPer' => $ingredientesArticulo);
                    break;
                case 3:
                    //Menu
                    $platosMenu =
                            $this->obtenerDetalleComandaMenu
                                    ($detalle['id_detalle_comanda'])->result_array();

                    $art = array('detalleComandaArticulo' => $detalle
                        , 'tipoComanda' => $tipoComanda
                        , 'detalleMenu' => $platosMenu);
                    break;
                case 4:
                    //Carta
                    //Se carga el modelo de menus para obtener el detalle del plato
                    $this->load->model('menus/Menus_model');

                    //Se obtiene el articulo
                    $platoLocal =
                            $this->Menus_model->obtenerPlatoLocal
                                    ($detalle['id_articulo'])->row_array();

                    $art = array('detalleComandaArticulo' => $detalle
                        , 'tipoComanda' => $tipoComanda
                        , 'datosPlato' => $platoLocal);
                    break;
            }

            $detComanda[] = $art;
        }

        //Se genera el array con los datos
        $comanda = array('datosComanda' => $datosComanda,
            'detalleComanda' => $detComanda);

        return $comanda;
    }

    function obtenerDetalleComandaPer($idDetalleComanda) {
        $sql = "SELECT cap.*,i.ingrediente 
                FROM comanda_articulo_per cap, ingredientes i
                WHERE cap.id_ingrediente = i.id_ingrediente
                AND id_detalle_comanda = ?";

        $result = $this->db->query($sql, array($idDetalleComanda));

        return $result;
    }

    function obtenerDetallesComandaArticulo($idComanda, $idArticulo) {
        $sql = "SELECT * FROM detalle_comanda 
                WHERE id_comanda = ?
                AND id_articulo = ?";

        $result = $this->db->query($sql, array($idComanda, $idArticulo));

        return $result;
    }

    function obtenerDetalleComandaMenu($idDetalleComanda) {
        $sql = "SELECT cm.*,pl.nombre nombrePlato, pl.precio precioPlato,
                tp.descripcion tipoPlato, tp.id_tipo_plato idTipoPlato
                FROM comanda_menu cm,platos_local pl, tipos_plato tp
                WHERE cm.id_plato = pl.id_plato_local
                AND pl.id_tipo_plato = tp.id_tipo_plato
                AND cm.id_detalle_comanda = ?
                ORDER BY tp.id_tipo_plato";

        $result = $this->db->query($sql, array($idDetalleComanda));

        return $result;
    }

    function obtenerDetalleComanda($idDetalleComanda) {
        $sql = "SELECT *
                FROM detalle_comanda
                WHERE id_detalle_comanda = ?";

        $result = $this->db->query($sql, array($idDetalleComanda));

        return $result;
    }

    public function anadirComanda($datosComanda, $observaciones
    , $precioComanda, $idComanda) {

        $transOk = true;
        try {
            //Se inicia la transaccion
            $this->db->trans_begin();

            //Se añade los datos a la comanda ya existente.
            $sql = "UPDATE comanda SET observaciones = observaciones + ?,
                        precio = precio + ?,  estado = ? 
                       WHERE id_comanda = ?";

            $this->db->query($sql, array($observaciones
                , $precioComanda, "EC", $idComanda));

            foreach ($datosComanda as $lineaComanda) {

                /*
                 * Si se trata de un articulo personalizado se inserta
                 * el idTipoArticulo en el campo id_articulo
                 */

                if ($lineaComanda['options']['idTipoComanda'] == 2) {
                    $id = $lineaComanda['options']['idTipoArticulo'];
                } else {
                    $id = strstr($lineaComanda['id'], '.', true);
                }

                /*
                 * Si se trata de un menu se comprueba si se esta 
                 * añadiendo un plato a un menu existente para no insertar de 
                 * nuevo el detalle de la comanda
                 */

                if ($lineaComanda['options']['idTipoComanda'] == 3) {
                    if ($lineaComanda['options']['anadirMenuIncompleto']) {
                        //Se busca un menu incompleto
                        $idTipoMenuLocal = strstr($lineaComanda['id'], '.', true);
                        $detalleMenu = $this->obtenerDetallesComandaArticulo($idComanda, $idTipoMenuLocal);

                        if ($detalleMenu->num_rows() == 0) {
                            $msg = "No existe el menu en la comanda";

                            //Se finaliza la transaccion
                            $this->db->trans_complete();
                            $this->db->trans_rollback();
                            return array('noError' => false, 'mensaje' => $msg);
                        } else {
                            $idDetalleComanda = $detalleMenu->first_row()->id_detalle_comanda;
                        }
                    } else {
                        //Se inserta el detalle de la comanda
                        $idDetalleComanda =
                                $this->insertarDetalleComanda($lineaComanda['options']['idTipoComanda']
                                , $lineaComanda['qty'], $lineaComanda['price'], $idComanda
                                , $id);
                    }
                } else {
                    //Se inserta el detalle de la comanda
                    $idDetalleComanda =
                            $this->insertarDetalleComanda($lineaComanda['options']['idTipoComanda']
                            , $lineaComanda['qty'], $lineaComanda['price'], $idComanda
                            , $id);
                }

                /*
                 * Si el idDetalleComanda es menor que cero ha habido error
                 * rollback y se sale con false
                 */

                if ($idDetalleComanda < 0) {
                    //Se finaliza la transaccion
                    $this->db->trans_complete();
                    $this->db->trans_rollback();
                    $msg = "Error insertando el detalle de la comanda";
                    return array('noError' => false, 'mensaje' => $msg);
                }

                switch ($lineaComanda['options']['idTipoComanda']) {
                    case 2:
                        $insertOk = true;
                        foreach ($lineaComanda['options']['ingredientes'] as $ingrediente) {
                            //Se inserta el detalle del articulo personalizado
                            $insertOk = $this->insertarComandaArticuloPer($idDetalleComanda
                                    , $ingrediente['idIngrediente']
                                    , $ingrediente['precioIngrediente']);

                            if (!$insertOk) {
                                $transOk = false;
                            }
                        }

                        break;
                    case 3:
                        $insertOk = true;
                        foreach ($lineaComanda['options']['platosMenu'] as $plato) {
                            //Se inserta el detalle del menu
                            $insertOk = $this->insertarComandaMenu($idDetalleComanda
                                    , $plato['idPlatoLocal']
                                    , $plato['platoCantidad']);

                            if (!$insertOk) {
                                $transOk = false;
                            }
                        }

                        break;
                }
            }
            //Se finaliza la transaccion
            $this->db->trans_complete();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = "Error añadiendo datos a la comanda";
            return array('noError' => false, 'mensaje' => $msg);
        }

        if ($this->db->trans_status() === FALSE || !$transOk) {
            $this->db->trans_rollback();
            $msg = "Error añadiendo datos a la comanda";
            return array('noError' => false, 'mensaje' => $msg);
        }
        $this->db->trans_commit();
        $msg = "Datos añadidos correctamente";

        $idLocal = $this->obtenerLocalComanda($idComanda)->row()->id_local;

        //Se carga el modelo de alertas
        $this->load->model('alertas/Alertas_model');

        //Se inserta la alerta
        $this->Alertas_model->insertAlertaLocal
                (5, $idLocal, $idComanda);

        return array('noError' => true, 'mensaje' => $msg);
    }

    public function cambiarEstadoDetalleComanda($idDetalleComanda, $estado) {

        //Se cambia el estado de la comanda
        $sql = "UPDATE detalle_comanda SET  estado = ?
                        WHERE id_detalle_comanda = ?";

        $this->db->query($sql, array($estado, $idDetalleComanda));
    }

}

