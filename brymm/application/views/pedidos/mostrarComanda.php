<div>
	<?php if (!$servicioComandasActivo):?>
	<div class="alert alert-danger" role="alert">El servicio de comandas
		est� desactivado</div>
	<?php endif;?>
	<div id="comandasLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-pencil"></i> Comandas
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="comandasActivasCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaComandasActivas"
								class="accordion-toggle collapsed"><i class="fa fa-unlock"></i>
								Comandas activas </a>
						</h4>
					</div>
					<div id="listaComandasActivas"
						class="panel-body collapse sub-panel altoMaximo">
						<?php foreach ($comandasActivas as $comanda): ?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td class="titulo" colspan="3">Comanda <?php echo $comanda->id_comanda;										
										if ($comanda->estado == "EC"):?>
											<button class="btn btn-success btn-sm pull-right"
												type="button" data-toggle="tooltip"
												data-original-title="Remove this user"
												onclick="<?php
                    echo "doAjax('" . site_url() . "/comandas/terminarComandaCocina','idComanda="
                    . $comanda->id_comanda . "','listaComandasCocina','post',1)";
                ?>"
												title="Terminar comanda">
												<span class="glyphicon glyphicon-ok"></span>
											</button> <?php endif;?>
											<button class="btn btn-default btn-sm pull-right"
												type="button" data-toggle="tooltip"
												data-original-title="Remove this user"
												onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','mostrarComandaRealizadaCocina','post',1)";
                ?>"
												title="Ver comanda">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php echo $comanda->nombreCamarero;?> <i
											class="fa fa-user"></i>
										</td>
										<td><?php echo $comanda->precio." ";?><span
											class="glyphicon glyphicon-euro"></span>
										</td>
										<td><?php if ($comanda->id_mesa == 0) {
											echo $comanda->destino;
											?> <i class="fa fa-flag" title="Destinatario"></i> <?php
										} else {
                    echo $comanda->nombreMesa." ";
                    ?> <i class="fa fa-flag" title="Mesa"></i> <?php
                }?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php endforeach;?>
					</div>
				</div>
				<div id="comandasCerradasCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaComandasCerradas"
								class="accordion-toggle collapsed"><i class="fa fa-lock"></i>
								Comandas cerradas </a>
						</h4>
					</div>
					<div id="listaComandasCerradas"
						class="panel-body collapse sub-panel altoMaximo">
						<?php foreach ($comandasCerradas as $comanda): ?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td class="titulo" colspan="3">Comanda <?php echo $comanda->id_comanda;?>
											<button class="btn btn-default btn-sm pull-right"
												type="button" data-toggle="tooltip"
												data-original-title="Remove this user"
												onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','mostrarComandaRealizada','post',1)";
                ?>"
												title="Ver comanda">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php echo $comanda->nombreCamarero;?> <i
											class="fa fa-user"></i>
										</td>
										<td><?php echo $comanda->precio." ";?><span
											class="glyphicon glyphicon-euro"></span>
										</td>
										<td><?php if ($comanda->id_mesa == 0) {
											echo $comanda->destino;
											?> <i class="fa fa-flag" title="Destinatario"></i> <?php
										} else {
                    echo $comanda->nombreMesa." ";
                    ?> <i class="fa fa-flag" title="Mesa"></i> <?php
                }?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php
						endforeach;
						?>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="detalleComandaCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<i class="fa fa-list"></i> Detalle Comanda
						</h4>
					</div>
					<div id="mostrarComanda" class="panel-body sub-panel altoMaximo"></div>
				</div>
			</div>
		</div>
	</div>