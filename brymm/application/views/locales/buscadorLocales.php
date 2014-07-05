
<div id="FormularioBuscadoLocal" style="background-color:grey">
    <table>
        <form id="formBuscadorLocal" method="post" action="<?= site_url() ?>/locales/buscarLocal">
            <tr>
                <td>
                    Tipo comida
                </td>
                <td  width="46">
                    <select name="idTipoComida">
                        <option value="0">Todas</option>
                        <?php foreach ($tiposComida as $linea): ?>
                            <option value="<?php echo $linea->id_tipo_comida; ?>"><? echo $linea->tipo_comida; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Local
                </td>
                <td  width="46">
                    <input type="text" name="local"/>
                </td>
            </tr>
            <tr>
                <td>
                    Poblacion
                </td>
                <td  width="46">
                    <input type="text" name="poblacion"/>
                </td>
            </tr>
            <tr>
                <td>
                    Calle
                </td>
                <td  width="46">
                    <input type="text" name="calle"/>
                </td>
            </tr>
            <tr>
                <td>
                    codigo postal
                </td>
                <td  width="46">
                    <input type="text" name="codigoPostal"/>
                </td>
            </tr>
            <tr>
                <?php foreach ($servicios as $linea):
                    if ($linea->mostrar_buscador):
                        ?>
                        <td>
                            <input type="checkbox" name="servicios[]" value="<?php echo $linea->id_tipo_servicio_local; ?>"/>
                        <?php echo $linea->servicio; ?>
                        </td>
                    <?php endif;
                endforeach;
                ?>
            </tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="submit" value="Buscar local" />
                </td>
            </tr>
        </form>
    </table>
</div>

