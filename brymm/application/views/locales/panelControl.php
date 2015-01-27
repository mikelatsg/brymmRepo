
<div id="panelControl" class="masthead">
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div id="logo" class="navbar-header">
				<a class="navbar-brand" href="#">Brymm</a>
			</div>
			<div>
				<ul class="nav nav-tabs">
					<li><?php
					echo anchor('/home', 'Inicio');
					?>
					</li>
					<li><?php
					if ($_SESSION['controlTotal']) {
			echo anchor('/articulos/gestionArticulos', 'Articulos');
		} else {
                ?> <a>Articulos</a> <?php
            }
            ?>
					</li>
					<li><?php
					if ($_SESSION['controlTotal']) {
                echo anchor('/locales/gestionHorarios', 'Horarios');
            } else {
                ?> <a>Horarios</a> <?php
            }
            ?>
					</li>
					<li><?php
					if ($_SESSION['controlTotal']) {
                echo anchor('/servicios/gestionServicios', 'Servicios');
            } else {
                ?> <a>Servicios</a> <?php
            }
            ?>
					</li>
					<li><?php
					if ($_SESSION['controlTotal']) {
                echo anchor('/pedidos/verPedidosLocal', 'Pedidos/Comandas');
            } else {
?> <a>Pedidos/Comandas</a> <?php
//echo 'Pedidos/Comandas';
            }
            ?></li>
					<li><?php
					if ($_SESSION['controlTotal']) {
                echo anchor('/menus/menusLocal', 'Menus');
            } else {
?> <a>Menus</a> <?php
//     echo 'Menus';
            }
            ?>
					</li>
					<li><?php
					if ($_SESSION['controlTotal']) {
                echo anchor('/reservas/reservasLocal', 'Reservas');
            } else {
               ?> <a>Reservas</a> <?php
            }
            ?>
					</li>
					<li><?php echo anchor('/camareros/camarerosLocal', 'Camareros'); ?>
					</li>
					<li class="navbar-tab navbar-right"><?php echo anchor('/usuarios/logout', 'Salir'); ?>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</div>

