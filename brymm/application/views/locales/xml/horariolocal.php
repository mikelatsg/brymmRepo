<?php

foreach ($horarioLocal as $linea) {
    echo "<horarioLocal>";
    echo "<dia>";
    echo html_entity_decode($linea->dia);
    echo "</dia>";
    echo "<idHorarioLocal>";
    echo html_entity_decode($linea->id_horario_local);
    echo "</idHorariolocal>";
    echo "<horaInicio>";
    echo html_entity_decode($linea->hora_inicio);
    echo "</horaInicio>";
    echo "<horaFin>";
    echo html_entity_decode($linea->hora_fin);
    echo "</horaFin>";
    echo "</horarioLocal>";
}
?>
