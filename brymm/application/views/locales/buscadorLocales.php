<div>
	<div id="FormularioBuscadoLocal" class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-target="#collapseFormBuscador"
					class="accordion-toggle collapsed"> Buscador </a>
			</h4>
		</div>
		<div id="collapseFormBuscador" class="panel-collapse collapse">
			<form id="formBuscadorLocal" method="post"
				action="<?= site_url() ?>/locales/buscarLocal" class="form-inline">
				<!-- Tipo comida <select name="idTipoComida">
					<option value="0">Todas</option>
					<?php foreach ($tiposComida as $linea): ?>
					<option value="<?php echo $linea->id_tipo_comida; ?>">
						<? echo $linea->tipo_comida; ?>
					</option>
					<?php endforeach; ?>
				</select> -->
				<div class="col-md-12">
					<div>
						<label for="idTipoComida">Tipo comida</label> <select
							name="idTipoComida" id="idTipoComida">
							<?php foreach ($tiposComida as $linea): ?>
							<option class="form-control"
								value="<?php echo $linea->id_tipo_comida; ?>">
								<?php echo $linea->tipo_comida; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="local">Local</label> <input type="text"
							class="form-control" name="local" id="local" placeholder="Local">
					</div>
					<div class="form-group">
						<label for="poblacion">Poblacion</label> <input type="text"
							class="form-control" name="poblacion" id="poblacion"
							placeholder="Poblacion">
					</div>
					<div class="form-group">
						<label for="calle">Calle</label> <input type="text"
							class="form-control" name="calle" id="calle" placeholder="Calle">
					</div>
					<div class="form-group">
						<label for="codigoPostal">Cod. postal</label> <input type="text"
							class="form-control" name="codigoPostal" id="codigoPostal"
							placeholder="Codigo postal">
					</div>
				</div>
				<!-- <input type="text" name="local" placeholder="Local" />  
				<input type="text" name="poblacion" placeholder="Poblacion" /> <input
					type="text" name="calle" placeholder="Calle" /> <input type="text"
					name="codigoPostal" placeholder="Codigo postal" /> <br>-->
				<br>
				<?php foreach ($servicios as $linea):
				if ($linea->mostrar_buscador):
				?>
				<label class="checkbox-inline"> <input type="checkbox"
					id="inlineCheckbox1" name="servicios[]"
					value="<?php echo $linea->id_tipo_servicio_local; ?>"> <?php echo $linea->servicio; ?>
				</label>
				<!--  <input type="checkbox" name="servicios[]"
					value="<?php echo $linea->id_tipo_servicio_local; ?>" />
				<?php echo $linea->servicio; ?>
 				-->
				<?php endif;
				endforeach;
				?>
				<br> <input type="submit" value="Buscar local" />
				</td>

			</form>
		</div>
	</div>
</div>

