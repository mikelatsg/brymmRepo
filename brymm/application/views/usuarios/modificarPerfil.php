<div class="col-md-12 noPadLeft noPadRight">
	<div id="pedidosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-user"></i> Datos usuario
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<?php if (isset($msg)):?>
			<div class="alert alert-info" role="alert">
				<i class="fa fa-info-circle fa-lg"></i> <?php echo $msg;?>
			</div>
			<?php endif;?>
			<div class="well col-md-6 colCentered">
				<form method="post" id="formLoginUsuario" class="form-horizontal"
					action="<?php echo site_url() ?>/usuarios/modificarUsuario">
					<div class="form-group">
						<label for="nick" class="col-md-4 control-label">Nick</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="nick"
								placeholder="Nick" name="nick" disabled
								value="<?php echo $usuario->nick;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="nombre" class="col-md-4 control-label">Nombre</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="nombre"
								placeholder="Nombre" name="nombre"
								value="<?php echo $usuario->nombre;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="apellido" class="col-md-4 control-label">Apellido</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="apellido"
								placeholder="Apellido" name="apellido"
								value="<?php echo $usuario->apellido;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Email</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="email"
								placeholder="Email" name="email"
								value="<?php echo $usuario->email;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="telefono" class="col-md-4 control-label">Telefono</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="telefono"
								placeholder="Telefono" name="telefono"
								value="<?php echo $usuario->telefono;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="localidad" class="col-md-4 control-label">Localidad</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="localidad"
								placeholder="Localidad" name="localidad"
								value="<?php echo $usuario->localidad;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="provincia" class="col-md-4 control-label">Provincia</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="provincia"
								placeholder="Provincia" name="provincia"
								value="<?php echo $usuario->provincia;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="codPostal" class="col-md-4 control-label">Codigo
							postal</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="codPostal"
								placeholder="Codigo postal" name="codigoPostal"
								value="<?php echo $usuario->codPostal;?>">
						</div>
					</div>
					<button class="btn btn-success" type="submit" data-toggle="tooltip"
						data-original-title="Remove this user">
						<span class="glyphicon glyphicon-edit"></span>Modificar datos
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
