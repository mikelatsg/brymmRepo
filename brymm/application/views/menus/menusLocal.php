<div id="menusLocal">
    <!-- Div que contiene el formulario para crear los platos-->
    <div id="anadirPlato">
        <h3>Añadir plato</h3>
        <table>
            <form id="formAnadirPlato">
                <tr>
                    <td>
                        Nombre
                    </td>
                    <td  width="46">
                        <input type="text" name="nombre" /></td>
                    </td>
                </tr>
                <tr>
                    <td>
                        Tipo de plato
                    </td>
                    <td  width="46">
                        <select name="idTipoPlato">
                            <?php
                            foreach ($tiposPlato as $tipoPlato) {
                                echo "<option value =  \"" . $tipoPlato->id_tipo_plato .
                                "\">" . $tipoPlato->descripcion . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio
                    </td>
                    <td  width="46">
                        <input type="text" name="precio" /></td>
                    </td>
                </tr>
                <tr> 
                    <td width="51" colspan="2" align="center">
                        <input type="button" 
                               onclick="
                               <?php
                               echo "enviarFormulario('" . site_url() .
                               "/menus/anadirPlatoLocal','formAnadirPlato','listaPlatosLocal',1)"
                               ?>" 
                               value="Añadir plato" />
                    </td>
                </tr>
            </form>
        </table>
    </div>
    <!-- Div que contiene el formulario para modificar los platos-->
    <div id="modificarPlato">
        <h3>Modificar plato</h3>

        <form id="formModificarPlato">
            <table>
                <tr>
                    <td>
                        Nombre
                    </td>
                    <td  width="46">
                        <input type="text" name="nombre" />
                        <input type="hidden" name="idPlatoLocal" value="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        Tipo de plato
                    </td>
                    <td  width="46">
                        <select name="idTipoPlato">
                            <?php
                            foreach ($tiposPlato as $tipoPlato) {
                                echo "<option value =  \"" . $tipoPlato->id_tipo_plato .
                                "\">" . $tipoPlato->descripcion . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio
                    </td>
                    <td  width="46">
                        <input type="text" name="precio" /></td>
                    </td>
                </tr>
                <tr> 
                    <td width="51" colspan="2" align="center">
                        <input type="button" 
                               onclick="
                               <?php
                               echo "enviarFormulario('" . site_url() .
                               "/menus/modificarPlatoLocal','formModificarPlato','listaPlatosLocal',1)"
                               ?>" 
                               value="Modificar plato" />
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- Div que contiene los platos creados del local-->
    <div id="listaPlatosLocal">
        <?php
        $idTipoPlato = 0;
        $idTipoPlatoAnterior = 0;
        foreach ($platosLocal as $plato) {

            if ($plato->id_tipo_plato <> $idTipoPlato) {
                if ($plato->id_tipo_plato <> $idTipoPlatoAnterior && $idTipoPlato <> 0) {
                    echo "</ul>";
                    //echo "</div>";
                }
                //echo "<div id=\"tipoPlato" . $plato->id_tipo_plato . "\">";
                echo "<h2>";
                echo $plato->descripcion;
                echo "</h2>";
                echo "<ul>";
                $idTipoPlatoAnterior = $idTipoPlato;
                $idTipoPlato = $plato->id_tipo_plato;
            }
            echo "<li>";
            echo $plato->nombre . " - " . $plato->precio;
            echo " - <a onclick=";
            echo "doAjax('" . site_url() . "/menus/borrarPlatoLocal','idPlatoLocal="
            . $plato->id_plato_local . "','listaPlatosLocal','post',1)";
            echo "> B </a>";
            ?>
            <!--    Modificar un plato        -->
            <a href="javascript:llenarFormularioModificarPlato(
               '<?php echo trim($plato->nombre); ?>',
               '<?php echo trim($plato->precio); ?>',
               '<?php echo trim($plato->id_plato_local); ?>',
               '<?php echo trim($plato->id_tipo_plato); ?>')"> - M</a>
               <?php
               //Añadir plato a menu
               echo " - <a onclick=";
               echo "enviarDatosMenu('" . site_url() .
               "/menus/anadirPlatoMenu','formAnadirPlatoMenu','idPlatoLocal="
               . $plato->id_plato_local . "','mostrarMenu',1)";
               echo "> A </a>";
               echo "</li>";
           }
           if ($idTipoPlato <> 0) {
               echo "</ul>";
               //echo "</div>";
           }
           ?>
    </div>
    <!-- Div que contiene el formulario para añadir los tipos de menu
    (menu del dia, menu especial...)-->

    <div id="anadirTipoMenuLocal">
        <h3>Añadir menu</h3>
        <table>
            <form id="formAnadirTipoMenuLocal">
                <tr>
                    <td>
                        Nombre menu
                    </td>
                    <td  width="46">
                        <input type="text" name="nombreMenu" /></td>
                    </td>
                </tr>
                <tr>
                    <td>
                        Menu
                    </td>
                    <td>
                        <select name="idTipoMenu">
                            <?php
                            foreach ($tiposMenu as $tipoMenu) {
                                echo "<option value = \"" . $tipoMenu->id_tipo_menu
                                . "\">" . $tipoMenu->descripcion . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio
                    </td>
                    <td  width="46">
                        <input type="text" name="precioMenu" /></td>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td  width="46">
                        <input type="radio" name="esCarta" value="1">Carta
                        <input type="radio" name="esCarta" value="0" checked>Menu
                    </td>                    
                </tr>
                <tr> 
                    <td width="51" colspan="2" align="center">
                        <input type="button" 
                               onclick="
                               <?php
                               echo "enviarFormulario('" . site_url() .
                               "/menus/anadirTipoMenuLocal','formAnadirTipoMenuLocal','listaTipoMenuLocal',1)"
                               ?>" 
                               value="Añadir menu" />
                    </td>
                </tr>
            </form>
        </table>
    </div>
    <div id="modificarTipoMenuLocal">
        <h3>Modificar menu</h3>
        <table>
            <form id="formModificarTipoMenuLocal">
                <tr>
                    <td>
                        Nombre menu
                    </td>
                    <td  width="46">
                        <input type="text" name="nombreMenuModificar" /></td>
                    </td>
                </tr>
                <tr>
                    <td>
                        Menu
                    </td>
                    <td>
                        <select name="idTipoMenuModificar">
                            <?php
                            foreach ($tiposMenu as $tipoMenu) {
                                echo "<option value = \"" . $tipoMenu->id_tipo_menu
                                . "\">" . $tipoMenu->descripcion . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio
                    </td>
                    <td  width="46">
                        <input type="text" name="precioMenuModificar" /></td>
                    </td>
                <input type="hidden" name="idTipoMenuLocalModificar"/>
                </tr>
                <tr>
                    <td></td>
                    <td  width="46">
                        <input type="radio" name="esCarta" value="1">Carta
                        <input type="radio" name="esCarta" value="0">Menu
                    </td>                    
                </tr>
                <tr> 
                    <td width="51" colspan="2" align="center">
                        <input type="button" 
                               onclick="
                               <?php
                               echo "enviarFormulario('" . site_url() .
                               "/menus/modificarTipoMenuLocal','formModificarTipoMenuLocal','listaTipoMenuLocal',1)"
                               ?>" 
                               value="Modificar menu" />
                    </td>
                </tr>
            </form>
        </table>
    </div>
    <!-- Div que contiene los tipos de menu creados del local-->
    <div id="listaTipoMenuLocal">
        <?php
        echo "<ul>";
        foreach ($tiposMenuLocal as $tipoMenuLocal) {

            echo "<li>";
            echo $tipoMenuLocal->nombre_menu . " - " . $tipoMenuLocal->descripcion
            . " - " . $tipoMenuLocal->precio_menu;

            //Borrar un tipo de menu
            echo " - <a onclick=";
            echo "doAjax('" . site_url() . "/menus/borrarTipoMenuLocal','idTipoMenuLocal="
            . $tipoMenuLocal->id_tipo_menu_local . "','listaTipoMenuLocal','post',1)";
            echo "> B </a>";
            //Modificar un tipo de menu
            echo " - <a onclick=";
            echo "doAjax('" . site_url() . "/menus/cargarTipoMenuLocal','idTipoMenuLocal="
            . $tipoMenuLocal->id_tipo_menu_local . "','cargarTipoMenuLocal','post',1)";
            echo "> M </a>";
            echo "</li>";
        }
        echo "</ul>";
        ?>
    </div>
    <div id="anadirPlatoMenu">
        <h3>Añadir plato a menu</h3>
        <table>
            <form id="formAnadirPlatoMenu">
                <tr>
                    <td>
                        Fecha
                    </td>
                    <td  width="46">
                        <input type="text" name="fechaMenu" id="datepickerFechaPlatoMenu" /></td>
                    </td>
                </tr>
                <tr>
                    <td>
                        Menu
                    </td>
                    <td>
                        <select name="tipoMenuLocal">
                            <?php
                            foreach ($tiposMenuLocal as $tipoMenuLocal) {
                                echo "<option value = \"" . $tipoMenuLocal->id_tipo_menu_local
                                . "\">" . $tipoMenuLocal->nombre_menu . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </form>
        </table>
    </div>
    <div id="calendarioMenu">
        <?php
        echo $calendario;
        ?>
    </div> 
    <div id ="actualizarCalendario">
        <?php
        echo "<a onclick=";
        echo "doAjax('" . site_url() . "/menus/actualizarCalendario',''" .
        ",'actualizarCalendarioMenu','post',1)";
        echo "> Actualizar calendario </a>";
        ?>
    </div>
    <div id="menuDia">
    </div> 
</div>


