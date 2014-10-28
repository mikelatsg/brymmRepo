<div id="tituloListaDirecciones" class="col-md-6">
	<h3>Mis direcciones</h3>

	<div id="listaDirecciones">
		<ul>
			<?php foreach ($direccionesEnvio as $linea): ?>
			<li><?php
			echo "Nombre direccion : " . $linea->nombre . " - Direccion : " . $linea->direccion
			. " - Poblacion : " . $linea->poblacion
			. " - Provincia : " . $linea->provincia;
			?> <a
				onclick="<?php
                echo "doAjax('" . site_url() . "/usuarios/borrarDireccionEnvio','idDireccionEnvio="
                . $linea->id_direccion_envio . "','','post',1)";
                ?>"> Borrar </a></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div id="anadirDireccion">
		<?php
		echo "<a class=\"enlaceAnadirDireccion\" data-toggle=\"modal\" > Añadir direccion </a>";
		?>
	</div>
</div>
