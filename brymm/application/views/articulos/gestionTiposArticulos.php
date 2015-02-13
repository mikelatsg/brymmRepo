<div id="dialogModificarTipoArticulo" style="display: none">
	<form id="formModificarTipoArticulo">
		<input type="hidden" name="idTipoArticuloLocal">
		<div class="form-group">
			<label for="listaTiposArticulos" class="col-sm-4 control-label">Tipo
				articulo</label>
			<div class="col-sm-8">
				<select name="tipoArticulo" id="listaTiposArticulos">
					<?php foreach ($tiposArticulo as $linea): ?>
					<option class="form-control"
						value="<?php echo $linea->id_tipo_articulo; ?>">
						<?php echo $linea->tipo_articulo; ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="personalizarTipoArticulo" class="col-sm-4 control-label">Personalizar</label>
			<div class="col-sm-8">
				<select name="personalizar" id="personalizarTipoArticulo">
					<option class="form-control" value="1">Si</option>
					<option class="form-control" value="0">No</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="precioBaseTipoArticulo" class="col-sm-4 control-label">Precio
				base</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="precioBaseTipoArticulo"
					placeholder="Precio base" name="precioBase">
			</div>
		</div>		
	</form>
</div>
<div>
	<div id="tiposArticulo" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title"><i class="fa fa-tags"></i> Tipos articulo</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="nuevoTipoArticulo" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaTipoArticulo"
								class="accordion-toggle collapsed"><i class="fa fa-plus"></i> Nuevo tipo articulo </a>
						</h4>
					</div>
					<div id="altaTipoArticulo" class="panel-body collapse sub-panel">
						<form id="formAltaTipoArticulo" class="form-horizontal">
							<div class="form-group">
								<label for="listaTiposArticulos" class="col-sm-4 control-label">Tipo
									articulo</label>
								<div class="col-sm-8">
									<select name="tipoArticulo" id="listaTiposArticulos">
										<?php foreach ($tiposArticulo as $linea): ?>
										<option class="form-control"
											value="<?php echo $linea->id_tipo_articulo; ?>">
											<?php echo $linea->tipo_articulo; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="personalizarTipoArticulo"
									class="col-sm-4 control-label">Personalizar</label>
								<div class="col-sm-8">
									<select name="personalizar" id="personalizarTipoArticulo">
										<option class="form-control" value="1">Si</option>
										<option class="form-control" value="0">No</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="precioBaseTipoArticulo"
									class="col-sm-4 control-label">Precio base</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"
										id="precioBaseTipoArticulo" placeholder="Precio base"
										name="precioBase">
								</div>
							</div>							
						</form>
						<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/articulos/anadirTipoArticulo','formAltaTipoArticulo','listaTiposArticulo',1)"
                           ?>">
								<span class="glyphicon glyphicon-plus">
							
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="nuevoTipoArticulo" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaTipoArticulos"
								class="accordion-toggle collapsed"><i class="fa fa-list"></i> Lista tipos articulo </a>
						</h4>
					</div>
					<div id="listaTipoArticulos" class="panel-body collapse sub-panel">
						<?php 
						$contador = 0;
						foreach ($tiposArticuloLocal as $linea):
						$contador++;
						if ($contador%2 <> 0):?>
						<div class="col-md-12">
							<?php 
							endif;
							?>
							<div class="well col-md-6">
								<div class="span6">
									<strong><?php echo $linea->tipo_articulo;?> </strong><br>
									<table
										class="table table-condensed table-responsive table-user-information">
										<tbody>
											<tr>
												<td>Personalizable</td>
												<td><?php if ($linea->personalizar){
													echo "Si";
												}else{
													echo "No";		
												}?></td>
											</tr>
											<tr>
												<td>Precio</td>
												<td><?php echo $linea->precio;?> <i class="fa fa-euro"></i></td>
											</tr>
										</tbody>
									</table>
								</div>
								<span class="pull-right">
									<button class="btn btn-warning btn-sm" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="mostrarVentanaModificarTipoArticulo(
										'<?php echo trim($linea->id_tipo_articulo_local); ?>',
					                   '<?php echo trim($linea->id_tipo_articulo); ?>',
					                   '<?php echo trim($linea->personalizar); ?>',
					                   '<?php echo trim($linea->precio); ?>')">
										<span class="glyphicon glyphicon-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" type="button"
										data-toggle="tooltip" data-original-title="Remove this user"
										onclick="<?php
                						echo "doAjax('" . site_url() . "/articulos/borrarTipoArticuloLocal','idTipoArticuloLocal="
                						. $linea->id_tipo_articulo_local . "','listaTiposArticulo','post',1)";
                							?>">
										<span class="glyphicon glyphicon-remove"></span>
									</button>
								</span>
							</div>
							<?php 									
								if ($contador%2 == 0):?>
						</div>
						<?php
						endif;
						endforeach;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

