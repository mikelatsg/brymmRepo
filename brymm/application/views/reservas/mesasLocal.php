<div id="tiposMenuLocal" class="panel panel-default">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">Mesas local</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-4">
			<div id="altaMesasPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#altaMesas"
							class="accordion-toggle collapsed">Alta mesas </a>
					</h4>
				</div>
				<div id="altaMesas" class="panel-body collapse sub-panel">
					<form id="formAltaMesasLocal" class="form-horizontal">
						<div class="form-group">
							<label for="nombreMesa" class="col-sm-4 control-label">Nombre
								mesa</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="nombreMesa"
									placeholder="Nombre mesa" name="nombreMesa">
							</div>
						</div>
						<div class="form-group">
							<label for="capacidad" class="col-sm-4 control-label">Capacidad</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="capacidad"
									placeholder="Capacidad" name="capacidad">
							</div>
						</div>						
					</form>
					<span class="pull-right">
						<button class="btn btn-success" type="button"
							data-toggle="tooltip" data-original-title="Edit this user"
							onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/reservas/anadirMesaLocal','formAltaMesasLocal','listaMesasLocal',1)"
					                           ?>">
							<span class="glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div id="listaMesasPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#listaMesasLocal"
							class="accordion-toggle collapsed">Lista mesas </a>
					</h4>
				</div>
				<div id="listaMesasLocal" class="panel-body collapse sub-panel">
				<?php foreach ($mesasLocal as $mesa): ?>
					<div class="well col-md-6">
						<div class="span6">
							<table
								class="table table-condensed table-responsive table-user-information">
								<tbody>
									<tr>
										<td class="titulo">Nombre mesa</td>
										<td><?php echo  $mesa->nombre_mesa; ?></td>
									</tr>
									<tr>
										<td class="titulo">Capacidad</td>
										<td><?php echo   $mesa->capacidad; ?></td>
									</tr>									
								</tbody>
							</table>
							<span class="pull-right">
								<button class="btn btn-danger btn-sm" type="button"
									data-toggle="tooltip" data-original-title="Edit this user"
									onclick="<?php
                           echo "doAjax('" . site_url() . "/reservas/borrarMesaLocal','idMesaLocal="
				. $mesa->id_mesa_local . "','listaMesasLocal','post',1)"
					                           ?>">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							</span>
						</div>
					</div>
					<?php endforeach;?>
					<!--  <ul>
						<?php foreach ($mesasLocal as $mesa): ?>
						<li><?php echo $mesa->nombre_mesa . " - " . $mesa->capacidad ?> <a
							onclick="<?php
                echo "doAjax('" . site_url() . "/reservas/borrarMesaLocal','idMesaLocal="
                . $mesa->id_mesa_local . "','listaMesasLocal','post',1)";
                ?>"> B </a>
						</li>
						<?php endforeach; ?>
					</ul>-->
				</div>
			</div>
		</div>
	</div>
</div>
