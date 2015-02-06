<div class="col-md-5 noPadRight">
	<div class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">Detalle pedido</h4>
		</div>
		<div id="mostrarPedido" class="panel-body panel-verde">
			<div id="detallePedido">
				<?php
				$existePedido = false;
				foreach ($pedido as $linea) :
				if (!$existePedido):?>
				<div class="col-md-12 well">
					<table
						class="table table-condensed table-responsive table-user-information">
						<tbody>
							<?php 
							endif;
							$existePedido = true;
							?>
							<tr>
								<td class="titulo text-center" colspan="2"><?php echo $linea['name'];?>
								</td>
								<td>
									<button class="btn btn-danger btn-sm pull-right" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="<?php
            echo "doAjax('" . site_url() . "/pedidos/borrarArticulo','rowid=".$linea['rowid']."','mostrarPedido','post',1)"
            ?>">
										<span class="glyphicon glyphicon-remove"></span>
									</button>
								</td>
							</tr>
							<tr>
								<td class="titulo">Cantidad</td>
								<td><?php echo $linea['qty'];?>
								</td>
								<td></td>
							</tr>
							<tr>
								<td
									class="titulo <?php if ($linea['options']['personalizado'] != 1){
										echo "separadorArticulo";}?>">Precio</td>
								<td
									class="<?php if ($linea['options']['personalizado'] != 1){
										echo "separadorArticulo";}?>"><?php echo round($linea['price'],2);?><i
									class="fa fa-euro"></i>
								</td>
								<td
									class="<?php if ($linea['options']['personalizado'] != 1){
										echo "separadorArticulo";}?>"></td>
							</tr>
							<?php if ($linea['options']['personalizado'] == 1):?>
							<tr>
								<td class="titulo">Tipo articulo</td>
								<td><?php echo $linea['options']['tipoArticulo'];?>
								</td>
								<td></td>
							</tr>
							<?php 
							$i= 0;
							$textoIngredientes = "";
							foreach ($linea['options']['ingredientes'] as $ingredientes) {
								if ($i > 0) {
									$textoIngredientes .= ", ";
								}
								$textoIngredientes .= $ingredientes['ingrediente'];
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
							<?php
							//Si existe el pedido se muestra total y opcion cancelar
							if ($existePedido) :?>

						</tbody>
					</table>
				</div>
				<div class="well col-md-12">
					<div class="titulo col-md-5 text-left">Total</div>
					<div class="titulo col-md-5 text-left">
						<?php echo $precioTotal;?>
						<i class="fa fa-euro"></i>
					</div>
					<div class="col-md-2">
						<button class="btn btn-danger" type="button" data-toggle="tooltip"
							data-original-title="Edit this user"
							onclick="<?php
            echo "doAjax('" . site_url() . "/pedidos/cancelarPedido','','mostrarPedido','post',1)"
            ?>">
							<span class="glyphicon glyphicon-remove"></span>
						</button>
					</div>
				</div>
				<?php endif;?>
				<div id="formPedido" class="col-md-12 well"
				<?php if(!$existePedido) echo "style=display:none;"; ?>>
					<?php 
				if (isset($_SESSION['idUsuario'])): ?>
					<form method="post"
						action="<?php echo site_url() ?>/pedidos/confirmarPedido"
						class="form-horizontal">
						<input type="hidden" name="idLocal"
							value="<?php echo $idLocal; ?>">
						<div class="form-group">
							<span class="pull-left"> <label for="retrasarPedido"
								class="col-sm-12 control-label pull-left"><input type="checkbox"
									name="retrasarPedido" id="retrasarPedido" value="1"
									onchange="<?php echo "gestionRetrasarPedido()";?>"> Retrasar
									pedido </label>
							</span>
						</div>
						<span id="contenidoRetrasarPedido" style="display: none;">
							<div class="form-group">
								<label for="datepickerFechaRecogidaPedido"
									class="col-sm-4 control-label">Fecha</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"
										id="datepickerFechaRecogidaPedido"
										placeholder="Fecha recogida" name="fechaRecogida">
								</div>
							</div>
							<div class="form-group">
								<label for="horaFechaRecogidaPedido"
									class="col-sm-4 control-label">Hora</label>
								<div class="col-sm-8">
									<span class="pull-left"> <select name="horaRecogida"
										id="horaFechaRecogidaPedido">
											<option value="0" class="form-control">00</option>
											<option value="1" class="form-control">01</option>
											<option value="2" class="form-control">02</option>
											<option value="3" class="form-control">03</option>
											<option value="4" class="form-control">04</option>
											<option value="5" class="form-control">05</option>
											<option value="6" class="form-control">06</option>
											<option value="7" class="form-control">07</option>
											<option value="8" class="form-control">08</option>
											<option value="9" class="form-control">09</option>
											<option value="10" class="form-control">10</option>
											<option value="11" class="form-control">11</option>
											<option value="12" class="form-control">12</option>
											<option value="13" class="form-control">13</option>
											<option value="14" class="form-control">14</option>
											<option value="15" class="form-control">15</option>
											<option value="16" class="form-control">16</option>
											<option value="17" class="form-control">17</option>
											<option value="18" class="form-control">18</option>
											<option value="19" class="form-control">19</option>
											<option value="20" class="form-control">20</option>
											<option value="21" class="form-control">21</option>
											<option value="22" class="form-control">22</option>
											<option value="23" class="form-control">23</option>
									</select> : <select name="minutoRecogida"
										id="minutoFechaRecogidaPedido">
											<option value="00" class="form-control">00</option>
											<option value="05" class="form-control">05</option>
											<option value="10" class="form-control">10</option>
											<option value="15" class="form-control">15</option>
											<option value="20" class="form-control">20</option>
											<option value="25" class="form-control">25</option>
											<option value="30" class="form-control">30</option>
											<option value="35" class="form-control">35</option>
											<option value="40" class="form-control">40</option>
											<option value="45" class="form-control">45</option>
											<option value="50" class="form-control">50</option>
											<option value="55" class="form-control">55</option>
									</select>
									</span>
								</div>
							</div>
						</span>
						<?php if ($envioPedidos): ?>
						<div class="form-group">
							<span class="pull-left"> <label for="envioPedido"
								class="col-sm-12 control-label"><input type="checkbox"
									name="envioPedido" id="envioPedido" value="1"
									onchange="<?php echo "gestionEnvioPedido()";?>"> Envio pedido [<?php  echo round($precioEnvioPedido->precio,2); ?><i
									class="fa fa-euro"></i> ]</label>
							</span>
						</div>
						<div class="form-group" id="contenidoDireccionEnvio"
							style="display: none;">
							<label for="comboDireccionesEnvio" class="col-sm-4 control-label">Direccion
								envio</label>
							<div class="col-sm-6">
								<select name="direccionEnvio" id="comboDireccionesEnvio"
									class="pull-left">
									<?php foreach ($direccionesEnvio as $linea): ?>
									<option class="form-control"
										value="<?php echo $linea->id_direccion_envio; ?>">
										<?php echo $linea->nombre; ?>
									</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-success btn-sm enlaceAnadirDireccion"
									type="button" data-toggle="modal"
									data-original-title="Edit this user" title="Anadir direccion">
									<span class="glyphicon glyphicon-plus"></span>
								</button>
							</div>
						</div>
						<?php endif;?>

						<div class="form-group">
							<label for="observacionesPedido" class="col-sm-4 control-label">Observaciones</label>
							<div class="col-sm-8">
								<textarea name="observaciones" id="observacionesPedido"></textarea>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" value=" Send" class="btn btn-success"
								id="submit">
								<span class="glyphicon glyphicon-send"></span> Enviar pedido
							</button>
						</div>
					</form>

					<?php					
					else:
					echo "Logeate para realizar pedidos";
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- En vista de realizar pedido -->
