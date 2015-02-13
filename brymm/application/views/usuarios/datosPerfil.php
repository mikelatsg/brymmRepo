<!-- Formulario modal para valora a los usuarios -->
<div id="dialogAnadirValoracionUsuario" title="Añadir valoracion"
	style="display: none">
	<form id="formAnadirValoracionUsuario">
		<table>
			<tr>
				<input type="hidden" name="idUsuario"
					value="<?php echo $usuario->idUsuario;?>" />
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
<?php if(isset($_SESSION['idLocal'])):?>
<div class="col-md-6 noPadLeft">
	<div id="pedidosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-user"></i> Usuario
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="well">
				<table
					class="table table-condensed table-responsive table-user-information">
					<tbody>
						<tr>
							<td class="titulo">Nombre</td>
							<td><?php echo $usuario->nombre?>
							</td>
							<td class="titulo">Apellido</td>
							<td><?php echo $usuario->apellido?>
							</td>
						</tr>
						<tr>
							<td class="titulo">Email</td>
							<td><?php echo $usuario->email?>
							</td>
							<td class="titulo">Telefono</td>
							<td><?php echo $usuario->telefono?>
							</td>
						</tr>
						<tr>
							<td class="titulo">Localidad</td>
							<td><?php echo $usuario->localidad?>
							</td>
							<td class="titulo">Provincia</td>
							<td><?php echo $usuario->provincia?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="col-md-6 noPadRight altoMaximo">
	<div id="pedidosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-pencil"></i> Valoraciones usuario
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<a class="enlaceAnadirValoracionUsuario" data-toggle="modal"><i
				class="fa fa-plus"></i> Valorar Usuario </a> <span
				id="valoracionesUsuario"> <?php
				if (count($valoraciones) > 0):
				foreach ($valoraciones as $valoracion):
				?>
				<div class="col-md-12 well">
					<div class="col-md-5">
						<table
							class="table table-condensed table-responsive table-user-information">
							<tbody>
								<tr>
									<td class="titulo">Local</td>
									<td><?php echo  $valoracion->local->nombre;?></td>
								</tr>
								<tr>
									<td class="titulo">Fecha</td>
									<td><?php echo  $valoracion->fecha;?></td>
								</tr>
								<tr>
									<td class="titulo">Nota</td>
									<td><div class="progress">
											<div class="progress-bar <?php 
											if ($valoracion->nota <= 3){
												echo "progress-bar-danger";
											}else if(($valoracion->nota > 3 && $valoracion->nota <= 5)){
												echo "progress-bar-warning";
											}else if(($valoracion->nota > 5 && $valoracion->nota <= 7)){
												echo "progress-bar-primary";
											}else if(($valoracion->nota > 7)){
												echo "progress-bar-success";
											}
											?>" role="progressbar"
											aria-valuenow="<?php echo $valoracion->nota;?>" aria-valuemin="0" aria-valuemax="10"
											style="width: <?php echo ($valoracion->nota * 100/10); ?>%">
												<?php echo trim($valoracion->nota);?>
											</div>
										</div></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-7">
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
				</div> <?php
				endforeach;
				?>
				<div class="col-md-12">
					<a
						onclick="<?php
                    echo "doAjax('" . site_url() . "/valoraciones/mostrarTodasValoracionesUsuario','idUsuario="
					.$usuario->idUsuario."','listaValoracionesUsuario','post',0)";
                    ?>"><i class="fa fa-plus"></i> Mostrar todas</a>
				</div> <?php 
				else:
				?>
				<div class="col-md-12">No se ha realizado ninguna valoracion</div> <?php 			
				endif;
				?>
			</span>
		</div>
	</div>
</div>
<?php else:?>
<div class="col-md-6 noPadRight altoMaximo">
	<div id="pedidosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-pencil"></i> Acceso restringido
			</h4>
		</div>
		<div class="panel-body panel-verde">Informacion solo disponible para
			locales.</div>
	</div>
</div>
<?php endif;?>