<?php
if (isset($_POST["modificarPerfil"])):

    $nombre = $funcion->antihack_mysqli(!empty($_POST["nombrePerfil"]) ? $_POST["nombrePerfil"] : $usuarioData['nombre']);
    $apellido = $funcion->antihack_mysqli(!empty($_POST["apellidoPerfil"]) ? $_POST["apellidoPerfil"] : $usuarioData['apellido']);
    $email = $funcion->antihack_mysqli(!empty($_POST["emailPerfil"]) ? $_POST["emailPerfil"] : $usuarioData['email']);
    $provincia = $funcion->antihack_mysqli(!empty($_POST["provinciaPerfil"]) ? $_POST["provinciaPerfil"] : $usuarioData['provincia']);
    $localidad = $funcion->antihack_mysqli(!empty($_POST["localidadPerfil"]) ? $_POST["localidadPerfil"] : $usuarioData['localidad']);
    $direccion = $funcion->antihack_mysqli(!empty($_POST["direccionPerfil"]) ? $_POST["direccionPerfil"] : $usuarioData['direccion']);
    $telefono = $funcion->antihack_mysqli(!empty($_POST["telefonoPerfil"]) ? $_POST["telefonoPerfil"] : $usuarioData['telefono']);
    $postal = $funcion->antihack_mysqli(!empty($_POST["postalPerfil"]) ? $_POST["postalPerfil"] : $usuarioData['postal']);
    $plan = $usuarioData['plan'];
    $vendedor = $usuarioData['vendedor'];
    if (!empty($_POST["new_passwordPerfil"]) && !empty($_POST["new_password2Perfil"]) && !empty($_POST["old_passwordPerfil"])):
        if ($_POST["old_passwordPerfil"] == $usuarioData['password']):
            if ($_POST["new_passwordPerfil"] == $_POST["new_password2Perfil"]):
                $password = $funcion->antihack_mysqli($_POST["new_passwordPerfil"]);
            else:
                echo '<div class="alert alert-warning" role="alert">Las contraseña nueva no coincide con la confirmación</div>';
                $password = $usuarioData['password'];
            endif;
        else:
            echo '<div class="alert alert-warning" role="alert">Ha escrito mal su contraseña actual</div>';
            $password = $usuarioData['password'];
        endif;
    else:
        $password = $usuarioData['password'];
    endif;

    $usuario->set("cod", $usuarioData['cod']);
    $usuario->set("nombre", $nombre);
    $usuario->set("apellido", $apellido);
    $usuario->set("email", $email);
    $usuario->set("provincia", $provincia);
    $usuario->set("localidad", $localidad);
    $usuario->set("barrio", $barrio);
    $usuario->set("direccion", $direccion);
    $usuario->set("telefono", $telefono);
    $usuario->set("postal", $postal);
    $usuario->set("password", $password);
    $usuario->set("vendedor", $vendedor);
    $usuario->set("plan", $plan);
    $usuario->set("fecha", $usuarioData['fecha']);

    $usuario->edit();
    $funcion->headerMove(URL . '/panel');
endif;
?>
<div class="row">
    <div class="col-md-6 col-sm-6 add_bottom_15">
        <form method="post">
            <div class="indent_title_in">
                <i class="icon_mail_alt"></i>
                <h3>Modificar Datos</h3>
                <p>
                    Completa los siguientes campos:
                </p>
            </div>
            <div class="wrapper_indent">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control"
                                   value="<?php if (!empty($usuarioData['nombre'])) {
                                       echo $usuarioData['nombre'];
                                   } ?>" name="nombrePerfil" id="nombrePerfil" type="text"
                                   placeholder="Ej. Jorge">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellido</label>
                            <input class="form-control"
                                   value="<?php if (!empty($usuarioData['apellido'])) {
                                       echo $usuarioData['apellido'];
                                   } ?>" name="apellidoPerfil" id="apellidoPerfil" type="text"
                                   placeholder="Ej. Pérez">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" value="<?php if (!empty($usuarioData['email'])) {
                        echo $usuarioData['email'];
                    } ?>" name="emailPerfil" id="emailPerfil" type="email"
                           placeholder="Ej. jorge@tumail.com">
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <label>Provincia</label>
                        <select class="form-control" name="provinciaPerfil" id="provincia" required>
                            <option value="" selected disabled>Provincia</option>
                            <?php $funcion->provincias() ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <label>Localidad</label>
                        <select class="form-control" name="localidadPerfil" id="localidad" required>
                            <option value="" selected disabled>Localidad</option>
                        </select>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <label>Direccion</label>
                    <input class="form-control" value="<?php if (!empty($usuarioData['direccion'])) {
                        echo $usuarioData['direccion'];
                    } ?>" name="direccionPerfil" id="direccionPerfil" type="text"
                           placeholder="Ej. Av. Urquiza 369">
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <label>Teléfono</label>
                        <div class="form-group">
                            <input class="form-control"
                                   value="<?php if (!empty($usuarioData['telefono'])) {
                                       echo $usuarioData['telefono'];
                                   } ?>" name="telefonoPerfil" id="telefonoPerfil" type="text"
                                   placeholder="Ej. 3564555555">
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <label>Postal</label>
                        <div class="form-group">
                            <input class="form-control"
                                   value="<?php if (!empty($usuarioData['postal'])) {
                                       echo $usuarioData['postal'];
                                   } ?>" name="postalPerfil" id="postalPerfil" type="text"
                                   placeholder="Ej. 2400">
                        </div>
                    </div>
                </div>
                <button type="submit" name="modificarPerfil" class="btn_1 green">Modificar Datos
                </button>
            </div><!-- End wrapper_indent -->
        </form>
    </div>

    <div class="col-md-6 col-sm-6 add_bottom_15">
        <form method="post">
            <div class="indent_title_in">
                <i class="icon_lock_alt"></i>
                <h3>Modificar contraseña</h3>
                <p>
                    Completa los siguientes campos:
                </p>
            </div>
            <div class="wrapper_indent">
                <div class="form-group">
                    <label>Contraseña actual</label>
                    <input class="form-control" name="old_passwordPerfil" id="old_passwordPerfil"
                           type="password" placeholder="********">
                </div>
                <div class="form-group">
                    <label>Nueva contraseña</label>
                    <input class="form-control" name="new_passwordPerfil" id="new_passwordPerfil"
                           type="password" placeholder="Ej. Azf45D3yU">
                </div>
                <div class="form-group">
                    <label>Confirmar nueva contraseña</label>
                    <input class="form-control" name="new_password2Perfil" id="new_password2Perfil"
                           type="password" placeholder="Ej. Azf45D3yU">
                </div>
                <button type="submit" name="modificarPerfil" class="btn_1 green">Modificar contraseña
                </button>
            </div><!-- End wrapper_indent -->
        </form>
    </div>

</div><!-- End row -->

<hr class="styled_2">