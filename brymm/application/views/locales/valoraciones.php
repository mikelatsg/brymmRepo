<!-- Formulario modal añadir valoracion-->
<div id="dialogAnadirValoracionLocal" title="Añadir valoracion"
	style="display: none">
	<form id="formAnadirValoracionLocal">
		<table>
			<tr>
				<input type="hidden" name="idLocal" value="<?php echo $idLocal;?>" />
				<td>Nota :</td>
				<td><select value="5" name="nota">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
				</select>
				</td>
			</tr>
			<tr>
				<td><label for="observaciones">Observaciones</label></td>
				<td><textarea name="observaciones"
						class="text ui-widget-content ui-corner-all"></textarea>
				</td>
			</tr>
		</table>
	</form>
</div>
<div class="col-md-12 noPadLeft noPadRight">
	<div id="valoracionesLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-target="#listaValoraciones"
					class="accordion-toggle collapsed"> Valoraciones </a>
			</h4>
		</div>
		<div id="listaValoraciones" class="panel-body collapse sub-panel altoMaximo">
			<a class="enlaceAnadirValoracionLocal" data-toggle="modal"><i class="fa fa-plus"></i> Valorar
				local </a>
			<?php
			if (count($valoraciones) > 0):
			foreach ($valoraciones as $valoracion):
			?>
			<div class="col-md-12 well">
				<div class="col-md-4">
					<table
						class="table table-condensed table-responsive table-user-information">
						<tbody>
							<tr>
								<td class="titulo">Usuario</td>
								<td><?php echo  $valoracion->nick;?></td>
							</tr>
							<tr>
								<td class="titulo">Fecha</td>
								<td><?php echo  $valoracion->fecha;?></td>
							</tr>
							<tr>
								<td class="titulo">Nota</td>
								<td><div class="progress">
										<div class="progress-bar progress-bar-warning" role="progressbar"
											aria-valuenow="<?php echo $valoracion->nota;?>" aria-valuemin="0" aria-valuemax="5"
											style="width: <?php echo $valoracion->nota * 100/10; ?>%;">
											<span class="sr-only">60% Complete</span>
											<?php echo $valoracion->nota."/10";?>
										</div>
									</div></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-8">
					<table
						class="table table-condensed table-responsive table-user-information">
						<tbody>
							<tr>
								<td class="titulo col-md-3">Observaciones</td>
								<td class="text-left col-md-9"><?php echo  $valoracion->observaciones;?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<?php
			endforeach;
			else:
			?>
			<div class="col-md-12">No se ha realizado ninguna valoracion</div>
			<?php 			
			endif;
			?>
		</div>
	</div>
</div>
</div>
