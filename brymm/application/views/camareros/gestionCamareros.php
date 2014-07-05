<div id="tituloSesionCamarero"><h4>Camarero</h4></div>
<div id="sesionCamarero">
    <?php
    if (isset($_SESSION['idCamarero'])) {
        echo $camareroSesion->nombre;
        /* echo "<a onclick=\"";
          echo "doAjax('" . site_url() . "/camareros/cerrarSesionCamarero','','sesionCamarero','post',1)";
          echo "\"> Cerrar sesion </a>"; */
    } else {
        echo "No hay ningún camarero activo";
    }
    ?>
</div>
<div id="tituloAltaCamarero"><h4>Alta de camareros</h4></div>
<div id="altaCamarero">
    <form id="formAltaCamarero">
        <table>     
            <tr>
                <td>Nombre camarero</td>
                <td>
                    <input type="text" name="nombreCamarero" >
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <input type="text" name="password" >
                </td>
            </tr>
            <tr>
                <td>Repite password</td>
                <td>
                    <input type="text" name="password2" >
                </td>
            </tr>
            <tr>
                <td>Control total</td>
                <td>
                    <input type="checkbox" name="controlTotal" value="1" >
                </td>
            </tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <!-- 
                    Si no tiene control total no se permite crear nuevos camareros
                    -->
                    <input type="button" 
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/camareros/anadirCamarero','formAltaCamarero','listaCamareros',1)"
                           ?>" 
                           <?php
                           if (!$_SESSION['controlTotal']):
                               ?>
                               disabled="true"
                               <?php
                           endif;
                           ?>
                           value="Añadir camarero" />
                </td>
            </tr>

        </table>
    </form>
</div>
<div id="tituloModificarCamarero"><h4>Modificar camarero</h4></div>
<div id="modificarCamarero">
    <form id="formModificarCamarero">
        <input type="hidden" name="idCamarero" >
        <table>     
            <tr>
                <td>Nombre camarero</td>
                <td>
                    <input type="text" name="nombreCamarero" >
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <input type="text" name="password" >
                </td>
            </tr>
            <tr>
                <td>Repite password</td>
                <td>
                    <input type="text" name="password2" >
                </td>
            </tr>
            <tr>
                <td>Control total</td>
                <td>
                    <input type="checkbox" name="controlTotal" value="1" >
                </td>
            </tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="button" 
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/camareros/modificarCamarero','formModificarCamarero','listaCamareros',1)"
                           ?>" 
                           value="Modificar camarero" />
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="tituloAltaCamarero"><h4>Lista de camareros</h4></div>
<div id="listaCamarerors">
    <ul>
        <?php foreach ($camarerosLocal as $camarero): ?>
            <li> <?php echo $camarero->nombre . "-" . $camarero->control_total; ?>
                <!-- 
                Si no tiene control total no se permite borrar ni iniciar sesiones
                -->
                <?php
                if ($_SESSION['controlTotal']):
                    ?>
                    <a onclick="<?php
                    echo "doAjax('" . site_url() . "/camareros/borrarCamarero','idCamarero="
                    . $camarero->id_camarero . "','listaCamareros','post',1)";
                    ?>
                       "> B </a>
                    <a onclick="<?php
                    echo "doAjax('" . site_url() . "/camareros/iniciarSesionCamarero','idCamarero="
                    . $camarero->id_camarero . "','sesionCamarero','post',1)";
                    ?>
                       "> Iniciar sesion </a>
                    <a href="javascript:llenarFormularioModificarCamarero(
                       '<?php echo trim($camarero->id_camarero); ?>',
                       '<?php echo trim($camarero->nombre); ?>',
                       '<?php echo trim($camarero->control_total); ?>')"> M </a>
                       <?php
                   endif;
                   ?>
            </li>		
            <?php
        endforeach;
        ?>
    </ul>
</div>
