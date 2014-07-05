<?php

foreach ($ingredientesArticulo as $linea) {
    echo "<articuloLocal>";
    echo "<idIngrediente>";
    echo html_entity_decode($linea->id_ingrediente);
    echo "</idIngrediente>";
    echo "<idDetArticulo>";
    echo html_entity_decode($linea->id_det_articulo);
    echo "</idDetArticulo>";
    echo "</articuloLocal>";
}
?>
