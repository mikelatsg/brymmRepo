
<div id="homeUsuario">
	<div>
		<div id="pedidosUsuario" class="panel panel-default">
			<div class="panel-heading panel-verde">
				<h4 class="panel-title">
					<i class="fa fa-shopping-cart"></i> Pedidos
				</h4>
			</div>
			<div id="collapsePedidosUsuario" class="panel-body panel-verde">
				<div class="col-md-4">
					<div id="ultimosPedidosUsuario"
						class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-target="#collapseUltimosPedidos"
									class="accordion-toggle collapsed"><i
									class="fa fa-long-arrow-down"></i> Ultimos pedidos </a>
							</h4>
						</div>
						<div id="collapseUltimosPedidos"
							class="panel-body collapse sub-panel altoMaximo">
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
                ?>"
													title="Ver detalle del pedido">
													<span class="glyphicon glyphicon-eye-open"></span>
												</button> <?php 
												if ($linea['fechaPedido'] >= date('Y-m-d')):
												?> <a class="btn btn-primary btn-sm pull-right"
												role="button"
												href="<?php echo site_url();?>/pedidos/mostrarEstadoPedido/<?php echo $linea['idPedido'];?>"
												title="Ver el estado del pedido"><i class="fa fa-tag"></i> </a>
												<?php 
												endif;?> <a class="btn btn-warning btn-sm pull-right"
												role="button"
												href="<?php echo site_url();?>/pedidos/generarPedidoAntiguo/<?php echo $linea['idPedido'];?>"
												title="Cargar el pedido para realizar un nuevo pedido"><i
													class="fa fa-refresh"></i> </a>
											</td>
										</tr>
										<tr>
											<td><?php echo $linea['precio'];?> <i class="fa fa-euro"
												title="Precio"></i>
											</td>
											<td><?php echo $linea['estado'];?> <i class="fa fa-tag"
												title="Estado"></i>
											</td>
											<td><a
												href="<?php echo site_url();?>/locales/mostrarLocal/<?php echo $linea['idLocal'];?>">
													<?php echo $linea['nombreLocal'];?> <i class="fa fa-home"
													title="Local"> </i>
											</a></td>
										</tr>
									</tbody>
								</table>
							</div>
							<?php
							endforeach;
							?>
							<div class="col-md-12 text-center">
								<a
									onclick="<?php
						                    echo "doAjax('" . site_url() . "/pedidos/mostrarTodosPedidosUsuario','','listaPedidosUsuario','post',1)";
						                    ?>"><i class="fa fa-plus"></i> Mostrar todos</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div id="detallePedidoUsuario"
						class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">
								<i class="fa fa-list"></i> Detalle pedido
							</h4>
						</div>
						<div id="muestraDetalle" class="panel-body sub-panel altoMaximo"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>
		<div id="reservasUsuario" class="panel panel-default">
			<div class="panel-heading panel-verde">
				<h4 class="panel-title">
					<i class="fa fa-calendar"></i> Reservas
				</h4>
			</div>
			<div id="collapseReservasUsuario" class="panel-body panel-verde">
				<div class="col-md-4">
					<div id="ultimasReservasUsuario"
						class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-target="#listaReservasUsuario"
									class="accordion-toggle collapsed"><i
									class="fa fa-long-arrow-down"></i> Ultimas Reservas </a>
							</h4>
						</div>
						<div id="listaReservasUsuario"
							class="panel-body collapse sub-panel altoMaximo">
							<?php 
							foreach ($ultimasReservas as $reserva):
							?>

							<div class="col-md-12 list-div">
								<table class="table">
									<tbody>
										<tr>
											<td class="titulo" colspan="3">Reserva <?php echo $reserva->id_reserva;?>
												<button class="btn btn-default btn-sm pull-right"
													type="button" data-toggle="tooltip"
													data-original-title="Remove this user"
													onclick="<?php
                    								echo "doAjax('" . site_url() . "/reservas/mostrarReservaUsuario','idReserva="
						. $reserva->id_reserva . "','mostrarReservaHomeUsuario','post',1)";
                									?>"
													title="Ver detalle de la reserva">
													<span class="glyphicon glyphicon-eye-open"></span>
												</button> <?php  
												if ($reserva->estado == 'P' || $reserva->estado == 'AL'): ?>
												<button class="btn btn-danger pull-right btn-sm"
													type="button" data-toggle="tooltip"
													data-original-title="Anular reserva"
													onclick="<?php
                    echo "doAjax('" . site_url() . "/reservas/anularReservaUsuario','idReserva="
                    . $reserva->id_reserva . "','listaUltimasReservasUsuario','post',1)";
                    ?>"
													title="Anular reserva">
													<span class="glyphicon glyphicon-remove"></span>
												</button> <?php endif;?>
											</td>
										</tr>
										<tr>
											<td><?php echo $reserva->fecha;?> <i class="fa fa-calendar"
												title="Fecha reserva"></i>
											</td>
											<td><?php echo estadosReserva($reserva->estado);?> <i
												class="fa fa-tag" title="Estado"></i>
											</td>
											<td><a
												href="<?php echo site_url();?>/locales/mostrarLocal/<?php echo $linea['idLocal'];?>">
													<?php echo $reserva->nombreLocal;?> <i class="fa fa-home"
													title="Local"> </i>
											</a></td>
										</tr>
									</tbody>
								</table>
							</div>
							<?php
            				endforeach;?>
							<div class="col-md-12 text-center">
								<a
									onclick="<?php
						                    echo "doAjax('" . site_url() . "/reservas/mostrarTodasReservasUsuario','','listaUltimasReservasUsuario','post',1)";
						                    ?>"><i class="fa fa-plus"></i> Mostrar todas</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div id="detalleReservaUsuario"
						class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">
								<i class="fa fa-list"></i> Detalle reserva
							</h4>
						</div>
						<div id="muestraDetalleReserva" class="panel-body sub-panel"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div id="localesFavoritosUsuario" class="panel panel-default">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#localesFavoritos"
								class="accordion-toggle collapsed"><i class="fa fa-cutlery"></i>
								Locales favoritos </a>
						</h4>
					</div>
					<div id="localesFavoritos"
						class="panel-body collapse sub-panel altoMaximo">
						<?php
						foreach ($localesFavoritos as $local):
						?>
						<div class="col-md-12 list-div"
							id="local_<?php echo $local->id_local;?>">
							<table class="table">
								<tbody>
									<tr>
										<td colspan="2"><a
											href="<?php echo site_url().'/locales/mostrarLocal/'.$local->id_local;?>"><i
												class="fa fa-home"></i> <?php echo $local->nombre;?> [<?php echo $local->localidad;?>]</a>
											<button class="btn btn-danger pull-right btn-sm"
												type="button" data-toggle="tooltip"
												data-original-title="Anular reserva"
												onclick="<?php
                    echo "doAjax('" . site_url() . "/locales/quitarLocalFavorito','idLocal="
                    . $local->id_local . "','eliminarLocalFavorito','post',1)";
                    ?>"
												title="Borrar favorito">
												<span class="glyphicon glyphicon-remove"></span>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php
						endforeach;
						?>
					</div>
				</div>

			</div>
			<div class="col-md-8">
				<div id="misDireccionesUsuario" class="panel panel-default">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaDirecciones"
								class="accordion-toggle collapsed"><i class="fa fa-inbox"></i>
								Mis direcciones </a>
						</h4>
					</div>
					<div id="listaDirecciones"
						class="panel-body collapse sub-panel altoMaximo">
						<?php foreach ($direccionesEnvio as $linea): ?>
						<div class="col-md-12 list-div"
							id="local_<?php echo $local->id_local;?>">
							<table class="table">
								<tbody>
									<tr>
										<td class="titulo" colspan="4"><?php echo $linea->nombre;?>
											<button class="btn btn-danger pull-right btn-sm"
												type="button" data-toggle="tooltip"
												data-original-title="Anular reserva"
												onclick="<?php
                    echo "doAjax('" . site_url() . "/usuarios/borrarDireccionEnvio','idDireccionEnvio="
                    . $linea->id_direccion_envio . "','listaDireccionEnvio','post',1)";
                    ?>"
												title="Borrar direccion">
												<span class="glyphicon glyphicon-remove"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td class="titulo col-md-2">Direccion</td>
										<td class="col-md-10" colspan="3"><?php echo  $linea->direccion;?>
										</td>
									</tr>
									<tr>
										<td class="titulo col-md-2">Poblacion</td>
										<td class="col-md-4"><?php echo  $linea->poblacion;?></td>
										<td class="titulo col-md-2">Provincia</td>
										<td class="col-md-4"><?php echo  $linea->provincia;?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- <span class="list-group-item"><?php
						echo "Nombre direccion : " . $linea->nombre . " - Direccion : " . $linea->direccion
						. " - Poblacion : " . $linea->poblacion
						. " - Provincia : " . $linea->provincia;
						?> <a
							onclick="<?php
                echo "doAjax('" . site_url() . "/usuarios/borrarDireccionEnvio','idDireccionEnvio="
                . $linea->id_direccion_envio . "','listaDireccionEnvio','post',1)";
                ?>"> Borrar </a> </span>
                 -->
						<?php endforeach; ?>
						<div id="anadirDireccion">
							<a onclick="<?php echo "anadirDireccion(true)";?>"
								data-toggle="modal"><i class="fa fa-plus"></i> <?php echo utf8_encode('Añadir direccion');?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>