<div id="tituloMenusCamarero"><h4>Menus</h4></div>
<div id="menusCamarero">
    <form id="anadirMenuComanda">
        <table>     
            <tr>
                <td>Menu</td>                
                <td>
                    <select name="idTipoMenuLocal">
                        <?php
                        foreach ($menusDia as $menu) {
                            echo "<OPTION value=" . $menu['idTipoMenuLocal'] . ">"
                            . $menu['nombreMenu'] . "-" . $menu['precioMenu'] . "</OPTION>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Cantidad</td>
                <td>
                    <input type="text" size="2" maxlength="2" value="1" name="menuCantidad">
                </td>
            </tr>  
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="button" 
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/comandas/anadirMenuComanda','anadirMenuComanda','mostrarComanda',1)"
                           ?>" 
                           value="Nueva comanda" />
                </td>
            </tr>


            <?php
            echo "<br>";
            foreach ($menusDia as $menu) :
                if (!$menu['esCarta']):
                    $idTipoPlato = 0;
                    echo"<tr colspan=2>";
                    echo"<td>";
                    echo $menu['nombreMenu'];
                    echo"</td>";
                    echo"</tr>";
                    foreach ($menu["detalleMenu"] as $plato) :
                        if ($idTipoPlato != $plato['idTipoPlato']) {
                            echo"<tr colspan=2>";
                            echo"<td>";
                            echo $plato['tipoPlato'];
                            echo"</td>";
                            echo"</tr>";
                        }
                        $idTipoPlato = $plato['idTipoPlato'];
                        ?>
                        <tr>
                            <td><?php echo $plato['nombrePlato']; ?></td>
                            <td>
                                <input type="text" size="2" maxlength="2" value="0" 
                                       name="platoCantidad_<?php echo $plato['idPlatoLocal']; ?>"
                                       id="platoCantidad_<?php echo $plato['idPlatoLocal'] ?>" >
                                <!--Enlace para añadir plato a menu incompleto.-->
                                <a onclick="
                                <?php
                                echo "enviarArticuloComanda('" . site_url() . "/comandas/anadirPlatoMenuComanda','idPlatoLocal="
                                . $plato['idPlatoLocal'] . "&idTipoMenuLocal=" . $menu['idTipoMenuLocal']
                                . "','platoCantidad_" . $plato['idPlatoLocal']
                                . "','mostrarComanda',1)";
                                ?>
                                   "> Anadir a menu </a>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                endif;
            endforeach;
            ?>
        </table>
    </form>
</div>
<div id ="tituloCartaCamarero"><h4>Carta</h4></div>
<div id="menusCamarero">
    <ul>
        <?php
        foreach ($menusDia as $menu) :
            if ($menu['esCarta']):
                $idTipoPlato = 0;
                echo"<h4>";
                echo $menu['nombreMenu'];
                echo"</h4>";
                foreach ($menu["detalleMenu"] as $plato) :
                    if ($idTipoPlato != $plato['idTipoPlato']) {
                        echo $plato['tipoPlato'];
                    }
                    $idTipoPlato = $plato['idTipoPlato'];
                    ?>

                    <li>
                        <?php echo $plato['nombrePlato'] . "-" . $plato['precioPlato'] ?>
                        <br>Cantidad <input type="text" size="2" maxlength="2" 
                                            value="1" id="<?php echo "cantidadPL" . $plato['idPlatoLocal'] ?>">
                        <a onclick="<?php
                        echo "enviarArticuloComanda('" . site_url()
                        . "/comandas/anadirPlatoComanda','idPlatoLocal="
                        . $plato['idPlatoLocal'] . "&precioPlato="
                        . $plato['precioPlato']
                        . "&nombrePlato=" . $plato['nombrePlato'] .
                        "','cantidadPL" . $plato['idPlatoLocal']
                        . "','mostrarComanda',1)";
                        ?>"> + </a>
                    </li>
                    <?php
                endforeach;
            endif;
        endforeach;
        ?>
    </ul>
</div>
