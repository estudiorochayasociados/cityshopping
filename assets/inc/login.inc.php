<?php
$usuario = new Clases\Usuarios();
$funcion = new Clases\PublicFunction();
$correo = new Clases\Email();
?>
<!-- Login modal -->
<?php
if (isset($_POST["login"])) {

// Verify the reCAPTCHA response
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . CAPTCHA_SECRET . '&response=' . $_POST['g-recaptcha-response']);

// Decode json data
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {
        if ($_POST["recuperarPass"]) {
            $recuperarPass = $funcion->antihack_mysqli(isset($_POST["recuperarPass"]) ? $_POST["recuperarPass"] : '');
            $cod = substr(md5(uniqid(rand())), 0, 10);

            $usuario->set("email", $recuperarPass);
            $usuarioData = $usuario->validate2();
            if ($usuarioData['status']) {
                $usuario->set("cod", $usuarioData['data']["cod"]);
                $usuario->editUnico("password", $cod);

                $mensaje = "Su nueva contraseña es: <b>" . $cod . "</b><br><br>";

                $correo->set("asunto", "Recuperar Contraseña");
                $correo->set("receptor", $recuperarPass);
                $correo->set("emisor", EMAIL);
                $correo->set("mensaje", $mensaje);
                $correo->emailEnviar();
                ?>
                <script>
                    $(document).ready(function () {
                        $("#errorLogin").html('<br/><div class="alert alert-success" role="alert">Revise su email para ver su nueva contraseña.</div>');
                        $('#login_2').modal("show");
                    });
                </script>
                <?php
            } else {
                ?>
                <script>
                    $(document).ready(function () {
                        $("#errorLogin").html('<br/><div class="alert alert-warning" role="alert">El email no existe.</div>');
                        $('#login_2').modal("show");
                    });
                </script>
                <?php
            }
        } else {
            $email = $funcion->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
            $password = $funcion->antihack_mysqli(isset($_POST["password"]) ? $_POST["password"] : '');

            $usuario->set("email", $email);
            $usuario->set("password", $password);

            if ($usuario->login() == 0) {
                ?>
                <script>
                    $(document).ready(function () {
                        $("#errorLogin").html('<br/><div class="alert alert-warning" role="alert">Email o contraseña incorrecta.</div>');
                        $('#login_2').modal("show");
                    });
                </script>
                <?php
            } else {
                $funcion->headerMove(URL.'/panel?op=perfil');
            }
        }
    } else {
        ?>
        <script>
            $(document).ready(function () {
                $("#errorLogin").html('<br/><div class="alert alert-warning" role="alert">Completar CAPTCHA correctamente.</div>');
                $('#login_2').modal("show");
            });
        </script>
        <?php
    }
}
?>
<div class="modal fade" id="login_2" tabindex="-1" role="dialog" aria-labelledby="myLogin" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-popup">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2>Iniciar Sesión</h2>
            </div>
            <div class="modal-body">
                <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                <p id="errorLogin"></p>
                <form class="login_form row" id="myLogin" method="post">
                    <div class="col-md-12 form-group">
                        <input type="email" class="form-control form-white" name="email" placeholder="Email">
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="password" class="form-control form-white" name="password" placeholder="Contraseña">
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="g-recaptcha" data-sitekey="<?= CAPTCHA_KEY ?>"></div>
                    </div>
                    <div class="col-md-12 mb-5">
                        <a id="btnPass" href="#">¿Olvidaste tu contraseña?</a>
                        <div id="recuperarPass" class="mb-5 mt-5 centro"></div>
                    </div>
                    <div class="col-md-12 mt-5 centro">
                        <button type="submit" name="login" class="btn btn--round btn-sm">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- End modal -->

<!-- REGISTRAR -->
<?php
if (isset($_POST["registrar"])):
    if ($_POST["password"] == $_POST["password2"]):
        $nombre = $funcion->antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : '');
        $apellido = $funcion->antihack_mysqli(isset($_POST["apellido"]) ? $_POST["apellido"] : '');
        $email = $funcion->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
        $password = $funcion->antihack_mysqli(isset($_POST["password"]) ? $_POST["password"] : '');
        $senalVendedor = $funcion->antihack_mysqli(isset($_POST["senalVendedor"]) ? $_POST["senalVendedor"] : 0);
        $cod = substr(md5(uniqid(rand())), 0, 10);
        $fecha = getdate();
        $fecha = $fecha['year'] . '-' . $fecha['mon'] . '-' . $fecha['mday'];

        $usuario->set("cod", $cod);
        $usuario->set("nombre", $nombre);
        $usuario->set("apellido", $apellido);
        $usuario->set("email", $email);
        $usuario->set("password", $password);
        $usuario->set("plan", 3);
        $usuario->set("vendedor", 0);
        $usuario->set("fecha", $fecha);

        if ($usuario->add() == 0):
            ?>
            <script>
                $(document).ready(function () {
                    $("#errorRegistro").html('<br/><div class="alert alert-warning" role="alert">El email ya está registrado.</div>');
                    $('#register').modal("show");
                });
            </script>
        <?php
        else:
            $usuario->set("password", $password);
            $usuario->login();

            $mensajeFinal = "<b>Gracias por registrarte en nuestra plataforma.</b>  " . " <br/>";

            //USUARIO
            $correo->set("asunto", "Realizaste tu registro");
            $correo->set("receptor", $_SESSION["usuarios"]['email']);
            $correo->set("emisor", EMAIL);
            $correo->set("mensaje", $mensajeFinal);
            $correo->emailEnviar();

            $mensajeFinalAdmin = "<b>Usuario :</b>: " . $_SESSION["usuarios"]['nombre'] . $_SESSION["usuarios"]['apellido'] . " <br/>";
            $mensajeFinalAdmin .= "<b>Email</b>: " . $_SESSION["usuarios"]['email'] . "<br/>";
            //ADMIN
            $correo->set("asunto", "Nuevo usuario registrado");
            $correo->set("receptor", EMAIL);
            $correo->set("mensaje", $mensajeFinalAdmin);
            $correo->emailEnviar();
            $funcion->headerMove(URL);
        endif;
    else:
        ?>
        <script>
            $(document).ready(function () {
                $("#errorRegistro").html('<br/><div class="alert alert-warning" role="alert">Las contraseñas no coinciden.</div>');
                $('#register').modal("show");
            });
        </script>
    <?php
    endif;
endif;
?>
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myRegister" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-popup">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2>Registro</h2>
            </div>
            <div class="modal-body">
                <p id="errorRegistro"></p>
                <form class="popup-form " id="myRegister" method="post">
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control form-white" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control form-white" name="apellido" placeholder="Apellido" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="email" class="form-control form-white" name="email" placeholder="Email" required>
                    </div>
                    <p id="senalVendedor"></p>
                    <div class="col-md-12 form-group">
                        <input type="password" class="form-control form-white" name="password" placeholder="Contraseña"
                               id="password1" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="password" class="form-control form-white" name="password2" placeholder="Confirmar contraseña"
                               id="password2" required>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input checks" id="opt1" value="1" name="terminos" required>
                                <span>He leído y acepto los <strong>Términos &amp; Condiciones</strong>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-10 centro">
                        <button type="submit" name="registrar" class="btn btn--round btn-sm">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Register modal -->
<!-- VENDEDOR -->
<?php
if (isset($_POST["vendedor"])):
    $nombre = $funcion->antihack_mysqli(isset($_POST["nombreVendedor"]) ? $_POST["nombreVendedor"] : '');
    $localidad = $funcion->antihack_mysqli(isset($_POST["localidadVendedor"]) ? $_POST["localidadVendedor"] : '');
    $telefono = $funcion->antihack_mysqli(isset($_POST["telefonoUsuario"]) ? $_POST["telefonoUsuario"] : '');

    $usuario->set("cod", $_SESSION["usuarios"]['cod']);
    $usuario->set("email", $_SESSION["usuarios"]['email']);
    $usuario->editUnico("telefono", $telefono);
    $usuario->editUnico("vendedor", 2);

    $mensajeFinal = "<b>Recibimos tu suscripción, en breve te contactaremos.</b>  " . " <br/>";

    //USUARIO
    $correo->set("asunto", "Realizaste tu registro como vendedor");
    $correo->set("receptor", $_SESSION["usuarios"]['email']);
    $correo->set("emisor", EMAIL);
    $correo->set("mensaje", $mensajeFinal);
    $correo->emailEnviar();

    $mensajeFinalAdmin = "<b>Nombre de comercio:</b>: " . $nombre . " <br/>";
    $mensajeFinalAdmin .= "<b>Email</b>: " . $_SESSION["usuarios"]['email'] . "<br/>";
    $mensajeFinalAdmin .= "<b>Teléfono</b>: " . $telefono . "<br/>";
    $mensajeFinalAdmin .= "<b>Localidad</b>: " . $localidad . "<br/>";
    //ADMIN
    $correo->set("asunto", "Suscripción para ser vendedor");
    $correo->set("receptor", EMAIL);
    $correo->set("mensaje", $mensajeFinalAdmin);
    $correo->emailEnviar();
    ?>
    <script>
        $(document).ready(function () {
            $('#modalOK').modal("show");
        });
    </script>
<?php
endif;
?>

<div class="modal fade" id="vendedor" tabindex="-1" role="dialog" aria-labelledby="myVendedor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-popup">
            <div class="modal-header">
                <h2>Registro de comercio</h2>
            </div>
            <div class="modal-body">
                <p id="errorVendedor"></p>
                <form class="popup-form" id="myVendedor" method="post">
                    <div class="login_icon"><i class="icon_lock_alt"></i></div>
                    <input type="text" class="form-control form-white" name="nombreVendedor"
                           placeholder="Nombre de tu empresa / negocio" required>
                    <div class="row mt-5">
                        <label class="col-md-12">
                            <select class="form-control" name="localidadVendedor" id="localidad" required>
                                <option value="" selected disabled>Localidad</option>
                                <option value="San Francisco">San Francisco</option>
                            </select>
                        </label>
                    </div>
                    <?php if (empty($_SESSION["usuarios"]["telefono"])): ?>
                        <input type="number" class="form-control form-white" name="telefonoUsuario"
                               placeholder="Tu teléfono personal" required>
                    <?php endif; ?>
                    <div class="centro">
                        <button type="submit" name="vendedor" class="btn btn--round mt-5 btn-sm">Solicitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Register modal -->

<div class="modal fade" id="modalOK" tabindex="-1" role="dialog" aria-labelledby="modalOK" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-popup">
            <div class="modal-body">
                <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                <br/>
                <div id="confirm">
                    <i class="icon_check_alt2 text_white"></i>
                    <h3 class="text_white">¡Tu solicitud fue enviada correctamente!</h3>
                </div>
                <br/>
                <div class="alert alert-success" role="alert">¡Tu solicitud fue enviada correctamente!. Te vamos a
                    avisar
                    por email o teléfono cuando te habilitemos.
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Register modal -->
<script>
    function Cambb() {
        $(document).ready(function () {
            $("#senalVendedor").html('<input name="senalVendedor" value="1" type="hidden">');
        });
    }
</script>
<script>
    $('#btnPass').click(
        function () {
            $('#recuperarPass').empty();
            $('#recuperarPass').append('<input type="email" name="recuperarPass" class="form-control form-white" placeholder="Email">');
            $('#recuperarPass').append('<button type="submit" name="login" class="btn btn--round btn-sm mt-5">Recuperar Contraseña</button>');
        }
    );
</script>