<!-- Formulario modal modificar articulo -->
<div id="dialogModificarArticulo" style="display: none">
	<form id="formModificarArticulo">
		<table>
			<tr>
			
			
			<tr>
				<td></td>
				<td width="46"><select name="tipoArticulo"
					id="listaTiposArticulosArticuloMod">
						<?php foreach ($tiposArticuloLocal as $linea): ?>
						<option value="<?php echo $linea->id_tipo_articulo; ?>">
							<?php echo $linea->tipo_articulo; ?>
						</option>
						<?php endforeach; ?>
				</select></td>
			</tr>
			<tr>
				<td>Nombre articulo</td>
				<td width="46"><input type="text" name="articulo" /></td>
			</tr>
			<tr>
				<td>Descripción</td>
				<td><input type="text" name="descripcion" /></td>
			</tr>
			<tr>
				<td>Precio</td>
				<td><input type="text" name="precio" /> <input type="hidden"
					name="idArticuloLocal" value="0"></td>
			</tr>
			<tr>
				<td>Se puede enviar en pedidos</td>
				<td><input type="checkbox" name="validoPedidos" value="1" /></td>
			</tr>
			</tr>
			<tr id="tituloIngredientesArticuloMod">
				<td>Ingredientes</td>
			</tr>
			<?php foreach ($ingredientes as $linea): ?>
			<tr class="listaIngredientesArticulo">
				<td></td>
				<td><input type="checkbox" name="ingrediente[]"
					value="<?php echo $linea->id_ingrediente; ?>" /> <?php echo $linea->ingrediente; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</form>
</div>

<!-- Formulario modal modificar ingrediente -->
<div id="dialogModificarIngrediente" style="display: none">
	<form id="formModificarIngrediente">
		<table>
			<tr>
				<td>Nombre ingrediente</td>
				<td width="46"><input type="text" name="ingrediente" />
				</td>
			</tr>
			<tr>
				<td>Descripción</td>
				<td><input type="text" name="descripcion" />
				</td>
			</tr>
			<tr>
				<td>Precio</td>
				<td><input type="text" name="precio" /> <input type="hidden"
					name="idIngrediente" value="0">
				</td>
			</tr>
		</table>
	</form>
</div>

<div>
	<div id="articulos" class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Articulos</h4>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<div id="nuevoArticulo" class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaArticulo"
								class="accordion-toggle collapsed"> Nuevo articulo </a>
						</h4>
					</div>
					<div id="altaArticulo" class="panel-body collapse">

						<form id="formAltaArticulo">
							<table id="idTabla">
								<tr>
									<td></td>
									<td width="46"><select name="tipoArticulo"
										id="listaTiposArticulosArticulo">
											<?php foreach ($tiposArticuloLocal as $linea): ?>
											<option value="<?php echo $linea->id_tipo_articulo; ?>">
												<?php echo $linea->tipo_articulo; ?>
											</option>
											<?php endforeach; ?>
									</select>
									</td>
								</tr>
								<tr>
									<td>Nombre articulo</td>
									<td width="46"><input type="text" name="articulo" /></td>
								</tr>
								<tr>
									<td>Descripcion</td>
									<td><input type="text" name="descripcion" />
									</td>
								</tr>
								<tr>
									<td>Precio</td>
									<td><input type="text" name="precio" />
									</td>
								</tr>
								<tr>
									<td>Se puede enviar en pedidos</td>
									<td><input type="checkbox" name="validoPedidos" value="1" />
									</td>
								</tr>
								<tr id="tituloIngredientesArticulo">
									<td>Ingredientes</td>
								</tr>
								<?php foreach ($ingredientes as $linea): ?>
								<tr class="listaIngredientesArticulo">
									<td></td>
									<td><input type="checkbox" name="ingrediente[]"
										value="<?php echo $linea->id_ingrediente; ?>" /> <?php echo $linea->ingrediente; ?>
									</td>
								</tr>
								<?php endforeach; ?>
								<tr>
									<td width="51" colspan="2" align="center"><input type="button"
										onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/articulos/anadirArticulo','formAltaArticulo','listaArticulos',1)"
                           ?>"
										<?php
										if (!count($tiposArticuloLocal)) {
                               echo "disabled";
                           }
                           ?>
										value="Añadir articulo" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
			<!--  <div id="tituloModificarArticulo">
					<h4>Modificar articulos</h4>
				</div>-->
			<div class="col-md-6">
				<div id="listaArticulosCabecera" class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaArticulos"
								class="accordion-toggle collapsed"> Lista articulos </a>
						</h4>
					</div>
					<div id="listaArticulos" class="panel-body collapse">

						<?php
						$idTipoArticulo = 0;
						?>
						<?php
						if (count($articulosLocal)):
						echo "<ul>";
						foreach ($articulosLocal as $linea):
						?>
						<?php
						if ($linea['id_tipo_articulo'] <> $idTipoArticulo) {
                echo $linea['tipo_articulo'];
            }
            ?>
						<li><?php echo $linea['articulo'] . "-" . $linea['descripcion'] . "-" . $linea['precio']; ?>
							<a
							onclick="mostrarVentanaModificarArticulo(
								<?php echo trim($linea['id_articulo_local']); ?>,
								'<?php echo trim($linea['articulo']); ?>',
                   '<?php echo trim($linea['descripcion']); ?>',
                   '<?php echo trim($linea['precio']); ?>',
                   '<?php echo trim($linea['id_tipo_articulo']); ?>',
                   '<?php echo trim($linea['validoPedidos']); ?>')"
							data-toggle='modal'> M </a> <a
							onclick="<?php
                echo "doAjax('" . site_url() . "/articulos/borrarArticulo','idArticuloLocal="
                . $linea['id_articulo_local'] . "','listaArticulos','post',1)";
                ?>
                   "> B </a>
						</li>
						<?php
						echo "<ul>";
						foreach ($linea['ingredientes'] as $ingrediente) {
                echo "<li>";
                echo $ingrediente['ingrediente'];
                echo "</li>";
            }
            echo "</ul>";
            if ($linea['id_tipo_articulo'] <> $idTipoArticulo) {
                $idTipoArticulo = $linea['id_tipo_articulo'];
            }
            ?>
						<?php
						endforeach;
						echo "</ul>";
						endif;
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
	<div id="inigredientes" class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Ingredientes</h4>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<div id="nuevoIngrediente" class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaIngrediente"
								class="accordion-toggle collapsed"> Nuevo Ingrediente </a>
						</h4>
					</div>
					<div id="altaIngrediente" class="panel-body collapse">
						<table>
							<form id="formAltaIngrediente">
								<tr>
								
								
								<tr>
									<td>Nombre ingrediente</td>
									<td width="46"><input type="text" name="ingrediente" />
									</td>
								</tr>
								<tr>
									<td>Descripción</td>
									<td><input type="text" name="descripcion" />
									</td>
								</tr>
								<tr>
									<td>Precio</td>
									<td><input type="text" name="precio" />
									</td>
								</tr>

								</tr>
								<tr>
									<td width="51" colspan="2" align="center"><input type="button"
										onclick="<?php
                           echo "enviarFormulario('" . site_url()
                           . "/ingredientes/anadirIngrediente','formAltaIngrediente','listaIngredientes',1)"
                           ?>"
										value="Añadir ingrediente" />
									</td>
								</tr>
							</form>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div id="ingredientes" class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaIngredientes"
								class="accordion-toggle collapsed"> Lista ingredientes </a>
						</h4>
					</div>
					<div id="listaIngredientes" class="panel-body collapse">
						<ul>
							<?php foreach ($ingredientes as $ingrediente): ?>

							<li><?php
							echo $ingrediente->ingrediente . "-"
		. $ingrediente->descripcion .
		"-"
		. $ingrediente->precio
		?> <a
								onclick="mostrarVentanaModificarIngrediente(
								'<?php echo trim($ingrediente->ingrediente); ?>',
                   '<?php echo trim($ingrediente->descripcion); ?>',
                   '<?php echo trim($ingrediente->precio); ?>',
                   '<?php echo trim($ingrediente->id_ingrediente); ?>')"
								data-toggle='modal'> M </a> <a
								onclick="<?php
                echo "doAjax('" . site_url() . "/ingredientes/borrarIngrediente','idIngrediente="
                . $ingrediente->id_ingrediente . "','listaIngredientes','post',1)";
                ?>
                   "> B </a>
							</li>



							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
