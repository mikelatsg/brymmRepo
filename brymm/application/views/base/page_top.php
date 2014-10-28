<body>
	<div id="container" align="center" class="container">

		<!-- Web -->
		<div id="cont_web">

			<!-- Cabecera -->
			<div id="cabecera">
				<div id="dialogMensaje" title="Mensaje" style="display: none"></div>
			</div>
			<!-- Fin Cabecera -->

			<!-- Menu Horinzontal-->
			<div id="menuH" align="center">

				<?php
				//echo anchor('/home', 'Inicio');
				if (isset($_SESSION['idUsuario'])):
				?>
				<nav class="navbar navbar-inverse">
					<ul class="nav nav-tabs">
						<li><?php echo anchor('/home', 'Inicio'); ?></li>
						<li><?php echo anchor('/usuarios/home', 'Home usuario'); ?>
						</li>
						<li class="navbar-tab navbar-right"><?php echo anchor('/usuarios/logout', 'Salir'); ?>
						</li>
					</ul>
				</nav>

				<?php
				else:
				?>

				<?php
				if (isset($_SESSION['idLocal'])):
				$this->load->view('/locales/panelControl');
				else:
				?>
				<div id="usuarios" class="masthead">
					<nav class="navbar navbar-inverse">
						<ul class="nav nav-tabs">
							<li><?php echo anchor('/usuarios/alta', 'Alta usuario'); ?></li>
							<li class="dropdown" id="menuLoginUsuario"><a
								class="dropdown-toggle" href="#" data-toggle="dropdown"
								id="navLoginUsuario">Login usuario</a>
								<div class="dropdown-menu">
									<form method="post" id="formLoginUsuario"
										action="<?php echo site_url() ?>/usuarios/login">
										<input type="text" name="nick" placeholder="Nick" /> <input
											type="password" placeholder="Password" name="password" /> <input
											type="submit" value="Login" />
									</form>
								</div></li>
							<li><?php echo anchor('/locales/alta', 'Alta local'); ?></li>
							<li class="dropdown" id="menuLoginLocal"><a
								class="dropdown-toggle" href="#" data-toggle="dropdown"
								id="navLoginLocal">Login local</a>
								<div class="dropdown-menu">
									<form method="post" id="formLoginLocal"
										action="<?= site_url() ?>/locales/login">
										<input type="text" name="nombre" placeholder="Local" /> <input
											type="password" name="password" placeholder="Password" /> <input
											type="submit" value="Login" />
									</form>
								</div>
							</li>
							<li class="dropdown" id="menuLoginLocal"><a
								class="dropdown-toggle" href="#" data-toggle="dropdown"
								id="navLoginLocal">Login camarero</a>
								<div class="dropdown-menu">
									<form method="post" id="formLoginLocal"
										action="<?= site_url() ?>/camareros/login">
										<input type="text" name="nombreLocal" placeholder="Local" /> <input
											type="text" name="nombreCamarero" placeholder="Camarero" /> <input
											type="password" name="password" placeholder="Password" /> <input
											type="submit" value="Login" />
									</form>
								</div>
							</li>

						</ul>
					</nav>
				</div>
				<?php
				endif;
				endif;
				?>


			</div>

			<!-- Fin Menu Horinzontal-->


			<!-- Contenidos -->
			<div id="contenidos">