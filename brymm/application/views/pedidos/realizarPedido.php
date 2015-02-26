
<div class="col-md-7 noPadLeft">
	<div class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title"><i class="fa fa-shopping-cart"></i> Realizar pedido</h4>
		</div>
		<div id="realizarPedido" class="panel-body panel-verde">
			<?php
			if (isset($precioEnvioPedido)) :
			?>
			<div class="well">

				<div class="titulo col-md-4">Envio a domicilio:</div>
				<div class="titulo col-md-4">
					Importe minimo :
					<?php echo round($precioEnvioPedido->importe_minimo,2); ?>
					<i class="fa fa-euro"></i>
				</div>
				<div class="titulo col-md-4">
					Precio :
					<?php echo round($precioEnvioPedido->precio,2); ?>
					<i class="fa fa-euro"></i>
				</div>

			</div>
			<?php
			endif;
			?>

			<?php
			$idTipoArticulo = 0;
			?>
			<?php
			$vuelta = false;
			foreach ($articulosLocal as $linea):
			/*
			 * Se muestran los articulos validos para pedidos
			*/
			if ($linea['validoPedidos']):
			if ($linea['id_tipo_articulo'] <> $idTipoArticulo) :
			if ($vuelta){
					echo "</div></div>";
				}
				?>


			<div class="panel panel-default sub-panel">
				<div class="panel-heading panel-verde">
					<h4 class="panel-title">
						<a data-toggle="collapse"
							data-target="<?php echo "#".$linea['tipo_articulo'];?>"
							class="accordion-toggle collapsed"> <?php echo $linea['tipo_articulo'];?>
						</a>
					</h4>
				</div>
				<div id="<?php echo $linea['tipo_articulo'];?>"
					" class="panel-body collapse sub-panel altoMaximo">
					<?php 
					endif;
					?>
					<div class="well col-md-6">
						<table
							class="table table-condensed table-responsive table-user-information">
							<tbody>
								<tr>
									<td class="titulo text-center" colspan="2"><?php echo $linea['articulo']?>
									</td>
								</tr>
								<tr>
									<td class="titulo">Descripcion</td>
									<td><?php echo $linea['descripcion']?></td>
								</tr>
								<tr>
									<td class="titulo">Precio</td>
									<td><?php echo $linea['precio']?> <i class="fa fa-euro"></i></td>
								</tr>
								<tr>
									<td class="titulo">Cantidad</td>
									<td><form>
											<select value="1"
												id="<?php echo "art" . $linea['id_articulo_local'] ?>">
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
										</form></td>
								</tr>
								<tr>
									<td colspan="2"><span class="pull-right">
											<button class="btn btn-success btn-sm" type="button"
												data-toggle="tooltip" data-original-title="Edit this user"
												onclick="<?php
								                        echo "enviarArticuloPedido('" . site_url() . "/pedidos/anadirArticuloPedido','idArticuloLocal="
								                        . $linea['id_articulo_local'] . "&precio=" . $linea['precio']
								                        . "&articulo=" . $linea['articulo']
								                        . "&idTipoArticulo=" . $linea['id_tipo_articulo'] . "&idLocal="
								                        . $idLocal . "','art" . $linea['id_articulo_local']
								                        . "','mostrarPedido',1)";
								                        ?>"
								                        title="Añadir al pedido">
												<span class="glyphicon glyphicon-plus"></span>
											</button>
									</span></td>
								</tr>
							</tbody>
						</table>
					</div>
					<?php
					$idTipoArticulo = $linea['id_tipo_articulo'];
					$vuelta = true;
					endif;
					endforeach;
					if ($vuelta){
							echo "</div></div>";
						}
						?>

					<?php
					/*
					 * Se comprueba si hay articulos personzalibles para mostrar el formulario
					*/
					if ($hayArticuloPersonalizable):
					?>

					<div class="panel panel-default sub-panel">
						<div class="panel-heading panel-verde">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-target="#personalizarArticulo"
									class="accordion-toggle collapsed"> Personalizar articulo </a>
							</h4>
						</div>
						<div id="personalizarArticulo" class="panel-body collapse altoMaximo">
							<div class="col-md-12 well">
								<form id="formArticuloPersonalizado" class="form-horizontal"
									role="form">
									<input type="hidden" name="idLocal"
										value="<?php echo $idLocal ?>">
									<div class="form-group">
										<label for="idTipoArticuloLocal"
											class="col-sm-4 control-label">Tipo de articulo</label>
										<div class="col-sm-8">
											<select class="pull-left" name="idTipoArticuloLocal"
												id="idTipoArticuloLocal">
												<?php foreach ($tiposArticuloLocal as $linea):
													if ($linea->personalizar) : ?>
												<option class="form-control"
													value="<?php echo $linea->id_tipo_articulo_local; ?>">
													<?php echo $linea->tipo_articulo . " [ " . $linea->precio; ?>
													<?php echo  " €]"; ?>
												</option>

												<?php 
												endif;
													endforeach; ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="idTipoArticuloLocal"
											class="col-sm-4 control-label">Ingredientes</label>
										<?php 
										$i=false;
										foreach ($ingredientesLocal as $linea):
										if ($i):
										?>
										<label for="idTipoArticuloLocal"
											class="col-sm-4 control-label"></label>
										<?php
										endif;
										?>
										<div class="checkbox col-md-8">
											<label class="pull-left"> <input type="checkbox"
												name="ingrediente[]"
												value="<?php echo $linea->id_ingrediente;?>"> <?php echo $linea->ingrediente . " [" . $linea->precio ; ?>
												<i class="fa fa-euro"></i> <?php echo " ]"; ?>
											</label>
										</div>

										<?php
										$i=true;
										endforeach;
										?>
									</div>
									<div class="form-group">
										<label for="cantidadArticuloPersonalizado"
											class="col-sm-4 control-label">Cantidad</label>
										<div class="col-sm-8">
											<select class="pull-left" value="1"
												name="cantidadArticuloPersonalizado"
												id="cantidadArticuloPersonalizado">
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
										</div>
									</div>
								</form>
								<span class="pull-right">
									<button class="btn btn-success" type="button"
										data-toggle="tooltip" data-original-title="Edit this user"
										onclick="<?php
            echo "enviarFormulario('" . site_url() .
            "/pedidos/anadirArticuloPersonalizadoPedido','formArticuloPersonalizado','mostrarPedido',1)"
            ?>"
            title="Añadir al pedido">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
							</div>
							<?php
							endif;
							?>
						</div>
					</div>
				</div>
			</div>

		</div>