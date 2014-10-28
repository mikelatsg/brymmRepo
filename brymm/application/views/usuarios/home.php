
<div id="homeUsuario">
	<div>
		<div id="pedidosUsuario" class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a data-toggle="collapse" data-target="#collapsePedidosUsuario"
									class="accordion-toggle collapsed"> Pedidos</a>
				</h4>
			</div>			
			<div id="collapsePedidosUsuario" class="panel-body collapse">
				<div class="col-md-6">
					<div id="ultimosPedidosUsuario" class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-target="#collapseUltimosPedidos"
									class="accordion-toggle collapsed"> Ultimos pedidos </a>
							</h4>
						</div>
						<div id="collapseUltimosPedidos" class="panel-collapse collapse">
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
				endforeach;
				echo "</ul>";
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div id="detallePedidoUsuario" class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Detalle pedido</h4>
						</div>
						<div id="muestraDetalle"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div id="localesFavoritosUsuario" class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#localesFavoritos"
							class="accordion-toggle collapsed"> Locales favoritos </a>
					</h4>
				</div>
				<div id="localesFavoritos" class="collapse">
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
			</div>

			<div id="misDireccionesUsuario" class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#listaDirecciones"
							class="accordion-toggle collapsed"> Mis direcciones </a>
					</h4>
				</div>

				<div id="listaDirecciones" class="collapse">
					<ul>
						<?php foreach ($direccionesEnvio as $linea): ?>
						<li><?php
						echo "Nombre direccion : " . $linea->nombre . " - Direccion : " . $linea->direccion
						. " - Poblacion : " . $linea->poblacion
						. " - Provincia : " . $linea->provincia;
						?> <a
							onclick="<?php
                echo "doAjax('" . site_url() . "/usuarios/borrarDireccionEnvio','idDireccionEnvio="
                . $linea->id_direccion_envio . "','','post',1)";
                ?>"> Borrar </a></li>
						<?php endforeach; ?>
					</ul>
					<div id="anadirDireccion">
						<?php
						echo "<a class=\"enlaceAnadirDireccion\" data-toggle=\"modal\" > Añadir direccion </a>";
						?>
					</div>
				</div>

			</div>

		</div>
		<div class="col-md-6">
			<div id="ultimasReservasUsuario" class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#ultimasReservas"
							class="accordion-toggle collapsed"> Ultimas reservas </a>
					</h4>
				</div>
				<div id="ultimasReservas" class="collapse">
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
		</div>
	</div>
</div>

