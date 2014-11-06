<div id="dialogModificarTipoArticulo" style="display: none">
	<form id="formModificarTipoArticulo">
		<input type="hidden" name="idTipoArticuloLocal">
		<table>
			<tr>
				<td>Tipo articulo</td>
				<td width="46"><select name="tipoArticulo" disabled>
						<?php foreach ($tiposArticulo as $linea): ?>
						<option value="<?php echo $linea->id_tipo_articulo; ?>">
							<?php echo $linea->tipo_articulo; ?>
						</option>
						<?php endforeach; ?>
				</select></td>
			</tr>
			<tr>
				<td>Personalizar</td>
				<td width="46"><select name="personalizar">
						<option value="1">Si</option>
						<option value="0">No</option>
				</select></td>
			</tr>
			<tr>
				<td>Precio base</td>
				<td width="46"><input type="text" name="precioBase"></td>
			</tr>
			<!--  <tr>
				<td width="51" colspan="2" align="center"><input type="button"
					onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/articulos/modificarTipoArticulo','formModificarTipoArticulo','listaTiposArticulo',1)"
                           ?>"
					value="Modificar tipo articulo" /></td>
			</tr>
			-->
		</table>
	</form>
</div>
<div>
	<div id="tiposArticulo" class="panel panel-default">
		<div class="panel-heading panel-azul">
			<h4 class="panel-title">Tipos articulo</h4>
		</div>
		<div class="panel-body">
			<div class="col-md-4">
				<div id="nuevoTipoArticulo" class="panel panel-default sub-panel">
					<div class="panel-heading panel-azul">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaTipoArticulo"
								class="accordion-toggle collapsed"> Nuevo tipo articulo </a>
						</h4>
					</div>
					<div id="altaTipoArticulo" class="panel-body collapse sub-panel">
						<form id="formAltaTipoArticulo">
							<table>
								<tr>
									<td>Tipo articulo</td>
									<td width="46"><select name="tipoArticulo">
											<?php foreach ($tiposArticulo as $linea): ?>
											<option value="<?php echo $linea->id_tipo_articulo; ?>">
												<?php echo $linea->tipo_articulo; ?>
											</option>
											<?php endforeach; ?>
									</select>
									</td>
								</tr>
								<tr>
									<td>Personalizar</td>
									<td width="46"><select name="personalizar">
											<option value="1">Si</option>
											<option value="0">No</option>
									</select>
									</td>
								</tr>
								<tr>
									<td>Precio base</td>
									<td width="46"><input type="text" size="2" maxlength="5"
										value="1" name="precioBase">
									</td>
								</tr>
								<tr>
									<td width="51" colspan="2" align="center"><input type="button"
										onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/articulos/anadirTipoArticulo','formAltaTipoArticulo','listaTiposArticulo',1)"
                           ?>"
										value="Añadir tipo articulo" />
									</td>
								</tr>
							</table>
						</form>

					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="nuevoTipoArticulo" class="panel panel-default sub-panel">
					<div class="panel-heading panel-azul">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaTipoArticulos"
								class="accordion-toggle collapsed"> Lista tipos articulo </a>
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
												<td><?php echo $linea->personalizar;?></td>
											</tr>
											<tr>
												<td>Precio</td>
												<td><?php echo $linea->precio;?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<span class="pull-right">
									<button class="btn btn-warning" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="mostrarVentanaModificarTipoArticulo(
										'<?php echo trim($linea->id_tipo_articulo_local); ?>',
					                   '<?php echo trim($linea->id_tipo_articulo); ?>',
					                   '<?php echo trim($linea->personalizar); ?>',
					                   '<?php echo trim($linea->precio); ?>')">
										<span class="glyphicon glyphicon-edit"></span>
									</button>
									<button class="btn btn-danger" type="button"
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

