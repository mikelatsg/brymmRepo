<div>
	<div id="horariosLocal" class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Horarios pedido</h4>
		</div>
		<div class="panel-body">
			<div class="col-md-4">
				<div id="altaHorariosLocal" class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaHorarioPedido"
								class="accordion-toggle collapsed"> Nuevo horario pedido </a>
						</h4>
					</div>
					<div id="altaHorarioPedido" class="panel-body collapse">
						<form id="formAltaHorarioPedido">
							<table>
								<tr>
									<td>Dia</td>
									<td><select name="dia">
											<?php foreach ($dias as $dia): ?>
											<option value="<?php echo $dia->id_dia; ?>">
												<?php echo $dia->dia; ?>
											</option>
											<?php endforeach; ?>
									</select>
									</td>
								</tr>

								<tr>
									<td>Hora inicio</td>
									<td>
										<!--<input type="text" name="horaInicio" />--> <select
										name="horaInicio">
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
									</select> : <select name="minutoInicio">
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
								<tr>
									<td>Hora fin</td>
									<td>
										<!--<input type="text" name="horaFin" />--> <select
										name="horaFin">
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
									</select> : <select name="minutoFin">
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
							</table>
						</form>
						<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
                           echo "enviarFormulario('" . site_url()
                           . "/locales/anadirHorarioPedido','formAltaHorarioPedido','listaHorarioPedido',1)"
                           ?>">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="listaHorariosLocal" class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaHorarioPedidos"
								class="accordion-toggle collapsed"> Lista horarios pedido </a>
						</h4>
					</div>
					<div id="listaHorarioPedidos" class="panel-body collapse">
						<?php
						$contador = 0;
						foreach ($horarioPedido as $linea):
						$contador++;
						if ($contador%2 <> 0):?>
						<div class="col-md-12">
							<?php 
							endif;
							?>
							<div class="well col-md-6">
								<div class="span6">
									<table
										class="table table-condensed table-responsive table-user-information">
										<tbody>
											<tr>
												<td>Dia</td>
												<td><?php echo $linea->dia;?>
												</td>
											</tr>
											<tr>
												<td>Hora inicio</td>
												<td><?php echo $linea->hora_inicio;?>
												</td>
											</tr>
											<tr>
												<td>Hora fin</td>
												<td><?php echo $linea->hora_fin;?>
												</td>
											</tr>
										</tbody>
									</table>
									<span class="pull-right">
										<button class="btn btn-danger" type="button"
											data-toggle="tooltip" data-original-title="Remove this user"
											onclick="<?php
                echo "doAjax('" . site_url() . "/locales/borrarHorarioPedido','idHorarioPedido="
                . $linea->id_horario_pedido . "','listaHorarioPedido','post',1)";
                ?>">
											<span class="glyphicon glyphicon-remove"></span>
										</button>
									</span>
								</div>
							</div>
							<?php 
						if ($contador%2 == 0):?>
						</div>
						<?php 
						endif;
							endforeach; ?>
					</div>
				</div>
			</div>
		</div>