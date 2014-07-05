<div id="tituloMostrarComanda"><h4>Comanda</h4></div>
<div id="mostrarComanda">
    <ul>    
        <?php
        $existeComanda = false;
        $existeArticuloPer = false;
        $existeArticulo = false;
        $existeCarta = false;
        $existeMenu = false;
        $articulos = "";
        $articulosPer = "";
        $menus = "";
        $cartas = "";
        $detalleComanda = "";
        foreach ($comanda as $linea) {
            $existeComanda = true;

            $detalleComanda = "";
            $detalleComanda = $linea['name'] . " - " . $linea['qty'] . " - " . $linea['price'];
            $detalleComanda .= htmlentities("<a onclick=\"doAjax('" .
                    site_url() . "/comandas/borrarArticuloComanda','rowid=" .
                    $linea['rowid'] . "','mostrarComanda','post',1)\"> X </a>");

            //Articulo 
            if ($linea['options']['idTipoComanda'] == 1) {
                if (!$existeArticulo) {
                    $articulos = htmlentities("<h4>" . $linea['options']['tipoComanda'] . "</h4>");
                }
                $articulos .= htmlentities("<li> ");
                /* echo $linea['name'] . " - " . $linea['qty'] . " - " . $linea['price'];
                  echo "<a onclick=\"doAjax('" .
                  site_url() . "/camareros/borrarArticuloComanda','rowid=" .
                  $linea['rowid'] . "','mostrarComanda','post',1)\"> X ";
                  echo "</a>"; */
                $articulos .= $detalleComanda;
                $articulos .= htmlentities("</li>");
                $existeArticulo = true;

                //echo "<br>";
            }

            //Articulo personalizado
            if ($linea['options']['idTipoComanda'] == 2) {
                if (!$existeArticuloPer) {
                    $articulosPer = htmlentities("<h4>" . $linea['options']['tipoComanda'] . "</h4>");
                }

                $articulosPer .= htmlentities("<li> ");
                $articulosPer .= $detalleComanda;


                $existeArticuloPer = true;
                $i = 0;
                $articulosPer .= htmlentities("<br>");
                $articulosPer .= $linea['options']['tipoArticulo'] . " - ";
                foreach ($linea['options']['ingredientes'] as $ingredientes) {
                    if ($i > 0) {
                        $articulosPer .= ", ";
                    }
                    $articulosPer .= $ingredientes['ingrediente'];
                    $i += 1;
                }
                $articulosPer .= htmlentities("</li>");
            }

            //Menu
            if ($linea['options']['idTipoComanda'] == 3) {
                if (!$existeMenu) {
                    $menus = htmlentities("<h4>" . $linea['options']['tipoComanda'] . "</h4>");
                }

                $menus .= htmlentities("<li> ");
                $menus .= $detalleComanda;


                $existeMenu = true;
                $i = 0;
                $menus .= htmlentities("<br>");
                foreach ($linea['options']['platosMenu'] as $plato) {
                    if ($i == 0) {
                        $menus .= "<ul>";
                    }
                    $menus .= htmlentities("<li>");
                    $menus .= $plato['nombrePlato'];
                    $menus .= htmlentities("</li>");
                    $i += 1;
                }
                if ($i > 0) {
                    $menus .= htmlentities("</ul>");
                }
                $menus .= htmlentities("</li>");
            }

            //Carta 
            if ($linea['options']['idTipoComanda'] == 4) {
                if (!$existeCarta) {
                    $cartas = htmlentities("<h4>" . $linea['options']['tipoComanda'] . "</h4>");
                }
                $cartas .= htmlentities("<li>");
                $cartas .= $detalleComanda;
                $cartas .= htmlentities("</li>");
                $existeCarta = true;
            }
        }
        //Se muestran los datos
        echo html_entity_decode($articulos);
        echo html_entity_decode($articulosPer);
        echo html_entity_decode($menus);
        echo html_entity_decode($cartas);

        if ($existeComanda) {
            echo "Total : " . $precioTotalComanda;
            echo "<br>";
            echo "<a onclick=\"doAjax('" . site_url() .
            "/comandas/cancelarComanda','','mostrarComanda','post',1)\">" .
            "Cancelar</a>";
        }
        ?>
    </ul>    
</div>
<div id="formularioComanda">
    <form id="formAceptarComanda">
        <table>   
            <tr>
                <td></td>
                <td>                    
                    <input type="radio" name="localLlevar" value="0">Para llevar
                </td>                    
            </tr>
            <tr>
                <td>
                    A nombre de:
                </td>
                <td>
                    <input type="text" name="aNombre" value=""/>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="radio" name="localLlevar" value="1" checked>Local
                </td>

            </tr>
            <tr>
                <td>
                    Mesa:
                </td>
                <td>
                    <select name="idMesaLocal">
                        <?php foreach ($mesasLocal as $mesa): ?>
                            <option value="<?php echo $mesa->id_mesa_local ?>">
                                <?php echo $mesa->nombre_mesa ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Observaciones
                </td>
                <td>
                    <textarea name="observaciones"></textarea>
                </td>
            </tr>

            <tr>
                <td width="51" colspan="2" align="center">
                    <input type="button" id="butAceptarComanda"
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/comandas/aceptarComanda','formAceptarComanda','mostrarComandasActivas',1)"
                           ?>" 
                           value="Aceptar comanda" />                
                </td>
                <td width="51" colspan="2" align="center">
                    <input type="button" id="butAnadirComanda"
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/comandas/anadirComanda','formAceptarComanda','mostrarComandasActivas',1)"
                           ?>" 
                           value="Anadir a comanda" />                          
                </td>
                <td>
                    <select name="idComandaAbierta" id="cmbComandasActivas">
                        <?php foreach ($comandasActivas as $comanda): ?>
                            <option value="<?php echo $comanda->id_comanda ?>">
                                <?php
                                echo $comanda->id_comanda . " - ";
                                if ($comanda->id_mesa == 0) {
                                    echo $comanda->destino;
                                } else {
                                    echo $comanda->nombreMesa;
                                }
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="tituloComandasActivas"><h4>Comandas activas</h4></div>
<div id="listaComandasActivas">
    <ul>
        <?php foreach ($comandasActivas as $comanda): ?>
            <li> 
                <?php
                echo $comanda->id_comanda . " - ";
                if ($comanda->id_mesa == 0) {
                    echo $comanda->destino;
                } else {
                    echo $comanda->nombreMesa;
                }
                echo " - " . $comanda->nombreCamarero
                . " - " . $comanda->precio . " - " . $comanda->estado . " - "
                . $comanda->fecha_alta;
                ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/cerrarComandaCamarero','idComanda="
                . $comanda->id_comanda . "','listaComandas','post',1)";
                ?>
                   "> Cerrar </a>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/cancelarComandaCamarero','idComanda="
                . $comanda->id_comanda . "','listaComandas','post',1)";
                ?>
                   "> Cancelar </a>

                <a onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','mostrarComandaRealizada','post',1)";
                ?>
                   "> Ver </a>
            </li>		
            <?php
        endforeach;
        ?>
    </ul>
</div>
<div id="tituloComandasCerradas"><h4>Comandas cerradas</h4></div>
<div id="listaComandasCerradas">
    <ul>
        <?php foreach ($comandasCerradas as $comanda): ?>
            <li> 
                <?php
                echo $comanda->id_comanda . " - ";
                if ($comanda->id_mesa == 0) {
                    echo $comanda->destino;
                } else {
                    echo $comanda->nombreMesa;
                }
                echo "-" . $comanda->nombreCamarero
                . "-" . $comanda->precio . "-" . $comanda->estado . "-"
                . $comanda->fecha_alta;
                ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','mostrarComandaRealizada','post',1)";
                ?>
                   "> Ver </a>
            </li>		
            <?php
        endforeach;
        ?>
    </ul>
</div>
