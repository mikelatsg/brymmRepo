<!-- Formulario modal rechazar reserva (rechazad por el local)-->
<div id="dialogRechazarReserva" title="Rechazar reserva"
	style="display: none">
	<form id="formRechazarReserva">
		<fieldset>
			<input type="hidden" name="idReserva"
				id="idReservaFormRechazarReserva" value="0" /> <label for="motivo">Motivo</label>
			<textarea name="motivo" class="text ui-widget-content ui-corner-all"></textarea>
		</fieldset>
	</form>
</div>

<!-- Formulario modal anular reserva (para posibles anulaciones bajo pedido de usuario)-->
<div id="dialogAnularReservaLocal" title="Anular reserva"
	style="display: none">
	<form id="formAnularReservaLocal">
		<fieldset>
			<input type="hidden" name="idReserva"
				id="idReservaFormAnularReservaLocal" value="0" /> <label
				for="motivo">Motivo</label>
			<textarea name="motivo" class="text ui-widget-content ui-corner-all"></textarea>
		</fieldset>
	</form>
</div>
<div id="reservasLocal" class="panel panel-default">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">Reservas</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-4">
			<div id="reservasPendientesPanel"
				class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse"
							data-target="#listaReservasPendientesLocal"
							class="accordion-toggle collapsed">Reservas pendientes </a>
					</h4>
				</div>
				<div id="listaReservasPendientesLocal"
					class="panel-body collapse sub-panel">
					<ul>
						<?php foreach ($reservasLocal as $reserva): ?>
						<li><?php
						echo $reserva->id_reserva . " - " . $reserva->fecha . " - " . $reserva->hora_inicio
						. " - " . $reserva->nombreUsuario . " - " . $reserva->nick
						?> <a
							onclick="<?php
                echo "doAjax('" . site_url() . "/reservas/mostrarReservaLocal','idReserva="
                . $reserva->id_reserva . "','datosReservaLocal','post',1)";
                ?>"> Ver </a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div id="reservasAceptadasPanel"
				class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse"
							data-target="#listaReservasAceptadasLocal"
							class="accordion-toggle collapsed">Ultimas reservas aceptadas </a>
					</h4>
				</div>
				<div id="listaReservasAceptadasLocal"
					class="panel-body collapse sub-panel">
					<ul>
						<?php foreach ($reservasAceptadasLocal as $reserva): ?>
						<li><?php
						echo $reserva->id_reserva . " - " . $reserva->fecha . " - " . $reserva->hora_inicio . " - ";
						//Si el idUsuario es 0 se muestra el emisor, no el nombre
						if ($reserva->id_usuario == 0) {
                    echo $reserva->nombre_emisor;
                } else {
                    echo $reserva->nombreUsuario . " - " . $reserva->nick;
                }
                //Se muestra el enlace para ver la reserva
                echo "<a onclick=\"";
                echo "doAjax('" . site_url() . "/reservas/mostrarReservaLocal','idReserva="
		. $reserva->id_reserva . "','datosReservaAceptadaLocal','post',1)\"";
                echo "> Ver </a>";
                ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div id="reservasRechazadasPanel"
				class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse"
							data-target="#listaReservasRechazadasLocal"
							class="accordion-toggle collapsed">Ultimas reservas rechazadas </a>
					</h4>
				</div>
				<div id="listaReservasRechazadasLocal"
					class="panel-body collapse sub-panel">
					<ul>
						<?php foreach ($reservasRechazadasLocal as $reserva): ?>
						<li><?php
						echo $reserva->id_reserva . " - " . $reserva->fecha . " - " . $reserva->hora_inicio . " - ";
						//Si el idUsuario es 0 se muestra el emisor, no el nombre
						if ($reserva->id_usuario == 0) {
                    echo $reserva->nombre_emisor;
                } else {
                    echo $reserva->nombreUsuario . " - " . $reserva->nick;
                }
                echo " - " . $reserva->estado;
                //Se muestra el enlace para ver la reserva
                echo "<a onclick=\"";
                echo "doAjax('" . site_url() . "/reservas/mostrarReservaLocal','idReserva="
		. $reserva->id_reserva . "','datosReservaRechazadaLocal','post',1)\"";
                echo "> Ver </a>";
                ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div id="detalleReservaPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">Detalle reserva</h4>
				</div>
				<div id="detalleReserva" class="panel-body sub-panel"></div>
			</div>
		</div>
	</div>
</div>
<div id="reservasLocal" class="panel panel-default">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">Calendario reservas</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-4">
			<div id="nuevaReservaPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#insertarReservas"
							class="accordion-toggle collapsed">Nueva reserva </a>
					</h4>
				</div>
				<div id="insertarReservas" class="panel-body collapse sub-panel">
					<form id="formAltaReservaLocal" class="form-horizontal">
						<div class="form-group">
							<label for="datepickerReservas" class="col-sm-4 control-label">Fecha
							</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="datepickerReservas"
									placeholder="Fecha" name="fecha"
									onchange="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/obtenerMesasLibres','formAltaReservaLocal','listaMesasLibres',1)"
                           ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="hora" class="col-sm-4 control-label">Hora</label>
							<div class="col-sm-8">
								<select name="hora" id="hora">
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
								</select>: <select name="minuto">
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
							<label for="hora" class="col-sm-4 control-label">Tipo comida</label>
							<div class="col-sm-8">
								<select name="idTipoMenu"
									onchange="<?php
                            echo "enviarFormulario('" . site_url() .
                            "/reservas/obtenerMesasLibres','formAltaReservaLocal','listaMesasLibres',1)"
                            ?>">
									<?php
									foreach ($tiposMenu as $linea):
									if ($linea->id_tipo_menu != 4 && $linea->id_tipo_menu != 1)://carta y desayunos
									?>
									<option class="form-control"
										value="<?php echo $linea->id_tipo_menu; ?>">
										<? echo $linea->descripcion; ?>
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
								de personas </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="numeroPersonas"
									placeholder="Numero de personas" name="numeroPersonas">
							</div>
						</div>
						<div class="form-group">
							<label for="nombreEmisor" class="col-sm-4 control-label">A nombre
								de </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="nombreEmisor"
									placeholder="A nombre de " name="nombreEmisor">
							</div>
						</div>
						<div class="form-group">
							<label for="observaciones" class="col-sm-4 control-label">Observaciones
							</label>
							<div class="col-sm-8">
								<textarea type="text" class="form-control" id="observaciones"
									placeholder="Observaciones" name="observaciones">
									</textarea>
							</div>
						</div>
						<div class="form-group">
						<label for="listaMesasLibres" class="col-sm-4 control-label">Mesas libres
							</label>
							<div id="listaMesasLibres"></div>
						</div>

						<!--  <table>
							<tr>
								<td>fecha:</td>
								<td><input type="text" name="fecha" id="datepickerReservas"
									onchange="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/obtenerMesasLibres','formAltaReservaLocal','listaMesasLibres',1)"
                           ?>" />
								</td>
								<td>hora:</td>
								<td><select name="hora">
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
								<td>Tipo comida</td>
								<td width="46"><select name="idTipoMenu"
									onchange="<?php
                            echo "enviarFormulario('" . site_url() .
                            "/reservas/obtenerMesasLibres','formAltaReservaLocal','listaMesasLibres',1)"
                            ?>">
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
								</select>
								</td>
								<td>Numero de personas:</td>
								<td><input type="text" name="numeroPersonas" value="0" />
								</td>
							</tr>
							<tr>
								<td>A nombre de:</td>
								<td><input type="text" name="nombreEmisor" />
								</td>
							</tr>
							<tr>
								<td>Mesas:</td>
								<td id="listaMesasLibres"></td>
							</tr>
							<tr>
								<td>Observaciones:</td>
								<td><textarea name="observaciones"></textarea>
								</td>
							</tr>
							<tr>
								<td width="51" colspan="2" align="center"><input type="button"
									onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/anadirReservaLocal','formAltaReservaLocal','listaReservasGestionadasLocal',1)"
                           ?>"
									value="Realizar reserva" />
								</td>
							</tr>
						</table>-->
					</form>
					<span class="pull-right">
						<button class="btn btn-success" type="button"
							data-toggle="tooltip" data-original-title="Edit this user"
							onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/anadirReservaLocal','formAltaReservaLocal','listaReservasGestionadasLocal',1)"
					                           ?>">
							<span class="glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
			<div id="reservasDiaPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">Reservas del dia</h4>
				</div>
				<div id="reservasDiaLocal" class="panel-body sub-panel"></div>
			</div>
		</div>
		<div class="col-md-8">
			<div id="reservasDiaPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">Calendario reservas</h4>
				</div>
				<div id="calendarioReservasLocal" class="panel-body sub-panel">
					<?php
					echo $calendarioReservas;
					?>
				</div>
				<div id="actualizarCalendarioReservas" class="panel-body sub-panel">
					<?php
					echo "<a onclick=";
					echo "doAjax('" . site_url() . "/reservas/actualizarCalendarioReservas',''" .
							",'actualizarCalendarioReservas','post',1)";
					echo "> Actualizar calendario </a>";
					?>
				</div>
			</div>
		</div>
	</div>
</div>
