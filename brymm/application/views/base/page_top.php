<body>

    <div id="container" align="center">

        <!-- Web -->
        <div id="cont_web">

            <!-- Cabecera -->
            <div id="cabecera">
                <div id="dialogMensaje" title="Mensaje" style="display:none">                   
                </div>
            </div>
            <!-- Fin Cabecera -->

            <!-- Menu Horinzontal-->
            <div id="menuH" align="center">


                <?php
                echo anchor('/home', 'Inicio');
                if (isset($_SESSION['idUsuario'])):
                    ?>
                    <ul>				
                        <li><?php echo anchor('/usuarios/logout', 'Salir'); ?> </li>
                        <li><?php echo anchor('/usuarios/home', 'Home usuario'); ?> </li>
                    </ul>

                    <?php
                else:
                    ?>

                    <?php
                    if (isset($_SESSION['idLocal'])):
                        $this->load->view('/locales/panelControl');
                        ?>                        
                        <li><?php echo anchor('/usuarios/logout', 'Salir'); ?> </li>
                        <?php
                    else:
                        ?>
                        <div id="usuarios">	
                            <ul>	
                                <li><?php echo anchor('/usuarios/alta', 'Date de alta'); ?> </li>
                            </ul>	
                            <table>
                                <form method="post" action="<?php echo site_url() ?>/usuarios/login">
                                    <tr>
                                        <td  width="47">Nick:</td>
                                        <td  width="46"><input type="text" name="nick" /></td>
                                    </tr>
                                    <tr>
                                        <td width="69">Password:</td>
                                        <td  width="46"><input type="password" name="password"/></td>
                                    </tr>
                                    <tr>
                                        <td width="51" colspan="2" align="center">
                                            <input type="submit" value="Login" />
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>    
                        <div id="locales">
                            <ul>  
                                <li><?php echo anchor('/locales/alta', 'Alta local'); ?> </li>
                                <!--<li><?php echo anchor('/locales/login', 'Login'); ?> </li>-->
                            </ul>
                            Soy camarero<input type="checkbox" name="soyCamarero" value="1"/>
                            <table>
                                <form method="post" action="<?= site_url() ?>/locales/login">
                                    <tr>
                                        <td  width="47">Local:</td>
                                        <td  width="46"><input type="text" name="nombre" /></td>
                                    </tr>
                                    <tr>
                                        <td width="69">Password:</td>
                                        <td  width="46"><input type="password" name="password"/></td>
                                    </tr>
                                    <tr>
                                        <td width="51" colspan="2" align="center">
                                            <input type="submit" value="Login" />
                                        </td>
                                    </tr>
                                </form>
                            </table>
                            <table>
                                <form method="post" action="<?= site_url() ?>/camareros/login">
                                    <tr>
                                        <td  width="47">Local:</td>
                                        <td  width="46"><input type="text" name="nombreLocal" /></td>
                                    </tr>
                                    <tr>
                                        <td  width="47">Camarero:</td>
                                        <td  width="46"><input type="text" name="nombreCamarero" /></td>
                                    </tr>
                                    <tr>
                                        <td width="69">Password:</td>
                                        <td  width="46"><input type="password" name="password"/></td>
                                    </tr>
                                    <tr>
                                        <td width="51" colspan="2" align="center">
                                            <input type="submit" value="Login" />
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                    <?php
                    endif;
                endif;
                ?>


            </div>
            <!-- Fin Menu Horinzontal-->


            <!-- Contenidos -->
            <div id="contenidos">




