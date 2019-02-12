<?php
$usuarios = new Clases\Usuarios();
$funcion = new Clases\PublicFunction();
?>
    <div class="mt-20">
        <div class="col-lg-12 col-md-12">
            <h4>Usuarios Vendedores <a class="btn btn-success pull-right" href="<?= URL ?>/index.php?op=usuarios&accion=agregar">AGREGAR
                    USUARIOS</a></h4>
            <hr/>
            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
            <hr/>
            <table class="table  table-bordered  ">
                <thead>
                <th>Nombre</th>
                <th>Email</th>
                <th>Vendedor</th>
                <th>Plan</th>
                <th>Ajustes</th>
                </thead>
                <tbody>
                <?php

                if (isset($_POST["email"])):
                    $cod = $funcion->antihack_mysqli(isset($_POST["cod"]) ? $_POST["cod"] : '');
                    $email = $funcion->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
                    $vendedor = $funcion->antihack_mysqli(isset($_POST["vendedor"]) ? $_POST["vendedor"] : 0);

                    $usuarios->set("cod", $cod);
                    $usuarios->set("email", $email);
                    $usuarios->editUnico("vendedor", $vendedor);

                endif;

                if (isset($_POST["email"])):
                    $cod = $funcion->antihack_mysqli(isset($_POST["cod"]) ? $_POST["cod"] : '');
                    $email = $funcion->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
                    $plan = $funcion->antihack_mysqli(isset($_POST["plan"]) ? $_POST["plan"] : 1);

                    $usuarios->set("cod", $cod);
                    $usuarios->set("email", $email);
                    $usuarios->editUnico("plan", $plan);

                endif;

                $filter = array("vendedor = 1");
                $data = $usuarios->list($filter, "", "");
                if (is_array($data)) {
                    for ($i = 0; $i < count($data); $i++) {
                        if($data[$i]['plan'] == 1){$plan1 = 'selected';}else{$plan1 = '';}
                        if($data[$i]['plan'] == 2){$plan2 = 'selected';}else{$plan2 = '';}
                        if($data[$i]['plan'] == 3){$plan3 = 'selected';}else{$plan3 = '';}
                        if(strtoupper($data[$i]["vendedor"]) == 1):
                            $check = "checked";
                        else:
                            $check = "";
                        endif;
                        echo "<tr>";
                        echo "<td>" . strtoupper($data[$i]["nombre"]) . " " . strtoupper($data[$i]["apellido"]) . "</td>";
                        echo "<td>" . strtoupper($data[$i]["email"]) . "</td>";
                        echo "<form method='post'>";
                        echo "<td>";
                        echo "<input type='hidden' name='cod' value='".strtoupper($data[$i]["cod"])."' >";
                        echo "<input type='hidden' name='email' value='".strtoupper($data[$i]["email"])."' >";
                        echo "<input type='checkbox' onchange='this.form.submit()' name='vendedor' value='1' ".$check.">";
                        echo "</td>";
                        echo "<td><select name='plan' onchange='this.form.submit()'>";
                        echo "<option value='1'".$plan1.">Básico</option>";
                        echo "<option value='2'".$plan2.">Medio</option>";
                        echo "<option value='3'".$plan3.">Completo</option>";
                        echo "</select></td>";
                        echo "</form>";
                        echo "<td>";
                        echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="' . URL . '/index.php?op=usuarios&accion=modificar&cod=' . $data[$i]["cod"] . '">
                        <i class="fa fa-cog"></i></a>';

                        echo '<a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="' . URL . '/index.php?op=usuarios&accion=verVendedores&borrar=' . $data[$i]["cod"] . '">
                        <i class="fa fa-trash"></i></a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
if (isset($_GET["borrar"])) {
    $cod = $funciones->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : '');
    $usuarios->set("cod",$cod);
    $usuarios->delete();
    $funciones->headerMove(URL . "/index.php?op=usuarios&accion=verVendedores");
}
?>