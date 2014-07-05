<?php

/* foreach ($horarioLocal as $linea) {
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
  } */
echo "<pedido>";
foreach ($pedido as $linea) {
    echo "<articulo>";
    echo "<rowid>";
    echo html_entity_decode($linea['rowid']);
    echo "</rowid>";
    echo "<idArticuloLocal>";
    echo html_entity_decode($linea['id']);
    echo "</idArticuloLocal>";
    echo "<nombre>";
    echo html_entity_decode($linea['name']);
    echo "</nombre>";
    echo "<cantidad>";
    echo html_entity_decode($linea['qty']);
    echo "</cantidad>";
    echo "<precio>";
    echo html_entity_decode($linea['price']);
    echo "</precio>";
    echo "</articulo>";
}
echo "</pedido>";
?>
