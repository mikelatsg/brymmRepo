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

<div id="dialogModificarTipoPlato"
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
<div id="platosLocal" class="panel panel-default">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">Platos</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-4">
			<div id="altaPlatosPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#anadirPlato"
							class="accordion-toggle collapsed">Plato </a>
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
						<!-- <tr>
							<td>Nombre</td>
							<td width="46"><input type="text" name="nombre" /></td>
							</td>
						</tr>
						<tr>
							<td>Tipo de plato</td>
							<td width="46"><select name="idTipoPlato">
									<?php
									foreach ($tiposPlato as $tipoPlato) {
                                echo "<option value =  \"" . $tipoPlato->id_tipo_plato .
                                "\">" . $tipoPlato->descripcion . "</option>";
                            }
                            ?>
							</select>
							</td>
						</tr>
						<tr>
							<td>Precio</td>
							<td width="46"><input type="text" name="precio" /></td>
							</td>
						</tr>
						<tr>
							<td width="51" colspan="2" align="center"><input type="button"
								onclick="
                               <?php
                               echo "enviarFormulario('" . site_url() .
                               "/menus/anadirPlatoLocal','formAnadirPlato','listaPlatosLocal',1)"
                               ?>"
								value="Añadir plato" />
							</td>
						</tr> -->
					</form>
					<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/menus/anadirPlatoLocal','formAnadirPlato','listaPlatosLocal',1)"
					                           ?>">
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
							class="accordion-toggle collapsed"> Lista platos </a>
					</h4>
				</div>
				<div id="listaPlatosLocal" class="panel-body collapse sub-panel">
					<?php
					$idTipoPlato = 0;
					$idTipoPlatoAnterior = 0;
					foreach ($platosLocal as $plato) {

            if ($plato->id_tipo_plato <> $idTipoPlato) {
                if ($plato->id_tipo_plato <> $idTipoPlatoAnterior && $idTipoPlato <> 0) {
                    echo "</ul>";
                    //echo "</div>";
                }
                //echo "<div id=\"tipoPlato" . $plato->id_tipo_plato . "\">";
                echo "<h2>";
                echo $plato->descripcion;
                echo "</h2>";
                echo "<ul>";
                $idTipoPlatoAnterior = $idTipoPlato;
                $idTipoPlato = $plato->id_tipo_plato;
            }
            echo "<li>";
            echo $plato->nombre . " - " . $plato->precio;
            echo " - <a onclick=";
            echo "doAjax('" . site_url() . "/menus/borrarPlatoLocal','idPlatoLocal="
							. $plato->id_plato_local . "','listaPlatosLocal','post',1)";
            echo "> B </a>";
            ?>
					<!--    Modificar un plato        -->
					<button class="btn btn-warning" type="button" data-toggle="tooltip"
						data-original-title="Edit this user"
						onclick="mostrarVentanaModificarPlato(
								'<?php echo trim($plato->nombre); ?>',
               '<?php echo trim($plato->precio); ?>',
               '<?php echo trim($plato->id_plato_local); ?>',
               '<?php echo trim($plato->id_tipo_plato); ?>')">
						<span class="glyphicon glyphicon-edit"></span>
					</button>
					<!--  <a
			href="javascript:mostrarVentanaModificarPlato(
               '<?php echo trim($plato->nombre); ?>',
               '<?php echo trim($plato->precio); ?>',
               '<?php echo trim($plato->id_plato_local); ?>',
               '<?php echo trim($plato->id_tipo_plato); ?>')"> - M</a>-->
					<?php
					//Añadir plato a menu
					echo " - <a onclick=";
					echo "enviarDatosMenu('" . site_url() .
					"/menus/anadirPlatoMenu','formAnadirPlatoMenu','idPlatoLocal="
			. $plato->id_plato_local . "','mostrarMenu',1)";
					echo "> A </a>";
					echo "</li>";
           }
           if ($idTipoPlato <> 0) {
               echo "</ul>";
               //echo "</div>";
           }
           ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Div que contiene el formulario para añadir los tipos de menu
    (menu del dia, menu especial...)-->
<div id="tiposMenuLocal" class="panel panel-default">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">Tipos menu</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-4">
			<div id="altaTiposMenuPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#anadirTipoMenuLocal"
							class="accordion-toggle collapsed">Tipo menu </a>
					</h4>
				</div>
				<div id="anadirTipoMenuLocal" class="panel-body collapse sub-panel">
					<table>
						<form id="formAnadirTipoMenuLocal">
							<tr>
								<td>Nombre menu</td>
								<td width="46"><input type="text" name="nombreMenu" /></td>
								</td>
							</tr>
							<tr>
								<td>Menu</td>
								<td><select name="idTipoMenu">
										<?php
										foreach ($tiposMenu as $tipoMenu) {
                                echo "<option value = \"" . $tipoMenu->id_tipo_menu
                                . "\">" . $tipoMenu->descripcion . "</option>";
                            }
                            ?>
								</select>
								</td>
							</tr>
							<tr>
								<td>Precio</td>
								<td width="46"><input type="text" name="precioMenu" /></td>
								</td>
							</tr>
							<tr>
								<td></td>
								<td width="46"><input type="radio" name="esCarta" value="1">Carta
									<input type="radio" name="esCarta" value="0" checked>Menu</td>
							</tr>
							<tr>
								<td width="51" colspan="2" align="center"><input type="button"
									onclick="
                               <?php
                               echo "enviarFormulario('" . site_url() .
                               "/menus/anadirTipoMenuLocal','formAnadirTipoMenuLocal','listaTipoMenuLocal',1)"
                               ?>"
									value="Añadir menu" />
								</td>
							</tr>
						</form>
					</table>
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
							class="accordion-toggle collapsed"> Lista tipos menu </a>
					</h4>
				</div>
				<div id="listaTipoMenuLocal" class="panel-body collapse sub-panel">
					<?php
					echo "<ul>";
					foreach ($tiposMenuLocal as $tipoMenuLocal) {

            echo "<li>";
            echo $tipoMenuLocal->nombre_menu . " - " . $tipoMenuLocal->descripcion
            . " - " . $tipoMenuLocal->precio_menu;

            //Borrar un tipo de menu
            echo " - <a onclick=";
            echo "doAjax('" . site_url() . "/menus/borrarTipoMenuLocal','idTipoMenuLocal="
				. $tipoMenuLocal->id_tipo_menu_local . "','listaTipoMenuLocal','post',1)";
            echo "> B </a>";
            //Modificar un tipo de menu
            echo " - <a onclick=";
            echo "mostrarVentanaModificarTipoMenu(".$tipoMenuLocal->id_tipo_menu_local.")";
            /*echo "doAjax('" . site_url() . "/menus/cargarTipoMenuLocal','idTipoMenuLocal="
             . $tipoMenuLocal->id_tipo_menu_local . "','cargarTipoMenuLocal','post',1)";*/
            echo "> M </a>";
            echo "</li>";
        }
        echo "</ul>";
        ?>
				</div>
			</div>
		</div>
	</div>
	<div id="tiposMenuLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">Calendario menu</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="altaTiposMenuPanel" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#anadirPlatoMenu"
								class="accordion-toggle collapsed">A�adir plato a menu </a>
						</h4>
					</div>
					<div id="anadirPlatoMenu" class="panel-body collapse sub-panel">
						<table>
							<form id="formAnadirPlatoMenu">
								<tr>
									<td>Fecha</td>
									<td width="46"><input type="text" name="fechaMenu"
										id="datepickerFechaPlatoMenu" /></td>
									</td>
								</tr>
								<tr>
									<td>Menu</td>
									<td><select name="tipoMenuLocal">
											<?php
											foreach ($tiposMenuLocal as $tipoMenuLocal) {
                                echo "<option value = \"" . $tipoMenuLocal->id_tipo_menu_local
                                . "\">" . $tipoMenuLocal->nombre_menu . "</option>";
                            }
                            ?>
									</select>
									</td>
								</tr>
							</form>
						</table>
					</div>
				</div>
				<div id="altaTiposMenuPanel" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">Menu Dia</h4>
					</div>
					<div id="menuDia" class="panel-body sub-panel"></div>
				</div>
			</div>
			<div class="col-md-8">
				<!-- Div que contiene los platos creados del local-->
				<div id="listaPlatosLocalPanel"
					class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">Calendario</h4>
					</div>
					<div id="calendarioMenu" class="panel-body sub-panel">
						<?php
						echo $calendario;
						?>
					</div>
					<div id="actualizarCalendario" class="panel-body sub-panel">
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
