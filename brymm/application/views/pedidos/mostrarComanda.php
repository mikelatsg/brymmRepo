<div>
	<div id="comandasLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">Comandas</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="comandasActivasCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaComandasActivas"
								class="accordion-toggle collapsed"> Comandas activas </a>
						</h4>
					</div>
					<div id="listaComandasActivas"
						class="panel-body collapse sub-panel">


						<?php foreach ($comandasActivas as $comanda): ?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td colspan="3">Comanda <?php echo $comanda->id_comanda;										
										if ($comanda->estado == "EC"):?>
											<button class="btn btn-success pull-right" type="button"
												data-toggle="tooltip" data-original-title="Remove this user"
												onclick="<?php
                    echo "doAjax('" . site_url() . "/comandas/terminarComandaCocina','idComanda="
                    . $comanda->id_comanda . "','listaComandasCocina','post',1)";
                ?>">
												<span class="glyphicon glyphicon-ok"></span>
											</button> <?php endif;?>
											<button class="btn btn-default pull-right" type="button"
												data-toggle="tooltip" data-original-title="Remove this user"
												onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','mostrarComandaRealizadaCocina','post',1)";
                ?>">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php echo $comanda->nombreCamarero;?>
										<i class="fa fa-user"></i>																			
										</td>
										<td><?php echo $comanda->precio." ";?><span
											class="glyphicon glyphicon-euro"></span>
										</td>
										<td><?php if ($comanda->id_mesa == 0) {
											echo $comanda->destino;
										} else {
                    echo $comanda->nombreMesa." ";
                }?><i class="fa fa-flag"></i></td>
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
								class="accordion-toggle collapsed"> Comandas cerradas </a>
						</h4>
					</div>
					<div id="listaComandasCerradas"
						class="panel-body collapse sub-panel">
						<ul>
							<?php foreach ($comandasCerradas as $comanda): ?>
							<li><?php
							echo $comanda->id_comanda . " - ";
							if ($comanda->id_mesa == 0) {
                    echo $comanda->destino;
                } else {
                    echo $comanda->nombreMesa;
                }
                echo "-" . $comanda->nombreCamarero
                . "-" . $comanda->precio . "-" . $comanda->estado . "-"
								. $comanda->fecha_alta;
                ?> <a
								onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','mostrarComandaRealizada','post',1)";
                ?>
                   "> Ver </a></li>
							<?php
							endforeach;
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<!-- <div id="tituloMostrarComanda">
					<h4>Comanda</h4>
				</div>
				 -->
				<div id="detalleComandaCab" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title sub-panel">Detalle Comanda</h4>
					</div>
					<div id="mostrarComanda" class="panel-body sub-panel"></div>
				</div>
			</div>
		</div>
	</div>
	
	
		