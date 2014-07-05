
<div id="mostrarLocal">
    <?php
    /* foreach ($datosLocal as $local) {
      echo $local->nombre . "-" . $local->direccion;
      } */
    echo $datosLocal->nombre . "-" . $datosLocal->direccion;
    ?>
    <a onclick="
    <?php
    echo "doAjax('" . site_url() . "/locales/anadirLocalFavorito','idLocal="
    . $datosLocal->id_local . "','','post',1)";
    ?>
       "> F </a>
       <?php
       echo "<br>";
       foreach ($serviciosLocal as $linea) {
           switch ($linea->id_tipo_servicio_local) {
               case 1:
                   if ($linea->activo) {
                       echo anchor('/locales/mostrarLocal/' . $linea->id_local . '/' . $linea->id_tipo_servicio_local, 'Pedidos');
                   }
                   break;
               case 3:
                   if ($linea->activo) {
                       echo anchor('/locales/mostrarLocal/' . $linea->id_local . '/' . $linea->id_tipo_servicio_local, 'Reservas');
                   }
                   break;
               case 4:
                   if ($linea->activo) {
                       echo anchor('/locales/mostrarLocal/' . $linea->id_local . '/' . $linea->id_tipo_servicio_local, 'Menus');
                   }
                   break;
           }
           /* if ($linea->id_tipo_servicio_local == 1) {//Pedidos
             echo anchor('/locales/mostrarLocal/' . $linea->id_local . '/' . $linea->id_tipo_servicio_local, 'Pedidos');
             } */
       }
       ?>
</div>

