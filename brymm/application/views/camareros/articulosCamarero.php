<div id="tituloArticulosCamarero"><h4>Articulos</h4></div>
<div id="articulosCamarero">
    <ul>
        <?php
        $idTipoArticulo = 0;
        ?>
        <?php
        foreach ($articulosLocal as $linea):
            if ($linea['id_tipo_articulo'] <> $idTipoArticulo) {
                echo '<b>' . $linea['tipo_articulo'] . '</b>';
            }
            ?>
            <form>
                <li>
                    <?php echo $linea['articulo'] . "-" . $linea['descripcion'] . "-" . $linea['precio']; ?>
                    <br>Cantidad 
                    <!--<input type="text" size="2" maxlength="2" value="1" id="<?php echo "cmd" . $linea['id_articulo_local'] ?>">-->
                    <select  value="1" id="<?php echo "cmd" . $linea['id_articulo_local'] ?>">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                    </select>
                    <a onclick="<?php
                    echo "enviarArticuloComanda('" . site_url() . "/comandas/anadirArticuloComanda','idArticuloLocal="
                    . $linea['id_articulo_local'] . "&precio=" . $linea['precio'] . "&articulo=" . $linea['articulo'] .
                    "&idTipoArticulo=" . $linea['id_tipo_articulo'] . "','cmd" . $linea['id_articulo_local']
                    . "','mostrarComanda',1)";
                    ?>"> + </a>
                </li>
            </form>
            <?php
            $idTipoArticulo = $linea['id_tipo_articulo'];
        endforeach;
        ?>
    </ul>
</div>
<?php
if ($hayPersonalizado):
    ?>
    <div id="articulosPerCamarero"><h4>Articulos personalizados</h4></div>
    <div id="articulosPerCamarero">
        <form id="formArticuloPerCamarero">
            <ul>    
                <?php
                echo "<SELECT name=\"idTipoArticuloLocal\">";
                foreach ($tiposArticuloPerLocal as $linea) {

                    echo "<OPTION value=" . $linea->id_tipo_articulo_local . ">"
                    . $linea->tipo_articulo . "-" . $linea->precio . "</OPTION>";
                }
                echo "</SELECT>";
                foreach ($ingredientesLocal as $linea):
                    ?>

                    <li>
                        <input type="checkbox" name="ingrediente[]" value="<? echo $linea->id_ingrediente; ?>"/>
                        <?php echo $linea->ingrediente . "-" . $linea->precio; ?>
                    </li>

                    <?php
                endforeach;
                ?>
            </ul>
            Cantidad 
            <!--<input type="text" size="2" maxlength="2" value="1" name="cantidadArticuloPersonalizado">-->
            <select  value="1" name="cantidadArticuloPersonalizado">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                    </select>
            <a onclick="<?php
            echo "enviarFormulario('" . site_url() .
            "/comandas/anadirArticuloPerComanda','formArticuloPerCamarero','mostrarComanda',1)"
            ?>"> + </a>
        </form>
    </div>
    <?php
endif;
?>
