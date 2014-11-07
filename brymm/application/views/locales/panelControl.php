
<div id="panelControl" class="masthead">
	<nav class="navbar navbar-default">
		<ul class="nav nav-tabs">
			<li><?php
			echo anchor('/home', 'Inicio');
			?>
			</li>
			<li><?php
			if ($_SESSION['controlTotal']) {
			echo anchor('/articulos/gestionArticulos', 'Articulos');
		} else {
                echo 'Alta articulos';
            }
            ?>
			</li>
			<li><?php
			if ($_SESSION['controlTotal']) {
                echo anchor('/locales/gestionHorarios', 'Horarios');
            } else {
                echo 'Horarios';
            }
            ?>
			</li>
			<li><?php
			if ($_SESSION['controlTotal']) {
                echo anchor('/servicios/gestionServicios', 'Servicios');
            } else {
                echo 'Servicios';
            }
            ?>
			</li>
			<li><?php
			if ($_SESSION['controlTotal']) {
                echo anchor('/pedidos/verPedidosLocal', 'Pedidos/Comandas');
            } else {
                echo 'Pedidos/Comandas';
            }
            ?>
			</li>
			<li><?php
			if ($_SESSION['controlTotal']) {
                echo anchor('/menus/menusLocal', 'Menus');
            } else {
                echo 'Menus';
            }
            ?>
			</li>
			<li><?php
			if ($_SESSION['controlTotal']) {
                echo anchor('/reservas/reservasLocal', 'Reservas');
            } else {
                echo 'Reservas';
            }
            ?>
			</li>
			<li><?php echo anchor('/camareros/camarerosLocal', 'Camareros'); ?></li>
			<li class="navbar-tab navbar-right"><?php echo anchor('/usuarios/logout', 'Salir'); ?>
			</li>
		</ul>
	</nav>
</div>

