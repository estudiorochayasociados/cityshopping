<?php
$usuario = new Clases\Usuarios();
$funcion = new Clases\PublicFunction();
?>
<!-- Login modal -->
<?php
if (isset($_POST["login"])):
    $email = $funcion->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
    $password = $funcion->antihack_mysqli(isset($_POST["password"]) ? $_POST["password"] : '');

    $usuario->set("email", $email);
    $usuario->set("password", $password);

    if ($usuario->login() == 0):
        ?>
        <script>
            $(document).ready(function () {
                $("#errorLogin").html('<br/><div class="alert alert-warning" role="alert">Email o contraseña incorrecta.</div>');
                $('#login_2').modal("show");
            });
        </script>
    <?php
    else:
        $funcion->headerMove(URL);
    endif;
endif;
?>
<div class="modal fade" id="login_2" tabindex="-1" role="dialog" aria-labelledby="myLogin" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-popup">
            <div class="modal-header">
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
                    <div class="col-md-12 mb-5">
                        <a href="#">¿Olvidaste tu contraseña?</a>
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
            $usuario->login();
            if ($senalVendedor == 0):
                $funcion->headerMove(URL);
            else:
                ?>
                <script>
                    $(document).ready(function () {
                        $('#vendedor').modal("show");
                    });
                </script>
            <?php
            endif;
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
                <h2>Registro</h2>
            </div>
            <div class="modal-body">
                <p id="errorRegistro"></p>
                <form class="popup-form" id="myRegister" method="post">
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
                        <input type="text" class="form-control form-white" name="password" placeholder="Contraseña"
                               id="password1" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control form-white" name="password2" placeholder="Confirmar contraseña"
                               id="password2" required>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <input type="checkbox" value="1" id="check_2" name="terminos" required>
                            <label for="check_2"><span>He leído y acepto los <strong>Términos &amp; Condiciones</strong></span></label>
                        </div>
                    </div>
                    <div class="col-md-12 centro">
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
    $provincia = $funcion->antihack_mysqli(isset($_POST["provinciaVendedor"]) ? $_POST["provinciaVendedor"] : '');
    $localidad = $funcion->antihack_mysqli(isset($_POST["localidadVendedor"]) ? $_POST["localidadVendedor"] : '');
    $telefono = $funcion->antihack_mysqli(isset($_POST["telefonoUsuario"]) ? $_POST["telefonoUsuario"] : '');

    $usuario->set("cod", $_SESSION["usuarios"]['cod']);
    $usuario->set("email", $_SESSION["usuarios"]['email']);
    $usuario->editUnico("telefono", $telefono);
    $usuario->editUnico("vendedor", 2);

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
                           placeholder="Nombre de tu restaurtante / negocio" required>
                    <div class="row">
                        <label class="col-md-6 col-xs-6" style="visibility: hidden;">
                            <input type="text" name="provinciaVendedor" value="Córdoba">
                        </label>
                        <label class="col-md-6 col-xs-6">
                            <select class="form-control" name="localidadVendedor" id="localidad" required >
                            <option value="" selected disabled>Localidad</option>
                            <option value="San Francisco">San Francisco</option>
                            <option value="Gran Buenos Aires Zona Sur">Gran Buenos Aires Zona Sur</option>
                            </select>
                        </label>
                    </div>
                    <?php if (empty($_SESSION["usuarios"]["telefono"])): ?>
                        <input type="text" class="form-control form-white" name="telefonoUsuario"
                               placeholder="Tu teléfono personal" required>
                    <?php endif; ?>
                    <button type="submit" name="vendedor" class="btn btn-submit">Solicitar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Register modal -->

<div class="modal fade" id="modalOK" tabindex="-1" role="dialog" aria-labelledby="modalOK" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-popup">
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
<!-- End Register modal -->
<script>
    function Cambb(){
        $(document).ready(function () {
            $("#senalVendedor").html('<input name="senalVendedor" value="1" type="hidden">');
        });
    }
</script>