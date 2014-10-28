<div>
	<div id="FormularioBuscadoLocal" class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-target="#collapseFormBuscador"
					class="accordion-toggle collapsed"> Buscador </a>
			</h4>
		</div>
		<div id="collapseFormBuscador" class="panel-collapse collapse">
			<form id="formBuscadorLocal" method="post"
				action="<?= site_url() ?>/locales/buscarLocal">
				Tipo comida <select name="idTipoComida">
					<option value="0">Todas</option>
					<?php foreach ($tiposComida as $linea): ?>
					<option value="<?php echo $linea->id_tipo_comida; ?>">
						<? echo $linea->tipo_comida; ?>
					</option>
					<?php endforeach; ?>
				</select> <input type="text" name="local" placeholder="Local" /> <input
					type="text" name="poblacion" placeholder="Poblacion" /> <input
					type="text" name="calle" placeholder="Calle" /> <input type="text"
					name="codigoPostal" placeholder="Codigo postal" /> <br>
				<?php foreach ($servicios as $linea):
				if ($linea->mostrar_buscador):
				?>
				<input type="checkbox" name="servicios[]"
					value="<?php echo $linea->id_tipo_servicio_local; ?>" />
				<?php echo $linea->servicio; ?>

				<?php endif;
				endforeach;
				?>
				<br> <input type="submit" value="Buscar local" />
				</td>

			</form>
		</div>
	</div>
</div>

