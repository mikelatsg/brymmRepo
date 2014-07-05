<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <META NAME="Title" CONTENT="Brymm">
            <META NAME="Author" CONTENT="Brymm">
                <META NAME="Subject" CONTENT="Brymm">
                    <META NAME="Description" CONTENT="Brymm">
                        <META NAME="Keywords" CONTENT="Brymm">
                            <META NAME="Generator" CONTENT="Aptana Studio">
                                <META NAME="Language" CONTENT="Spanish">
                                    <META NAME="Revisit" CONTENT="1 day">
                                        <META NAME="Distribution" CONTENT="Global">
                                            <META NAME="Robots" CONTENT="All">
                                                <title>Brymm</title>
                                                <base href="<?php echo base_url() ?>" />
                                                <!--<link rel="stylesheet" href="css/inicio.css" type="text/css" />
                                                <link rel="stylesheet" href="css/basemenu.css" type="text/css" />-->
                                                <link rel="stylesheet" 
                                                      href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
                                                <link rel="stylesheet" type="text/css"
                                                      href="css/jqueryui/jquery-ui-1.10.3.custom.css" />
                                                <link rel="stylesheet" type="text/css"
                                                      href="css/jqueryui/jquery-ui-1.10.3.custom.min.css" />
                                                      <?php
                                                      if (isset($estilos)) {
                                                          foreach ($estilos as $estilo) {
                                                              echo '<link rel="stylesheet" href="css/' . $estilo . '" type="text/css" />';
                                                          }
                                                      }
                                                      if (isset($javascript)) {
                                                          foreach ($javascript as $js) {
                                                              echo '<script type="text/javascript" src="js/' . $js . '.js"></script>';
                                                          }
                                                      }
                                                      ?>
                                                <script type="text/javascript">
                                                    base_url = '<?php echo base_url(); ?>';
                                                    site_url = '<?php echo site_url(); ?>';
                                                </script>
                                                </head>