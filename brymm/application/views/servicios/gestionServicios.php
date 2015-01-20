<!-- Formulario modal modificar servicios -->
<div id="dialogModificarServicios" style="display: none">
	<form id="formModificarServicioLocal" class="form-horizontal">
		<input type="hidden" name="idServicioLocal" value="0">
		<div class="form-group">
			<label for="idTipoServicioLocal" class="col-sm-4 control-label">Servicio</label>
			<div class="col-sm-8">
				<select name="idTipoServicioLocal" id="idTipoServicioLocal" disabled>
					<?php foreach ($servicios as $linea): ?>
					<option class="form-control"
						value="<?php echo $linea->id_tipo_servicio_local; ?>">
						<?php echo $linea->servicio; ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="importeMinimo" class="col-sm-4 control-label">Importe
				minimo</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="importeMinimo"
					placeholder="Importe minimo" name="importeMinimo">
			</div>
		</div>
		<div class="form-group">
			<label for="precio" class="col-sm-4 control-label">Precio</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="precio"
					placeholder="Precio" name="precio">
			</div>
		</div>
	</form>

</div>
<div>
	<div id="serviciosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">Servicios</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="altaServiciosPanel" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaServicios"
								class="accordion-toggle collapsed"> Nuevo servicio </a>
						</h4>
					</div>
					<div id="altaServicios" class="panel-body collapse sub-panel">
						<form id="formAltaServicioLocal" class="form-horizontal">
							<div class="form-group">
								<label for="idTipoServicioLocal" class="col-sm-4 control-label">Servicio</label>
								<div class="col-sm-8">
									<select name="idTipoServicioLocal" id="idTipoServicioLocal">
										<?php foreach ($servicios as $linea): ?>
										<option class="form-control"
											value="<?php echo $linea->id_tipo_servicio_local; ?>">
											<?php echo $linea->servicio; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="importeMinimo" class="col-sm-4 control-label">Importe
									minimo</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="importeMinimo"
										placeholder="Importe minimo" name="importeMinimo">
								</div>
							</div>
							<div class="form-group">
								<label for="precio" class="col-sm-4 control-label">Precio</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="precio"
										placeholder="Precio" name="precio">
								</div>
							</div>
						</form>
						<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/servicios/anadirServicioLocal','formAltaServicioLocal','listaServiciosLocal',1)"
					                           ?>">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>

					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="listaServicioLocalPanel"
					class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaServicioLocal"
								class="accordion-toggle collapsed"> Lista servicios </a>
						</h4>
					</div>
					<div id="listaServicioLocal" class="panel-body collapse sub-panel">
						<?php
						$contador = 0;
						foreach ($serviciosLocal as $linea):
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
												<td>Servicio</td>
												<td><?php echo $linea->servicio;?>
												</td>
											</tr>
											<tr>
												<td>Importe minimo</td>
												<td><?php echo $linea->importe_minimo;?>
												</td>
											</tr>
											<tr>
												<td>Precio</td>
												<td><?php echo $linea->precio;?>
												</td>
											</tr>
										</tbody>
									</table>
									<span class="pull-right">
										<button class="btn btn-warning" type="button"
											data-toggle="tooltip" data-original-title="Edit this user"
											onclick="mostrarVentanaModificarServicio(
								'<?php echo trim($linea->id_tipo_servicio_local); ?>',
                   '<?php echo trim($linea->importe_minimo); ?>',
                   '<?php echo trim($linea->precio); ?>',
                   '<?php echo trim($linea->id_servicio_local); ?>')">
											<span class="glyphicon glyphicon-edit"></span>
										</button> <?php if ($linea->activo): ?>
										<button class="btn btn-danger" type="button"
											data-toggle="tooltip" data-original-title="Remove this user"
											onclick="<?php
                    echo "doAjax('" . site_url() . "/servicios/desactivarServicio','idServicioLocal="
                    . $linea->id_servicio_local . "','listaServiciosLocal','post',1)";
                ?>">
											<span class="glyphicon glyphicon-off"></span>
										</button> <?php else: ?>
										<button class="btn btn-success" type="button"
											data-toggle="tooltip" data-original-title="Remove this user"
											onclick="<?php
                    echo "doAjax('" . site_url() . "/servicios/activarServicio','idServicioLocal="
                    . $linea->id_servicio_local . "','listaServiciosLocal','post',1)";
                ?>">
											<span class="glyphicon glyphicon-off"></span>
										</button> <?php endif;?>
										<button class="btn btn-danger" type="button"
											data-toggle="tooltip" data-original-title="Remove this user"
											onclick="<?php
                echo "doAjax('" . site_url() . "/servicios/borrarServicio','idServicioLocal="
                . $linea->id_servicio_local . "','listaServiciosLocal','post',1)";
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
	</div>
</div>
