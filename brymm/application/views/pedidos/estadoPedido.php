<div id="resumenPedido">
    <div id="detallePedido">
        <?php
        echo $pedido['idPedido'] . " - " . $pedido['precio']
        . " - " . $pedido['observaciones'] . " - " . $pedido['fechaPedido'] .
        " - <span id=\"estadoPedido\">" . $pedido['estado'] . "</span>";
        if ($pedido['idEstado'] == 'A' || $pedido['idEstado'] == 'T') {
            echo " - Fecha entrega : " . $pedido['fechaEntrega'];
        }
        if (isset($gastosEnvio)) {
            echo "<br>Gastos de envio:" . $gastosEnvio;
        }
        echo "<ol>";
        foreach ($pedido['detallePedido'] as $detallePedido) {
            echo "<li>";
            echo $detallePedido['tipoArticulo'] . " - " . $detallePedido['articulo'] . " - " .
            $detallePedido['precioArticulo'] . " - " . $detallePedido['cantidad'];
            if (isset($detallePedido['detalleArticulo'])) {
                echo "<ul>";
                foreach ($detallePedido['detalleArticulo'] as $detalleArticulo) {
                    echo "<li>";
                    echo $detalleArticulo['ingrediente'];
                    echo "</li>";
                }
                echo "</ul>";
            }
            echo "</li>";
        }
        echo "</ol>";
        ?>
    </div>    
    <input type="button" value="actualizar datos"
           onclick=" <?php
           echo "doAjax('" .
           site_url() . "/pedidos/obtenerEstadoPedido','idPedido=" .
           $pedido['idPedido'] . "','actualizarEstadoPedido','post',1)\""
           ?>">
</div>
