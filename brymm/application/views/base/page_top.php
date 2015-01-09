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
						<div class="container-fluid">
							<div id="logo" class="navbar-header">
								<a class="navbar-brand" href="#">Brymm</a>
							</div>
							<div>
								<ul class="nav nav-tabs">
									<li class="dropdown" id="menuLoginUsuario"><a
										class="dropdown-toggle" href="#" data-toggle="dropdown"
										id="navLoginUsuario">Usuario</a>
										<div class="dropdown-menu">
											<div class="col-md-12">
												<form method="post" id="formLoginUsuario"
													action="<?php echo site_url() ?>/usuarios/login">
													<input type="text" name="nick" placeholder="Nick" /> <input
														type="password" placeholder="Password" name="password" />
													<button class="btn btn-success pull-right" type="submit"
														data-toggle="tooltip"
														data-original-title="Remove this user">
														<span class="glyphicon glyphicon-log-in"></span>
													</button>
												</form>
											</div>
											<div class="col-md-12">
												<a href="<?php echo site_url();?>/usuarios/alta">Nuevo
													usuario</a>
											</div>
										</div></li>
									<li class="dropdown" id="menuLoginLocal"><a
										class="dropdown-toggle" href="#" data-toggle="dropdown"
										id="navLoginLocal">Local</a>
										<div class="dropdown-menu">
											<div class="col-md-12">
												<form method="post" id="formLoginLocal"
													action="<?= site_url() ?>/locales/login">
													<input type="text" name="nombre" placeholder="Local" /> <input
														type="password" name="password" placeholder="Password" />
													<button class="btn btn-success pull-right" type="submit"
														data-toggle="tooltip"
														data-original-title="Remove this user">
														<span class="glyphicon glyphicon-log-in"></span>
													</button>
												</form>
											</div>
											<div class="col-md-12">
												<a href="<?php echo site_url();?>/locales/alta">Nuevo local</a>
											</div>
										</div>
									</li>
									<li class="dropdown" id="menuLoginLocal"><a
										class="dropdown-toggle" href="#" data-toggle="dropdown"
										id="navLoginLocal">Camarero</a>
										<div class="dropdown-menu">
											<div class="col-md-12">
												<form method="post" id="formLoginLocal"
													action="<?= site_url() ?>/camareros/login">
													<input type="text" name="nombreLocal" placeholder="Local" />
													<input type="text" name="nombreCamarero"
														placeholder="Camarero" /> <input type="password"
														name="password" placeholder="Password" />
													<button class="btn btn-success pull-right" type="submit"
														data-toggle="tooltip"
														data-original-title="Remove this user">
														<span class="glyphicon glyphicon-log-in"></span>
													</button>
												</form>
											</div>
										</div>
									</li>

								</ul>
							</div>
						</div>
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