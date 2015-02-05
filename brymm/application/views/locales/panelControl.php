
<div id="panelControl" class="masthead">
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div id="logo" class="navbar-header">
				<a class="navbar-brand" href="#">Brymm</a>
			</div>
			<div>
				<ul class="nav nav-tabs">
					<li><?php
					if ($_SESSION['controlTotal']) {
			?><a href="<?php echo site_url();?>/articulos/gestionArticulos"><i
							class="fa fa-beer"> </i> Articulos</a> <?php
		} else {
                ?> <a>Articulos</a> <?php
            }
            ?>
					</li>
					<li><?php
					if ($_SESSION['controlTotal']) {
                ?><a
						href="<?php echo site_url();?>/locales/gestionHorarios"><i
							class="fa fa-clock-o"> </i> Horarios</a> <?php 
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
                ?><a
						href="<?php echo site_url();?>/pedidos/verPedidosLocal"><i
							class="fa fa-file-text-o"> </i> Pedidos/Comandas</a> <?php
            } else {
?> <a>Pedidos/Comandas</a> <?php
//echo 'Pedidos/Comandas';
            }
            ?></li>
					<li><?php
					if ($_SESSION['controlTotal']) {                
                ?><a
						href="<?php echo site_url();?>/locales/gestionHorarios"><i
							class="fa fa-cutlery"> </i> Menus</a> <?php
            } else {
?> <a>Menus</a> <?php
//     echo 'Menus';
            }
            ?>
					</li>
					<li><?php
					if ($_SESSION['controlTotal']) {                
                ?><a href="<?php echo site_url();?>/reservas/reservasLocal"><i
                							class="fa fa-calendar"> </i> Reservas</a> <?php
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

