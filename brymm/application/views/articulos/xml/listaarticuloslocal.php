<?php

foreach ($articulosLocal as $linea) {
    echo "<articuloLocal>";
    echo "<articulo>";
    echo html_entity_decode($linea['articulo']);
    echo "</articulo>";
    echo "<descripcion>";
    echo html_entity_decode($linea['descripcion']);
    echo "</descripcion>";
    echo "<precio>";
    echo html_entity_decode($linea['precio']);
    echo "</precio>";
    echo "<idArticuloLocal>";
    echo html_entity_decode($linea['id_articulo_local']);
    echo "</idArticuloLocal>";
    echo "<idTipoArticulo>";
    echo html_entity_decode($linea['id_tipo_articulo']);
    echo "</idTipoArticulo>";
    echo "<tipoArticulo>";
    echo html_entity_decode($linea['tipo_articulo']);
    echo "</tipoArticulo>";
    echo "<ingredientes>";
    foreach ($linea['ingredientes'] as $ingrediente) {
        echo "<ingrediente>";
        echo html_entity_decode($ingrediente['id_ingrediente']);
        echo "</ingrediente>";
    }
    echo "</ingredientes>";
    echo "</articuloLocal>";
}
?>
