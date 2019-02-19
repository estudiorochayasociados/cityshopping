<?php
$contenido = new Clases\Contenidos();
$contenido->set("cod","Empresa creada");
$contenido_data=$contenido->view();
?>
<div class="dashboard-area">
    <div class="dashboard_contents">
        <div class="container">
            <div class="dashboard_title_area">
                <div class="dashboard__title">
                    <h1>Crea tu empresa en 3 simples pasos:</h1>
                    <p>Paso 3: subir logotipo y galerias de la empresa.</p>
                </div>
            </div>
            <?php
            $senal = 0;
            if (isset($_POST["crear_empresa_paso3"])):
                $senal = 1;

                $cod_usuario = $_SESSION['usuarios']['cod'];
                $empresa->set("cod_usuario", $cod_usuario);
                $empresaData = $empresa->view();

                $empresa->set("id", $empresaData['id']);
                $empresa->set("cod", $empresaData['cod']);
                $empresa->set("titulo", $empresaData['titulo']);
                $empresa->set("telefono", $empresaData['telefono']);
                $empresa->set("email", $empresaData['email']);
                $empresa->set("desarrollo", $empresaData['desarrollo']);
                $empresa->set("fecha", $empresaData['fecha']);
                $empresa->set("cod_usuario", $empresaData['cod_usuario']);
                $empresa->set("provincia", $empresaData['provincia']);
                $empresa->set("ciudad", $empresaData['ciudad']);
                $empresa->set("barrio", $empresaData['barrio']);
                $empresa->set("direccion", $empresaData['direccion']);
                $empresa->set("postal", $empresaData['postal']);
                $empresa->set("coordenadas", $empresaData['coordenadas']);

                //logo
                $imgInicio = $_FILES["logo"]["tmp_name"];
                $tucadena = $_FILES["logo"]["name"];
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

                    $empresa->set("logo", str_replace("../", "", $destinoRecortado));
                }
                //logo

                if (!empty($_FILES["portada"]["name"])):
                    //portada
                    $imgInicio = $_FILES["portada"]["tmp_name"];
                    $tucadena = $_FILES["portada"]["name"];
                    $partes = explode(".", $tucadena);
                    $dom = (count($partes) - 1);
                    $dominio = $partes[$dom];
                    $prefijo = substr(md5(uniqid(rand())), 0, 10);
                    if ($dominio != ''):
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

                        if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)):
                            unlink($destinoFinal);
                        endif;

                        $empresa->set("portada", str_replace("../", "", $destinoRecortado));
                    endif;
                //portada
                else:
                    $empresa->set("portada", $empresaData['portada']);
                endif;

                //galeria
                $count = 0;
                foreach ($_FILES['files']['name'] as $f => $name) {
                    $imgInicio = $_FILES["files"]["tmp_name"][$f];
                    $tucadena = $_FILES["files"]["name"][$f];
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

                        $imagenes->set("cod", $empresaData['cod']);
                        $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
                        $imagenes->add();
                    }

                    $count++;
                }
                //galeria

                $empresa->edit();
            endif;
            ?>
            <div class="information_module">
                <div class="information_module">
                    <div class="information__set toggle_module collapse show">
                        <div class="information_wrapper form--fields">
                            <?php if ($senal == 0): ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box_style_2" id="order_process">
                                            <form id="paso3" method="post" enctype="multipart/form-data">
                                                <h2 class="inner">Logo y Creación</h2>
                                                <div class="form-group">
                                                    <h3>Logo</h3><br/>
                                                    <input class="input-imagen" type="file" id="logo" name="logo"/>
                                                </div>
                                                <hr/>
                                                <div class="hidden-plan1 form-group">
                                                    <h3>Portada</h3><br/>
                                                    <input class="input-imagen" type="file" id="portada" name="portada"/>
                                                </div>
                                                <hr/>
                                                <div class="hidden-plan1 form-group">
                                                    <h3>Galería</h3>
                                                    <label>Subir fotos para armar una galería de tu empresa</label><br/>
                                                    <input class="input-imagen" type="file" id="file" name="files[]" multiple="multiple"/>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <button class="btn btn--round btn--md" name="crear_empresa_paso3" type="submit">¡ FINALIZAR !</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- End box_style_1 -->
                                    </div><!-- End col-md-6 -->
                                </div><!-- End row -->
                            <?php endif; ?>

                            <?php if ($senal == 1): ?>
                                <!-- Content ================================================== -->
                                <div class="container margin_60_35">
                                    <div class="row">
                                        <div class="col-md-12 centro">
                                            <div class="box_style_2">
                                                <div id="confirm">
                                                    <?=$contenido_data['contenido'];?>
                                                </div>
                                                <a class="btn btn--round btn--md" href="<?= URL; ?>/panel">Panel de empresa <i class="icon-shop-1"></i></a>
                                            </div>
                                        </div>
                                    </div><!-- End row -->
                                </div><!-- End container -->
                                <!-- End Content =============================================== -->
                            <?php endif; ?>
                        </div>
                        <!-- end /.information_wrapper -->
                    </div>
                    <!-- end /.information__set -->
                </div>
                <!-- end /.information_module -->
            </div>
        </div>
    </div>
</div>
<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?= URL ?>/assets/img/bkg.jpg" data-natural-width="1400" >
    <div id="subheader">
        <div id="sub_content">
            <h1>Crea tu empresa en 3 simples pasos</h1>
            <div class="bs-wizard">
                <div class="col-xs-4 bs-wizard-step active">
                    <div class="text-center bs-wizard-stepnum"><strong>1.</strong> Descripción</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="#0" class="bs-wizard-dot"></a>
                </div>

                <div class="col-xs-4 bs-wizard-step active">
                    <div class="text-center bs-wizard-stepnum"><strong>2.</strong> Ubicación</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="cart_2.html" class="bs-wizard-dot"></a>
                </div>

                <div class="col-xs-4 bs-wizard-step active">
                    <div class="text-center bs-wizard-stepnum"><strong>3.</strong> Logo y Creación</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="cart_3.html" class="bs-wizard-dot"></a>
                </div>
            </div><!-- End bs-wizard -->
        </div><!-- End sub_content -->
    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<?php
$senal = 0;
if (isset($_POST["crear_empresa_paso3"])):
    $senal = 1;

    $cod_usuario = $_SESSION['usuarios']['cod'];
    $empresa->set("cod_usuario", $cod_usuario);
    $empresaData = $empresa->view();

    $empresa->set("id", $empresaData['id']);
    $empresa->set("cod", $empresaData['cod']);
    $empresa->set("titulo", $empresaData['titulo']);
    $empresa->set("telefono", $empresaData['telefono']);
    $empresa->set("email", $empresaData['email']);
    $empresa->set("desarrollo", $empresaData['desarrollo']);
    $empresa->set("fecha", $empresaData['fecha']);
    $empresa->set("cod_usuario", $empresaData['cod_usuario']);
    $empresa->set("provincia", $empresaData['provincia']);
    $empresa->set("ciudad", $empresaData['ciudad']);
    $empresa->set("barrio", $empresaData['barrio']);
    $empresa->set("direccion", $empresaData['direccion']);
    $empresa->set("postal", $empresaData['postal']);
    $empresa->set("coordenadas", $empresaData['coordenadas']);

    //logo
    $imgInicio = $_FILES["logo"]["tmp_name"];
    $tucadena = $_FILES["logo"]["name"];
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

        $empresa->set("logo", str_replace("../", "", $destinoRecortado));
    }
    //logo

    if (!empty($_FILES["portada"]["name"])):
        //portada
        $imgInicio = $_FILES["portada"]["tmp_name"];
        $tucadena = $_FILES["portada"]["name"];
        $partes = explode(".", $tucadena);
        $dom = (count($partes) - 1);
        $dominio = $partes[$dom];
        $prefijo = substr(md5(uniqid(rand())), 0, 10);
        if ($dominio != ''):
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

            if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)):
                unlink($destinoFinal);
            endif;

            $empresa->set("portada", str_replace("../", "", $destinoRecortado));
        endif;
    //portada
    else:
        $empresa->set("portada", $empresaData['portada']);
    endif;

    //galeria
    $count = 0;
    foreach ($_FILES['files']['name'] as $f => $name) {
        $imgInicio = $_FILES["files"]["tmp_name"][$f];
        $tucadena = $_FILES["files"]["name"][$f];
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

            $imagenes->set("cod", $empresaData['cod']);
            $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
            $imagenes->add();
        }

        $count++;
    }
    //galeria

    $empresa->edit();
endif;
?>

<?php if ($senal == 0): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box_style_2" id="order_process">
                <form id="paso3" method="post" enctype="multipart/form-data">
                    <h2 class="inner">Logo y Creación</h2>
                    <div class="form-group">
                        <h3>Logo</h3><br/>
                        <input type="file" id="logo" name="logo"/>
                    </div>
                    <hr/>
                    <div class="hidden-plan1 form-group">
                        <h3>Portada</h3><br/>
                        <input type="file" id="portada" name="portada"/>
                    </div>
                    <hr/>
                    <div class="hidden-plan1 form-group">
                        <h3>Galería</h3>
                        <label>Subir fotos para armar una galería de tu empresa</label><br/>
                        <input type="file" id="file" name="files[]" multiple="multiple"/>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn_full btn btn-primary" name="crear_empresa_paso3" type="submit">¡ FINALIZAR !</button>
                        </div>
                    </div>
                </form>
            </div><!-- End box_style_1 -->
        </div><!-- End col-md-6 -->
    </div><!-- End row -->
<?php endif; ?>

<?php if ($senal == 1): ?>
    <!-- Content ================================================== -->
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="box_style_2">
                    <h2 class="inner">¡Empresa creada!</h2>
                    <div id="confirm">
                        <i class="icon_check_alt2"></i>
                        <h3>¡Bienvenido/a!</h3>
                        <p class="hidden-plan2 hidden-plan3">
                            Ya formás parte de la plataforma. Podés ver tu empresa en la pestaña de <a target="_blank" href="<?=URL?>/restaurantes">restaurantes</a>.
                        </p>
                        <p class="hidden-plan1 hidden-plan3">
                            Ya formás parte de la plataforma, lo único que necesitás es añadir los menús que ofrecés. Podés ver tu empresa en la pestaña de <a target="_blank" href="<?=URL?>/restaurantes">restaurantes</a>.
                        </p>
                        <p class="hidden-plan1 hidden-plan2">
                            Ya podés empezar a vender desde la plataforma, lo único que necesitás es añadir los menús que ofrecés. Podés ver tu empresa en la pestaña de <a target="_blank" href="<?=URL?>/restaurantes">restaurantes</a>.
                        </p>
                    </div>
                    <a class="hidden-plan2 hidden-plan3 btn_full btn btn-primary" href="<?= URL; ?>/panel">Panel de empresa <i class="icon-shop-1"></i></a>
                    <a class="hidden-plan1 hidden-plan3 btn_full btn btn-primary" href="<?= URL; ?>/crear_menu">Añadir menús <i class="icon-food"></i></a>
                    <a class="hidden-plan1 hidden-plan2 btn_full btn btn-primary" href="<?= URL; ?>/crear_menu">Añadir menús <i class="icon-food"></i></a>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
    <!-- End Content =============================================== -->
<?php endif; ?>

<!-- SPECIFIC SCRIPTS -->
<script src="<?= URL ?>/assets/js/theia-sticky-sidebar.js"></script>
<script>
    jQuery('#sidebar').theiaStickySidebar({
        additionalMarginTop: 80
    });
</script>
