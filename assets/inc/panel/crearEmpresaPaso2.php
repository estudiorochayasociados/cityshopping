<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?= URL ?>/assets/img/bkg.jpg" data-natural-width="1400">

    <div id="subheader">
        <div id="sub_content">
            <h1>Ya estás más cerca</h1>
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
if (isset($_POST["crear_empresa_paso2"])):
    $provincia = $funcion->antihack_mysqli(isset($_POST["provinciaEmpresa"]) ? $_POST["provinciaEmpresa"] : '');
    $ciudad = $funcion->antihack_mysqli(isset($_POST["ciudadEmpresa"]) ? $_POST["ciudadEmpresa"] : '');
    $barrio = $funcion->antihack_mysqli(isset($_POST["barrioEmpresa"]) ? $_POST["barrioEmpresa"] : '');
    $direccion = $funcion->antihack_mysqli(isset($_POST["direccionEmpresa"]) ? $_POST["direccionEmpresa"] : '');
    $postal = $funcion->antihack_mysqli(isset($_POST["postalEmpresa"]) ? $_POST["postalEmpresa"] : '');

    $ubicacionEmpresa = str_replace(' ', '+', $direccion . '+' . $ciudad . '+' . $provincia);
    $ubicacionEmpresa = $funcion->normalizar_link($ubicacionEmpresa);
    $jsonEmpresa = json_decode(file_get_contents('https://geocoder.api.here.com/6.2/geocode.json?app_id=Nkd7zJVtg6iaOyaQoEvK&app_code=HTkK8DlaV14bg6RDCA-pQA&searchtext=' . $ubicacionEmpresa));
    $empresaLongitud = $jsonEmpresa->Response->View[0]->Result[0]->Location->DisplayPosition->Longitude;
    $empresaLatitud = $jsonEmpresa->Response->View[0]->Result[0]->Location->DisplayPosition->Latitude;
    $coordenadas = $empresaLatitud . ',' . $empresaLongitud;

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

    //Agregado
    $empresa->set("provincia", $provincia);
    $empresa->set("ciudad", $ciudad);
    $empresa->set("barrio", $barrio);
    $empresa->set("direccion", $direccion);
    $empresa->set("postal", $postal);
    $empresa->set("coordenadas", $coordenadas);

    $empresa->edit();
    $funcion->headerMove(URL . '/panel?op=crearEmpresaPaso3');
endif;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box_style_2" id="order_process">
            <form method="post">
                <h2 class="inner">Ubicación</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Provincia</label>
                            <select class="form-control" name="provinciaEmpresa" id="provinciaEmpresa">
                                <option value="" selected disabled>Selecciona tu provincia</option>
                                <option value="Córdoba">Córdoba</option>
                                <option value="Buenos Aires">Buenos Aires</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ciudad</label>
                            <select class="form-control" name="ciudadEmpresa" id="ciudadEmpresa">
                                <option value="" selected disabled>Selecciona tu localidad</option>
                                <option value="San Francisco">San Francisco</option>
                                <option value="Gran Buenos Aires Zona Sur">Gran Buenos Aires Zona Sur</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" id="direccionEmpresa" name="direccionEmpresa" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Barrio</label>
                            <input type="text" id="barrioEmpresa" name="barrioEmpresa" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Código Postal</label>
                            <input type="text" id="postalEmpresa" name="postalEmpresa" class="form-control">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn_full" name="crear_empresa_paso2" type="submit">Siguiente Paso <i
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