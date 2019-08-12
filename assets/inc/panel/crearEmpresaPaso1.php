<div class="dashboard-area">
    <div class="dashboard_contents">
        <div class="container">
            <div class="dashboard_title_area">
                <div class="dashboard__title">
                    <h1>Crea tu empresa en 3 simples pasos:</h1>
                    <p>Paso 1: completar con la información de la empresa.</p>
                </div>
            </div>
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
                $empresa->set('tiempoEntrega', 0);
                $empresa->set('delivery', 0);

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

                $funcion->headerMove(URL . '/panel?op=crear-empresa-2');
            endif;
            ?>
            <div class="information_module">
                <div class="information_module">
                    <div class="information__set toggle_module collapse show">
                        <div class="information_wrapper form--fields">
                            <p>
                                Completa los siguientes campos:
                            </p>
                            <form method="post">
                                <h2 class="inner">Descripción</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nombre de la empresa</label>
                                            <input class="text_field" value="" name="tituloEmpresa" id="tituloEmpresa" type="text"
                                                   placeholder="Ej. Restaurante Argentino" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" class="text_field" id="telefonoEmpresa" name="telefonoEmpresa"
                                           placeholder="Teléfono" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="emailEmpresa" name="emailEmpresa" class="text_field"
                                           placeholder="Email" required>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Breve descripción sobre la empresa</label>
                                        <textarea class="text_field" style="height:150px" placeholder="Breve descripción"
                                                  name="desarrolloEmpresa" id="desarrolloEmpresa" required></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button class="btn btn--round btn--md" name="crear_empresa" type="submit">Siguiente paso <i
                                                    class="icon-right-open-5"></i></button>
                                    </div>
                                </div>
                            </form>
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
<!-- SPECIFIC SCRIPTS -->
<script src="<?= URL ?>/assets/js/theia-sticky-sidebar.js"></script>
<script>
    jQuery('#sidebar').theiaStickySidebar({
        additionalMarginTop: 80
    });
</script>