
<div id="panelControl" class="masthead">
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div id="logo" class="navbar-header">
				<a class="navbar-brand" href="#"><i class="fa fa-home"></i> Brymm</a>
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
                ?><a
						href="<?php echo site_url();?>/servicios/gestionServicios"><i
							class="fa fa-cloud"> </i> Servicios</a> <?php
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
						href="<?php echo site_url();?>/menus/menusLocal"><i
							class="fa fa-cutlery"> </i> Menus</a> <?php
            } else {
?> <a>Menus</a> <?php
//     echo 'Menus';
            }
            ?>
					</li>
					<li><?php
					if ($_SESSION['controlTotal']) {
                ?><a
						href="<?php echo site_url();?>/reservas/reservasLocal"><i
							class="fa fa-calendar"> </i> Reservas</a> <?php
            } else {
               ?> <a>Reservas</a> <?php
            }
            ?>
					</li>
					<li><a href="<?php echo site_url();?>/camareros/camarerosLocal"><i
							class="fa fa-user"> </i> Camareros</a>
					</li>
					<li class="navbar-tab navbar-right"><?php echo anchor('/usuarios/logout', 'Salir'); ?>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</div>

