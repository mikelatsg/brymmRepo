<div class="col-md-12 noPadLeft noPadRight">
	<div id="datosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-home"></i> Datos Local
			</h4>
		</div>
		<div id="formularioModificarLocal" class="panel-body panel-verde">
			<?php if (isset($msg)):?>
			<div class="alert alert-warning" role="alert">				
				<?php echo $msg;?>
			</div>
			<?php endif;?>
			<form method="post" class="form-horizontal" onsubmit="return validarModificarLocal()"
				action="<?= site_url() ?>/locales/modificarLocal">
				<div class="form-group">
					<label for="nombre" class="col-md-4 control-label">Nombre</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="nombre"
							placeholder="Nombre local" name="Nombre" disabled
							value="<?php echo $local->nombre;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="idTipoComida" class="col-sm-4 control-label">Tipo
						Comida</label>
					<div class="col-sm-8">
						<select name="idTipoComida" id="idTipoComida" class="pull-left">
							<?php foreach ($tiposComida as $tipoComida): ?>
							<option class="form-control"
								value="<?php echo  $tipoComida->idTipoComida; ?>"
								<?php if ($tipoComida->idTipoComida == $local->tipoComida->idTipoComida):?>
								selected <?php endif;?>>
								<?php echo $tipoComida->tipoComida; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="direccion" class="col-md-4 control-label">Direccion</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="direccion"
							placeholder="Direccion" name="direccion"
							value="<?php echo $local->direccion;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="localidad" class="col-md-4 control-label">Localidad</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="localidad"
							placeholder="Localidad" name="localidad"
							value="<?php echo $local->localidad;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="provincia" class="col-md-4 control-label">Provincia</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="provincia"
							placeholder="Provincia" name="provincia"
							value="<?php echo $local->provincia;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="codigoPostal" class="col-md-4 control-label">Codigo
						postal</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="codigoPostal"
							placeholder="Codigo postal" name="codigoPostal"
							value="<?php echo $local->codPostal;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="localidad" class="col-md-4 control-label">Telefono</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="telefono"
							placeholder="Telefono" name="telefono"
							value="<?php echo $local->telefono;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-md-4 control-label">Email</label>
					<div class="col-md-6">
						<input type="email" class="form-control" id="email"
							placeholder="Email" name="email"
							value="<?php echo $local->email;?>">
					</div>
				</div>
				<button class="btn btn-success" type="submit" data-toggle="tooltip"
					data-original-title="Remove this user">
					<span class="glyphicon glyphicon-edit"></span> Modificar datos
				</button>
			</form>
		</div>
	</div>
</div>
