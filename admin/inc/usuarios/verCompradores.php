<?php
$usuarios = new Clases\Usuarios();
$funcion = new Clases\PublicFunction();
?>
    <div class="mt-20">
        <div class="col-lg-12 col-md-12">
            <h4>Usuarios Compradores <a class="btn btn-success pull-right" href="<?= URL ?>/index.php?op=usuarios&accion=agregar">AGREGAR
                    USUARIOS</a></h4>
            <hr/>
            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
            <hr/>
            <table class="table  table-bordered  ">
                <thead>
                <th>Nombre</th>
                <th>Email</th>
                <th>Vendedor</th>
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

                $filter = array("vendedor = 0");
                $data = $usuarios->list($filter);
                if (is_array($data)) {
                    for ($i = 0; $i < count($data); $i++) {
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
                        echo "</form>";
                        echo "<td>";
                        echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="' . URL . '/index.php?op=usuarios&accion=modificar&cod=' . $data[$i]["cod"] . '">
                        <i class="fa fa-cog"></i></a>';

                        echo '<a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="' . URL . '/index.php?op=usuarios&accion=verCompradores&borrar=' . $data[$i]["cod"] . '">
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
    $funciones->headerMove(URL . "/index.php?op=usuarios&accion=verCompradores");
}
?>