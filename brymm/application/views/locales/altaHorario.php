<div>
	<div id="horariosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-clock-o"></i> Horarios local
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="altaHorariosLocal" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaHorarioLocal"
								class="accordion-toggle collapsed"><i class="fa fa-plus"></i>
								Nuevo horario local </a>
						</h4>
					</div>
					<div id="altaHorarioLocal" class="panel-body collapse sub-panel">
						<form id="formAltaHorarioLocal" class="form-horizontal">
							<div class="form-group">
								<label for="idDia" class="col-sm-4 control-label">Dia</label>
								<div class="col-sm-8">
									<select name="idDia" id="idDia">
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
									apertura</label>
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
								<label for="horaFin" class="col-sm-4 control-label">Hora cierre</label>
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
								onclick="<?php echo "enviarFormulario('" . site_url() . "/locales/anadirHorarioLocal','formAltaHorarioLocal','listaHorarioLocal',1)" ?>"
								title="Añadir horario">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="listahorariosLocal" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaHorarioLocal"
								class="accordion-toggle collapsed"><i class="fa fa-list"></i>
								Lista horarios local </a>
						</h4>
					</div>
					<div id="listaHorarioLocal"
						class="panel-body collapse sub-panel altoMaximo">
						<?php
						$contador = 0;
						foreach ($horarioLocal as $linea):
						$contador++;
						if ($contador%2 <> 0):?>
						<div class="col-md-12">
							<?php 
							endif;
							?>
							<div class="well col-md-6">
								<div class="span6">
									<strong><?php echo $linea->dia;?>
									</strong><br>
									<table
										class="table table-condensed table-responsive table-user-information">
										<tbody>
											<!-- <tr>
												<td>Dia</td>
												<td><?php echo $linea->dia;?></td>
											</tr> -->
											<tr>
												<td>Hora inicio</td>
												<td><?php echo $linea->hora_inicio;?></td>
											</tr>
											<tr>
												<td>Hora fin</td>
												<td><?php echo $linea->hora_fin;?></td>
											</tr>
										</tbody>
									</table>
									<span class="pull-right">
										<button class="btn btn-danger btn-sm" type="button"
											data-toggle="tooltip" data-original-title="Remove this user"
											onclick="<?php
                echo "doAjax('" . site_url() . "/locales/borrarHorarioLocal','idHorarioLocal="
                . $linea->id_horario_local . "','listaHorarioLocal','post',1)";
                ?>"
											title="Eliminar horario">
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
	</div>
</div>
<div>
	<div id="diasCierreLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-calendar-o"></i> Dias cierre local
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="altaDiasCierre" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaDiasCierreLocal"
								class="accordion-toggle collapsed"><i class="fa fa-plus"></i>
								Nuevo dia cierre </a>
						</h4>
					</div>
					<div id="altaDiasCierreLocal" class="panel-body collapse sub-panel">
						<form id="formDiasCierreLocal" class="form-horizontal">
							<div class="form-group">
								<label for="datepickerDiasCierre" class="col-sm-4 control-label">Dia</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"
										id="datepickerDiasCierre" placeholder="Selecciona dia"
										name="fecha">
								</div>
							</div>
						</form>
						<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
                           echo "enviarFormulario('" . site_url()
                           . "/locales/anadirDiaCierreLocal','formDiasCierreLocal','listaDiasCierreLocal',1)"
                           ?>"
								title="Añadir dia cierre">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="listaDiasCierre" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaDiasCierreLocal"
								class="accordion-toggle collapsed"><i class="fa fa-list"></i>
								Lista dia cierre </a>
						</h4>
					</div>
					<div id="listaDiasCierreLocal"
						class="panel-body collapse sub-panel altoMaximo">
						<?php
						$contador = 0;
						foreach ($diasCierreLocal as $linea):
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
												<td><?php echo $linea->fecha;?>
												</td>
												<td><span class="pull-right">
														<button class="btn btn-danger btn-sm" type="button"
															data-toggle="tooltip"
															data-original-title="Remove this user"
															onclick="<?php
                echo "doAjax('" . site_url() . "/locales/borrarDiaCierreLocal','idDiaCierreLocal="
                . $linea->id_dia_cierre_local . "','listaDiasCierreLocal','post',1)";
                ?>"
															title="Eliminar dia cierre">
															<span class="glyphicon glyphicon-remove"></span>
														</button>
												</span></td>
											</tr>
										</tbody>
									</table>
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
	</div>
</div>
