<div>
	<div id="ultimosLocales" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title small-title">
				<i class="fa fa-home"></i> Ultimos locales
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="slider4">
				<?php foreach($ultimosLocales as $local):?>
				<div class="slide">
					<div id="itemUltimoLocal" class="itemLocal">
						<div class="row">
							<a
								href="<?php echo site_url();?>/locales/mostrarLocal/<?php echo $local->local->idLocal;?>">
								<h4>
									<?php echo $local->local->nombre;?>
								</h4>
							</a>
						</div>
						<div class="row">
							Tipo comida :
							<?php echo $local->local->tipoComida->tipoComida;?>
						</div>
						<div class="row">
							Localidad :
							<?php echo $local->local->localidad;?>
						</div>
						<div class="row">
							Provincia :
							<?php echo $local->local->provincia;?>
						</div>
						<?php $hayPedidos = false;
						$hayEnvio = false;
						$hayMenus = false;
						foreach($local->serviciosLocal as $servicio):
						if($servicio->tipoServicio->idTipoServicio == 1):
						if($servicio->activo == 1):
						$hayPedidos = true;
						endif;
						endif;
						if($servicio->tipoServicio->idTipoServicio == 2):
						if($servicio->activo == 1):
						$hayEnvio = true;
						endif;
						endif;
						if($servicio->tipoServicio->idTipoServicio == 4):
						if($servicio->activo == 1):
						$hayMenus = true;
						endif;
						endif;
						endforeach;?>
						<table
							class="table table-condensed table-responsive table-user-information">
							<tbody>
								<tr>
									<td><?php if ($hayPedidos):?> <span
										class="glyphicon glyphicon-shopping-cart green"
										title="Se pueden realizar pedidos"></span> <?php else:?> <span
										class="glyphicon glyphicon-shopping-cart red"
										title="No se pueden realizar pedidos"></span> <?php endif;?></td>
									<td><?php if ($hayEnvio):?> <span
										class="glyphicon glyphicon-send green"
										title="Hay envio a domicilio"></span> <?php else:?> <span
										class="glyphicon glyphicon-send red"
										title="No hay envio a domicilio"></span> <?php endif;?></td>
									<td><?php if ($hayMenus):?> <span
										class="glyphicon glyphicon-cutlery green" title="Hay menus"></span>
										<?php else:?> <span class="glyphicon glyphicon-cutlery red"
										title="No hay menus"></span> <?php endif;?></td>
								</tr>
							</tbody>
						</table>
						<!-- <div class="itemLocalServicios">
							<div class="col-md-4">
								<?php if ($hayPedidos):?>
								<span class="glyphicon glyphicon-shopping-cart green"
									title="Se pueden realizar pedidos"></span>
								<?php else:?>
								<span class="glyphicon glyphicon-shopping-cart red"
									title="No se pueden realizar pedidos"></span>
								<?php endif;?>
							</div>
							<div class="col-md-4">
								<?php if ($hayEnvio):?>
								<span class="glyphicon glyphicon-send green"
									title="Hay envio a domicilio"></span>
								<?php else:?>
								<span class="glyphicon glyphicon-send red"
									title="No hay envio a domicilio"></span>
								<?php endif;?>
							</div>
							<div class="col-md-4">
								<?php if ($hayMenus):?>
								<span class="glyphicon glyphicon-cutlery green"
									title="Hay menus"></span>
								<?php else:?>
								<span class="glyphicon glyphicon-cutlery red"
									title="No hay menus"></span>
								<?php endif;?>
							</div>
						</div> -->
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
