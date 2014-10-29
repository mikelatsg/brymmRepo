
<div id="FormularioReserva">
	<div class="col-md-4">
		<div id="horariosLocal" class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-target="#HorarioLocal"
						class="accordion-toggle collapsed"> Horario local </a>
				</h4>
			</div>
			<div id="HorarioLocal" class="panel-body collapse">
				<div class="list-group">
					<?php foreach ($horarioLocal as $horario): ?>
					<span class="list-group-item"><?php
					echo $horario->dia . " - " . $horario->hora_inicio
					. " - " . $horario->hora_fin
					?> </span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div id="reservaLocal" class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-target="#realizarReservaLocal"
						class="accordion-toggle collapsed"> Realizar reserva </a>
				</h4>
			</div>
			<div id="realizarReservaLocal" class="panel-body collapse">
				<form id="formAltaReservaUsuario">
					<input type="hidden" name="idLocal" value="<?php echo $idLocal; ?>" />
					<input type="text" name="fecha" id="datepickerReservas"
						placeholder="fecha" /><select name="hora">
						<option value="hora">Hora</option>
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
					</select>:<select name="minuto">
						<option value="minuto">Minuto</option>
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
					</select> Tipo comida <select name="idTipoMenu">
						<?php
						foreach ($tiposMenu as $linea):
						if ($linea->id_tipo_menu != 4 && $linea->id_tipo_menu != 1)://carta y desayunos
						?>
						<option value="<?php echo $linea->id_tipo_menu; ?>">
							<? echo $linea->descripcion; ?>
						</option>
						<?php
						endif;
						endforeach;
						?>
					</select> <input type="text" name="numeroPersonas"
						placeholder="Numero de personas" />
					<textarea name="observaciones" placeholder="Observaciones"></textarea>
					<input type="button"
						onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/anadirReservaUsuario','formAltaReservaUsuario','listaReservasUsuario',1)"
                           ?>"
						value="Realizar reserva" />
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div id="reservaLocal" class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-target="#listaReservasUsuario"
						class="accordion-toggle collapsed"> Reservas usuario </a>
				</h4>
			</div>
			<div id="listaReservasUsuario" class="panel-body collapse">
				<div class="list-group">
					<?php foreach ($reservasUsuario as $reserva): ?>
					<span class="list-group-item"><?php
					echo $reserva->fecha . "-" . $reserva->hora_inicio . "-"
				. $reserva->nombreLocal . " - "
				. $reserva->numero_personas . " - " . $reserva->estado;
					if ($reserva->estado == 'P' || $reserva->estado == 'AL'):
					?> <a
						onclick="<?php
                    echo "doAjax('" . site_url() . "/reservas/anularReservaUsuario','idReserva="
                    . $reserva->id_reserva . "','listaReservasUsuario','post',1)";
                    ?>"> Anular </a> <?php endif; ?> </span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
