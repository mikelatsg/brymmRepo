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
		<div class="panel-heading">
			<h4 class="panel-title">Tipos articulo</h4>
		</div>
		<div class="panel-body">
			<div class="col-md-4">
				<div id="nuevoTipoArticulo" class="panel panel-default sub-panel">
					<div class="panel-heading">
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
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaTipoArticulos"
								class="accordion-toggle collapsed"> Lista tipos articulo </a>
						</h4>
					</div>
					<div id="listaTipoArticulos" class="panel-body collapse sub-panel">
						<ul>
							<?php foreach ($tiposArticuloLocal as $linea): ?>

							<li><?php echo $linea->tipo_articulo . "-" . $linea->personalizar . "-" . $linea->precio; ?>
								<a
								onclick="<?php
                echo "doAjax('" . site_url() . "/articulos/borrarTipoArticuloLocal','idTipoArticuloLocal="
                . $linea->id_tipo_articulo_local . "','listaTiposArticulo','post',1)";
                ?>
                   "> B </a> <!--Enlace modificar tipo articulo--> <a
								onclick="mostrarVentanaModificarTipoArticulo(
								'<?php echo trim($linea->id_tipo_articulo_local); ?>',
                   '<?php echo trim($linea->id_tipo_articulo); ?>',
                   '<?php echo trim($linea->personalizar); ?>',
                   '<?php echo trim($linea->precio); ?>')"
								data-toggle='modal'> M </a>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

