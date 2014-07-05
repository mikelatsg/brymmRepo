<div id="tituloComandasActivas"><h4>Comandas activas</h4></div>
<div id="listaComandasActivas">
    <ul>
        <?php foreach ($comandasActivas as $comanda): ?>
            <li> 
                <?php
                echo $comanda->id_comanda . " - ";
                if ($comanda->id_mesa == 0) {
                    echo $comanda->destino;
                } else {
                    echo $comanda->nombreMesa;
                }
                echo " - " . $comanda->nombreCamarero
                . " - " . $comanda->precio . " - " . $comanda->estado . " - "
                . $comanda->fecha_alta;
                if ($comanda->estado == "EC"):
                    ?>
                    <a onclick="<?php
                    echo "doAjax('" . site_url() . "/comandas/terminarComandaCocina','idComanda="
                    . $comanda->id_comanda . "','listaComandasCocina','post',1)";
                    ?>
                       "> Terminar </a>  
                   <?php endif; ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','mostrarComandaRealizadaCocina','post',1)";
                ?>
                   "> Ver </a>
            </li>		
            <?php
        endforeach;
        ?>
    </ul>
</div>
<div id="tituloComandasCerradas"><h4>Comandas cerradas</h4></div>
<div id="listaComandasCerradas">
    <ul>
        <?php foreach ($comandasCerradas as $comanda): ?>
            <li> 
                <?php
                echo $comanda->id_comanda . " - ";
                if ($comanda->id_mesa == 0) {
                    echo $comanda->destino;
                } else {
                    echo $comanda->nombreMesa;
                }
                echo "-" . $comanda->nombreCamarero
                . "-" . $comanda->precio . "-" . $comanda->estado . "-"
                . $comanda->fecha_alta;
                ?>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/comandas/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','mostrarComandaRealizada','post',1)";
                ?>
                   "> Ver </a>
            </li>		
            <?php
        endforeach;
        ?>
    </ul>
</div>
<div id="tituloMostrarComanda"><h4>Comanda</h4></div>
<div id="mostrarComanda">   
</div>