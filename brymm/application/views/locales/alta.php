
<div id="FormularioAltaLocal">
    <table>
        <form method="post" action="<?= site_url() ?>/locales/nuevoLocal">
            <tr>
                <td  width="47">Nombre:</td>
                <td  width="46"><input type="text" name="nombre" /></td>
            </tr>
            <tr>
                <td width="69">Password:</td>
                <td  width="46"><input type="password" name="password"/></td>
            </tr>
            <tr>
                <td width="69">Confirmar password:</td>
                <td  width="46"><input type="password" name="passwordConf"/></td>
            </tr>
            <tr>
                <td  width="46">Tipo Comida</td>
                <td  width="46">
                    <select name="idTipoComida">
                        <?php foreach ($tiposComida as $linea): ?>
                            <option value="<? echo $linea->id_tipo_comida; ?>"><? echo $linea->tipo_comida; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td  width="47">Localidad:</td>
                <td  width="46"><input type="text" name="localidad" /></td>
            </tr>
            <tr>
                <td width="69">Telefono</td>
                <td  width="46"><input type="text" name="telefono"/></td>
            </tr>
            <tr>
                <td  width="47">Provincia:</td>
                <td  width="46"><input type="text" name="provincia" /></td>
            </tr>
            <tr>
                <td  width="47">Dirección:</td>
                <td  width="46"><input type="text" name="direccion" /></td>
            </tr>
            <tr>
                <td  width="47">Codigo postal:</td>
                <td  width="46"><input type="text" name="codigoPostal" /></td>
            </tr>
            <tr>
                <td width="69">Email:</td>
                <td  width="46"><input type="text" name="email"/></td>
            </tr>
            <!--
            <tr>
                <td width="69">Permitir pedidos:</td>
                <td  width="46"><input type="radio" name="pedidos" value="1" checked>Si</td>
                <td  width="46"><input type="radio" name="pedidos" value="0">No</td>
            </tr>
            <tr>
                <td width="69">Envio de pedidos a domicilio:</td>
                <td  width="46"><input type="radio" name="envioPedidos" value="1" checked>Si</td>
                <td  width="46"><input type="radio" name="envioPedidos" value="0">No</td>
            </tr>
            <tr>
                <td width="69">Permitir reservas:</td>
                <td  width="46"><input type="radio" name="reservas" value="1" checked>Si</td>
                <td  width="46"><input type="radio" name="reservas" value="0">No</td>
            </tr>   
            -->
            <tr>  
                <td width="51" colspan="2" align="center">
                    <input type="submit" value="Crear nuevo Local" />
                </td>
            </tr>
        </form>
    </table>
</div>
