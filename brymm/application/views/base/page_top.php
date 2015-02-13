<body class="fondo">
	<div class="color">
		<!-- Menu Horinzontal-->
		<div id="menuH" align="center" class="container">
			<?php
			//echo anchor('/home', 'Inicio');
			if (isset($_SESSION['idUsuario'])):
			?>
			<div id="opcionesUsuario" class="masthead">
				<nav class="navbar navbar-inverse">
					<div class="container-fluid">
						<div id="logo" class="navbar-header">
							<a class="navbar-brand" href="#"><i class="fa fa-home"></i> Brymm</a>
						</div>
						<div>
							<ul class="nav nav-tabs">
								<li><a href="<?php echo site_url();?>/usuarios/home"><i
										class="fa fa-home"> </i> Home</a>
								</li>
								<li class="navbar-tab navbar-right"><a class="dropdown-toggle"
									href="#" data-toggle="dropdown" id="navUsuario"><i
										class="fa fa-user"></i> <?php echo $_SESSION['nick'];?> </a>
									<div class="dropdown-menu menuUsuario">										
										<div class="col-md-12">
											<a href="<?php echo site_url();?>/usuarios/perfil"><i
												class="fa fa-user"> </i> Perfil</a>
										</div>
										<div class="col-md-12">
											<a href="<?php echo site_url();?>/usuarios/logout"><i
												class="fa fa-sign-out"> </i> Salir</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
				
				</nav>
			</div>
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
							<a class="navbar-brand" href="#"><i class="fa fa-home"></i> Brymm</a>
						</div>
						<div>
							<ul class="nav nav-tabs">
								<li class="dropdown" id="menuLoginUsuario"><a
									class="dropdown-toggle" href="#" data-toggle="dropdown"
									id="navLoginUsuario"><i class="fa fa-user"></i> Usuario</a>
									<div class="dropdown-menu">
										<!--  <div class="col-md-12">-->
										<form method="post" id="formLoginUsuario"
											action="<?php echo site_url() ?>/usuarios/login">
											<div class="form-group">
												<label for="nick" class="col-md-4 control-label">Nick</label>
												<div class="col-md-8">
													<input type="text" class="form-control" id="nick"
														placeholder="Nick" name="nick">
												</div>
											</div>
											<div class="form-group">
												<label for="password" class="col-md-4 control-label">Password</label>
												<div class="col-md-8">
													<input type="password" class="form-control" id="password"
														placeholder="Password" name="password">
												</div>
											</div>
											<div class="col-md-12">
												<button class="btn btn-success pull-right" type="submit"
													data-toggle="tooltip"
													data-original-title="Remove this user">
													<span class="glyphicon glyphicon-log-in"></span>
												</button>
											</div>
										</form>
										<!--  </div> -->
										<div class="col-md-12">
											<a href="<?php echo site_url();?>/usuarios/alta">Nuevo
												usuario</a>
										</div>
									</div>
								</li>
								<li class="dropdown" id="menuLoginLocal"><a
									class="dropdown-toggle" href="#" data-toggle="dropdown"
									id="navLoginLocal"><i class="fa fa-home"></i> Local</a>
									<div class="dropdown-menu">
										<div class="col-md-12">
											<form method="post" id="formLoginLocal"
												action="<?= site_url() ?>/locales/login">
												<div class="form-group">
													<label for="nombre" class="col-md-4 control-label">Local</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="nombre"
															placeholder="Local" name="nombre">
													</div>
												</div>
												<div class="form-group">
													<label for="password" class="col-md-4 control-label">Password</label>
													<div class="col-md-8">
														<input type="password" class="form-control" id="password"
															placeholder="Password" name="password">
													</div>
												</div>
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
									</div></li>
								<li class="dropdown" id="menuLoginLocal"><a
									class="dropdown-toggle" href="#" data-toggle="dropdown"
									id="navLoginLocal"><i class="fa fa-user"></i> Camarero</a>
									<div class="dropdown-menu">
										<div class="col-md-12">
											<form method="post" id="formLoginLocal"
												action="<?= site_url() ?>/camareros/login">
												<div class="form-group">
													<label for="nombreLocal" class="col-md-4 control-label">Local</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="nombreLocal"
															placeholder="Local" name="nombreLocal">
													</div>
												</div>
												<div class="form-group">
													<label for="nombreCamarero" class="col-md-4 control-label">Camarero</label>
													<div class="col-md-8">
														<input type="text" class="form-control"
															id="nombreCamarero" placeholder="Camarero"
															name="nombreCamarero">
													</div>
												</div>
												<div class="form-group">
													<label for="password" class="col-md-4 control-label">Password</label>
													<div class="col-md-8">
														<input type="password" class="form-control" id="password"
															placeholder="Password" name="password">
													</div>
												</div>
												<button class="btn btn-success pull-right" type="submit"
													data-toggle="tooltip"
													data-original-title="Remove this user">
													<span class="glyphicon glyphicon-log-in"></span>
												</button>
											</form>
										</div>
									</div></li>

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
	</div>
	<div id="container" align="center" class="container">

		<!-- Web -->
		<div id="cont_web">

			<!-- Cabecera -->
			<div id="cabecera">
				<div id="dialogMensaje" title="Mensaje" style="display: none"></div>
			</div>
			<!-- Fin Cabecera -->

			<!-- Contenidos -->
			<div id="contenidos">