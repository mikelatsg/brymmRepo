<!-- Formulario modal modificar camareros -->
<script type="text/javascript">
sesionControlTotal = '<?php echo $_SESSION['controlTotal'];?>';
</script>

<div>
	<div id="dialogModificarCamareros" title="Modificar camarero"
		style="display: none">
		<div id="modificarCamarero">
			<form id="formModificarCamarero" class="form-horizontal">
				<input type="hidden" name="idCamarero">
				<table>
					<div class="form-group">
						<label for="nombreCamarero" class="col-sm-4 control-label">Nombre
							camarero</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="nombreCamarero"
								placeholder="Nombre camarero" name="nombreCamarero">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-4 control-label">Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="password"
								placeholder="Password" name="password">
						</div>
					</div>
					<div class="form-group">
						<label for="password2" class="col-sm-4 control-label">Repite
							password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="password2"
								placeholder="Repite password" name="password2">
						</div>
					</div>
					<div class="form-group">
						<label for="controlTotal" class="col-sm-4 control-label">Control
							total</label>
						<div class="col-sm-8">
							<input type="checkbox" class="form-control" id="controlTotal"
								placeholder="Repite password" name="controlTotal">
						</div>
					</div>
				</table>
			</form>
		</div>
	</div>
	<div id="camarerosLocal" class="panel panel-default col-md-12">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-user"></i> Camareros
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="sesionCamareroPanel" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<i class="fa fa-sign-in"></i> Sesion camarero
						</h4>
					</div>
					<div id="sesionCamarero" class="panel-body sub-panel">
						<strong> <?php
						if (isset($_SESSION['idCamarero'])) {
        echo $camareroSesion->nombre;
        /* echo "<a onclick=\"";
         echo "doAjax('" . site_url() . "/camareros/cerrarSesionCamarero','','sesionCamarero','post',1)";
        echo "\"> Cerrar sesion </a>"; */
    } else {
        echo "No hay ningún camarero activo";
    }
    ?>
						</strong>
					</div>
				</div>
				<div id="altaCamarerosPanel" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#altaCamarero"
								class="accordion-toggle collapsed"><i class="fa fa-plus"></i>
								Nuevo camarero </a>
						</h4>
					</div>
					<div id="altaCamarero" class="panel-body collapse sub-panel">
						<form id="formAltaCamarero" class="form-horizontal">
							<div class="form-group">
								<label for="nombreCamarero" class="col-sm-4 control-label">Nombre
									camarero</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="nombreCamarero"
										placeholder="Nombre camarero" name="nombreCamarero">
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-sm-4 control-label">Password</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="password"
										placeholder="Password" name="password">
								</div>
							</div>
							<div class="form-group">
								<label for="password2" class="col-sm-4 control-label">Repite
									password</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="password2"
										placeholder="Repite password" name="password2">
								</div>
							</div>
							<div class="form-group">
								<label for="controlTotal" class="col-sm-4 control-label">Control
									total</label>
								<div class="col-sm-8">
									<input type="checkbox" class="form-control" id="controlTotal"
										placeholder="Repite password" name="controlTotal">
								</div>
							</div>
						</form>
						<!-- 
                    Si no tiene control total no se permite crear nuevos camareros-->
						<span class="pull-right">
							<button class="btn btn-success" type="button"
								data-toggle="tooltip" data-original-title="Edit this user"
								onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/camareros/anadirCamarero','formAltaCamarero','listaCamareros',1)"
					                           ?>"
								<?php
								if (!$_SESSION['controlTotal']):
								?>
								disabled="true" <?php
								endif;
								?>
								title="Nuevo camarero">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="listaCamarerosPanel" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaCamarerors"
								class="accordion-toggle collapsed"><i class="fa fa-group"></i>
								Lista de camareros </a>
						</h4>
					</div>
					<div id="listaCamarerors" class="panel-body collapse sub-panel">
						<?php foreach ($camarerosLocal as $camarero): ?>
						<div class="well col-md-6">
							<div class="span6">
								<table
									class="table table-condensed table-responsive table-user-information">
									<tbody>
										<tr>
											<td class="titulo">Nombre camarero</td>
											<td><?php echo $camarero->nombre;?>
											</td>
										</tr>
										<tr>
											<td class="titulo">Control total</td>
											<td><?php 
											if ($camarero->control_total == 1){
												echo "Si";
											}else{
												echo "No";
											}
											?>
											</td>
										</tr>
									</tbody>
								</table>
								<!-- 
                Si no tiene control total no se permite borrar ni iniciar sesiones
                -->
								<?php
								if ($_SESSION['controlTotal']):
								?>
								<span class="pull-right">
									<button class="btn btn-success btn-sm" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="<?php
                    echo "doAjax('" . site_url() . "/camareros/iniciarSesionCamarero','idCamarero="
                    . $camarero->id_camarero . "','sesionCamarero','post',1)";
                    ?>"
                    title="Iniciar sesion camarero">
										<span class="glyphicon glyphicon-log-in"></span>
									</button>
									<button class="btn btn-warning btn-sm" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="mostrarVentanaModificarCamarero(
                       '<?php echo trim($camarero->id_camarero); ?>',
                       '<?php echo trim($camarero->nombre); ?>',
                       '<?php echo trim($camarero->control_total); ?>')"
                       title="Modificar camarero">
										<span class="glyphicon glyphicon-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="<?php
                    echo "doAjax('" . site_url() . "/camareros/borrarCamarero','idCamarero="
                    . $camarero->id_camarero . "','listaCamareros','post',1)";
                    ?>"
                    title="Eliminar camarero">
										<span class="glyphicon glyphicon-remove"></span>
									</button>
								</span>
								<?php endif;?>
							</div>
						</div>

						<?php
						endforeach;
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
