<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Realizar pedido</h4>
			</div>
			<div id="realizarPedido" class="panel-body">
				<?php
				if (isset($precioEnvioPedido)) {
					echo "<br>";
					echo "Envio a domicilio:";
					echo "<br>";
					echo "Importe minimo:" . $precioEnvioPedido->importe_minimo;
					echo " - ";
					echo "Precio:" . $precioEnvioPedido->precio;
				}
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


				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-target="<?php echo "#".$linea['tipo_articulo'];?>"
								class="accordion-toggle collapsed"> <?php echo $linea['tipo_articulo'];?>
							</a>
						</h4>
					</div>
					<div id="<?php echo $linea['tipo_articulo'];?>"" class="panel-body collapse">
						<?php 
						endif;
						?>


						<div class="list-group">

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

						<form id="formArticuloPersonalizado">
							<input type="hidden" name="idLocal"
								value="<?php echo $idLocal ?>">
							<ol>
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
                echo "</SELECT>";
                foreach ($ingredientesLocal as $linea):
                ?>

								<li><input type="checkbox" name="ingrediente[]"
									value="<? echo $linea->id_ingrediente; ?>" /> <?php echo $linea->ingrediente . "-" . $linea->precio; ?>
								</li>

								<?php
								endforeach;
								?>
							</ol>
							Cantidad
							<!--<input type="text" size="2" maxlength="2" value="1" name="cantidadArticuloPersonalizado">-->
							<select value="1" name="cantidadArticuloPersonalizado">
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