<div id="tituloComandasActivas"><h4>Comandas activas</h4></div>
<div id="listaComandasActivas">
    <ul>
        <?php foreach ($comandasActivas as $comanda): ?>
            <li> 
                <?php
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
                echo "doAjax('" . site_url() . "/camareros/cerrarComandaCamarero','idComanda="
                . $comanda->id_comanda . "','listaComandas','post',1)";
                ?>
                   "> Cerrar </a>
                <a onclick="<?php
                echo "doAjax('" . site_url() . "/camareros/cancelarComandaCamarero','idComanda="
                . $comanda->id_comanda . "','listaComandas','post',1)";
                ?>
                   "> Cancelar </a>

                <a onclick="<?php
                echo "doAjax('" . site_url() . "/camareros/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','listaComandas','post',1)";
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
                echo "doAjax('" . site_url() . "/camareros/verComandaCamarero','idComanda="
                . $comanda->id_comanda . "','listaComandas','post',1)";
                ?>
                   "> Ver </a>
            </li>		
            <?php
        endforeach;
        ?>
    </ul>
</div>
