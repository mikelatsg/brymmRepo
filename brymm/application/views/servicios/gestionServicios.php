
<div id="tituloAltaServicios"><h4>Añadir servicios</h4></div>
<div id="FormularioAltaServicios">

    <form id="formAltaServicioLocal">
        <table>
            <tr>           
                <td>
                    Servicio : 
                </td>
                <td>
                    <select name="idTipoServicioLocal">
                        <?php foreach ($servicios as $linea): ?>
                            <option value="<?php echo $linea->id_tipo_servicio_local; ?>"><?php echo $linea->servicio; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Importe minimo:
                </td>
                <td>
                    <input type="text" name="importeMinimo" value="0"/>
                </td>
            </tr>
            <tr>
                <td>
                    Precio:
                </td>
                <td>
                    <input type="text" name="precio" value="0"/>
                </td>
            </tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="button" 
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/servicios/anadirServicioLocal','formAltaServicioLocal','listaServiciosLocal',1)"
                           ?>" 
                           value="Añadir servicio" />
                </td>
            </tr>
        </table>
    </form>

</div>

<div id="tituloModificarServicios"><h4>Modificar servicio</h4></div>
<div id="FormularioModificarServicios">

    <form id="formModificarServicioLocal">
        <input type="hidden" name="idServicioLocal" value="0">
        <table>
            <tr>           
                <td>
                    Servicio : 
                </td>
                <td>
                    <select name="idTipoServicioLocal" disabled>
                        <?php foreach ($servicios as $linea): ?>
                            <option value="<?php echo $linea->id_tipo_servicio_local; ?>">
                                <?php echo $linea->servicio; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Importe minimo:
                </td>
                <td>
                    <input type="text" name="importeMinimo" value="0"/>                    
                </td>
            </tr>
            <tr>
                <td>
                    Precio:
                </td>
                <td>
                    <input type="text" name="precio" value="0"/>
                </td>
            </tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="button" 
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/servicios/modificarServicioLocal','formModificarServicioLocal','listaServiciosLocal',1)"
                           ?>" 
                           value="Modificar servicio" />
                </td>
            </tr>
        </table>
    </form>

</div>
<div id="tituloListaServicioLocal"><h4>Lista servicios</h4></div>
<div id="listaServicioLocal">
    <ul>
        <?php foreach ($serviciosLocal as $linea): ?>
            <li>
                <?php echo $linea->servicio . " - " . $linea->importe_minimo . " - " . $linea->precio ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/servicios/borrarServicio','idServicioLocal="
                . $linea->id_servicio_local . "','listaServiciosLocal','post',1)";
                ?>"> B </a>      
                <!-- Enlace para modificar el servicio-->
                <a href="javascript:llenarFormularioModificarServicio(
                   '<?php echo trim($linea->id_tipo_servicio_local); ?>',
                   '<?php echo trim($linea->importe_minimo); ?>',
                   '<?php echo trim($linea->precio); ?>',
                   '<?php echo trim($linea->id_servicio_local); ?>')"> M </a>
                   <?php if ($linea->activo): ?>
                    <a onclick="<?php
                    echo "doAjax('" . site_url() . "/servicios/desactivarServicio','idServicioLocal="
                    . $linea->id_servicio_local . "','listaServiciosLocal','post',1)";
                    ?>"> Desactivar </a> 
                   <?php else: ?>
                    <a onclick="<?php
                    echo "doAjax('" . site_url() . "/servicios/activarServicio','idServicioLocal="
                    . $linea->id_servicio_local . "','listaServiciosLocal','post',1)";
                    ?>"> Activar </a>
                   <?php endif; ?>
            </li>		
        <?php endforeach; ?>
    </ul>
</div>
