<div class="col-md-12 noPadLeft noPadRight">
	<div id="datosLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-home"></i> Nuevo local
			</h4>
		</div>
		<div id="FormularioAltaLocal" class="panel-body panel-verde">			
			<?php if (isset($msg)):?>
			<div class="alert alert-warning" role="alert">
				<?php echo $msg;?>
			</div>
			<?php endif;?>
			<form method="post" class="form-horizontal"
				onsubmit="return validarAltaLocal()"
				action="<?= site_url() ?>/locales/nuevoLocal">
				<div class="form-group">
					<label for="nombre" class="col-md-4 control-label">Nombre</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="nombre"
							placeholder="Nombre local" name="nombre">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-md-4 control-label">Password</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="password"
							placeholder="Password" name="password">
					</div>
				</div>
				<div class="form-group">
					<label for="passwordConf" class="col-md-4 control-label">Repite
						password</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="passwordConf"
							placeholder="Repite password" name="passwordConf">
					</div>
				</div>
				<div class="form-group">
					<label for="idTipoComida" class="col-sm-4 control-label">Tipo
						Comida</label>
					<div class="col-sm-8">
						<select name="idTipoComida" id="idTipoComida" class="pull-left">
							<?php foreach ($tiposComida as $tipoComida): ?>
							<option class="form-control"
								value="<?php echo  $tipoComida->id_tipo_comida; ?>">
								<?php echo $tipoComida->tipo_comida; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="direccion" class="col-md-4 control-label">Direccion</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="direccion"
							placeholder="Direccion" name="direccion">
					</div>
				</div>
				<div class="form-group">
					<label for="localidad" class="col-md-4 control-label">Localidad</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="localidad"
							placeholder="Localidad" name="localidad">
					</div>
				</div>
				<div class="form-group">
					<label for="provincia" class="col-md-4 control-label">Provincia</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="provincia"
							placeholder="Provincia" name="provincia">
					</div>
				</div>
				<div class="form-group">
					<label for="codigoPostal" class="col-md-4 control-label">Codigo
						postal</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="codigoPostal"
							placeholder="Codigo postal" name="codigoPostal">
					</div>
				</div>
				<div class="form-group">
					<label for="localidad" class="col-md-4 control-label">Telefono</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="telefono"
							placeholder="Telefono" name="telefono">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-md-4 control-label">Email</label>
					<div class="col-md-6">
						<input type="email" class="form-control" id="email"
							placeholder="Email" name="email">
					</div>
				</div>
				<button class="btn btn-success" type="submit" data-toggle="tooltip"
					data-original-title="Remove this user">
					<span class="glyphicon glyphicon-home"></span> Nuevo local
				</button>
				<!-- 
				<tr>
					<td width="47">Nombre:</td>
					<td width="46"><input type="text" name="nombre" /></td>
				</tr>
				<tr>
					<td width="69">Password:</td>
					<td width="46"><input type="password" name="password" /></td>
				</tr>
				<tr>
					<td width="69">Confirmar password:</td>
					<td width="46"><input type="password" name="passwordConf" /></td>
				</tr>
				<tr>
					<td width="46">Tipo Comida</td>
					<td width="46"><select name="idTipoComida">
							<?php foreach ($tiposComida as $linea): ?>
							<option value="<? echo $linea->id_tipo_comida; ?>">
								<? echo $linea->tipo_comida; ?>
							</option>
							<?php endforeach; ?>
					</select>
					</td>
				</tr>
				<tr>
					<td width="47">Localidad:</td>
					<td width="46"><input type="text" name="localidad" /></td>
				</tr>
				<tr>
					<td width="69">Telefono</td>
					<td width="46"><input type="text" name="telefono" /></td>
				</tr>
				<tr>
					<td width="47">Provincia:</td>
					<td width="46"><input type="text" name="provincia" /></td>
				</tr>
				<tr>
					<td width="47">Dirección:</td>
					<td width="46"><input type="text" name="direccion" /></td>
				</tr>
				<tr>
					<td width="47">Codigo postal:</td>
					<td width="46"><input type="text" name="codigoPostal" /></td>
				</tr>
				<tr>
					<td width="69">Email:</td>
					<td width="46"><input type="text" name="email" /></td>
				</tr>
				<tr>
					<td width="51" colspan="2" align="center"><input type="submit"
						value="Crear nuevo Local" />
					</td>
				</tr> -->
			</form>
		</div>
	</div>
</div>
