
<div id="FormularioReserva">
	<div class="col-md-4 noPadLeft">
		<div id="horariosLocal" class="panel panel-default">
			<div class="panel-heading panel-verde">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-target="#HorarioLocal"
						class="accordion-toggle collapsed"> Horario local </a>
				</h4>
			</div>
			<div id="HorarioLocal" class="panel-body collapse sub-panel altoMaximo">
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td class="titulo">Dia</td>
							<td class="titulo">Apertura</td>
							<td class="titulo">Cierre</td>
						</tr>
						<?php foreach ($horarioLocal as $horario): ?>
						<tr>
							<td class="titulo"><?php
							echo $horario->dia?>
							</td>
							<td><?php
							echo $horario->hora_inicio?></td>
							<td><?php
							echo $horario->hora_fin?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div id="reservaLocal" class="panel panel-default">
			<div class="panel-heading panel-verde">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-target="#realizarReservaLocal"
						class="accordion-toggle collapsed"> Realizar reserva </a>
				</h4>
			</div>
			<div id="realizarReservaLocal" class="panel-body collapse sub-panel">
				<form id="formAltaReservaUsuario" class="form-horizontal">
					<input type="hidden" name="idLocal" value="<?php echo $idLocal; ?>" />
					<div class="form-group">
						<label for="datepickerReservas" class="col-sm-4 control-label">Fecha</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="datepickerReservas"
								placeholder="Fecha" name="fecha">
						</div>
					</div>
					<div class="form-group">
						<label for="hora" class="col-sm-4 control-label">Tipo articulo</label>
						<div class="col-sm-8">
							<span class="pull-left"> <select name="hora" id="hora">
									<option class="form-control" value="hora">Hora</option>
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
							</select>:<select name="minuto">
									<option class="form-control" value="minuto">Minuto</option>
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
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="idTipoMenu" class="col-sm-4 control-label">Tipo menu</label>
						<div class="col-sm-8">
							<select class="pull-left" name="idTipoMenu" id="idTipoMenu">
								<?php
								foreach ($tiposMenu as $linea):
								if ($linea->id_tipo_menu != 4 && $linea->id_tipo_menu != 1)://carta y desayunos
								?>
								<option class="form-control"
									value="<?php echo $linea->id_tipo_menu;?>">
									<?php echo $linea->descripcion; ?>
								</option>
								<?php
								endif;
								endforeach;
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="numeroPersonas" class="col-sm-4 control-label">Numero
							de personas</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="numeroPersonas"
								placeholder="Numero de personas" name="numeroPersonas">
						</div>
					</div>
					<div class="form-group">
						<label for="observaciones" class="col-sm-4 control-label">Observaciones</label>
						<div class="col-sm-8">
							<textarea class="form-control" id="observaciones"
								placeholder="Observaciones" name="observaciones"></textarea>
						</div>
					</div>
				</form>
				<?php if(isset($_SESSION['idUsuario'])):?>
				<span class="pull-right">
					<button class="btn btn-success" type="button" data-toggle="tooltip"
						data-original-title="Edit this user"
						onclick="<?php
	                           echo "enviarFormulario('" . site_url() .
	                           "/reservas/anadirReservaUsuario','formAltaReservaUsuario','listaReservasUsuario',1)"
	                           ?>">
						<span class="glyphicon glyphicon-plus"></span>
					</button>
				</span>
				<?php 
				else:
				echo "Logeate para hacer reservas";
						endif;?>
			</div>
		</div>
	</div>
	<div class="col-md-4 noPadRight">
		<div id="reservaLocal" class="panel panel-default">
			<div class="panel-heading panel-verde">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-target="#listaReservasUsuario"
						class="accordion-toggle collapsed"> Reservas usuario </a>
				</h4>
			</div>
			<div id="listaReservasUsuario" class="panel-body collapse sub-panel altoMaximo" >
				<?php					
				if (isset($_SESSION['idUsuario'])):
					foreach ($reservasUsuario as $reserva): ?>
				<div class="col-md-12 list-div">
					<table class="table">
						<tbody>
							<tr>
								<td colspan="3" class="text-left titulo">Reserva <?php echo $reserva->id_reserva;
								if ($reserva->estado == 'P' || $reserva->estado == 'AL'):
								?>
									<button class="btn btn-danger pull-right btn-sm" type="button"
										data-toggle="tooltip" data-original-title="Remove this user"
										onclick="<?php
                    echo "doAjax('" . site_url() . "/reservas/anularReservaUsuario','idReserva="
                    . $reserva->id_reserva . "','listaReservasUsuario','post',1)";
                    ?>"
										title="Anular reserva">
										<span class="glyphicon glyphicon-remove"></span>
									</button> <?php endif;?>
								</td>
							</tr>
							<tr>
								<td><?php echo $reserva->fecha;?> <i class="fa fa-calendar"></i>
								</td>
								<td><?php echo $reserva->estado;?> <i class="fa fa-tag"></i></td>
								<td><a
									href="<?php echo site_url();?>/locales/mostrarLocal/<?php echo $reserva->id_local;?>">
										<?php echo $reserva->nombreLocal;?> <i class="fa fa-home"> </i>
								</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php endforeach;?>
				<div class="col-md-12 text-center">
					<a
						onclick="<?php
						                    echo "doAjax('" . site_url() . "/reservas/mostrarTodasReservasUsuario','','listaReservasUsuario','post',1)";
						                    ?>"><i class="fa fa-plus"></i> Mostrar todas</a>
				</div>
				<?php  					
				else :
				echo "Usuario sin logear";
					endif;?>
			</div>
		</div>
	</div>
</div>
