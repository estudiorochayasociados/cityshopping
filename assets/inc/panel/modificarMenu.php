<?php
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';
$borrarImg = $funcion->antihack_mysqli(isset($_GET["borrarImg"]) ? $_GET["borrarImg"] : '');
//
$producto->set("cod", $cod);
$producto_data = $producto->view();
$categoria->set("cod", $producto_data['categoria']);
$categoria_data = $categoria->view();
$imagenes->set("cod", $producto_data['cod']);
$imagenes_data = $imagenes->listForProduct();
if (!empty($producto_data['variantes'])) {
    $variantesMostrar = unserialize($producto_data['variantes']);
} else {
    $variantesMostrar = array(",", ",");
}
if ($borrarImg != '') {
    $imagenes->set("id", $borrarImg);
    $imagenes->delete();
    $funcion->headerMove(URL . "/panel?op=editar&cod=" . $cod);
}
//
$filter = array("area = 'rubros'");
$order = "titulo ASC";
$categoriasArray = $categoria->list($filter, $order, "");

$cod_usuario = $_SESSION['usuarios']['cod'];
$empresa->set("cod_usuario", $cod_usuario);
$empresaData = $empresa->viewv2();
$cod_empresa = $empresaData['cod'];

if (isset($_POST["modificar_menu"])):
    $categoria_post = $funcion->antihack_mysqli(isset($_POST["categoriaMenu"]) ? $_POST["categoriaMenu"] : $producto_data['categoria']);
    $nombre = $funcion->antihack_mysqli(isset($_POST["nombreMenu"]) ? $_POST["nombreMenu"] : $producto_data['titulo']);
    $precio = $funcion->antihack_mysqli(isset($_POST["precioMenu"]) ? $_POST["precioMenu"] : $producto_data['precio']);
    $precioDescuento = $funcion->antihack_mysqli(isset($_POST["precioDescuento"]) ? $_POST["precioDescuento"] : $producto_data['precioDescuento']);
    $desarrollo = $funcion->antihack_mysqli(isset($_POST["desarrolloMenu"]) ? $_POST["desarrolloMenu"] : $producto_data['desarrollo']);
    $stock = $funcion->antihack_mysqli(isset($_POST["stockMenu"]) ? $_POST["stockMenu"] : $producto_data['stock']);

    //variantes
    for ($i = 0; $i < count($_POST["variante1"]); $i++) {
        if ($_POST["variante1"][$i] != '') {
            $variantes_temp[] = $_POST["variante1"][$i] . ',' . $_POST["variante2"][$i];
        }
    }
    if (isset($variantes_temp)) {
        $variantes = serialize($variantes_temp);
    } else {
        $variantes = '';
    }

    $producto->set("cod", $producto_data['cod']);
    $producto->set("cod_empresa", $producto_data['cod_empresa']);
    $producto->set("categoria", $categoria_post);
    $producto->set("titulo", $nombre);
    $producto->set("precio", $precio);
    $producto->set("precioDescuento", $precioDescuento);
    $producto->set("desarrollo", $desarrollo);
    $producto->set("stock", $stock);
    $producto->set("variantes", $variantes);
    $producto->set("fecha", $producto_data['fecha']);

    if (!empty($_FILES["filesEmpresa"]["name"])):
        //galeria
        $count = 0;
        foreach ($_FILES['filesEmpresa']['name'] as $f => $name) {
            $imgInicio = $_FILES["filesEmpresa"]["tmp_name"][$f];
            $tucadena = $_FILES["filesEmpresa"]["name"][$f];
            $partes = explode(".", $tucadena);
            $dom = (count($partes) - 1);
            $dominio = $partes[$dom];
            $prefijo = substr(md5(uniqid(rand())), 0, 15);
            if ($dominio != '') {
                $destinoFinal = "assets/archivos/" . $prefijo . "." . $dominio;
                move_uploaded_file($imgInicio, $destinoFinal);
                chmod($destinoFinal, 0777);
                $destinoRecortado = "assets/archivos/recortadas/a_" . $prefijo . "." . $dominio;

                $zebra->source_path = $destinoFinal;
                $zebra->target_path = $destinoRecortado;
                $zebra->jpeg_quality = 80;
                $zebra->preserve_aspect_ratio = true;
                $zebra->enlarge_smaller_images = true;
                $zebra->preserve_time = true;

                if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)) {
                    unlink($destinoFinal);
                }

                $imagenes->set("cod", $cod);

                $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
                $imagenes->add();
            }

            $count++;
        }
    endif;

    $producto->edit();
    $funcion->headerMove(URL . '/panel?op=productos');
endif;
?>
<!--================================
            START DASHBOARD AREA
    =================================-->
<div class="dashboard_contents">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="dashboard_title_area">
                    <div class="pull-left">
                        <div class="dashboard__title">
                            <h3>Editar producto</h3>
                            <p>Completar campos requeridos <label><sup>*</sup></label></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row -->

        <div class="row">
            <div class="col-md-12 ">
                <div class="upload_modules">
                    <form method="post" enctype="multipart/form-data">
                        <div class="modules__content">
                            <div class="strip_menu_items">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nombre del producto<sup>*</sup></label>
                                                    <input type="text" name="nombreMenu" class="text_field"
                                                           placeholder="Ej. Taladro" value="<?= $producto_data['titulo']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Precio<sup>*</sup></label>
                                                <div class="input-group mb-3" style="height: 50px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" class="form-control" name="precioMenu" value="<?= $producto_data['precio']; ?>" style="height: 50px;" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Precio descuento</label>
                                                <div class="input-group mb-3" style="height: 50px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" value="<?= $producto_data['precioDescuento'] ?>" class="form-control" name="precioDescuento" style="height: 50px;">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Stock<sup>*</sup></label>
                                                <input type="number" name="stockMenu" class="text_field"
                                                       placeholder="Ej. 24" value="<?= $producto_data['stock']; ?>" style="height: 50px;" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Categoría<sup>*</sup></label>
                                                    <div class="select-wrap select-wrap2">
                                                        <select name="categoriaMenu" id="categoriaMenu" class="text_field" required>
                                                            <option value="<?= $categoria_data['cod'] ?>" selected><?= $categoria_data['titulo']; ?></option>
                                                            <?php foreach ($categoriasArray as $key => $value): ?>
                                                                <option value="<?= $value['cod'] ?>"><?= $value['titulo'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <span class="lnr lnr-chevron-down"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Descripción<sup>*</sup></label>
                                            <textarea rows="12" class="text_field" name="desarrolloMenu" required><?= $producto_data['desarrollo']; ?></textarea>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-12">Variantes</label>
                                            <?php
                                            foreach ($variantesMostrar as $key => $value) {
                                                $valor = explode(",", $value);
                                                ?>
                                                <div class="col-md-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="text" value="<?= $valor[0]; ?>" class="form-control" name="variante1[]">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" name="variante2[]" value="<?= $valor[1]; ?>" class="text_field"
                                                               placeholder="Set de mechas chicas">
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <a class="MasCampos col-md-12" href="#" id="mascamposVariante">
                                                <span class="lnr lnr-plus-circle"></span> Agregar más campos</a>
                                        </div>
                                        <hr/>
                                    </div>
                                    <div class="col-md-12">
                                        <?php
                                        foreach ($imagenes_data as $img) {
                                            echo "<div class='col-md-4 mb-20 mt-20'>";
                                                echo "<div style=\"height: 150px;width:140px;background: url('". URL . "/" . $img['ruta'] . "') no-repeat center center/cover;\"></div>";
                                                echo "<a href='" . URL . "/panel?op=editar&cod=" . $producto_data["cod"] . "&borrarImg=" . $img["id"] . "' class='btn btn-primary' style='width: 140px'>BORRAR IMAGEN</a>";
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Fotos del producto</label><br/>
                                        <div id="dropContainer" class="drop_file">
                                        </div>
                                        <label class="btn_full btn btn-primary">
                                            Seleccionar foto<i class="icon-camera"></i>
                                            <input type="file" id="filesEmpresa" name="filesEmpresa[]" multiple="multiple" class="form-control">
                                        </label>
                                    </div>
                                </div><!-- End row -->
                            </div><!-- End strip_menu_items -->
                        </div><!-- End wrapper_indent -->

                        <div class="centro">
                            <div class="add_more_cat text_align_right">
                                <button type="submit" name="modificar_menu" class="btn btn--round btn--md mb-10">Guardar</button>
                            </div>
                        </div><!-- End wrapper_indent -->

                    </form>
                </div>
                <!-- end /.col-md-8 -->
            </div>
            <!-- end /.row -->
        </div>
        <!-- end /.container -->
    </div>
    <!--================================
            END DASHBOARD AREA
    =================================-->
