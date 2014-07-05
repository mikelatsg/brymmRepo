
<div id="listaLocal">
    <?php echo "Se han encontrado " . $numLocalesEncontrados . " locales."; ?>
    <ul>
        <?php foreach ($locales as $linea): ?>
            <li>
                <?php
                echo anchor('/locales/mostrarLocal/' . $linea->id_local, $linea->nombre .
                        "-" . $linea->direccion . "-" . $linea->localidad);
                if ($_SESSION['idUsuario']):
                    ?>
                    <a onclick="
                    <?php
                    echo "doAjax('" . site_url() . "/locales/anadirLocalFavorito','idLocal="
                    . $linea->id_local . "','','post',1)";
                    ?>
                       "> F </a>  
                   <?php endif; ?>
            </li>		
        <?php endforeach; ?>
    </ul>
</div>

