<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading panel-verde">
				<h4 class="panel-title">Realizar pedido</h4>
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
						" class="panel-body collapse sub-panel">
						<?php 
						endif;
						?>


						<div class="list-group col-md-8">

							<h4 class="list-group-item-heading">
								<?php echo $linea['articulo']?>
							</h4>
							<dl class="dl-horizontal">
								<dt>Descripcion</dt>
								<dd>
									<?php echo $linea['descripcion']; ?>
								</dd>
								<dt>Precio</dt>
								<dd>
									<?php echo $linea['precio']; ?>
								</dd>
								<dt>Cantidad</dt>
								<dd>
									<form>
										<select value="1"
											id="<?php echo "art" . $linea['id_articulo_local'] ?>">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21">21</option>
											<option value="22">22</option>
											<option value="23">23</option>
											<option value="24">24</option>
											<option value="25">25</option>
										</select> <a
											onclick="<?php
                        echo "enviarArticuloPedido('" . site_url() . "/pedidos/anadirArticuloPedido','idArticuloLocal="
                        . $linea['id_articulo_local'] . "&precio=" . $linea['precio']
                        . "&articulo=" . $linea['articulo']
                        . "&idTipoArticulo=" . $linea['id_tipo_articulo'] . "&idLocal="
                        . $idLocal . "','art" . $linea['id_articulo_local']
                        . "','mostrarPedido',1)";
                        ?>"> + </a>
									</form>
								</dd>
							</dl>
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
							<div id="personalizarArticulo" class="panel-body collapse">
								<form id="formArticuloPersonalizado">
									<input type="hidden" name="idLocal"
										value="<?php echo $idLocal ?>">
									<?php
									echo "<SELECT name=\"idTipoArticuloLocal\">";

									foreach ($tiposArticuloLocal as $linea) {
                    /*
                     * Si el tipo de articulo es personalizable se muestra
                    */
                    if ($linea->personalizar) {
                        echo "<OPTION value=" . $linea->id_tipo_articulo_local . ">"
							. $linea->tipo_articulo . "-" . $linea->precio . "</OPTION>";
                    }
                }
                echo "</SELECT>";?>
									<ol class="list-inline">
										<?php 
										foreach ($ingredientesLocal as $linea):
										?>

										<li class="col-md-4"><input type="checkbox"
											name="ingrediente[]"
											value="<?php echo $linea->id_ingrediente; ?>"
											class="pull-left" /> <span class="pull-left"> <?php echo $linea->ingrediente . "-" . $linea->precio; ?>
										</span></li>

										<?php
										endforeach;
										?>
									</ol>
									Cantidad <select value="1" name="cantidadArticuloPersonalizado">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
									</select> <a
										onclick="<?php
            echo "enviarFormulario('" . site_url() .
            "/pedidos/anadirArticuloPersonalizadoPedido','formArticuloPersonalizado','mostrarPedido',1)"
            ?>"> + </a>
								</form>
								<?php
								endif;
								?>
							</div>
						</div>
					</div>
				</div>

			</div>