
<div id="homeUsuario">
    <div id="ultimosPedidos">
        <h3>Ultimos pedidos</h3>
        <?php
        if (count($pedidosUsuario) > 0) {
            echo "</ul>";
            foreach ($pedidosUsuario as $linea):
                echo "<li>";
                //echo "Local : " . $linea['nombreLocal'];
                echo anchor('/locales/mostrarLocal/' . $linea['idLocal'], $linea['nombreLocal']);
                echo " - Pedido : " . $linea['idPedido'];
                echo " - Precio : " . $linea['precio'];
                echo " - Estado : <span id=\"estadoPedido\">" . $linea['estado'] . "</span>";
                echo "<a onclick=\"";
                echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido="
                . $linea['idPedido'] . "','verPedidoHomeUsuario','post',1)\"> Ver pedido </a>";
                echo anchor('/pedidos/generarPedidoAntiguo/' . $linea['idPedido'], ' Cargar pedido ');
                if ($linea['fechaPedido'] >= date('Y-m-d')) {
                    echo anchor('/pedidos/mostrarEstadoPedido/' . $linea['idPedido'], ' Estado pedido ');
                }
                echo "</li>";
            /* echo "<ol>";
              foreach ($linea['detallePedido'] as $articulo) {
              echo "<li>";
              echo " Articulo : " . $articulo['articulo'];
              echo " Cantidad : " . $articulo['cantidad'];
              echo " Precio articulo : " . $articulo['precioArticulo'];
              echo "<br>";
              echo $articulo['tipoArticulo'] . " : ";
              foreach ($articulo['detalleArticulo'] as $ingrediente) {
              echo $ingrediente['ingrediente'] . " - ";
              }
              echo "</li>";
              }
              echo "</ol>"; */
            endforeach;
            echo "</ul>";
        }
        ?>
    </div>
    <div id="muestraDetalle">
    </div>
    <div id="localesFavoritos">
        <h3>Locales favoritos</h3>
        <?php
        foreach ($localesFavoritos as $local):
            echo "<div id=\"local_" . $local->id_local . "\">";
            echo anchor('/locales/mostrarLocal/' . $local->id_local, $local->nombre .
                    " - tipo de comida : " . $local->tipo_comida .
                    " - localidad : " . $local->localidad);
            echo "<a onclick=\"";
            echo "doAjax('" . site_url() . "/locales/quitarLocalFavorito','idLocal="
            . $local->id_local . "','eliminarLocalFavorito','post',1)\">Eliminar favorito </a>";
            echo "</div>";
        endforeach;
        ?>
    </div>
    <div id="ultimasReservas">
        <h3>Ultimas reservas</h3>
        <?php
        if (count($ultimasReservas) > 0) {
            echo "<ul>";
            foreach ($ultimasReservas as $reserva):
                echo "<li>";
                echo "Reserva : " . $reserva->id_reserva;
                echo "Fecha : " . $reserva->fecha;
                echo anchor('/locales/mostrarLocal/' . $reserva->id_local, $reserva->nombreLocal);
                /*
                 * Se muestra el enlace para ver la reserva
                 */
                echo "<a onclick=\"";
                echo "doAjax('" . site_url() . "/reservas/mostrarReservaUsuario','idReserva="
                . $reserva->id_reserva . "','mostrarReservaHomeUsuario','post',1)\"> Ver </a>";
                echo "</li>";
            endforeach;
            echo "</ul>";
        }
        ?>
    </div>
</div>

