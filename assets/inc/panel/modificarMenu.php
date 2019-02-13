<?php
$filterCategoria = array("area = 'productos'");
$order = "titulo ASC";
$categoriasArray = $categoria->list($filterCategoria, $order, "");
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';
$menu->set("cod", $cod);
$menuData = $menu->view();

$filterSeccion = array("cod_empresa = '$menuData[cod_empresa]'");
$seccionesArray = $seccion->list($filterSeccion, $order, "");

$seccion->set("cod", $menuData['seccion']);
$seccionData = $seccion->view();

$imagenes->set("cod", $menuData['cod']);
$imagenData = $imagenes->view();

if (!empty($menuData['variantes'])) {
    $variantesMostrar = unserialize($menuData['variantes']);
} else {
    $variantesMostrar = array(",", ",");
}
if (!empty($menuData['adicionales'])) {
    $adicionalesMostrar = unserialize($menuData['adicionales']);
} else {
    $adicionalesMostrar = array(",", ",");
}
?>

<?php
if (isset($_POST["modificar_menu"])):
    $categoria = $funcion->antihack_mysqli(!empty($_POST["categoriaMenu"]) ? $_POST["categoriaMenu"] : '');
    $seccion = $funcion->antihack_mysqli(!empty($_POST["seccionMenu"]) ? $_POST["seccionMenu"] : '');
    $titulo = $funcion->antihack_mysqli(!empty($_POST["tituloMenu"]) ? $_POST["tituloMenu"] : '');
    $precio = $funcion->antihack_mysqli(!empty($_POST["precioMenu"]) ? $_POST["precioMenu"] : '');
    $desarrollo = $funcion->antihack_mysqli(!empty($_POST["desarrolloMenu"]) ? $_POST["desarrolloMenu"] : '');
    $stock = $funcion->antihack_mysqli(!empty($_POST["stockMenu"]) ? $_POST["stockMenu"] : '');


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

    if (!$seccionesArray) {
        $seccionesArray = array(0 => array("cod" => "vacio"));
    }
    foreach ($seccionesArray as $key => $value):
        $seccionValores[] = $value['cod'];
    endforeach;
    if (array_search($seccion, $seccionValores) === false):
        $seccionNueva = new Clases\Secciones();
        $cod_seccion = substr(md5(uniqid(rand())), 0, 10);
        $seccionNueva->set("cod", $cod_seccion);
        $seccionNueva->set("titulo", $seccion);
        $seccionNueva->set("cod_empresa", $menuData['cod_empresa']);
        $seccionNueva->add();
        $seccion = $cod_seccion;
    endif;

    $menu->set("cod", $menuData['cod']);
    $menu->set("cod_empresa", $menuData['cod_empresa']);
    $menu->set("categoria", $categoria);
    $menu->set("seccion", $seccion);
    $menu->set("titulo", $titulo);
    $menu->set("precio", $precio);
    $menu->set("desarrollo", $desarrollo);
    $menu->set("stock", $stock);
    $menu->set("variantes", $variantes);
    $menu->set("adicionales", $adicionales);
    $menu->set("fecha", $menuData['fecha']);

    if (isset($_FILES["files"]["name"])):
        //imagen
        $imgInicio = $_FILES["files"]["tmp_name"];
        $tucadena = $_FILES["files"]["name"];
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
            $imagenes->deleteAll();
            $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
            $imagenes->add();
        }
        //imagen
    endif;

    $menu->edit();
    $funcion->headerMove(URL . '/panel?op=modificarMenu&cod=' . $cod);
endif;
?>

<div class="row">
    <div class="col-md-2">
        <a href="<?= URL ?>/panel#seccion-2" class="btn_full"><i class="icon-reply"></i> Ir al panel</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <section id="section-2">
            <div class="indent_title_in">
                <i class="icon_document_alt"></i>
                <h3>Modificar Menú</h3>
                <p>Especifique a continuación los detalles del menú.</p>
            </div>

            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Categoría</label>
                    <select class="form-control" name="categoriaMenu" id="categoriaMenu">
                        <option value="" disabled selected>Seleccionar Categoría</option>
                        <?php foreach ($categoriasArray as $key => $value):
                            if ($menuData['categoria'] == $value['cod']): ?>
                                <option value="<?= $value['cod'] ?>" selected><?= $value['titulo'] ?></option>
                            <?php else: ?>
                                <option value="<?= $value['cod'] ?>"><?= $value['titulo'] ?></option>
                            <?php endif;
                        endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Sección</label>
                    <select class="form-control" name="seccionMenu" id="seccionMenu">
                        <option value="" disabled selected>Seleccionar Sección</option>
                        <?php foreach ($seccionesArray as $key => $value):
                            if ($menuData['seccion'] == $value['cod']): ?>
                                <option value="<?= $value['cod'] ?>" selected><?= $value['titulo'] ?></option>
                            <?php else: ?>
                                <option value="<?= $value['cod'] ?>"><?= $value['titulo'] ?></option>
                            <?php endif;
                        endforeach; ?>
                    </select>
                </div>
                <a class="MasCampos col-md-12" href="#position" id="btnSecciones"><i
                            class="icon_plus_alt"></i> Agregar</a>
                <div class="row">
                    <div class="col-md-3">
                        <input class="form-control" id="val1" style="display: none;"
                               placeholder="Ej. Platos Vegetarianos"/>
                        <a class="btn_full col-md-12" href="#position" id="masSecciones" style="display: none;">
                            Agregar</a>
                    </div>
                </div>
                <br/>
                <hr/>

                <div class="strip_menu_items">
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Subir foto del menú</label><br/>
                            <div id="dropContainer" class="drop_file">
                                <span id="spanDrop" style="display: none;">Arrastrar aquí</span>
                                <img id="imgSalida" src="<?= URL; ?>/<?= $imagenData['ruta'] ?>" width="100%"
                                     src=""/>
                            </div>
                            <label class="btn_full btn btn-primary">
                                Seleccionar foto<i class="icon-camera"></i>
                                <input type="file" id="fileInput" name="files" class="form-control">
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Nombre del menú</label>
                                        <input type="text" value="<?= $menuData['titulo'] ?>" name="tituloMenu"
                                               class="form-control"
                                               placeholder="Ej. Pizza Napolitana">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input type="text" value="<?= $menuData['precio'] ?>" name="precioMenu"
                                               class="form-control"
                                               placeholder="Ej. 180">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Breve descripción</label>
                                <input type="text" value="<?= $menuData['desarrollo'] ?>" name="desarrolloMenu"
                                       class="form-control"
                                       placeholder="Ej. Pizza cocinada a la piedra de masa casera">
                            </div>
                            <div class="row">
                                <label class="col-md-12">Variantes</label>
                                <?php foreach ($variantesMostrar as $key => $value):
                                    $valor = explode(",", $value); ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" value="<?= $valor[0]; ?>"
                                                   name="variante1[]" class="form-control"
                                                   placeholder="20.00">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" value="<?= $valor[1]; ?>"
                                                   name="variante2[]" class="form-control"
                                                   placeholder="Extra queso">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <a class="MasCampos col-md-12" href="#" id="mascamposVariante"><i
                                            class="icon_plus_alt"></i> Agregar más campos</a>
                            </div>
                            <hr/>
                            <div class="row">
                                <label class="col-md-12">Adicionales</label>
                                <?php foreach ($adicionalesMostrar as $key => $value):
                                    $valor = explode(",", $value); ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" value="<?= $valor[0]; ?>"
                                                   name="adicional1[]" class="form-control"
                                                   placeholder="40.00">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" value="<?= $valor[1]; ?>"
                                                   name="adicional2[]" class="form-control"
                                                   placeholder="x1 Coca-cola 500cc">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <a class="MasCampos col-md-12" href="#" id="mascamposAdicional"><i
                                            class="icon_plus_alt"></i> Agregar más campos</a>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Stock</label>
                                    <input type="text" value="<?= $menuData['stock'] ?>" name="stockMenu"
                                           class="form-control" placeholder="Ej. 24">
                                </div>
                            </div>
                        </div>
                    </div><!-- End row -->
                </div><!-- End strip_menu_items -->
    </div><!-- End wrapper_indent -->
    <hr class="styled_2">
    <div class="col-md-2">
        <button type="submit" name="modificar_menu" class="btn_1">Modificar</button>
    </div>
    </form>
    </section><!-- End section 2 -->
</div><!-- End col-md-6 -->
</div><!-- End row -->

<!-- SPECIFIC SCRIPTS -->
<script src="<?= URL ?>/assets/js/theia-sticky-sidebar.js"></script>
<script>
    jQuery('#sidebar').theiaStickySidebar({
        additionalMarginTop: 80
    });
</script>

<script>//Script para arrastrar imagenes
    dropContainer.ondragover = dropContainer.ondragenter = function (evt) {
        evt.preventDefault();
    };

    dropContainer.ondrop = function (evt) {
        fileInput.files = evt.dataTransfer.files;
        evt.preventDefault();
    };
</script>

<script>//Script para mostrar vista previa de la imagen cargada
    $(window).load(function () {

        $(function () {
            $('#fileInput').change(function (e) {
                addImage(e);
            });

            function addImage(e) {
                var file = e.target.files[0],
                    imageType = /image.*/;

                if (!file.type.match(imageType))
                    return;

                var reader = new FileReader();
                reader.onload = fileOnload;
                reader.readAsDataURL(file);
            }

            function fileOnload(e) {
                var result = e.target.result;
                $('#imgSalida').attr("src", result);
                document.getElementById('spanDrop').style.display = "none";
            }
        });
    });
</script>

<script>//Script para que el usuario genere nuevos campos
    jQuery.fn.generaNuevosCampos = function (nombreCampo1, nombreCampo2) {
        $(this).each(function () {
            elem = $(this);
            elem.data("nombreCampo1", nombreCampo1);
            elem.data("nombreCampo2", nombreCampo2);

            elem.click(function (e) {
                e.preventDefault();
                elem = $(this);
                nombreCampo1 = elem.data("nombreCampo1");
                nombreCampo2 = elem.data("nombreCampo2");
                texto_insertar = '<div class="col-md-4"><div class="form-group"><input type="text" name="' + nombreCampo1 + '" class="form-control" /></div></div><div class="col-md-8"><div class="form-group"><input type="text" name="' + nombreCampo2 + '" class="form-control" /></div></div>';
                nuevo_campo = $(texto_insertar);
                elem.before(nuevo_campo);
            });
        });
        return this;
    }

    $(document).ready(function () {
        $("#mascamposVariante").generaNuevosCampos("variante1[]", "variante2[]");
    });

    $(document).ready(function () {
        $("#mascamposAdicional").generaNuevosCampos("adicional1[]", "adicional2[]");
    });
</script>


<script>//agregar option a seccion
    document.getElementById('btnSecciones').addEventListener('click', function () {
        document.getElementById('val1').style.display = 'block';
        document.getElementById('masSecciones').style.display = 'block';
    }, false);

    $(document).ready(function () {
        $("#masSecciones").click(function () {
            var resultado = $("#val1").val();
            var option = "<option value='" + resultado + "' selected>" + resultado + "</option>";
            $("#seccionMenu").append(option);
            $("#val1").val("");
        });
    });
</script>
