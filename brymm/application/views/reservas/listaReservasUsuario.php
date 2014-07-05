<div id="listaReservasUsuario">
    <ul>
        <?php foreach ($reservasUsuario as $reserva): ?>
            <li>
                <?php
                echo $reserva->fecha . "-" . $reserva->hora_inicio . "-"
                . $reserva->nombreLocal . " - "
                . $reserva->numero_personas . " - " . $reserva->estado;
                if ($reserva->estado == 'P' || $reserva->estado == 'AL'):
                    ?>
                    <a onclick="<?php
                    echo "doAjax('" . site_url() . "/reservas/anularReservaUsuario','idReserva="
                    . $reserva->id_reserva . "','listaReservasUsuario','post',1)";
                    ?>"> Anular </a>    
                   <?php endif; ?>
            </li>		
        <?php endforeach; ?>
    </ul>
</div>
