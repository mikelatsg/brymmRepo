
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
							if (count($pedidosUsuario) > 0) :
							?>
							<div class="list-group">
								<?php
								foreach ($pedidosUsuario as $linea):
								echo "<span class=\"list-group-item\">";
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
				echo "</span>";
				endforeach;
				?>
							</div>
							<?php
							endif;
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
	<div>
		<div id="reservasUsuario" class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-target="#collapseReservasUsuario"
						class="accordion-toggle collapsed"> Reservas</a>
				</h4>
			</div>
			<div id="collapseReservasUsuario" class="panel-body collapse">
				<div class="col-md-6">
					<div id="ultimasReservasUsuario" class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-target="#ultimasReservas"
									class="accordion-toggle collapsed"> Ultimas Reservas </a>
							</h4>
						</div>
						<div id="ultimasReservas" class="collapse">
							<?php
							if (count($ultimasReservas) > 0) :
							?>

							<div class="list-group">
								<?php 
								foreach ($ultimasReservas as $reserva):
								echo "<a class=\"list-group-item\" onclick=\"";
								echo "doAjax('" . site_url() . "/reservas/mostrarReservaUsuario','idReserva="
						. $reserva->id_reserva . "','mostrarReservaHomeUsuario','post',1)\">";
								echo "Local : " .$reserva->nombreLocal;
								echo "Reserva : " . $reserva->id_reserva;
								echo "Fecha : " . $reserva->fecha;
								echo "</a>";
            endforeach;?>
							</div>
							<?php
							endif;
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div id="detalleReservaUsuario" class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Detalle reserva</h4>
						</div>
						<div id="muestraDetalleReserva"></div>
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
						<div class="list-group">
							<?php
							foreach ($localesFavoritos as $local):
							echo "<span class=\"list-group-item\" id=\"local_" . $local->id_local . "\">";
							echo anchor('/locales/mostrarLocal/' . $local->id_local, $local->nombre .
                    " - tipo de comida : " . $local->tipo_comida .
                    " - localidad : " . $local->localidad);
            echo "<a onclick=\"";
            echo "doAjax('" . site_url() . "/locales/quitarLocalFavorito','idLocal="
							. $local->id_local . "','eliminarLocalFavorito','post',1)\">Eliminar favorito </a>";
            echo "</span>";
            endforeach;
            ?>
						</div>
					</div>
				</div>

			</div>
			<div class="col-md-6">
				<div id="misDireccionesUsuario" class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaDirecciones"
								class="accordion-toggle collapsed"> Mis direcciones </a>
						</h4>
					</div>

					<div id="listaDirecciones" class="panel-body collapse">
						<div class="list-group">
							<?php foreach ($direccionesEnvio as $linea): ?>
							<span class="list-group-item"><?php
							echo "Nombre direccion : " . $linea->nombre . " - Direccion : " . $linea->direccion
							. " - Poblacion : " . $linea->poblacion
							. " - Provincia : " . $linea->provincia;
							?> <a
								onclick="<?php
                echo "doAjax('" . site_url() . "/usuarios/borrarDireccionEnvio','idDireccionEnvio="
                . $linea->id_direccion_envio . "','','post',1)";
                ?>"> Borrar </a> </span>
							<?php endforeach; ?>
						</div>
						<div id="anadirDireccion">
							<?php
							echo "<a class=\"enlaceAnadirDireccion\" data-toggle=\"modal\" > Añadir direccion </a>";
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>