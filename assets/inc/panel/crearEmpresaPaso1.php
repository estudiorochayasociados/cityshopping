<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="img/sub_header_cart.jpg"
         data-natural-width="1400" data-natural-height="350">
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

                <div class="col-xs-4 bs-wizard-step disabled">
                    <div class="text-center bs-wizard-stepnum"><strong>2.</strong> Ubicación</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="cart_2.html" class="bs-wizard-dot"></a>
                </div>

                <div class="col-xs-4 bs-wizard-step disabled">
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
if (isset($_POST["crear_empresa"])):
    $titulo = $funcion->antihack_mysqli(isset($_POST["tituloEmpresa"]) ? $_POST["tituloEmpresa"] : '');
    $telefono = $funcion->antihack_mysqli(isset($_POST["telefonoEmpresa"]) ? $_POST["telefonoEmpresa"] : '');
    $email = $funcion->antihack_mysqli(isset($_POST["emailEmpresa"]) ? $_POST["emailEmpresa"] : '');
    $desarrollo = $funcion->antihack_mysqli(isset($_POST["desarrolloEmpresa"]) ? $_POST["desarrolloEmpresa"] : '');

    $cod = substr(md5(uniqid(rand())), 0, 10);
    $cod_usuario = $_SESSION['usuarios']['cod'];

    $fecha = getdate();
    $fecha = $fecha['year'] . '-' . $fecha['mon'] . '-' . $fecha['mday'];

    $empresa->set("cod", $cod);
    $empresa->set("titulo", $titulo);
    $empresa->set("telefono", $telefono);
    $empresa->set("email", $email);
    $empresa->set("desarrollo", $desarrollo);
    $empresa->set("fecha", $fecha);
    $empresa->set("cod_usuario", $cod_usuario);

    $empresa->add();

    //envio default
    $cod_envios = substr(md5(uniqid(rand())), 0, 10);
    $envio1 = "Retiro en sucursal";
    $envio2 = 0;

    $envio->set("cod", $cod_envios);
    $envio->set("titulo", $envio1);
    $envio->set("precio", $envio2);
    $envio->set("cod_empresa", $cod);

    $envio->add();
    //envio default

    $funcion->headerMove(URL . '/panel?op=crearEmpresaPaso2');
endif;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box_style_2" id="order_process">
            <form method="post">
                <h2 class="inner">Descripción</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre de la empresa</label>
                            <input class="form-control" value="" name="tituloEmpresa" id="tituloEmpresa" type="text"
                                   placeholder="Ej. Restaurante Argentino">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="numeric" class="form-control" id="telefonoEmpresa" name="telefonoEmpresa"
                           placeholder="Teléfono">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="emailEmpresa" name="emailEmpresa" class="form-control"
                           placeholder="Email">
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <label>Breve descripción sobre la empresa</label>
                        <textarea class="form-control" style="height:150px" placeholder="Breve descripción"
                                  name="desarrolloEmpresa" id="desarrolloEmpresa"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn_full" name="crear_empresa" type="submit">Siguiente paso <i
                                    class="icon-right-open-5"></i></button>
                    </div>
                </div>
            </form>
        </div><!-- End box_style_1 -->
    </div><!-- End col-md-6 -->
</div><!-- End row -->

<!-- SPECIFIC SCRIPTS -->
<script src="<?= URL ?>/assets/js/theia-sticky-sidebar.js"></script>
<script>
    jQuery('#sidebar').theiaStickySidebar({
        additionalMarginTop: 80
    });
</script>