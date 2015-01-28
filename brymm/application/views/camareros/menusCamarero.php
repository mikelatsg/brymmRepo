<div id="menusCamareroPanel" class="panel panel-default col-md-6">
	<div class="panel-heading panel-verde">
		<h4 class="panel-title">Menus</h4>
	</div>
	<div class="panel-body panel-verde">
		<div class="col-md-12">
			<div id="articulosPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#menusCamarero"
							class="accordion-toggle collapsed">Menu</a>
					</h4>
				</div>
				<div id="menusCamarero" class="panel-body collapse sub-panel">
					<form id="anadirMenuComanda" class="form-horizontal">
						<?php														
						foreach ($menusDia as $menu) :
						if (!$menu['esCarta']):
						?>
						<h3 id="tituloMenu_<?php echo $menu['idTipoMenuLocal'];?>">
							<span class="label label-default"> <?php echo $menu['nombreMenu'];?>
							</span>
						</h3>
						<div class="well"
							id="platosMenu_<?php echo $menu['idTipoMenuLocal'];?>">
							<table
								class="table table-condensed table-responsive table-user-information">
								<tbody>
									<?php
									$idTipoPlatoAnterior = 0;
									foreach ($menu["detalleMenu"] as $plato) :
									if ($plato['idTipoPlato'] != $idTipoPlatoAnterior):?>
									<tr>
										<td colspan="4"><h4
												id="tituloMenu_<?php echo $menu['idTipoMenuLocal'];?>">
												<span class="label label-danger"> <?php echo $plato['tipoPlato'];?>
												</span>
											</h4></td>
									</tr>
									<?php endif;?>
									<tr>
										<td class="titulo">Plato</td>
										<td><?php echo $plato['nombrePlato']?></td>
										<td><select
											name="platoCantidad_<?php echo $plato['idPlatoLocal']; ?>"
											id="platoCantidad_<?php echo $plato['idPlatoLocal'] ?>">
												<option class="form-control" value="0">0</option>
												<option class="form-control" value="1">1</option>
												<option class="form-control" value="2">2</option>
												<option class="form-control" value="3">3</option>
												<option class="form-control" value="4">4</option>
												<option class="form-control" value="5">5</option>
												<option class="form-control" value="6">6</option>
												<option class="form-control" value="7">7</option>
												<option class="form-control" value="8">8</option>
												<option class="form-control" value="9">9</option>
												<option class="form-control" value="10">10</option>
												<option class="form-control" value="11">11</option>
												<option class="form-control" value="12">12</option>
												<option class="form-control" value="13">13</option>
												<option class="form-control" value="14">14</option>
												<option class="form-control" value="15">15</option>
												<option class="form-control" value="16">16</option>
												<option class="form-control" value="17">17</option>
												<option class="form-control" value="18">18</option>
												<option class="form-control" value="19">19</option>
												<option class="form-control" value="20">20</option>
												<option class="form-control" value="21">21</option>
												<option class="form-control" value="22">22</option>
												<option class="form-control" value="23">23</option>
												<option class="form-control" value="24">24</option>
												<option class="form-control" value="25">25</option>
										</select></td>
										<td><a
											onclick="
                                <?php
                                echo "enviarArticuloComanda('" . site_url() . "/comandas/anadirPlatoMenuComanda','idPlatoLocal="
                                . $plato['idPlatoLocal'] . "&idTipoMenuLocal=" . $menu['idTipoMenuLocal']
                                . "','platoCantidad_" . $plato['idPlatoLocal']
                                . "','mostrarComanda',1)";
                                ?>
                                   "> Anadir a menu </a>
										</td>

									</tr>
									<?php
									$idTipoPlatoAnterior = $plato['idTipoPlato'];
									endforeach;?>
								</tbody>
							</table>
						</div>
						<?php						
						endif;
						endforeach;?>

						<div class="well">
							<table
								class="table table-condensed table-responsive table-user-information">
								<tbody>
									<tr>
										<td class="titulo">Menu</td>
										<td><select name="idTipoMenuLocal" id="idTipoMenuLocal"
											onchange="<?php echo "gestionMenuSeleccionado()";?>">
												<?php foreach ($menusDia as $menu): 
									if ($menu['esCarta'] == 0 ):?>
												<option class="form-control"
													value="<?php echo $menu['idTipoMenuLocal']; ?>">
													<?php echo $menu['nombreMenu'] . " [" . $menu['precioMenu'] . " € ]" ?>
												</option>
												<?php
												endif;
									endforeach; ?>
										</select>
										</td>
									</tr>
									<tr>
										<td class="titulo">Cantidad</td>
										<td><select name="menuCantidad" id="menuCantidad">
												<option class="form-control" value="1">1</option>
												<option class="form-control" value="2">2</option>
												<option class="form-control" value="3">3</option>
												<option class="form-control" value="4">4</option>
												<option class="form-control" value="5">5</option>
												<option class="form-control" value="6">6</option>
												<option class="form-control" value="7">7</option>
												<option class="form-control" value="8">8</option>
												<option class="form-control" value="9">9</option>
												<option class="form-control" value="10">10</option>
												<option class="form-control" value="11">11</option>
												<option class="form-control" value="12">12</option>
												<option class="form-control" value="13">13</option>
												<option class="form-control" value="14">14</option>
												<option class="form-control" value="15">15</option>
												<option class="form-control" value="16">16</option>
												<option class="form-control" value="17">17</option>
												<option class="form-control" value="18">18</option>
												<option class="form-control" value="19">19</option>
												<option class="form-control" value="20">20</option>
												<option class="form-control" value="21">21</option>
												<option class="form-control" value="22">22</option>
												<option class="form-control" value="23">23</option>
												<option class="form-control" value="24">24</option>
												<option class="form-control" value="25">25</option>
										</select>
										</td>
									</tr>
									<tr>
										<td colspan="2"><span class="pull-right">
												<button class="btn btn-success" type="button"
													data-toggle="tooltip" data-original-title="Edit this user"
													onclick="<?php
                           echo  "enviarFormulario('" . site_url() .
							"/comandas/anadirMenuComanda','anadirMenuComanda','mostrarComanda',1)"
					                           ?>">
													<span class="glyphicon glyphicon-plus"></span>
												</button>
										</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</form>
				</div>
			</div>
			<div id="cartaPanel" class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-target="#cartaCamarero"
							class="accordion-toggle collapsed">Carta</a>
					</h4>
				</div>
				<div id="cartaCamarero" class="panel-body collapse sub-panel">
					<ul>
						<?php
						foreach ($menusDia as $menu) :
						if ($menu['esCarta']):
						$idTipoPlato = 0;
						echo"<h4>";
						echo $menu['nombreMenu'];
						echo"</h4>";
						foreach ($menu["detalleMenu"] as $plato) :
						if ($idTipoPlato != $plato['idTipoPlato']) {
                        echo $plato['tipoPlato'];
                    }
                    $idTipoPlato = $plato['idTipoPlato'];
                    ?>

						<li><?php echo $plato['nombrePlato'] . "-" . $plato['precioPlato'] ?>
							<br>Cantidad <input type="text" size="2" maxlength="2" value="1"
							id="<?php echo "cantidadPL" . $plato['idPlatoLocal'] ?>"> <a
							onclick="<?php
                        echo "enviarArticuloComanda('" . site_url()
                        . "/comandas/anadirPlatoComanda','idPlatoLocal="
                        . $plato['idPlatoLocal'] . "&precioPlato="
                        . $plato['precioPlato']
                        . "&nombrePlato=" . $plato['nombrePlato'] .
                        "','cantidadPL" . $plato['idPlatoLocal']
                        . "','mostrarComanda',1)";
                        ?>"> + </a></li>
						<?php
						endforeach;
						endif;
						endforeach;
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
