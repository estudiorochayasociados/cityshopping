<?php
if (empty($empresaData['cod'])) {
?>
    <center class="pt-50 pb-50">
        <h4>Primero debe crear su empresa</h4>
        <a href="<?= URL ?>/panel?op=empresa" class="btn-primary pr-20 pl-20 fs-20">CARGAR MI EMPRESA</a>
    </center>
<?php
} else {
    if (isset($_POST["modificarMercadoPago"])) {
        $empresa->set("cod", $empresaData['cod']);
        $empresa->set("clientID", isset($_POST["clientID"]) ? $_POST["clientID"] : '');
        $empresa->set("clientSecret", isset($_POST["clientSecret"]) ? $_POST["clientSecret"] : '');
        $empresa->addMercadoPago();
        $funcion->headerMove(URL . '/panel?op=mercadopago');
    } ?>
    <!--================================
        START DASHBOARD AREA
=================================-->
    <section class="">
        <div class="dashboard_contents">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard_title_area">
                            <div class="dashboard__title">
                                <h3>Datos Mercado Pago</h3>
                            </div>
                        </div>
                    </div>
                    <!-- end /.col-md-12 -->
                </div>
                <!-- end /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <form method="post" class="setting_form">
                            <div class="information_module">
                                <div class="information_module">
                                    <a class="toggle_title" href="#collapse1" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse1">
                                        <h4>Modificar datos
                                            <span class="lnr lnr-chevron-down"></span>
                                        </h4>
                                    </a>

                                    <div class="information__set toggle_module collapse show" id="collapse1">
                                        <div class="information_wrapper form--fields">
                                            <b class="fs-16">Completa los siguientes campos en 3 simples pasos:</b><br />
                                            <span class="alert alert-warning pt-20 pb-20" style="display:block;color:#111">
                                                <b class="mt-5">1) Ingresá al siguiente link: <a href="https://www.mercadopago.com/mla/account/credentials" target="_blank">CONECTAR A MERCADO PAGO</a>. Ingresá tus datos para iniciar sesión.</b>
                                                <hr class="mt-5 mb-5" />
                                                <b>2) Hacer click donde dice <a href="#">CHECKOUT BÁSICO</a> para ver tus credenciales</b>
                                                <hr class="mt-5 mb-5" />
                                                <b>3) Copiar tu <a href="#">CLIENT_ID</a> y <a href="#">CLIENT_SECRET</a> en los siguientes campos</b>
                                                <br />
                                            </span>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Client ID</label>
                                                            <input class="text_field" value="<?= (!empty($empresaData['clientID'])) ? $empresaData['clientID'] : ''; ?>" name="clientID" id="clientID" type="text" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Client Secret</label>
                                                <input class="text_field" value="<?= (!empty($empresaData['clientSecret'])) ? $empresaData['clientSecret'] : ''; ?>" name="clientSecret" id="clientSecret" type="text" placeholder="">
                                            </div>

                                            <div class="dashboard_setting_btn">
                                                <button type="submit" name="modificarMercadoPago" class="btn btn--round btn--md">Guardar Datos
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end /.information_wrapper -->
                                    </div>
                                    <!-- end /.information__set -->
                                </div>
                                <!-- end /.information_module -->
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end /.row -->
            </div>
            <!-- end /.container -->
        </div>
        <!-- end /.dashboard_menu_area -->
    </section>
<?php
}
?>
<!--================================
        END DASHBOARD AREA
==================== ?>