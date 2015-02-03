<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">Confirmar pedido</h4>
		</div>
		<div id="mostrarPedido">
			<div id="detallePedido">
				<ul>
					<?php
					$existePedido = false;
					foreach ($pedido as $linea) {
						$existePedido = true;
						echo "<li> " . $linea['name'] . " - " . $linea['qty'] . " - " . $linea['price'];
						echo "<a onclick=\"doAjax('" .
								site_url() . "/pedidos/borrarArticulo','rowid=" . $linea['rowid'] . "','mostrarPedido','post',1)\"> X ";
						echo "</a>";
						if ($linea['options']['personalizado'] == 1) {
							echo '<br>';
							$i = 0;
							echo $linea['options']['tipoArticulo'] . " - ";
							foreach ($linea['options']['ingredientes'] as $ingredientes) {
							if ($i > 0) {
								echo ", ";
							}
							echo $ingredientes['ingrediente'];
							$i += 1;
						}
						}
						echo "</li>";
					}
					?>
				</ul>
				<?php
				//Se muestra el total del pedido
				echo "Total : " . $precioTotal;
				echo "<br>";
				//Si existe el pedido se da la opción a cancelar el pedido
				if ($existePedido) {
            echo "<a onclick=\"doAjax('" . site_url() . "/pedidos/cancelarPedido','','mostrarPedido','post',1)\">";
            echo "Cancelar";
            echo "</a>";
        }
        ?>
			</div>
			<div id="formPedido">
				<?php if ($_SESSION): 
				if ($_SESSION['idUsuario']): ?>

				<form method="post"
					action="<?php echo site_url() ?>/pedidos/confirmarPedido">
					<input type="hidden" name="idLocal" value="<?php echo $idLocal; ?>">
					<table>
						<tr>
							<td><input type="checkbox" name="retrasarPedido" value="1">
								Retrasar pedido</td>
						</tr>
						<tr>
							<td>fecha:</td>
							<td><input type="text" name="fechaRecogida"
								id="datepickerFechaRecogidaPedido" />
							</td>
							<td>hora:</td>
							<td>
								<!--<input type="text" name="horaRecogida"/>:<input type="text" name="minutoRecogida"/>-->
								<select name="horaRecogida" id="horaFechaRecogidaPedido">
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
							</select> : <select name="minutoRecogida"
								id="minutoFechaRecogidaPedido">
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
							</td>
						</tr>
						<?php if ($envioPedidos): ?>
						<tr>
							<td><input type="checkbox" name="envioPedido" value="1"> Envio
								pedido</td>
						</tr>
						<tr>
							<td>Direccion envio</td>
							<td><select name="direccionEnvio" id="comboDireccionesEnvio">
									<?php foreach ($direccionesEnvio as $linea): ?>
									<option value="<?php echo $linea->id_direccion_envio; ?>">
										<?php echo $linea->nombre; ?>
									</option>
									<?php endforeach; ?>
							</select>
							</td>

							<td><?php
							echo "<a class=\"enlaceAnadirDireccion\" data-toggle=\"modal\" > Añadir direccion </a>";
							?></td>
						</tr>
						<tr>
							<td>Precio envio <?php echo $precioEnvioPedido->precio ?>
							</td>
						</tr>
						<?php endif; ?>
						<tr>
							<td>Observaciones</td>
							<td><textarea name="observaciones"></textarea>
							</td>
						</tr>
						<tr>
							<td width="51" colspan="2" align="center"><input type="submit"
								value="Confirmar" />
							</td>
						</tr>
					</table>
				</form>

				<?php
				/*else :

				echo "Logeate para realizar pedidos";*/

				endif;
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
