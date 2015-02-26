
<div id="mostrarLocal">
	<div class="panel panel-default">
		<div class="panel-body">
			<div id="datosLocal" class="row">
				<div class="col-md-5">
					<h1>
						<span class="label label-primary"><?php	
						echo $datosLocal->nombre;?> <?php
						if (isset($_SESSION['idUsuario'])):
						if ($esFavorito):
						?> <a
							onclick="
					    <?php
					    echo "doAjax('" . site_url() . "/locales/quitarLocalFavorito','idLocal="
					    . $datosLocal->id_local . "','','post',1)";
					    ?>"> <i class="fa fa-star starColor fa-2x"
								title="Eliminar favorito"></i>
						</a> <?php
					    else:?> <a
							onclick="
					    <?php
					    echo "doAjax('" . site_url() . "/locales/anadirLocalFavorito','idLocal="
					    . $datosLocal->id_local . "','','post',1)";
					    ?>"> <i class="fa fa-star-o starColor fa-2x"
								title="Agregar a favoritos"></i>
						</a> <?php
						endif;
						endif;
						?> </span>
					</h1>
				</div>
				<div class="col-md-7 well">
					<table
						class="table table-condensed table-responsive table-user-information">
						<tbody>
							<tr>
								<td class="titulo">Localidad</td>
								<td><?php echo $datosLocal->localidad;?></td>
							</tr>
							<tr>
								<td class="titulo">Direccion</td>
								<td colspan="3"><?php echo $datosLocal->direccion;?></td>
							</tr>
							<tr>
								<td class="titulo">Provincia</td>
								<td><?php echo $datosLocal->provincia;?></td>
								<td class="titulo">Codigo postal</td>
								<td><?php echo $datosLocal->cod_postal;?></td>
							</tr>
							<tr>
								<td class="titulo">Tlf</td>
								<td><?php echo $datosLocal->telefono;?></td>
								<td class="titulo">Email</td>
								<td><?php echo $datosLocal->email;?></td>
							</tr>
							<tr>
								<td class="titulo">Tipo de comida</td>
								<td><?php echo $datosLocal->tipo_comida;?></td>
							</tr>

						</tbody>
					</table>
				</div>
			</div>
			<div>
				<nav class="navbar navbar-default serviciosLocal">
					<ul class="nav nav-justified">
						<?php            
						foreach ($serviciosLocal as $linea) {
							switch ($linea->id_tipo_servicio_local) {
								case 1:
									if ($linea->activo) {
										if ($idTipoServicio == 1){
											echo "<li class=\"activo\">";
										}else{
											echo "<li>";
										}?>
						<a
							href="<?php echo site_url();?>/locales/mostrarLocal/<?php echo $linea->id_local . '/' . $linea->id_tipo_servicio_local;?>"><i
							class="fa fa-file-text-o"> </i> Pedidos</a>
						<?php 						
									}
									break;
								case 3:
									if ($linea->activo) {
										if ($idTipoServicio == 3){
											echo "<li class=\"activo\">";
										}else{
											echo "<li>";
										}?>
						<a
							href="<?php echo site_url();?>/locales/mostrarLocal/<?php echo $linea->id_local . '/' . $linea->id_tipo_servicio_local;?>"><i
							class="fa fa-calendar"> </i> Reservas</a>
						<?php
										//echo anchor('/locales/mostrarLocal/' . $linea->id_local . '/' . $linea->id_tipo_servicio_local, 'Reservas');
									}
									break;
								case 4:
									if ($linea->activo) {
										if ($idTipoServicio == 4){
											echo "<li class=\"activo\">";
										}else{
											echo "<li>";
										}?>
						<a
							href="<?php echo site_url();?>/locales/mostrarLocal/<?php echo $linea->id_local . '/' . $linea->id_tipo_servicio_local;?>"><i
							class="fa fa-cutlery"> </i> Menus</a>
						<?php
										//echo anchor('/locales/mostrarLocal/' . $linea->id_local . '/' . $linea->id_tipo_servicio_local, 'Menus');
									}
									break;
							}
							echo "</li>";
						}
						?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>

