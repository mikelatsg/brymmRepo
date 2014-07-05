
<div id="FormularioReserva">
    <div id="HorarioLocal">
        <ul>
            <?php foreach ($horarioLocal as $horario): ?>
                <li>
                    <?php
                    echo $horario->dia . " - " . $horario->hora_inicio
                    . " - " . $horario->hora_fin
                    ?>            
                </li>		
            <?php endforeach; ?>
        </ul>
    </div>
    <table>
        <form id="formAltaReservaUsuario">
            <input type="hidden" name="idLocal" value="<?php echo $idLocal; ?>" />
            <tr>
                <td>
                    fecha:
                </td>
                <td>
                    <input type="text" name="fecha" id="datepickerReservas" />
                </td>
                <td>
                    hora:
                </td>
                <td>
                    <select name="hora">
                        <option value="0">00</option>
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>
                        <option value="9">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                    </select>:<select name="minuto" >
                        <option value="00">00</option>
                        <option value="05">05</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="35">35</option>
                        <option value="40">40</option>
                        <option value="45">45</option>
                        <option value="50">50</option>
                        <option value="55">55</option>                
                    </select>
                </td>
                <td>
                    Tipo comida
                </td>
                <td  width="46">
                    <select name="idTipoMenu">
                        <?php
                        foreach ($tiposMenu as $linea):
                            if ($linea->id_tipo_menu != 4 && $linea->id_tipo_menu != 1)://carta y desayunos                                
                                ?>
                                <option value="<?php echo $linea->id_tipo_menu; ?>"><? echo $linea->descripcion; ?></option>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </select>
                </td>
                <td>
                    Numero de personas:
                </td>
                <td>
                    <input type="text" name="numeroPersonas" value="0"/>
                </td>
            </tr>
            <tr>
                <td>
                    Observaciones:
                </td>
                <td>
                    <textarea name="observaciones"></textarea>
                </td>
            </tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="button" 
                           onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/anadirReservaUsuario','formAltaReservaUsuario','listaReservasUsuario',1)"
                           ?>" 
                           value="Realizar reserva" />
                </td>
            </tr>
        </form>
    </table>
</div>
