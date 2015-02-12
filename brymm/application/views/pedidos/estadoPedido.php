<div id="resumenPedido">
	<div class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">Pedido</h4>
		</div>
		<div id="mostrarPedido" class="panel-body panel-verde">
			<div id="detallePedido">
				<div class="col-md-12 estadosPedido">
					<div class="col-md-3 titulo">
						<h4>
							<span class="col-md-12 label label-danger">Rechazado</span>
						</h4>
					</div>
					<div class="col-md-3 titulo">
						<h4>
							<span class="col-md-12 label label-warning">Pendiente</span>
						</h4>
					</div>
					<div class="col-md-3 titulo">
						<h4>
							<span class="col-md-12 label label-primary">Aceptado</span>
						</h4>
					</div>
					<div class="col-md-3 titulo">
						<h4>
							<span class="col-md-12 label label-success">Terminado</span>
						</h4>
					</div>
				</div>
				<div class="col-md-12">
					<div class="progress">
						<div id="progresoEstado"
							class="progress-bar progress-bar-striped active <?php 
						if ($pedido['idEstado'] == 'R'){
							echo "progress-bar-danger";
						}elseif ($pedido['idEstado'] == 'P') {
							echo "progress-bar-warning";
						}elseif ($pedido['idEstado'] == 'A') {
							echo "progress-bar-primary";
						}elseif ($pedido['idEstado'] == 'T') {
							echo "progress-bar-success";
						}
						?>"
							role="progressbar" aria-valuenow="45" aria-valuemin="0"
							aria-valuemax="100"<?php 
							if ($pedido['idEstado'] == 'R'){
							echo " style=\"width:13%\"";
						}elseif ($pedido['idEstado'] == 'P') {
							echo " style=\"width:37%\"";
						}elseif ($pedido['idEstado'] == 'A') {
							echo " style=\"width:63%\"";
						}elseif ($pedido['idEstado'] == 'T') {
							echo " style=\"width:87%\"";
						}
						?>>
							<span class="sr-only">45% Complete</span>
						</div>
					</div>
				</div>
				<div class="col-md-12" id="divBotonAct">
					<button class="btn btn-success" type="button" data-toggle="tooltip"
						data-original-title="Edit this user"
						onclick="<?php
            echo "doAjax('" . site_url() . "/pedidos/obtenerEstadoPedido','idPedido=" .
           $pedido['idPedido'] . "','actualizarEstadoPedido','post',1)"
            ?>">
						<span class="glyphicon glyphicon-refresh"></span> Actualizar
					</button>
				</div>
				<div class="col-md-6 well">
					<table
						class="table table-condensed table-responsive table-user-information">
						<tbody id="cabeceraPedido">
							<tr>
								<td id="idPedido"><h4>
										<span class="label label-default">Pedido <?php echo $pedido['idPedido'];?>
										</span>
									</h4>
								</td>
							</tr>
							<tr>

								<td class="titulo">Precio pedido</td>
								<td><?php if (isset($gastosEnvio)):?> <?php
								echo round( $pedido['precio'],2) - round($gastosEnvio,2);
								else:
								echo round( $pedido['precio'],2);
								endif;?> <i class="fa fa-euro"></i></td>
								<td class="titulo">Gastos de envio</td>
								<?php if (isset($gastosEnvio)):?>
								<td><?php echo round($gastosEnvio,2);?> <i class="fa fa-euro"></i>
								</td>
								<?php
								else:?>
								<td><?php echo "-";?>
								</td>
								<?php endif;?>

							</tr>
							<tr>
								<td class="titulo">Precio total</td>
								<td><?php echo round( $pedido['precio'],2);?> <i
									class="fa fa-euro"></i></td>
							</tr>
							<tr>
								<td class="titulo">Estado</td>
								<td><span id="estadoPedido"><?php echo $pedido['estado'];?> </span>
								</td>
								<td class="titulo">Fecha pedido</td>
								<td><?php echo $pedido['fechaPedido'];?>
								</td>
							</tr>
							<tr>
								<td class="titulo">Fecha entrega</td>
								<td><?php 
								if ($pedido['idEstado'] == 'A' || $pedido['idEstado'] == 'T') {
										echo $pedido['fechaEntrega'];
									}else {
										echo "-";
									}?>
								</td>
							</tr>
							<tr>
								<td class="titulo">Observaciones</td>
								<td colspan="3"><?php echo $pedido['observaciones'];?>
								</td>
							</tr>							
						</tbody>
					</table>
				</div>

				<div class="col-md-6 well altoMaximo">
					<table
						class="table table-condensed table-responsive table-user-information">
						<tbody>
							<?php foreach ($pedido['detallePedido'] as $detallePedido):?>
							<tr>
								<td id="nombreArticulo" class="titulo text-center" colspan="2"><?php echo $detallePedido['articulo'];?>
								</td>
								<td id="nombreArticulo"></td>
							</tr>
							<tr>
								<td class="titulo">Cantidad</td>
								<td><?php echo $detallePedido['cantidad'];?>
								</td>
								<td></td>
							</tr>
							<tr>
								<td
									class="titulo <?php if (!isset($detallePedido['detalleArticulo'])){
										echo "separadorArticulo";}?>">Precio</td>
								<td
									class="<?php if (!isset($detallePedido['detalleArticulo'])){
										echo "separadorArticulo";}?>"><?php echo round($detallePedido['precioArticulo'],2);?><i
									class="fa fa-euro"></i>
								</td>
								<td
									class="<?php if (!isset($detallePedido['detalleArticulo'])){
										echo "separadorArticulo";}?>"></td>
							</tr>
							<?php if (isset($detallePedido['detalleArticulo'])):?>
							<tr>
								<td class="titulo">Tipo articulo</td>
								<td><?php echo $detallePedido['tipoArticulo'];?>
								</td>
								<td></td>
							</tr>
							<?php 
							$i= 0;
							$textoIngredientes = "";
							foreach ($detallePedido['detalleArticulo'] as $detalleArticulo) {
								if ($i > 0) {
									$textoIngredientes .= ", ";
								}
								$textoIngredientes .= $detalleArticulo['ingrediente'];
								$i += 1;
							}?>
							<tr>
								<td class="titulo separadorArticulo">Ingredientes</td>
								<td class="separadorArticulo"><?php echo $textoIngredientes;?></i>
								</td>
								<td class="separadorArticulo"></td>
							</tr>
							<?php endif;	
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
