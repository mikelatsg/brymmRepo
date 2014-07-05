<!-- Formulario modal aceptar pedido-->
<div id="dialog" title="Aceptar pedido" style="display:none"> 
    <form id="formAceptarPedido">
        <fieldset>
            <input type="hidden" name="idPedido" id="idPedidoForm" value="0" />
            <input type="hidden" name="estado" value="A" />
            <label for="fechaEntrega">Fecha entrega</label>
            <input type="text" name="fechaEntrega" id="datePickerFechaEntregaPedido" 
                   class="text ui-widget-content ui-corner-all" />    
            <label for="horaEntrega">Hora</label>
            <select name="horaEntrega" id="horaFechaEntregaPedido" 
                    class="text ui-widget-content ui-corner-all">
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
            <select name="minutoEntrega" id="minutoFechaEntregaPedido" 
                    class="text ui-widget-content ui-corner-all">
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

        </fieldset>
    </form>
</div>  

<!-- Formulario modal rechazar pedido-->
<div id="dialogRechazar" title="Rechazar pedido" style="display:none"> 
    <form id="formRechazarPedido">
        <fieldset>
            <input type="hidden" name="idPedido" id="idPedidoFormRechazar" value="0" />
            <input type="hidden" name="estado" value="R" />
            <label for="observaciones">Motivo</label>
            <textarea name="motivoRechazo" class="text ui-widget-content ui-corner-all"></textarea>                            
        </fieldset>
    </form>
</div> 

<div id="pedidosLocal">
    <div id="pedidosPendientes">
        <h2>Pedidos pendientes</h2>
        <ul>
            <?php
            if ($pedidosPendientesLocal) {
                foreach ($pedidosPendientesLocal as $pedido):
                    echo "<div id=\"pedido_" . $pedido->id_pedido . "\">";
                    ?>
                    <li>
                        <?php
                        echo "Pedido : " . $pedido->id_pedido;
                        echo " - Precio : " . $pedido->precio;
                        echo " - Fecha : " . $pedido->fecha; //<span id=\"estadoPedido\">" . $pedido->estado  . "</span>";
                        echo "<br>";
                        echo "<a onclick=";
                        echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido=" . $pedido->id_pedido .
                        "&estado=A','verPedido','post',1)> Ver </a>";
                        echo "<div id=\"modificarEstado\">";
                        echo "<span id=\"aceptarPedido\">";
                        echo "<a class=\"enlaceAceptarPedido\" data-toggle=\"modal\" data-id=\""
                        . $pedido->id_pedido . "\" > Aceptar </a>";
                        echo "</span>";
                        echo "<span id=\"rechazarPedido\">";
                        /* echo "<a onclick=";
                          echo "doAjax('" . site_url() . "/pedidos/actualizarEstadoPedido','idPedido=" . $pedido->id_pedido .
                          "&estado=R','moverPedidoEstado','post',1)> Rechazar </a>"; */
                        echo "<a class=\"enlaceRechazarPedido\" data-toggle=\"modal\" data-id=\""
                        . $pedido->id_pedido . "\" > Rechazar </a>";
                        echo "</span>";
                        echo "</div>";
                        ?>   
                    </li>
                    <?php
                    echo "</div>";
                endforeach;
            }
            ?>
        </ul>
    </div>
    <div id="pedidosAceptados">
        <h2>Pedidos aceptados</h2>
        <ul>
            <?php
            if ($pedidosAceptadosLocal) {
                foreach ($pedidosAceptadosLocal as $pedido):
                    echo "<div id=\"pedido_" . $pedido->id_pedido . "\">";
                    ?>
                    <li>
                        <?php
                        echo "Pedido : " . $pedido->id_pedido;
                        echo " - Precio : " . $pedido->precio;
                        echo " - Fecha : " . $pedido->fecha;
                        echo "<br>";
                        echo "<a onclick=";
                        echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido=" . $pedido->id_pedido .
                        "&estado=A','verPedido','post',1)> Ver </a>";
                        echo "<div id=\"modificarEstado\">";
                        echo "<a onclick=";
                        echo "doAjax('" . site_url() . "/pedidos/actualizarEstadoPedido','idPedido=" . $pedido->id_pedido .
                        "&estado=T','moverPedidoEstado','post',1)> Terminar </a>";
                        echo "<a class=\"enlaceRechazarPedido\" data-toggle=\"modal\" data-id=\""
                        . $pedido->id_pedido . "\" > Rechazar </a>";
                        echo "</div>";
                        ?>   
                    </li>
                    <?php
                    echo "</div>";
                endforeach;
            }
            ?>
        </ul>
    </div>
    <div id="pedidosTerminados">
        <h2>Pedidos terminados</h2>
        <ul>
            <?php
            if ($pedidosTerminadosLocal) {
                foreach ($pedidosTerminadosLocal as $pedido):
                    echo "<div id=\"pedido_" . $pedido->id_pedido . "\">";
                    ?>
                    <li>
                        <?php
                        echo "Pedido : " . $pedido->id_pedido;
                        echo " - Precio : " . $pedido->precio;
                        echo " - Fecha : " . $pedido->fecha;
                        echo "<br>";
                        echo "<a onclick=";
                        echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido=" . $pedido->id_pedido .
                        "&estado=A','verPedido','post',1)> Ver </a>";
                        ?>   
                    </li>
                    <?php
                    echo "</div>";
                endforeach;
            }
            ?>
        </ul>
    </div>
    <div id="pedidosRechazados">
        <h2>Pedidos rechazados</h2>
        <ul>
            <?php
            if ($pedidosRechazadosLocal) {
                foreach ($pedidosRechazadosLocal as $pedido):
                    echo "<div id=\"pedido_" . $pedido->id_pedido . "\">";
                    ?>
                    <li>
                        <?php
                        echo "Pedido : " . $pedido->id_pedido;
                        echo " - Precio : " . $pedido->precio;
                        echo " - Fecha : " . $pedido->fecha;
                        echo "<br>";
                        echo "<a onclick=";
                        echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido=" . $pedido->id_pedido .
                        "&estado=A','verPedido','post',1)> Ver </a>";
                        ?>   
                    </li>
                    <?php
                    echo "</div>";
                endforeach;
            }
            ?>
        </ul>
    </div>
    <div id="tituloMostrarPedido"><h2>Pedido</h2></div>    
    <div id="mostrarPedido">        
    </div>
</div>


