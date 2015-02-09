
<div id="homeUsuario">
	<div>
		<div id="pedidosUsuario" class="panel panel-default">
			<div class="panel-heading panel-verde">
				<h4 class="panel-title">Pedidos</h4>
			</div>
			<div id="collapsePedidosUsuario" class="panel-body panel-verde">
				<div class="col-md-4">
					<div id="ultimosPedidosUsuario"
						class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-target="#collapseUltimosPedidos"
									class="accordion-toggle collapsed"> Ultimos pedidos </a>
							</h4>
						</div>
						<div id="collapseUltimosPedidos"
							class="panel-body collapse sub-panel">
							<?php
							foreach ($pedidosUsuario as $linea):
							?>
							<div class="col-md-12 list-div">
								<table class="table">
									<tbody>
										<tr>
											<td class="titulo" colspan="3">Pedido <?php echo $linea['idPedido'];?>
												<button class="btn btn-default btn-sm pull-right"
													type="button" data-toggle="tooltip"
													data-original-title="Remove this user"
													onclick="<?php
                    echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido="
									. $linea['idPedido'] . "','verPedidoHomeUsuario','post',1)";
                ?>" title="Ver detalle del pedido">
													<span class="glyphicon glyphicon-eye-open"></span>
												</button> <?php 
												if ($linea['fechaPedido'] >= date('Y-m-d')):
												?> <a class="btn btn-primary btn-sm pull-right"
												role="button"
												href="<?php echo site_url();?>/pedidos/mostrarEstadoPedido/<?php echo $linea['idPedido'];?>"
												title="Ver estado pedido"><i class="fa fa-tag"></i> </a> <?php 
												endif;?> <a class="btn btn-warning btn-sm pull-right"
												role="button"
												href="<?php echo site_url();?>/pedidos/generarPedidoAntiguo/<?php echo $linea['idPedido'];?>"
												title="Cargar el pedido para realizar un nuevo pedido"><i class="fa fa-refresh"></i> </a>
											</td>
										</tr>
										<tr>
											<td><?php echo $linea['precio'];?> <i class="fa fa-euro"></i>
											</td>
											<td><?php echo $linea['estado'];?> <i class="fa fa-tag"></i>
											</td>
											<td><a
												href="<?php echo site_url();?>/locales/mostrarLocal/<?php echo $linea['idLocal'];?>">
													<?php echo $linea['nombreLocal'];?> <i class="fa fa-home">
												</i>
											</a></td>
										</tr>
									</tbody>
								</table>
							</div>
							<!--
							echo "<a onclick=\"";
							echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido="
									. $linea['idPedido'] . "','verPedidoHomeUsuario','post',1)\"> Ver pedido </a>";
							echo anchor('/pedidos/generarPedidoAntiguo/' . $linea['idPedido'], ' Cargar pedido ');
							if ($linea['fechaPedido'] >= date('Y-m-d')) {
					echo anchor('/pedidos/mostrarEstadoPedido/' . $linea['idPedido'], ' Estado pedido ');
							}
							echo "</span>"; -->
							<?php
							endforeach;
							?>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div id="detallePedidoUsuario"
						class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">Detalle pedido</h4>
						</div>
						<div id="muestraDetalle" class="panel-body sub-panel"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>
		<div id="reservasUsuario" class="panel panel-default">
			<div class="panel-heading panel-verde">
				<h4 class="panel-title">Reservas</h4>
			</div>
			<div id="collapseReservasUsuario" class="panel-body panel-verde">
				<div class="col-md-4">
					<div id="ultimasReservasUsuario"
						class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-target="#ultimasReservas"
									class="accordion-toggle collapsed"> Ultimas Reservas </a>
							</h4>
						</div>
						<div id="ultimasReservas"
							class="panel-collapse collapse sub-panel">
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
				<div class="col-md-8">
					<div id="detalleReservaUsuario"
						class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">Detalle reserva</h4>
						</div>
						<div id="muestraDetalleReserva" class="panel-body sub-panel"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div id="localesFavoritosUsuario" class="panel panel-default">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#localesFavoritos"
								class="accordion-toggle collapsed"> Locales favoritos </a>
						</h4>
					</div>
					<div id="localesFavoritos" class="panel-body collapse sub-panel">
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
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaDirecciones"
								class="accordion-toggle collapsed"> Mis direcciones </a>
						</h4>
					</div>

					<div id="listaDirecciones" class="panel-body collapse sub-panel">
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