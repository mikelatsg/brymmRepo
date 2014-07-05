<?php

foreach ($direccionesEnvio as $linea) {
    echo "<direccionEnvio>";
    echo "<nombre>";
    echo html_entity_decode($linea->nombre);
    echo "</nombre>";
    echo "<idDireccionEnvio>";
    echo html_entity_decode($linea->id_direccion_envio);
    echo "</idDireccionEnvio>";
    echo "<direccion>";
    echo html_entity_decode($linea->direccion);
    echo "</direccion>";
    echo "</direccionEnvio>";
}
?>
