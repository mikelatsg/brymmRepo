<!-- Formulario modal modificar servicios -->
<div
	id="dialogModificarPlato" style="display: none">
	<!-- Div que contiene el formulario para modificar los platos-->
	<!-- <div id="modificarPlato">
        <h3>Modificar plato</h3> -->
	<form id="formModificarPlato" class="form-horizontal">
		<input type="hidden" name="idPlatoLocal" value="0">
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">Nombre</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="nombre"
					placeholder="Nombre" name="nombre">
			</div>
		</div>
		<div class="form-group">
			<label for="idTipoPlato" class="col-sm-4 control-label">Tipo de plato</label>
			<div class="col-sm-8">
				<select name="idTipoPlato" id="idTipoPlato">
					<?php foreach ($tiposPlato as $tipoPlato): ?>
					<option class="form-control"
						value="<?php echo $tipoPlato->id_tipo_plato; ?>">
						<?php echo $tipoPlato->descripcion; ?>
					</option>
					<?php endforeach; ?>
				</select>
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
	<!-- </div> -->
</div>

<div id="dialogModificarTipoMenu"
	style="display: none">
	<!-- id="modificarTipoMenuLocal" -->
	<form id="formModificarTipoMenuLocal" class="form-horizontal">
		<input type="hidden" name="idTipoMenuLocalModificar" />
		<div class="form-group">
			<label for="nombreMenuModificar" class="col-sm-4 control-label">Nombre
				menu</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="nombreMenuModificar"
					placeholder="Nombre menu" name="nombreMenuModificar">
			</div>
		</div>
		<div class="form-group">
			<label for="idTipoMenuModificar" class="col-sm-4 control-label">Menu</label>
			<div class="col-sm-8">
				<select name="idTipoMenuModificar" id="idTipoMenuModificar">
					<?php foreach ($tiposMenu as $tipoMenu): ?>
					<option class="form-control"
						value="<?php echo $tipoMenu->id_tipo_menu; ?>">
						<?php echo $tipoMenu->descripcion; ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="precioMenuModificar" class="col-sm-4 control-label">Precio</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="precioMenuModificar"
					placeholder="Precio" name="precioMenuModificar">
			</div>
		</div>
		<div class="radio">
			<label> <input type="radio" name="esCarta" id="esCarta" value="1"
				checked> Carta
			</label>
		</div>
		<div class="radio">
			<label> <input type="radio" name="esCarta" id="esCarta" value="0">
				Menu
			</label>
		</div>
	</form>
</div>

<?php if (!$menusActivos):?>
<div class="alert alert-danger" role="alert">El servicio de menus está
	desactivado</div>
<?php endif;?>

<div id="calendarioMenuLocal" class="panel panel-default">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">
			<i class="fa fa-calendar"></i> Calendario menu
		</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-4">
			<div id="altaTiposMenuPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<i class="fa fa-plus"></i> Añadir plato a menu
					</h4>
				</div>
				<div id="anadirPlatoMenu" class="panel-body sub-panel">
					<form id="formAnadirPlatoMenu" class="form-horizontal">
						<div class="form-group">
							<label for="datepickerFechaPlatoMenu"
								class="col-sm-4 control-label">Fecha</label>
							<div class="col-sm-8">
								<input type="text" class="form-control"
									id="datepickerFechaPlatoMenu" placeholder="Fecha"
									name="fechaMenu">
							</div>
						</div>
						<div class="form-group">
							<label for="tipoMenuLocal" class="col-sm-4 control-label">Menu</label>
							<div class="col-sm-8">
								<select name="tipoMenuLocal" id="tipoMenuLocal">
									<?php foreach ($tiposMenuLocal as $tipoMenuLocal): ?>
									<option class="form-control"
										value="<?php echo $tipoMenuLocal->id_tipo_menu_local; ?>">
										<?php echo $tipoMenuLocal->nombre_menu; ?>
									</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div id="altaTiposMenuPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<i class="fa fa-cutlery"></i> Menu Dia
					</h4>
				</div>
				<div id="menuDia" class="panel-body sub-panel altoMaximo"></div>
			</div>
		</div>
		<div class="col-md-8">
			<!-- Div que contiene los platos creados del local-->
			<div id="listaPlatosLocalPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<i class="fa fa-calendar"></i> Calendario
					</h4>
				</div>
				<div class="panel-body sub-panel">
					<span id="calendarioMenu"> <?php
					echo $calendario;
					?>
					</span>
					<div id="actualizarCalendario"
						class="col-md-12 actualizarCalendario">
						<?php
						echo "<a onclick=";
						echo "doAjax('" . site_url() . "/menus/actualizarCalendario',''" .
								",'actualizarCalendarioMenu','post',1)";
						echo "> Actualizar calendario </a>";
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="platosLocal" class="panel panel-default">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">
			<i class="fa fa-tag"></i> Platos
		</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-4">
			<div id="altaPlatosPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#anadirPlato"
							class="accordion-toggle collapsed"><i class="fa fa-plus"></i>
							Nuevo plato </a>
					</h4>
				</div>
				<!-- Div que contiene el formulario para crear los platos-->
				<div id="anadirPlato" class="panel-body collapse sub-panel">
					<form id="formAnadirPlato" class="form-horizontal">
						<div class="form-group">
							<label for="nombre" class="col-sm-4 control-label">Nombre</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="nombre"
									placeholder="Nombre" name="nombre">
							</div>
						</div>
						<div class="form-group">
							<label for="idTipoPlato" class="col-sm-4 control-label">Menu</label>
							<div class="col-sm-8">
								<select name="idTipoPlato" id="idTipoPlato">
									<?php foreach ($tiposPlato as $tipoPlato): ?>
									<option class="form-control"
										value="<?php echo $tipoPlato->id_tipo_plato; ?>">
										<?php echo $tipoPlato->descripcion; ?>
									</option>
									<?php endforeach; ?>
								</select>
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
                           "/menus/anadirPlatoLocal','formAnadirPlato','listaPlatosLocal',1)"
					                           ?>"
							title="Nuevo plato">
							<span class="glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<!-- Div que contiene los platos creados del local-->
			<div id="listaPlatosLocalPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#listaPlatosLocal"
							class="accordion-toggle collapsed"><i class="fa fa-list"></i>
							Lista platos </a>
					</h4>
				</div>
				<div id="listaPlatosLocal"
					class="panel-body collapse sub-panel altoMaximo">
					<?php
					$idTipoPlato = 0;
					$idTipoPlatoAnterior = 0;
					foreach ($platosLocal as $plato) :

					if ($plato->id_tipo_plato <> $idTipoPlato) {
                if ($plato->id_tipo_plato <> $idTipoPlatoAnterior && $idTipoPlato <> 0) :
                ?>
					</tbody>
					</table>
				</div>
			</div>
			<?php
			endif;
			?>
			<div class="well col-md-6">
				<div class="span6">
					<table
						class="table table-condensed table-responsive table-user-information">
						<tbody>
							<tr id="nombreMenu">
								<td>
									<h4>
										<span class="label label-danger"> <?php echo $plato->descripcion; ?>
										</span>
									</h4>
								</td>
							</tr>
							<?php 							
							$idTipoPlatoAnterior = $idTipoPlato;
							$idTipoPlato = $plato->id_tipo_plato;
            }
            ?>
							<tr>
								<td class="titulo">Nombre plato</td>
								<td><?php echo $plato->nombre; ?>
								</td>
							</tr>

							<tr>
								<td class="titulo">Precio</td>
								<td><?php echo round($plato->precio)." "; ?> <i
									class="fa fa-euro">
								
								</td>
							</tr>

							<tr class="separadorPlato">
								<td colspan="2"><span class="pull-right">
										<button class="btn btn-danger btn-sm" type="button"
											data-toggle="tooltip" data-original-title="Borrar plato"
											onclick="<?php
                           echo "doAjax('" . site_url() . "/menus/borrarPlatoLocal','idPlatoLocal="
			. $plato->id_plato_local . "','listaPlatosLocal','post',1)"
					                           ?>"
											title="Borrar plato">
											<span class="glyphicon glyphicon-remove"></span>
										</button> <!--    Modificar un plato        -->
										<button class="btn btn-warning btn-sm" type="button"
											data-toggle="tooltip" data-original-title="Modificar plato"
											onclick="mostrarVentanaModificarPlato(
								'<?php echo trim($plato->nombre); ?>',
               '<?php echo trim($plato->precio); ?>',
               '<?php echo trim($plato->id_plato_local); ?>',
               '<?php echo trim($plato->id_tipo_plato); ?>')"
											title="Modificar plato">
											<span class="glyphicon glyphicon-edit"></span>
										</button>
										<button class="btn btn-default btn-sm" type="button"
											data-toggle="tooltip"
											data-original-title="Añadir plato a menu"
											onclick="<?php
                           echo  "enviarDatosMenu('" . site_url() .
							"/menus/anadirPlatoMenu','formAnadirPlatoMenu','idPlatoLocal="
			. $plato->id_plato_local . "','mostrarMenu',1)"
					                           ?>"
											title="Añadir plato a menu">
											<span class="glyphicon glyphicon-plus"></span>
										</button>
								</span>
								</td>
							</tr>


							<?php 							
							endforeach;
									if ($idTipoPlato <> 0) :?>
						</tbody>
					</table>
				</div>
			</div>
			<?php 
			endif;
			?>

		</div>
	</div>
</div>
</div>
</div>

<!-- Div que contiene el formulario para aÃ±adir los tipos de menu
				(menu del dia, menu especial...)-->
<div id="tiposMenuLocal" class="panel panel-default">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">
			<i class="fa fa-tags"></i> Tipos menu
		</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-4">
			<div id="altaTiposMenuPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#anadirTipoMenuLocal"
							class="accordion-toggle collapsed"><i class="fa fa-plus"></i>
							Nuevo tipo menu </a>
					</h4>
				</div>
				<div id="anadirTipoMenuLocal" class="panel-body collapse sub-panel">
					<form id="formAnadirTipoMenuLocal" class="form-horizontal">
						<div class="form-group">
							<label for="nombreMenu" class="col-sm-4 control-label">Nombre
								menu</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="nombreMenu"
									placeholder="Nombre menu" name="nombreMenu">
							</div>
						</div>
						<div class="form-group">
							<label for="idTipoMenu" class="col-sm-4 control-label">Menu</label>
							<div class="col-sm-8">
								<select name="idTipoMenu" id="idTipoMenu">
									<?php foreach ($tiposMenu as $tipoMenu): ?>
									<option class="form-control"
										value="<?php echo $tipoMenu->id_tipo_menu; ?>">
										<?php echo $tipoMenu->descripcion; ?>
									</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="precioMenu" class="col-sm-4 control-label">Precio</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="precioMenu"
									placeholder="Precio" name="precioMenu">
							</div>
						</div>
						<div class="radio">
							<label> <input type="radio" name="esCarta" id="esCarta" value="1"
								checked> Carta
							</label>
						</div>
						<div class="radio">
							<label> <input type="radio" name="esCarta" id="esCarta" value="0">
								Menu
							</label>
						</div>
					</form>
					<span class="pull-right">
						<button class="btn btn-success" type="button"
							data-toggle="tooltip" data-original-title="Edit this user"
							onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/menus/anadirTipoMenuLocal','formAnadirTipoMenuLocal','listaTipoMenuLocal',1)"
					                           ?>"
							title="Nuevo tipo menu">
							<span class="glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
		</div>
		<!-- Div que contiene los tipos de menu creados del local-->
		<div class="col-md-8">
			<!-- Div que contiene los platos creados del local-->
			<div id="listaPlatosLocalPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#listaTipoMenuLocal"
							class="accordion-toggle collapsed"><i class="fa fa-list"></i>
							Lista tipos menu </a>
					</h4>
				</div>
				<div id="listaTipoMenuLocal" class="panel-body collapse sub-panel">
					<?php					
					foreach ($tiposMenuLocal as $tipoMenuLocal) {
?>
					<div class="well col-md-6">
						<div class="span6">
							<table
								class="table table-condensed table-responsive table-user-information">
								<tbody>
									<tr id="nombreMenu">
										<td class="titulo">Menu</td>
										<td><?php echo  $tipoMenuLocal->nombre_menu; ?>
										</td>
									</tr>
									<tr>
										<td class="titulo">Descripcion</td>
										<td><?php echo  $tipoMenuLocal->descripcion; ?>
										</td>
									</tr>
									<tr>
										<td class="titulo">Precio</td>
										<td><?php echo  $tipoMenuLocal->precio_menu." "; ?> <i
											class="fa fa-euro">
										
										</td>
									</tr>
								</tbody>
							</table>
							<span class="pull-right">
								<button class="btn btn-warning btn-sm" type="button"
									data-toggle="tooltip" data-original-title="Edit this user"
									onclick="mostrarVentanaModificarTipoMenu(<?php echo $tipoMenuLocal->id_tipo_menu_local?>)"
									title="Modificar tipo menu">
									<span class="glyphicon glyphicon-edit"></span>
								</button>
								<button class="btn btn-danger btn-sm" type="button"
									data-toggle="tooltip" data-original-title="Edit this user"
									onclick="<?php
                           echo "doAjax('" . site_url() . "/menus/borrarTipoMenuLocal','idTipoMenuLocal="
				. $tipoMenuLocal->id_tipo_menu_local . "','listaTipoMenuLocal','post',1)"
					                           ?>"
									title="Borrar tipo menu">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							</span>
						</div>
					</div>
					<?php
        }
        ?>
				</div>
			</div>
		</div>
	</div>
</div>
