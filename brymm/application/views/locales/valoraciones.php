<!-- Formulario modal añadir valoracion-->
<div id="dialogAnadirValoracionLocal" title="Añadir valoracion" style="display:none">     
    <form id="formAnadirValoracionLocal">        
        <table>
            <tr>
                <input type="hidden" name="idLocal" value="<?php echo $idLocal;?>" />
                <td>Nota :</td>
                <td>
                    <select  value="5" name="nota">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>                            
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="observaciones">Observaciones</label></td>
                <td>
                    <textarea name="observaciones" class="text ui-widget-content ui-corner-all"></textarea>                            
                </td>
            </tr>
        </table> 
    </form>
</div>

<div id="tituloListaValoraciones"><h3>Valoraciones</h3></div>
<div id="anadirValoracion">
    <?php
    echo "<a class=\"enlaceAnadirValoracionLocal\" data-toggle=\"modal\"> Valorar local </a>";
    ?>
</div>
<div id="listaValoraciones">
    <ul>
        <?php
        if (count($valoraciones) > 0):
            foreach ($valoraciones as $valoracion):
                ?>
                <li>
                    <?php
                    echo "Usuario : " . $valoracion->nick
                    . " - Fecha : " . $valoracion->fecha
                    . " - Nota : " . $valoracion->nota
                    . "<br> Observaciones : " . $valoracion->observaciones;
                    ?>           
                </li>		
                <?php
            endforeach;
        else:
            echo "No se ha realizado ninguna valoracion";
        endif;
        ?>
    </ul>
</div>
