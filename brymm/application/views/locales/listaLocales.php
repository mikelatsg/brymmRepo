
<div id="listaLocal">
	<div id="FormularioBuscadoLocal" class="panel panel-default">
		<div class="panel-heading panel-verde">
			<h4 class="panel-title">
				<i class="fa fa-list"></i> Locales encontrados
			</h4>
		</div>
		<div class="panel-body panel-verde">
			<div id="numLocalesEncontrados" class="col-md-12">
				<strong> <?php echo "Se han encontrado " . $numLocalesEncontrados . " locales."; ?>
				</strong>
			</div>
			<?php
			$contador = 0;
			$contenido1 = "";
			$contenido2 = "";
			foreach ($locales as $linea):
			$contador++;
			ob_start();
			?>
			<div class="col-md-12 list-div">
				<table class="table">
					<tbody>
						<tr>
							<td class="titulo" colspan="3"><strong> <a
									href="<?php echo site_url()?>/locales/mostrarLocal/<?php echo $linea->id_local?>"><?php 
									echo  $linea->nombre;
									?> <i class="fa fa-home"></i> </a>
							</strong>
							</td>
						</tr>
						<tr>
							<td><?php 
							echo  $linea->direccion;
							?>
							</td>
						</tr>
						<tr>
							<td><?php 
							echo  $linea->localidad;
							?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php 
				if ($_SESSION):
					if ($_SESSION['idUsuario']):?>
				<span id="pull-right">
					<button class="btn btn-default pull-right" type="button"
						data-toggle="tooltip" data-original-title="Remove this user"
						onclick="<?php
                    echo "doAjax('" . site_url() . "/locales/anadirLocalFavorito','idLocal=" . $linea->id_local .
							"','mostrarMensajeXml','post',1)";
                ?>"
						title="Añadir a favoritos">
						<span class="glyphicon glyphicon-star"></span>
					</button>
				</span>
				<?php 
				endif;
				endif;
				?>
			</div>
			<?php $contenido = ob_get_clean();
			/*echo $contenido;*/
			?>
			<?php 					
			if ($contador%2 <> 0){
				$contenido1 .=  $contenido;
			}else{
				$contenido2 .=  $contenido;
			}
			endforeach; ?>
			<div class="col-md-6">
				<?php 
				echo $contenido1 ;
				?>
			</div>
			<div class="col-md-6">
				<?php 
				echo $contenido2 ;
				?>
			</div>
		</div>
	</div>