<?php
$empresas = new Clases\Empresas();
$usuarios = new Clases\Usuarios();
$funcion = new Clases\PublicFunction();
$producto = new Clases\Productos();
$imagen = new Clases\Imagenes();
?>
    <div class="mt-20">
        <div class="col-lg-12 col-md-12">
            <h4>Empresas</h4>
            <hr/>
            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
            <hr/>
            <table class="table table-bordered">
                <thead>
                <th>Nombre</th>
                <th>Ajustes</th>
                </thead>
                <tbody>
                <?php
                $filter = array();
                $data = $empresas->list("", "", "");
                if (is_array($data)) {
                    for ($i = 0; $i < count($data); $i++) {
                        $usuarios->set("cod",$data[$i]["cod_usuario"]);
                        $usuarioData = $usuarios->view();
                        $email = $usuarioData["email"];
                        $password = $usuarioData["password"];
                        $cod = $usuarioData["cod"];
                        echo "<tr>";
                        echo "<td>" . strtoupper($data[$i]["titulo"]) . "</td>";
                        echo "<td>";
                        echo '<form target="_blank" method="post" action="' . URLSITE . '/loginEmpresa.php" style="float: left;">';
                        echo '<input name="email" type="hidden" value="'.$email.'" />';
                        echo '<input name="password" type="hidden" value="'.$password.'" />';
                        echo '<input name="cod" type="hidden" value="'.$cod.'" />';
                        echo '<button class="btn btn-info" type="submit" > <i class="fa fa-cog" ></i ></button >';
                        echo '</form>';
                        echo '<a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="' . URL . '/index.php?op=empresas&accion=ver&borrar=' . $data[$i]["cod"] . '">
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
    $empresas->set("cod",$cod);
    $producto_data=$producto->list(array("cod_empresa='".$cod."'"),'','');
    if (!empty($producto_data)){
        foreach ($producto_data as $prod){
            $producto->set("cod",$prod['cod']);
            $imagen->set("cod",$prod['cod']);
            $imagen->deleteAll();
            $producto->delete();
        }
    }
    $empresas->delete();
    $funciones->headerMove(URL . "/index.php?op=empresas");
}
?>