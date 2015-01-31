<div>
	<div id="comandasPanel" class="panel panel-default col-md-12">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">Comandas</h4>
		</div>
		<div class="panel-body panel-verde">
			<div class="col-md-4">
				<div id="camandasActivasPanel" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaComandasActivas"
								class="accordion-toggle collapsed">Comandas activas</a>
						</h4>
					</div>
					<div id="listaComandasActivas"
						class="panel-body collapse sub-panel">
						<?php $hayComandasActivas = false;
						foreach ($comandasActivas as $comandaActiva):
					 $hayComandasActivas = true;?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td colspan="3">Comanda <?php echo $comandaActiva->id_comanda;?>
											<button class="btn btn-danger btn-sm pull-right"
												type="button" data-toggle="tooltip"
												data-original-title="Remove this user"
												onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/cancelarComandaCamarero','idComanda="
                . $comandaActiva->id_comanda . "','listaComandas','post',1)";
                ?>">
												<span class="glyphicon glyphicon-remove"></span>
											</button>
											<button class="btn btn-warning btn-sm pull-right"
												type="button" data-toggle="tooltip"
												data-original-title="Remove this user"
												onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/cerrarComandaCamarero','idComanda="
                . $comandaActiva->id_comanda . "','listaComandas','post',1)";
                ?>">
												<span class="glyphicon glyphicon-check"></span>
											</button>
											<button class="btn btn-default btn-sm pull-right"
												type="button" data-toggle="tooltip"
												data-original-title="Remove this user"
												onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comandaActiva->id_comanda . "','mostrarComandaRealizada','post',1)";
                ?>">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php echo $comandaActiva->nombreCamarero;?> <i
											class="fa fa-user"></i></td>
										<td><?php echo $comandaActiva->precio;?> <i class="fa fa-euro">
										
										</td>
										<td><?php if ($comandaActiva->id_mesa == 0) {
											echo $comandaActiva->destino;
										} else {
                    echo $comandaActiva->nombreMesa;
                }?> <i class="fa fa-flag">
										
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php
						endforeach;
						?>
					</div>
				</div>
				<div id="camandasCerradasPanel"
					class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="#listaComandasCerradas"
								class="accordion-toggle collapsed">Comandas cerradas</a>
						</h4>
					</div>
					<div id="listaComandasCerradas"
						class="panel-body collapse sub-panel">
						<?php foreach ($comandasCerradas as $comandaCerrada): ?>
						<div class="col-md-12 list-div">
							<table class="table">
								<tbody>
									<tr>
										<td colspan="3">Comanda <?php echo $comandaCerrada->id_comanda;?>
											<button class="btn btn-default btn-sm pull-right"
												type="button" data-toggle="tooltip"
												data-original-title="Remove this user"
												onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comandaCerrada->id_comanda . "','mostrarComandaRealizada','post',1)";
                ?>">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
										</td>
									</tr>
									<tr>
										<td><?php echo $comandaCerrada->nombreCamarero;?> <i
											class="fa fa-user"></i></td>
										<td><?php echo $comandaCerrada->precio;?> <i
											class="fa fa-euro">
										
										</td>
										<td><?php if ($comandaCerrada->id_mesa == 0) {
											echo $comandaCerrada->destino;
										} else {
                    echo $comandaCerrada->nombreMesa;
                }?> <i class="fa fa-flag">
										
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- <li><?php
						echo $comandaCerrada->id_comanda . " - ";
						if ($comandaCerrada->id_mesa == 0) {
                    echo $comandaCerrada->destino;
                } else {
                    echo $comandaCerrada->nombreMesa;
                }
                echo "-" . $comandaCerrada->nombreCamarero
                . "-" . $comandaCerrada->precio . "-" . $comandaCerrada->estado . "-"
								. $comandaCerrada->fecha_alta;
                ?> <a
							onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comandaCerrada->id_comanda . "','mostrarComandaRealizada','post',1)";
                ?>
                   "> Ver </a>
						</li> -->
						<?php
						endforeach;
						?>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div id="detalleComandaPanel" class="panel panel-default sub-panel">
					<div class="panel-heading panel-verde">
						<h4 class="panel-title">Detalle comanda</h4>
					</div>
					<div class="panel-body sub-panel" class="panel-body sub-panel">
						<div id="mostrarComanda">							
								<?php
								$existeComanda = false;
								$existeArticuloPer = false;
								$existeArticulo = false;
								$existeCarta = false;
								$existeMenu = false;
								$articulos = "";
								$articulosPer = "";
								$menus = "";
								$cartas = "";
								$detalleComanda = "";
								foreach ($comanda as $linea) {
									$existeComanda = true;

									/*$detalleComanda = $linea['name'] . " - " . $linea['qty'] . " - " . $linea['price'];
									 $detalleComanda .= htmlentities("<a onclick=\"doAjax('" .
									 		site_url() . "/comandas/borrarArticuloComanda','rowid=" .
									 		$linea['rowid'] . "','mostrarComanda','post',1)\"> X </a>");*/

									//Articulo
									if ($linea['options']['idTipoComanda'] == 1) {
										if (!$existeArticulo) {
											$articulos = htmlentities("<span class=\"col-md-12\">");
											$articulos .= htmlentities("<span class=\"badge progress-bar-danger\">" . $linea['options']['tipoComanda'] . "</span>");
											$articulos .= htmlentities("</span>");
											$articulos .= htmlentities("<div class=\"well col-md-12\">");
											$articulos .= htmlentities("<table class=\"table table-condensed table-responsive table-user-information\">");
											$articulos .= htmlentities("<tbody>");
										}
										$detalleComanda = "";
										//Nombre
										$detalleComanda .= htmlentities("<tr> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= "Nombre";
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= $linea['name'];
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= htmlentities("<button class=\"btn btn-danger btn-sm pull-right\"
												type=\"button\" data-toggle=\"tooltip\"
												data-original-title=\"Remove this user\"
												onclick=\"doAjax('" .
												site_url() . "/comandas/borrarArticuloComanda','rowid=" .
												$linea['rowid'] . "','mostrarComanda','post',1)\"> <span class=\"glyphicon glyphicon-remove\"></span>
												</button>");
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("</tr> ");

										//Cantidad
										$detalleComanda .= htmlentities("<tr> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= "Cantidad";
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("<td colspan=\"2\"> ");
										$detalleComanda .= $linea['qty'];
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("</tr> ");

										//Precio
										$detalleComanda .= htmlentities("<tr> ");
										$detalleComanda .= htmlentities("<td class=\"separadorArticulo\"> ");
										$detalleComanda .= "Precio";
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("<td colspan=\"2\" class=\"separadorArticulo\"> ");
										$detalleComanda .= $linea['price'];
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("</tr> ");

										$articulos .= $detalleComanda;
										$existeArticulo = true;

										//echo "<br>";
									}

									//Articulo personalizado
									if ($linea['options']['idTipoComanda'] == 2) {
										if (!$existeArticuloPer) {
											//$articulosPer = htmlentities("<h4>" . $linea['options']['tipoComanda'] . "</h4>");

											$articulosPer = htmlentities("<span class=\"col-md-12\">");
											$articulosPer .= htmlentities("<span class=\"badge progress-bar-danger\">" . $linea['options']['tipoComanda'] . "</span>");
											$articulosPer .= htmlentities("</span>");
											$articulosPer .= htmlentities("<div class=\"well col-md-12\">");
											$articulosPer .= htmlentities("<table class=\"table table-condensed table-responsive table-user-information\">");
											$articulosPer .= htmlentities("<tbody>");
										}

										$detalleComanda = "";
										//Nombre
										$detalleComanda .= htmlentities("<tr> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= "Nombre";
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= $linea['name'];
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= htmlentities("<button class=\"btn btn-danger btn-sm pull-right\"
												type=\"button\" data-toggle=\"tooltip\"
												data-original-title=\"Remove this user\"
												onclick=\"doAjax('" .
												site_url() . "/comandas/borrarArticuloComanda','rowid=" .
												$linea['rowid'] . "','mostrarComanda','post',1)\"> <span class=\"glyphicon glyphicon-remove\"></span>
												</button>");
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("</tr> ");

										//Cantidad
										$detalleComanda .= htmlentities("<tr> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= "Cantidad";
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("<td colspan=\"2\"> ");
										$detalleComanda .= $linea['qty'];
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("</tr> ");

										//Precio
										$detalleComanda .= htmlentities("<tr> ");
										$detalleComanda .= htmlentities("<td> ");
										$detalleComanda .= "Precio";
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("<td colspan=\"2\"> ");
										$detalleComanda .= $linea['price'];
										$detalleComanda .= htmlentities("</td> ");
										$detalleComanda .= htmlentities("</tr> ");

										$articulosPer .= $detalleComanda;

										$existeArticuloPer = true;
										$i = 0;
										$articulosPer .= htmlentities("<tr>");
										$articulosPer .= htmlentities("<td>");
										$articulosPer .= "Tipo articulo";
										$articulosPer .= htmlentities("</td>");
										$articulosPer .= htmlentities("<td colspan=\"2\">");
										$articulosPer .= $linea['options']['tipoArticulo'];
										$articulosPer .= htmlentities("</td>");
										$articulosPer .= htmlentities("</tr>");

										$articulosPer .= htmlentities("<tr>");
										$articulosPer .= htmlentities("<td class=\"separadorArticulo\">");
										$articulosPer .= "Ingredientes";
										$articulosPer .= htmlentities("</td>");
										$articulosPer .= htmlentities("<td colspan=\"2\" class=\"separadorArticulo\">");
										foreach ($linea['options']['ingredientes'] as $ingredientes) {
									if ($i > 0) {
										$articulosPer .= ", ";
									}
									$articulosPer .= $ingredientes['ingrediente'];
									$i += 1;
								}

								$articulosPer .= htmlentities("</td>");
								$articulosPer .= htmlentities("</tr>");
									}

									//Menu
									if ($linea['options']['idTipoComanda'] == 3) {
								if (!$existeMenu) {
									//$menus = htmlentities("<h4>" . $linea['options']['tipoComanda'] . "</h4>");
									$menus = htmlentities("<span class=\"col-md-12\">");
									$menus .= htmlentities("<span class=\"badge progress-bar-danger\">" . $linea['options']['tipoComanda'] . "</span>");
									$menus .= htmlentities("</span>");
									$menus .= htmlentities("<div class=\"well col-md-12\">");
									$menus .= htmlentities("<table class=\"table table-condensed table-responsive table-user-information\">");
									$menus .= htmlentities("<tbody>");
								}

								//$menus .= htmlentities("<li> ");

								$detalleComanda = "";
								//Nombre
								$detalleComanda .= htmlentities("<tr> ");
								$detalleComanda .= htmlentities("<td> ");
								$detalleComanda .= "Menu";
								$detalleComanda .= htmlentities("</td> ");
								$detalleComanda .= htmlentities("<td> ");
								$detalleComanda .= $linea['name'];
								$detalleComanda .= htmlentities("</td> ");
								$detalleComanda .= htmlentities("<td> ");
								$detalleComanda .= htmlentities("<button class=\"btn btn-danger btn-sm pull-right\"
										type=\"button\" data-toggle=\"tooltip\"
										data-original-title=\"Remove this user\"
										onclick=\"doAjax('" .
										site_url() . "/comandas/borrarArticuloComanda','rowid=" .
										$linea['rowid'] . "','mostrarComanda','post',1)\"> <span class=\"glyphicon glyphicon-remove\"></span>
										</button>");
								$detalleComanda .= htmlentities("</td> ");
								$detalleComanda .= htmlentities("</tr> ");

								//Cantidad
								$detalleComanda .= htmlentities("<tr> ");
								$detalleComanda .= htmlentities("<td> ");
								$detalleComanda .= "Cantidad";
								$detalleComanda .= htmlentities("</td> ");
								$detalleComanda .= htmlentities("<td colspan=\"2\"> ");
								$detalleComanda .= $linea['qty'];
								$detalleComanda .= htmlentities("</td> ");
								$detalleComanda .= htmlentities("</tr> ");

								//Precio
								$detalleComanda .= htmlentities("<tr> ");
								$detalleComanda .= htmlentities("<td class=\"separadorMenuPlato\"> ");
								$detalleComanda .= "Precio";
								$detalleComanda .= htmlentities("</td> ");
								$detalleComanda .= htmlentities("<td colspan=\"2\" class=\"separadorMenuPlato\"> ");
								$detalleComanda .= $linea['price'];
								$detalleComanda .= htmlentities("</td> ");
								$detalleComanda .= htmlentities("</tr> ");

								$menus .= $detalleComanda;

								$existeMenu = true;
								$i = 0;
								foreach ($linea['options']['platosMenu'] as $plato) {
										$menus .= htmlentities("<tr> ");
										$menus .= htmlentities("<td> ");
										$menus .= "Plato";
										$menus .= htmlentities("</td> ");
										$menus .= htmlentities("<td colspan=\"2\"> ");
										$menus .= $plato['nombrePlato'];
										$menus .= htmlentities("</td> ");
										$menus .= htmlentities("</tr> ");

										$menus .= htmlentities("<tr> ");
										$menus .= htmlentities("<td class=\"separadorPlato\"> ");
										$menus .= "Cantidad";
										$menus .= htmlentities("</td> ");
										$menus .= htmlentities("<td colspan=\"2\" class=\"separadorPlato\"> ");
										$menus .= $plato['platoCantidad'];
										$menus .= htmlentities("</td> ");
										$menus .= htmlentities("</tr> ");

										/*$menus .= htmlentities("<li>");
										 $menus .= $plato['nombrePlato'];
										$menus .= htmlentities("</li>");*/
										$i += 1;
								}
								if ($i > 0) {
									$menus .= htmlentities("</ul>");
								}
								//$menus .= htmlentities("</li>");
							}

							//Carta
							if ($linea['options']['idTipoComanda'] == 4) {
								if (!$existeCarta) {
									$cartas = htmlentities("<h4>" . $linea['options']['tipoComanda'] . "</h4>");
								}
								$cartas .= htmlentities("<li>");
								$cartas .= $detalleComanda;
								$cartas .= htmlentities("</li>");
								$existeCarta = true;
							}
								}

								//Cierro el div y la tabla
								if ($existeArticulo){
							$articulos .= htmlentities("</tbody>");
							$articulos .= htmlentities("</table>");
							$articulos .= htmlentities("</div>");
						}

						//Cierro el div y la tabla
						if ($existeArticuloPer){
							$articulosPer .= htmlentities("</tbody>");
							$articulosPer .= htmlentities("</table>");
							$articulosPer .= htmlentities("</div>");
						}

						//Cierro el div y la tabla
						if ($existeMenu){
							$menus .= htmlentities("</tbody>");
							$menus .= htmlentities("</table>");
							$menus .= htmlentities("</div>");
						}

						//Se muestran los datos
						echo html_entity_decode("<div class=\"col-md-8\">");
						echo html_entity_decode($articulos);
						echo html_entity_decode($articulosPer);
						echo html_entity_decode($menus);
						echo html_entity_decode($cartas);
						echo html_entity_decode("</div>");

						if ($existeComanda) {
						echo "Total : " . $precioTotalComanda;
						echo "<br>";
						echo "<a onclick=\"doAjax('" . site_url() .
						"/comandas/cancelarComanda','','mostrarComanda','post',1)\">" .
						"Cancelar</a>";
        }
        ?>							
						</div>
						<div class="col-md-12 well">
							<form id="formAceptarComanda" class="form-horizontal">
								<div class="col-md-6">
									<div class="form-group">
										<label for="paraLlevar" class="col-sm-4 control-label">Para
											llevar </label>
										<div class="col-sm-8">
											<input type="radio" name="localLlevar" id="comandaParaLlevar"
												value="0" class="pull-left"
												onchange="<?php echo "gestionDestinoComanda()";?>">
										</div>

									</div>
									<div class="form-group">
										<label for="aNombre" class="col-sm-4 control-label">A nombre
											de </label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="aNombre"
												placeholder="A nombre de" name="aNombre">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="comandaLocal" class="col-sm-4 control-label">Local
										</label>
										<div class="col-sm-8">
											<input type="radio" name="localLlevar" id="comandaLocal"
												value="1" class="pull-left" checked
												onchange="<?php echo "gestionDestinoComanda()";?>">
										</div>
									</div>
									<div class="form-group">
										<label for="idMesaLocal" class="col-sm-4 control-label">Mesa</label>
										<div class="col-sm-8">
											<select name="idMesaLocal" id="idMesaLocal" class="pull-left">
												<?php foreach ($mesasLocal as $mesa): ?>
												<option class="form-control"
													value="<?php echo $mesa->id_mesa_local; ?>">
													<?php echo $mesa->nombre_mesa; ?>
												</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="observaciones" class="col-sm-2 control-label">Observaciones
										</label>
										<div class="col-sm-10">
											<textarea class="form-control" id="observaciones"
												placeholder="Observaciones" name="observaciones"></textarea>
										</div>
									</div>
									<span>
										<button class="btn btn-success" type="button"
											data-toggle="tooltip" data-original-title="Edit this user"
											onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/comandas/aceptarComanda','formAceptarComanda','mostrarComandasActivas',1)"
                           ?>">
											<span class="glyphicon glyphicon-plus"></span>
										</button> <?php if ($hayComandasActivas):?> <label
										for="cmbComandasActivas" class="control-label">Añadir a
											comanda</label> <select name="idComandaAbierta"
										id="cmbComandasActivas">
											<?php foreach ($comandasActivas as $comanda): ?>
											<option class="form-control"
												value="<?php echo $comanda->id_comanda ?>">
												<?php echo $comanda->id_comanda; ?>
											</option>
											<?php endforeach; ?>
									</select>
										<button class="btn btn-success" type="button"
											data-toggle="tooltip" data-original-title="Edit this user"
											onclick="<?php
                           echo "enviarFormulario('" . site_url() .
                           "/comandas/anadirComanda','formAceptarComanda','mostrarComandasActivas',1)"
                           ?>">
											<span class="glyphicon glyphicon-import"> </span>
										</button> <?php endif;?>


									</span>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
