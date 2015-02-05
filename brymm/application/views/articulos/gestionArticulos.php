<!-- Formulario modal modificar articulo -->
<div id="dialogModificarArticulo" style="display: none">
	<form id="formModificarArticulo">
		<input type="hidden" name="idArticuloLocal" value="0">
		<div class="form-group">
			<label for="listaTiposArticulosArticuloMod"
				class="col-sm-4 control-label">Tipo articulo</label>
			<div class="col-sm-8">
				<select name="tipoArticulo" id="listaTiposArticulosArticuloMod">
					<?php foreach ($tiposArticuloLocal as $linea): ?>
					<option class="form-control"
						value="<?php echo $linea->id_tipo_articulo; ?>">
						<?php echo $linea->tipo_articulo; ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="nombreArticuloMod" class="col-sm-4 control-label">Nombre</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="nombreArticuloMod"
					placeholder="Nombre articulo" name="articulo">
			</div>
		</div>
		<div class="form-group">
			<label for="descripcionArticuloMod" class="col-sm-4 control-label">Descripcion</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="descripcionArticuloMod"
					placeholder="Descripcion" name="descripcion">
			</div>
		</div>
		<div class="form-group">
			<label for="precioArticuloMod" class="col-sm-4 control-label">Precio</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="precioArticuloMod"
					placeholder="Precio" name="precio">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
				<div class="checkbox">
					<label class="pull-left"><input name="validoPedidos"
						type="checkbox"> Se puede enviar en pedidos</label>
				</div>
			</div>
		</div>		
		<?php $inicio = true; 
		foreach ($ingredientes as $linea):
		if ($inicio):
		?>
		<div class="form-group">
			<label class="col-sm-4 control-label">Ingredientes</label>
			<div class="col-sm-8">
				<div class="checkbox">
					<label class="pull-left"><input name="ingrediente[]"
						type="checkbox" value="<?php echo $linea->id_ingrediente; ?>"> <?php echo $linea->ingrediente; ?>
					</label>
				</div>
			</div>
		</div>
		<?php
		else:
		?>
		<div class="form-group listaIngredientesArticuloMod">
			<div class="col-sm-offset-4 col-sm-8">
				<div class="checkbox">
					<label class="pull-left"><input name="ingrediente[]"
						type="checkbox" value="<?php echo $linea->id_ingrediente; ?>"> <?php echo $linea->ingrediente; ?>
					</label>
				</div>
			</div>
		</div>
		<?php 
		endif;
		$inicio = false;
		?>

		<?php endforeach; ?>		
	</form>
</div>

<!-- Formulario modal modificar ingrediente -->
<div id="dialogModificarIngrediente" style="display: none">
	<form id="formModificarIngrediente">
		<div class="form-group">
			<label for="nombreIngredienteMod" class="col-sm-4 control-label">Nombre</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="nombreIngredienteMod"
					placeholder="Nombre ingrediente" name="ingrediente">
			</div>
		</div>
		<div class="form-group">
			<label for="descripcionIngredienteMod" class="col-sm-4 control-label">Descripcion</label>
			<div class="col-sm-8">
				<input type="text" class="form-control"
					id="descripcionIngredienteMod" placeholder="Descripcion"
					name="descripcion">
			</div>
		</div>
		<div class="form-group">
			<label for="precioIngredienteMod" class="col-sm-4 control-label">Precio</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="precioIngredienteMod"
					placeholder="Precio" name="precio">
			</div>
		</div>
		<input type="hidden" name="idIngrediente" value="0">
	</form>
</div>

<div>
	<div id="articulos" class="panel panel-default">
		<div class="panel-heading panel-rojo">
			<h4 class="panel-title"><i class="fa fa-beer"></i> Articulos</h4>
		</div>
		<div class="panel-body panel-rojo">
			<div class="col-md-4">
				<div id="nuevoArticulo" class="panel panel-default sub-panel">
					<div class="panel-heading panel-rojo">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaArticulo"
								class="accordion-toggle collapsed"> Nuevo articulo </a>
						</h4>
					</div>
					<div id="altaArticulo" class="panel-body collapse panel-rojo">
						<form id="formAltaArticulo" class="form-horizontal">
							<div class="form-group">
								<label for="listaTiposArticulosArticulo"
									class="col-sm-4 control-label">Tipo articulo</label>
								<div class="col-sm-8">
									<select name="tipoArticulo" id="listaTiposArticulosArticulo">
										<?php foreach ($tiposArticuloLocal as $linea): ?>
										<option class="form-control"
											value="<?php echo $linea->id_tipo_articulo; ?>">
											<?php echo $linea->tipo_articulo; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="nombreArticulo" class="col-sm-4 control-label">Nombre</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="nombreArticulo"
										placeholder="Nombre articulo" name="articulo">
								</div>
							</div>
							<div class="form-group">
								<label for="descripcionArticulo" class="col-sm-4 control-label">Descripcion</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"
										id="descripcionArticulo" placeholder="Descripcion"
										name="descripcion">
								</div>
							</div>
							<div class="form-group">
								<label for="precioArticulo" class="col-sm-4 control-label">Precio</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="precioArticulo"
										placeholder="Precio" name="precio">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-4 col-sm-8">
									<div class="checkbox">
										<label class="pull-left"><input name="validoPedidos"
											type="checkbox"> Se puede enviar en pedidos</label>
									</div>
								</div>
							</div>
							<?php $inicio = true; 
							foreach ($ingredientes as $linea):
							if ($inicio):
							?>
							<div class="form-group">
								<label for="precioArticulo" class="col-sm-4 control-label">Ingredientes</label>
								<div class="col-sm-8">
									<div class="checkbox">
										<label class="pull-left"><input name="ingrediente[]"
											type="checkbox" value="<?php echo $linea->id_ingrediente; ?>">
											<?php echo $linea->ingrediente; ?> </label>
									</div>
								</div>
							</div>
							<?php
							else:
							?>
							<div class="form-group listaIngredientesArticulo">
								<div class="col-sm-offset-4 col-sm-8">
									<div class="checkbox">
										<label class="pull-left"><input name="ingrediente[]"
											type="checkbox" value="<?php echo $linea->id_ingrediente; ?>">
											<?php echo $linea->ingrediente; ?> </label>
									</div>
								</div>
							</div>
							<?php 
							endif;
							$inicio = false;
							?>

							<?php endforeach; ?>
						</form>
						<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
					                           echo "enviarFormulario('" . site_url() .
					                           "/articulos/anadirArticulo','formAltaArticulo','listaArticulos',1)"
					                           ?>">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="listaArticulosCabecera"
					class="panel panel-default sub-panel">
					<div class="panel-heading panel-rojo">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaArticulos"
								class="accordion-toggle collapsed"> Lista articulos </a>
						</h4>
					</div>
					<div id="listaArticulos" class="panel-body collapse sub-panel">

						<?php
						$idTipoArticulo = 0;
						?>
						<?php
						if (count($articulosLocal)):
						$contador = 0;
						foreach ($articulosLocal as $linea):
						?>
						<?php
						if ($linea['id_tipo_articulo'] <> $idTipoArticulo) :
						$contador = 0;
						?>
						<div class="col-md-12">
							<h3>
								<span class="label label-default"> <?php 
								echo $linea['tipo_articulo'];
								?>
								</span>
							</h3>
						</div>
						<?php            
						endif;
						$contador++;
						if ($contador%2 <> 0):?>
						<div class="col-md-12">
							<?php 
							endif;
							?>
							<div class="well col-md-6">
								<div class="span6">
									<strong><?php echo $linea['articulo'];?> </strong><br>
									<table
										class="table table-condensed table-responsive table-user-information">
										<tbody>
											<tr>
												<td>Descripcion</td>
												<td><?php echo $linea['descripcion'];?></td>
											</tr>
											<tr>
												<td>Precio</td>
												<td><?php echo $linea['precio'];?></td>
											</tr>
											<tr>
												<td>Ingredientes</td>
												<td><?php
												$primeraVuelta = true;
												foreach ($linea['ingredientes'] as $ingrediente) {
												if (!$primeraVuelta){
													echo ",";
												}
												$primeraVuelta = false;
												echo $ingrediente['ingrediente'];
            								}
            								?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<span class="pull-right">
									<button class="btn btn-warning" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="mostrarVentanaModificarArticulo(
											<?php echo trim($linea['id_articulo_local']); ?>,
											'<?php echo trim($linea['articulo']); ?>',
                   							'<?php echo trim($linea['descripcion']); ?>',
                   							'<?php echo trim($linea['precio']); ?>',
                   							'<?php echo trim($linea['id_tipo_articulo']); ?>',
                   							'<?php echo trim($linea['validoPedidos']); ?>')">
										<span class="glyphicon glyphicon-edit"></span>
									</button>
									<button class="btn btn-danger" type="button"
										data-toggle="tooltip" data-original-title="Remove this user"
										onclick="<?php
                							echo "doAjax('" . site_url() . "/articulos/borrarArticulo','idArticuloLocal="
                							. $linea['id_articulo_local'] . "','listaArticulos','post',1)";
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
						if ($linea['id_tipo_articulo'] <> $idTipoArticulo) {
						$idTipoArticulo = $linea['id_tipo_articulo'];
						}
						?>
						<?php
						endforeach;
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
	<div id="inigredientes" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">Ingredientes</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="nuevoIngrediente" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaIngrediente"
								class="accordion-toggle collapsed"> Nuevo Ingrediente </a>
						</h4>
					</div>
					<div id="altaIngrediente" class="panel-body collapse sub-panel">
						<form id="formAltaIngrediente" class="form-horizontal">
							<div class="form-group">
								<label for="nombreIngrediente" class="col-sm-4 control-label">Nombre</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="nombreIngrediente"
										placeholder="Nombre ingrediente" name="ingrediente">
								</div>
							</div>
							<div class="form-group">
								<label for="descripcionIngrediente"
									class="col-sm-4 control-label">Descripcion</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"
										id="descripcionIngrediente" placeholder="Descripcion"
										name="descripcion">
								</div>
							</div>
							<div class="form-group">
								<label for="precioIngrediente" class="col-sm-4 control-label">Precio</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="precioIngrediente"
										placeholder="Precio" name="precio">
								</div>
							</div>
						</form>
						<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
                           echo "enviarFormulario('" . site_url()
                           . "/ingredientes/anadirIngrediente','formAltaIngrediente','listaIngredientes',1)"
                           ?>">
								<span class="glyphicon glyphicon-plus">
							
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="ingredientes" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaIngredientes"
								class="accordion-toggle collapsed"> Lista ingredientes </a>
						</h4>
					</div>
					<div id="listaIngredientes" class="panel-body collapse sub-panel">
						<?php
						$contador =0;
						foreach ($ingredientes as $ingrediente):
						$contador++;
						if ($contador%2 <> 0):?>
						<div class="col-md-12">
							<?php 
							endif;
							?>
							<div class="well col-md-6">
								<div class="span6">
									<strong><?php echo $ingrediente->ingrediente;?> </strong><br>
									<table
										class="table table-condensed table-responsive table-user-information">
										<tbody>
											<tr>
												<td>Descripcion</td>
												<td><?php echo $ingrediente->descripcion;?></td>
											</tr>
											<tr>
												<td>Precio</td>
												<td><?php echo $ingrediente->precio;?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<span class="pull-right">
									<button class="btn btn-warning" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="mostrarVentanaModificarIngrediente(
										'<?php echo trim($ingrediente->ingrediente); ?>',
                   						'<?php echo trim($ingrediente->descripcion); ?>',
                   						'<?php echo trim($ingrediente->precio); ?>',
                   						'<?php echo trim($ingrediente->id_ingrediente); ?>')">
										<span class="glyphicon glyphicon-edit"></span>
									</button>
									<button class="btn btn-danger" type="button"
										data-toggle="tooltip" data-original-title="Remove this user"
										onclick="<?php
                						echo "doAjax('" . site_url() . "/ingredientes/borrarIngrediente','idIngrediente="
                						. $ingrediente->id_ingrediente . "','listaIngredientes','post',1)";
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
						endforeach; ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
