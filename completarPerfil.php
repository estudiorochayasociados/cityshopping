<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funcion = new Clases\PublicFunction();
$template->set("title", TITULO ." | Completar perfil");
$template->set("description", "Completar perfil");
$template->set("keywords", "Completar perfil");
$template->set("favicon", FAVICON);
$template->set("body","checkout-page");
$template->themeInit();
//Clases
$usuario = new Clases\Usuarios();

$cod_usuario = $_SESSION['usuarios']['cod'];
$usuario->set("cod", $cod_usuario);
$usuarioData = $usuario->view();

?>
    <!--================================
                START BREADCRUMB AREA
            =================================-->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb">
                        <ul>
                            <li>
                                <a href="<?= URL ?>/index">Inicio</a>
                            </li>
                            <li class="active">
                                <a href="#">Completar perfil para continuar</a>
                            </li>
                        </ul>
                    </div>
                    <h1 class="page-title">Completar perfil para continuar</h1>
                </div>
                <!-- end /.col-md-12 -->
            </div>
            <!-- end /.row -->
        </div>
        <!-- end /.container -->
    </section>
    <!--================================
        END BREADCRUMB AREA
    =================================-->
    <div class="container mt-30">
        <?php
        if (isset($_POST["completarPerfil"])):
            $nombre = $funcion->antihack_mysqli(isset($_POST["nombreInvitado"]) ? $_POST["nombreInvitado"] : $usuarioData['nombre']);
            $apellido = $funcion->antihack_mysqli(isset($_POST["apellidoInvitado"]) ? $_POST["apellidoInvitado"] : $usuarioData['apellido']);
            $email = $usuarioData['email'];
            $password = $usuarioData['password'];
            $telefono = $funcion->antihack_mysqli(isset($_POST["telefonoInvitado"]) ? $_POST["telefonoInvitado"] : $usuarioData['telefono']);
            $provincia = $funcion->antihack_mysqli(isset($_POST["provinciaInvitado"]) ? $_POST["provinciaInvitado"] : $usuarioData['provincia']);
            $ciudad = $funcion->antihack_mysqli(isset($_POST["ciudadInvitado"]) ? $_POST["ciudadInvitado"] : $usuarioData['ciudad']);
            $postal = $funcion->antihack_mysqli(isset($_POST["postalInvitado"]) ? $_POST["postalInvitado"] : $usuarioData['postal']);
            $barrio = $funcion->antihack_mysqli(isset($_POST["barrioInvitado"]) ? $_POST["barrioInvitado"] : $usuarioData['barrio']);
            $direccion = $funcion->antihack_mysqli(isset($_POST["direccionInvitado"]) ? $_POST["direccionInvitado"] : $usuarioData['direccion']);
            $fecha = $usuarioData['fecha'];
            $vendedor = $usuarioData['vendedor'];
            $plan = $usuarioData['plan'];
            $cod = $usuarioData['cod'];

            $usuario->set("cod", $cod);
            $usuario->set("nombre", $nombre);
            $usuario->set("apellido", $apellido);
            $usuario->set("telefono", $telefono);
            $usuario->set("email", $email);
            $usuario->set("password", $password);
            $usuario->set("postal", $postal);
            $usuario->set("provincia", $provincia);
            $usuario->set("localidad", $ciudad);
            $usuario->set("barrio", $barrio);
            $usuario->set("direccion", $direccion);
            $usuario->set("invitado", 0);
            $usuario->set("plan", $plan);
            $usuario->set("vendedor", $vendedor);
            $usuario->set("fecha", $fecha);

            $usuario->edit();
            unset($_SESSION['usuarios']);
            $usuario->login();
            $funcion->headerMove(URL . '/pagar');
        endif;
        ?>
        <div class="col-md-12">
            <form method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Provincia</label>
                            <select class="form-control" name="provinciaInvitado" id="provinciaInvitado" required>
                                <option value="" selected disabled>Selecciona tu provincia</option>
                                <option value="Córdoba" <?php if ($usuarioData['provincia'] == 'Córdoba') echo 'selected'; ?>>
                                    Córdoba
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ciudad</label>
                            <select class="form-control" name="ciudadInvitado" id="ciudadInvitado" required>
                                <option value="" selected disabled>Selecciona tu localidad</option>
                                <option value="San Francisco" <?php if ($usuarioData['localidad'] == 'San Francisco') echo 'selected'; ?>>
                                    San Francisco
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Barrio</label>
                            <input type="text" id="barrioInvitado" value="<?= $usuarioData['barrio'] ?>"
                                   name="barrioInvitado" class="form-control"
                                   placeholder="Barrio" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" id="direccionInvitado" value="<?= $usuarioData['direccion'] ?>"
                                   name="direccionInvitado"
                                   class="form-control" placeholder="Dirección" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="number" class="form-control" id="telefonoInvitado"
                                   value="<?= $usuarioData['telefono'] ?>"
                                   name="telefonoInvitado"
                                   placeholder="Teléfono" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn--round btn--md mb-10" name="completarPerfil" type="submit">Confirmar <i
                                    class="icon-right-open-5"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php $template->themeEnd() ?>