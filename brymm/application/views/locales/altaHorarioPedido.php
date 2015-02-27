<div>
	<div id="horariosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title"><i class="fa fa-clock-o"></i> Horarios pedido</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="altaHorariosLocal" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaHorarioPedido"
								class="accordion-toggle collapsed"><i class="fa fa-plus"></i>  Nuevo horario pedido </a>
						</h4>
					</div>
					<div id="altaHorarioPedido" class="panel-body collapse sub-panel">
						<form id="formAltaHorarioPedido" class="form-horizontal">
						<div class="form-group">
								<label for="dia" class="col-sm-4 control-label">Dia</label>
								<div class="col-sm-8">
									<select name="dia" id="dia">
										<?php foreach ($dias as $dia): ?>
										<option class="form-control"
											value="<?php echo $dia->id_dia; ?>">
											<?php echo $dia->dia; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="horaInicio" class="col-sm-4 control-label">Hora
									inicio</label>
								<div class="col-sm-8">
									<select name="horaInicio" id="horaInicio">
										<option class="form-control" value="0">00</option>
										<option class="form-control" value="1">01</option>
										<option class="form-control" value="2">02</option>
										<option class="form-control" value="3">03</option>
										<option class="form-control" value="4">04</option>
										<option class="form-control" value="5">05</option>
										<option class="form-control" value="6">06</option>
										<option class="form-control" value="7">07</option>
										<option class="form-control" value="8">08</option>
										<option class="form-control" value="9">09</option>
										<option class="form-control" value="10">10</option>
										<option class="form-control" value="11">11</option>
										<option class="form-control" value="12">12</option>
										<option class="form-control" value="13">13</option>
										<option class="form-control" value="14">14</option>
										<option class="form-control" value="15">15</option>
										<option class="form-control" value="16">16</option>
										<option class="form-control" value="17">17</option>
										<option class="form-control" value="18">18</option>
										<option class="form-control" value="19">19</option>
										<option class="form-control" value="20">20</option>
										<option class="form-control" value="21">21</option>
										<option class="form-control" value="22">22</option>
										<option class="form-control" value="23">23</option>
									</select>: <select name="minutoInicio">
										<option class="form-control" value="00">00</option>
										<option class="form-control" value="05">05</option>
										<option class="form-control" value="10">10</option>
										<option class="form-control" value="15">15</option>
										<option class="form-control" value="20">20</option>
										<option class="form-control" value="25">25</option>
										<option class="form-control" value="30">30</option>
										<option class="form-control" value="35">35</option>
										<option class="form-control" value="40">40</option>
										<option class="form-control" value="45">45</option>
										<option class="form-control" value="50">50</option>
										<option class="form-control" value="55">55</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="horaFin" class="col-sm-4 control-label">Hora
									fin</label>
								<div class="col-sm-8">
									<select name="horaFin" id="horaFin">
										<option class="form-control" value="0">00</option>
										<option class="form-control" value="1">01</option>
										<option class="form-control" value="2">02</option>
										<option class="form-control" value="3">03</option>
										<option class="form-control" value="4">04</option>
										<option class="form-control" value="5">05</option>
										<option class="form-control" value="6">06</option>
										<option class="form-control" value="7">07</option>
										<option class="form-control" value="8">08</option>
										<option class="form-control" value="9">09</option>
										<option class="form-control" value="10">10</option>
										<option class="form-control" value="11">11</option>
										<option class="form-control" value="12">12</option>
										<option class="form-control" value="13">13</option>
										<option class="form-control" value="14">14</option>
										<option class="form-control" value="15">15</option>
										<option class="form-control" value="16">16</option>
										<option class="form-control" value="17">17</option>
										<option class="form-control" value="18">18</option>
										<option class="form-control" value="19">19</option>
										<option class="form-control" value="20">20</option>
										<option class="form-control" value="21">21</option>
										<option class="form-control" value="22">22</option>
										<option class="form-control" value="23">23</option>
									</select>: <select name="minutoFin">
										<option class="form-control" value="00">00</option>
										<option class="form-control" value="05">05</option>
										<option class="form-control" value="10">10</option>
										<option class="form-control" value="15">15</option>
										<option class="form-control" value="20">20</option>
										<option class="form-control" value="25">25</option>
										<option class="form-control" value="30">30</option>
										<option class="form-control" value="35">35</option>
										<option class="form-control" value="40">40</option>
										<option class="form-control" value="45">45</option>
										<option class="form-control" value="50">50</option>
										<option class="form-control" value="55">55</option>
									</select>
								</div>
							</div>							
						</form>
						<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
                           echo "enviarFormulario('" . site_url()
                           . "/locales/anadirHorarioPedido','formAltaHorarioPedido','listaHorarioPedido',1)"
                           ?>"
                           title="Añadir horario pedido">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="listaHorariosLocal" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaHorarioPedidos"
								class="accordion-toggle collapsed"><i class="fa fa-list"></i>  Lista horarios pedido </a>
						</h4>
					</div>
					<div id="listaHorarioPedidos" class="panel-body collapse sub-panel altoMaximo">
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
										<button class="btn btn-danger btn-sm" type="button"
											data-toggle="tooltip" data-original-title="Remove this user"
											onclick="<?php
                echo "doAjax('" . site_url() . "/locales/borrarHorarioPedido','idHorarioPedido="
                . $linea->id_horario_pedido . "','listaHorarioPedido','post',1)";
                ?>"
                title="Eliminar horario pedido">
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