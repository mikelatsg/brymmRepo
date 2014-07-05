<div id="tituloFormularioAltaMesas"><h4>Alta mesas</h4></div>
<div id="FormularioAltaMesas">
    <table>
        <form id="formAltaMesasLocal">
            <tr>
                <td>
                    Nombre mesa:
                </td>
                <td>
                    <input type="text" name="nombreMesa" value="0"/>
                </td>
                <td>
                    Capacidad:
                </td>
                <td>
                    <input type="text" name="capacidad" value="0"/>
                </td>
            </tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="button" 
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/anadirMesaLocal','formAltaMesasLocal','listaMesasLocal',1)"
                           ?>" 
                           value="Añadir Mesa" />
                </td>
            </tr>
        </form>
    </table>
</div>
<div id="tituloFormularioAltaMesas"><h4>Lista mesas</h4></div>
<div id="listaMesasLocal">
    <ul>
        <?php foreach ($mesasLocal as $mesa): ?>
            <li>
                <?php echo $mesa->nombre_mesa . " - " . $mesa->capacidad ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/reservas/borrarMesaLocal','idMesaLocal="
                . $mesa->id_mesa_local . "','listaMesasLocal','post',1)";
                ?>"> B </a>            
            </li>		
        <?php endforeach; ?>
    </ul>
</div>
