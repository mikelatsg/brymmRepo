<div id="tituloAltaHorarioLocal"><h4>Añadir horario local</h4></div>
<div id="FormularioAltaHorarioLocal">

    <form id="formAltaHorarioLocal">
        <table>
            <tr>
                <td>
                    Dia
                </td>
                <td>
                    <select name="idDia">
                        <?php foreach ($dias as $dia): ?>
                            <option value="<?php echo $dia->id_dia; ?>"><?php echo $dia->dia; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            <tr>
                <td>
                    Hora apertura
                </td>
                <td>
                    <select name="horaInicio" >
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
                    </select>
                    :
                    <select name="minutoInicio">
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
                            <!--<input type="text" name="horaInicio" />-->
                </td>
            </tr>
            <tr>
                <td>
                    Hora cierre
                </td>
                <td>
                    <!--<input type="text" name="horaFin" />-->
                    <select name="horaFin" >
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
                    </select>
                    :
                    <select name="minutoFin">
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
            </tr>
            </tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="button" 
                           onclick="<?php echo "enviarFormulario('" . site_url() . "/locales/anadirHorarioLocal','formAltaHorarioLocal','listaHorarioLocal',1)" ?>" 
                           value="Añadir horario local" />
                    <!--<input type="submit" value="Crear horarios" />-->
                </td>
            </tr>
        </table>
    </form>

</div>
<div id="tituloListaHorarioLocal"><h4>Horario local</h4></div>
<div id="listaHorarioLocal">
    <ul>
        <?php foreach ($horarioLocal as $linea): ?>
            <li>
                <?php echo $linea->dia . "-" . $linea->hora_inicio . "-" . $linea->hora_fin ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/locales/borrarHorarioLocal','idHorarioLocal="
                . $linea->id_horario_local . "','listaHorarioLocal','post',1)";
                ?>"> B </a>            
            </li>		
        <?php endforeach; ?>
    </ul>
</div>

<div id="tituloDiasCierreLocal"><h4>Dias cierre local</h4></div>
<div id="altaDiasCierreLocal">

    <form id="formDiasCierreLocal">
        <table>
            <tr>
                <td>
                    Dia
                </td>
                <td>
                    <input type="text" name="fecha" id="datepickerDiasCierre" />
                </td>
            <tr>
            <tr> 
                <td width="51" colspan="2" align="center">
                    <input type="button" 
                           onclick="<?php
                           echo "enviarFormulario('" . site_url()
                           . "/locales/anadirDiaCierreLocal','formDiasCierreLocal','listaDiasCierreLocal',1)"
                           ?>" 
                           value="Añadir dia cierre" />
                    <!--<input type="submit" value="Crear horarios" />-->
                </td>
            </tr>
        </table>
    </form>

</div>

<div id="tituloListaDiasCierreLocal"><h4>Horario local</h4></div>
<div id="listaDiasCierreLocal">
    <ul>
        <?php foreach ($diasCierreLocal as $linea): ?>
            <li>
                <?php echo $linea->fecha . " - " ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/locales/borrarDiaCierreLocal','idDiaCierreLocal="
                . $linea->id_dia_cierre_local . "','listaDiasCierreLocal','post',1)";
                ?>"> B </a>            
            </li>		
        <?php endforeach; ?>
    </ul>
</div>
