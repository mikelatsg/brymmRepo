<!-- Formulario modal aceptar pedido-->
<div id="dialog" title="Aceptar pedido" style="display: none">
	<form id="formAceptarPedido">
		<fieldset>
			<input type="hidden" name="idPedido" id="idPedidoForm" value="0" /> <input
				type="hidden" name="estado" value="A" /> <label for="fechaEntrega">Fecha
				entrega</label> <input type="text" name="fechaEntrega"
				id="datePickerFechaEntregaPedido"
				class="text ui-widget-content ui-corner-all" /> <label
				for="horaEntrega">Hora</label> <select name="horaEntrega"
				id="horaFechaEntregaPedido"
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
			</select> : <select name="minutoEntrega"
				id="minutoFechaEntregaPedido"
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
<div id="dialogRechazar" title="Rechazar pedido" style="display: none">
	<form id="formRechazarPedido">
		<fieldset>
			<input type="hidden" name="idPedido" id="idPedidoFormRechazar"
				value="0" /> <input type="hidden" name="estado" value="R" /> <label
				for="observaciones">Motivo</label>
			<textarea name="motivoRechazo"
				class="text ui-widget-content ui-corner-all"></textarea>
		</fieldset>
	</form>
</div>
<div>
	<?php if (!$servicioPedidoActivo):?>
	<div class="alert alert-danger" role="alert">El servicio de pedidos
		est� desactivado</div>
	<?php endif;?>
	<div id="pedidosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-shopping-cart"></i> Pedidos
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="pedidosPendientesCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#pedidosPendientes"
								class="accordion-toggle collapsed"><i class="fa fa-unlock"></i>
								Pedidos pendientes </a>
						</h4>
					</div>
					<div id="pedidosPendientes"
						class="panel-body collapse sub-panel altoMaximo">
						<?php
						if ($pedidosPendientesLocal) :
						foreach ($pedidosPendientesLocal as $pedido):
						echo "<div id=\"pedido_" . $pedido->id_pedido . "\">";
						?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td class="titulo" colspan="3"><?php
										echo "Pedido " . $pedido->id_pedido;
										?> <span id="modificarEstado"> <span class="rechazarPedido">
													<button
														class="btn btn-danger btn-sm pull-right enlaceRechazarPedido"
														type="button" data-toggle="tooltip"
														data-original-title="Remove this user"
														data-id="<?php echo $pedido->id_pedido;?>"
														title="Rechazar pedido">
														<span class="glyphicon glyphicon-remove"></span>
													</button>
											</span> <span class="aceptarPedido">
													<button
														class="btn btn-success btn-sm pull-right enlaceAceptarPedido"
														type="button" data-toggle="tooltip"
														data-original-title="Remove this user"
														data-id="<?php echo $pedido->id_pedido;?>"
														title="Aceptar pedido">
														<span class="glyphicon glyphicon-ok"></span>
													</button>
											</span>
										</span>
											<button class="btn btn-default btn-sm pull-right"
												type="button" data-toggle="tooltip"
												data-original-title="Remove this user"
												onclick="<?php
                    echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido=" . $pedido->id_pedido .
							"&estado=A','verPedido','post',1)";
                ?>"
												title="Ver pedido">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php 
										echo  $pedido->precio;
										?><i class="fa fa-euro"></i>
										</td>
										<td><?php 
										echo  $pedido->fecha;
										?> <i class="fa fa-calendar"></i>
										</td>
										<td><a
											href="<?php echo site_url()?>/usuarios/datosPerfil/<?php echo $pedido->id_usuario?>"><?php 
											echo  $pedido->nombre;
											?> <i class="fa fa-user"></i> </a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php
						echo "</div>";
						endforeach;
						endif;
						?>
					</div>
				</div>
				<div id="pedidosAceptadosCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#pedidosAceptados"
								class="accordion-toggle collapsed"><i class="fa fa-thumbs-up"></i>
								Pedidos aceptados </a>
						</h4>
					</div>
					<div id="pedidosAceptados"
						class="panel-body collapse sub-panel altoMaximo">
						<?php
						if ($pedidosAceptadosLocal) :
						foreach ($pedidosAceptadosLocal as $pedido):
						echo "<div id=\"pedido_" . $pedido->id_pedido . "\">";
						?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td class="titulo" colspan="3"><?php
										echo "Pedido " . $pedido->id_pedido;
										?> <span id="modificarEstado"> <span class="rechazarPedido">
													<button
														class="btn btn-danger btn-sm pull-right enlaceRechazarPedido"
														type="button" data-toggle="tooltip"
														data-original-title="Remove this user"
														data-id="<?php echo $pedido->id_pedido;?>"
														title="Rechazar pedido">
														<span class="glyphicon glyphicon-remove"></span>
													</button>
											</span> <span class="aceptarPedido">
													<button class="btn btn-success pull-right" type="button"
														data-toggle="tooltip"
														data-original-title="Remove this user"
														onclick="<?php 
														echo "doAjax('" . site_url() . "/pedidos/actualizarEstadoPedido','idPedido=" . $pedido->id_pedido .
							"&estado=T','moverPedidoEstado','post',1)";
														?>"
														title="Terminar pedido">
														<span class="glyphicon glyphicon-ok"></span>
													</button>
											</span>
										</span>
											<button class="btn btn-default pull-right" type="button"
												data-toggle="tooltip" data-original-title="Remove this user"
												onclick="<?php
                    echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido=" . $pedido->id_pedido .
							"&estado=A','verPedido','post',1)";
                ?>"
												title="Ver pedido">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php 
										echo  $pedido->precio;
										?><i class="fa fa-euro"></i>
										</td>
										<td><?php 
										echo  $pedido->fecha;
										?> <i class="fa fa-calendar"></i>
										</td>
										<td><a
											href="<?php echo site_url()?>/usuarios/datosPerfil/<?php echo $pedido->id_usuario?>"><?php 
											echo  $pedido->nombre;
											?> <i class="fa fa-user"></i> </a></td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php
						echo "</div>";
						endforeach;
						endif;
						?>
					</div>
				</div>
				<div id="pedidosTerminadosCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#pedidosTerminados"
								class="accordion-toggle collapsed"><i class="fa fa-lock"></i>
								Pedidos terminados </a>
						</h4>
					</div>
					<div id="pedidosTerminados"
						class="panel-body collapse sub-panel altoMaximo">
						<?php
						if ($pedidosTerminadosLocal) :
						foreach ($pedidosTerminadosLocal as $pedido):
						echo "<div id=\"pedido_" . $pedido->id_pedido . "\">";
						?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td class="titulo" colspan="3"><?php
										echo "Pedido " . $pedido->id_pedido;
										?>
											<button class="btn btn-default pull-right" type="button"
												data-toggle="tooltip" data-original-title="Remove this user"
												onclick="<?php
                    echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido=" . $pedido->id_pedido .
							"&estado=A','verPedido','post',1)";
                ?>"
												title="Ver pedido">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php 
										echo  $pedido->precio;
										?><i class="fa fa-euro"></i>
										</td>
										<td><?php 
										echo  $pedido->fecha;
										?> <i class="fa fa-calendar"></i>
										</td>
										<td><a
											href="<?php echo site_url()?>/usuarios/datosPerfil/<?php echo $pedido->id_usuario?>"><?php 
											echo  $pedido->nombre;
											?> <i class="fa fa-user"></i> </a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php
						echo "</div>";
						endforeach;
						endif;
						?>
					</div>
				</div>
				<div id="pedidosRechazadosCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#pedidosRechazados"
								class="accordion-toggle collapsed"><i class="fa fa-thumbs-down"></i>
								Pedidos rechazados </a>
						</h4>
					</div>
					<div id="pedidosRechazados"
						class="panel-body collapse sub-panel altoMaximo">
						<?php
						if ($pedidosRechazadosLocal) :
						foreach ($pedidosRechazadosLocal as $pedido):
						echo "<div id=\"pedido_" . $pedido->id_pedido . "\">";
						?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td class="titulo" colspan="3"><?php
										echo "Pedido " . $pedido->id_pedido;
										?>
											<button class="btn btn-default pull-right" type="button"
												data-toggle="tooltip" data-original-title="Remove this user"
												onclick="<?php
                    echo "doAjax('" . site_url() . "/pedidos/verPedido','idPedido=" . $pedido->id_pedido .
							"&estado=A','verPedido','post',1)";
                ?>"
												title="Ver pedido">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php 
										echo  $pedido->precio;
										?><i class="fa fa-euro"></i>
										</td>
										<td><?php 
										echo  $pedido->fecha;
										?> <i class="fa fa-calendar"></i>
										</td>
										<td><a
											href="<?php echo site_url()?>/usuarios/datosPerfil/<?php echo $pedido->id_usuario?>"><?php 
											echo  $pedido->nombre;
											?> <i class="fa fa-user"></i> </a></td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php
						echo "</div>";
						endforeach;
						endif;
						?>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="detallePedidoCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<i class="fa fa-list"></i> Detalle pedido
						</h4>
					</div>
					<!-- <div id="tituloMostrarPedido">						
					</div> -->
					<div id="mostrarPedido" class="panel-body sub-panel altoMaximo"></div>
				</div>
			</div>
		</div>
	</div>
</div>
