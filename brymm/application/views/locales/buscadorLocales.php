<div>
	<div id="FormularioBuscadoLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-target="#collapseFormBuscador"
					class="accordion-toggle collapsed"><i class="fa fa-search"></i> Buscador </a>
			</h4>
		</div>
		<div id="collapseFormBuscador"
			class="panel-body panel-verde panel-collapse collapse">
			<div class="buscador">
				<form id="formBuscadorLocal" method="post"
					action="<?= site_url() ?>/locales/buscarLocal"
					class="form-horizontal">
					<div class="form-group">
						<label for="idTipoComida" class="col-md-4 control-label">Tipo
							comida</label>
						<div class="col-sm-4">
							<select name="idTipoComida" id="idTipoComida" class="pull-left">
							<option class="form-control" value="0">Todas</option>
								<?php foreach ($tiposComida as $linea): ?>
								<option class="form-control"
									value="<?php echo $linea->id_tipo_comida; ?>">
									<?php echo $linea->tipo_comida; ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="local" class="col-md-4 control-label">Local</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="local" id="local"
								placeholder="Local">
						</div>
					</div>
					<div class="form-group">
						<label for="poblacion" class="col-md-4 control-label">Poblacion</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="poblacion"
								id="poblacion" placeholder="Poblacion">
						</div>
					</div>
					<div class="form-group">
						<label for="calle" class="col-md-4 control-label">Calle</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="calle" id="calle"
								placeholder="Calle">
						</div>
					</div>
					<div class="form-group">
						<label for="codigoPostal" class="col-md-4 control-label">Cod.
							postal</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="codigoPostal"
								id="codigoPostal" placeholder="Codigo postal">
						</div>
					</div>
					<div class="form-group">
						<?php foreach ($servicios as $linea):
						if ($linea->mostrar_buscador):
						?>
						<label class="checkbox-inline"> <input type="checkbox"
							id="inlineCheckbox1" name="servicios[]"
							value="<?php echo $linea->id_tipo_servicio_local; ?>"> <?php echo $linea->servicio; ?>
						</label>
						<?php endif;
						endforeach;
						?>
					</div>
					<div class="form-group">
						<button type="submit" value=" Send" class="btn btn-success"
							id="submit">
							<span class="glyphicon glyphicon-search"></span> Buscar locales
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

