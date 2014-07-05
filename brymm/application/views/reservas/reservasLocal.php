<!-- Formulario modal rechazar reserva (rechazad por el local)-->
<div id="dialogRechazarReserva" title="Rechazar reserva" style="display:none"> 
    <form id="formRechazarReserva">
        <fieldset>
            <input type="hidden" name="idReserva" id="idReservaFormRechazarReserva" value="0" />
            <label for="motivo">Motivo</label>
            <textarea name="motivo" class="text ui-widget-content ui-corner-all"></textarea>                            
        </fieldset>
    </form>
</div>

<!-- Formulario modal anular reserva (para posibles anulaciones bajo pedido de usuario)-->
<div id="dialogAnularReservaLocal" title="Anular reserva" style="display:none"> 
    <form id="formAnularReservaLocal">
        <fieldset>
            <input type="hidden" name="idReserva" id="idReservaFormAnularReservaLocal" value="0" />
            <label for="motivo">Motivo</label>
            <textarea name="motivo" class="text ui-widget-content ui-corner-all"></textarea>                            
        </fieldset>
    </form>
</div>

<div id="tituloReservasPendientes"><h4>Reservas pendientes</h4></div>
<div id="listaReservasPendientesLocal">
    <ul>
        <?php foreach ($reservasLocal as $reserva): ?>
            <li>
                <?php
                echo $reserva->id_reserva . " - " . $reserva->fecha . " - " . $reserva->hora_inicio
                . " - " . $reserva->nombreUsuario . " - " . $reserva->nick
                ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/reservas/mostrarReservaLocal','idReserva="
                . $reserva->id_reserva . "','datosReservaLocal','post',1)";
                ?>"> Ver </a>            
            </li>		
        <?php endforeach; ?>
    </ul>
</div>
<div id="tituloDetalleReserva"><h4>Detalle reserva</h4></div>
<div id="detalleReserva">
</div>
<div id="tituloReservasAceptadas"><h4>Ultimas reservas aceptadas</h4></div>
<div id="listaReservasAceptadasLocal">
    <ul>
        <?php foreach ($reservasAceptadasLocal as $reserva): ?>
            <li>
                <?php
                echo $reserva->id_reserva . " - " . $reserva->fecha . " - " . $reserva->hora_inicio . " - ";
                //Si el idUsuario es 0 se muestra el emisor, no el nombre
                if ($reserva->id_usuario == 0) {
                    echo $reserva->nombre_emisor;
                } else {
                    echo $reserva->nombreUsuario . " - " . $reserva->nick;
                }
                //Se muestra el enlace para ver la reserva
                echo "<a onclick=\"";
                echo "doAjax('" . site_url() . "/reservas/mostrarReservaLocal','idReserva="
                . $reserva->id_reserva . "','datosReservaAceptadaLocal','post',1)\"";
                echo "> Ver </a>";
                ?>                          
            </li>		
        <?php endforeach; ?>
    </ul>
</div>
<div id="tituloReservasRechazadas"><h4>Ultimas reservas rechazadas</h4></div>
<div id="listaReservasRechazadasLocal">
    <ul>
        <?php foreach ($reservasRechazadasLocal as $reserva): ?>
            <li>
                <?php
                echo $reserva->id_reserva . " - " . $reserva->fecha . " - " . $reserva->hora_inicio . " - ";
                //Si el idUsuario es 0 se muestra el emisor, no el nombre
                if ($reserva->id_usuario == 0) {
                    echo $reserva->nombre_emisor;
                } else {
                    echo $reserva->nombreUsuario . " - " . $reserva->nick;
                }
                echo " - " . $reserva->estado;
                //Se muestra el enlace para ver la reserva
                echo "<a onclick=\"";
                echo "doAjax('" . site_url() . "/reservas/mostrarReservaLocal','idReserva="
                . $reserva->id_reserva . "','datosReservaRechazadaLocal','post',1)\"";
                echo "> Ver </a>";
                ?>           
            </li>		
        <?php endforeach; ?>
    </ul>
</div>
<div id="tituloCalendarioReservasLocal"><h4>Calendario reservas</h4></div>
<div id="calendarioReservasLocal">
    <?php
    echo $calendarioReservas;
    ?>
</div>
<div id ="actualizarCalendarioReservas">
    <?php
    echo "<a onclick=";
    echo "doAjax('" . site_url() . "/reservas/actualizarCalendarioReservas',''" .
    ",'actualizarCalendarioReservas','post',1)";
    echo "> Actualizar calendario </a>";
    ?>
</div>
<div id="tituloReservasDiaLocal"><h4>Reservas del dia</h4></div>
<div id="reservasDiaLocal">
</div>
<div id="tituloInsertarReservas"><h4>Nueva reserva</h4></div>
<div id="insertarReservas">


    <form id="formAltaReservaLocal">
        <table>            
            <tr>
                <td>
                    fecha:
                </td>
                <td>
                    <input type="text" name="fecha" id="datepickerReservas" 
                           onchange="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/obtenerMesasLibres','formAltaReservaLocal','listaMesasLibres',1)"
                           ?>"/>
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
                    <select name="idTipoMenu"
                            onchange="<?php
                            echo "enviarFormulario('" . site_url() .
                            "/reservas/obtenerMesasLibres','formAltaReservaLocal','listaMesasLibres',1)"
                            ?>">
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
                    A nombre de:
                </td>
                <td>
                    <input type="text" name="nombreEmisor"/>
                </td>
            </tr>
            <tr>
                <td>
                    Mesas:
                </td>
                <td id="listaMesasLibres">
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
                           "/reservas/anadirReservaLocal','formAltaReservaLocal','listaReservasGestionadasLocal',1)"
                           ?>" 
                           value="Realizar reserva" />
                </td>
            </tr>
        </table>
    </form>

</div>