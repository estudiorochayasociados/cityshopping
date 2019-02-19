<?php
$filter = array("area = 'rubros'");
$order = "titulo ASC";
$categoriasArray = $categoria->list($filter, $order, "");

$cod_usuario = $_SESSION['usuarios']['cod'];
$empresa->set("cod_usuario", $cod_usuario);
$empresaData = $empresa->view();
$cod_empresa = $empresaData['cod'];

$filterSeccion = array("cod_empresa = '$cod_empresa'");
$seccionesArray = $seccion->list($filterSeccion, $order, "");
?>
<?php
if (isset($_POST["crear_menu"])):
    $categoria = $funcion->antihack_mysqli(isset($_POST["categoriaMenu"]) ? $_POST["categoriaMenu"] : '');
    $seccion = $funcion->antihack_mysqli(isset($_POST["seccionMenu"]) ? $_POST["seccionMenu"] : '');
    $nombre = $funcion->antihack_mysqli(isset($_POST["nombreMenu"]) ? $_POST["nombreMenu"] : '');
    $precio = $funcion->antihack_mysqli(isset($_POST["precioMenu"]) ? $_POST["precioMenu"] : '');
    $desarrollo = $funcion->antihack_mysqli(isset($_POST["desarrolloMenu"]) ? $_POST["desarrolloMenu"] : '');
    $stock = $funcion->antihack_mysqli(isset($_POST["stockMenu"]) ? $_POST["stockMenu"] : '');

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

    //adicionales
    for ($i = 0; $i < count($_POST["adicional1"]); $i++) {
        if ($_POST["adicional1"][$i] != '') {
            $adicionales_temp[] = $_POST["adicional1"][$i] . ',' . $_POST["adicional2"][$i];
        }
    }
    if (isset($adicionales_temp)) {
        $adicionales = serialize($adicionales_temp);
    } else {
        $adicionales = '';
    }

    if (empty($seccionesArray)):
        $seccionNueva = new Clases\Secciones();
        $cod_seccion = substr(md5(uniqid(rand())), 0, 10);
        $seccionNueva->set("cod", $cod_seccion);
        $seccionNueva->set("titulo", $seccion);
        $seccionNueva->set("cod_empresa", $empresaData['cod']);
        $seccionNueva->add();
        $seccion = $cod_seccion;
    else:
        foreach ($seccionesArray as $key => $value):
            $seccionValores[] = $value['cod'];
        endforeach;
        if (array_search($seccion, $seccionValores) === false):
            $seccionNueva = new Clases\Secciones();
            $cod_seccion = substr(md5(uniqid(rand())), 0, 10);
            $seccionNueva->set("cod", $cod_seccion);
            $seccionNueva->set("titulo", $seccion);
            $seccionNueva->set("cod_empresa", $empresaData['cod']);
            $seccionNueva->add();
            $seccion = $cod_seccion;
        endif;
    endif;

    $cod = substr(md5(uniqid(rand())), 0, 10);

    $fecha = getdate();
    $fecha = $fecha['year'] . '-' . $fecha['mon'] . '-' . $fecha['mday'];

    $producto->set("cod", $cod);
    $producto->set("cod_empresa", $cod_empresa);
    $producto->set("categoria", $categoria);
    $producto->set("seccion", $seccion);
    $producto->set("titulo", $nombre);
    $producto->set("precio", $precio);
    $producto->set("desarrollo", $desarrollo);
    $producto->set("stock", $stock);
    $producto->set("variantes", $variantes);
    $producto->set("adicionales", $adicionales);
    $producto->set("fecha", $fecha);

    if (!empty($_FILES["filesEmpresa"]["name"])):
        //galeria
        $count = 0;
        foreach ($_FILES['filesEmpresa']['name'] as $f => $name) {
            $imgInicio = $_FILES["filesEmpresa"]["tmp_name"][$f];
            $tucadena = $_FILES["filesEmpresa"]["name"][$f];
            $partes = explode(".", $tucadena);
            $dom = (count($partes) - 1);
            $dominio = $partes[$dom];
            $prefijo = substr(md5(uniqid(rand())), 0, 10);
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

    $producto->add();
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
                            <h3>Nuevo producto</h3>
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
                            <div class="form-group">
                                <label>Categoría</label>
                                <select class="form-control" name="categoriaMenu" id="categoriaMenu">
                                    <option value="" selected disabled>Categorías</option>
                                    <?php foreach ($categoriasArray as $key => $value): ?>
                                        <option value="<?= $value['cod'] ?>"><?= $value['titulo'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sección</label>
                                <select class="form-control" name="seccionMenu" id="seccionMenu">
                                    <option value="" disabled selected>Seleccionar Sección</option>
                                    <?php foreach ($seccionesArray as $key => $value): ?>
                                        <option value="<?= $value['cod'] ?>"><?= $value['titulo'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <a class="MasCampos col-md-12" href="#position" id="btnSecciones"><i
                                        class="icon_plus_alt"></i> Agregar</a>
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="text_field" id="val1" style="display: none;"
                                           placeholder="Ej. Platos Vegetarianos"/>
                                    <a class="btn_full col-md-12" href="#position" id="masSecciones" style="display: none;">
                                        Agregar</a>
                                </div>
                            </div>
                            <br/>
                            <hr/>

                            <div class="strip_menu_items">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Nombre del menú</label>
                                                    <input type="text" name="nombreMenu" class="text_field"
                                                           placeholder="Ej. Pizza Napolitana">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Precio</label>
                                                    <input type="text" name="precioMenu" class="text_field"
                                                           placeholder="Ej. 180">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <textarea name="desarrolloMenu"></textarea>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-12">Variantes</label>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" name="variante1[]" class="text_field"
                                                           placeholder="20.00">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input type="text" name="variante2[]" class="text_field"
                                                           placeholder="Extra queso">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" name="variante1[]" class="text_field"
                                                           placeholder="00.00">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input type="text" name="variante2[]" class="text_field"
                                                           placeholder="Sin aceitunas">
                                                </div>
                                            </div>
                                            <a class="MasCampos col-md-12" href="#" id="mascamposVariante"><i
                                                        class="icon_plus_alt"></i> Agregar más campos</a>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <label class="col-md-12">Adicionales</label>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" name="adicional1[]" class="text_field"
                                                           placeholder="40.00">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input type="text" name="adicional2[]" class="text_field"
                                                           placeholder="x1 Coca-cola 500cc">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" name="adicional1[]" class="text_field"
                                                           placeholder="20.00">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input type="text" name="adicional2[]" class="text_field"
                                                           placeholder="x1 Bolsa de Hielo 5kg">
                                                </div>
                                            </div>
                                            <a class="MasCampos col-md-12" href="#" id="mascamposAdicional"><i
                                                        class="icon_plus_alt"></i> Agregar más campos</a>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label>Stock</label>
                                                <input type="text" name="stockMenu" class="text_field"
                                                       placeholder="Ej. 24">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Fotos del producto</label><br/>
                                        <div id="dropContainer" class="drop_file">
                                        </div>
                                        <label class="btn_full btn btn-primary">
                                            Seleccionar foto<i class="icon-camera"></i>
                                            <input type="file" id="filesEmpresa" name="filesEmpresa[]"  multiple="multiple" class="form-control">
                                        </label>
                                    </div>
                                </div><!-- End row -->
                            </div><!-- End strip_menu_items -->
                        </div><!-- End wrapper_indent -->

                        <div class="centro">
                            <div class="add_more_cat text_align_right">
                                <button type="submit" name="crear_menu" class="btn btn--round btn--md">Crear</button>
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
