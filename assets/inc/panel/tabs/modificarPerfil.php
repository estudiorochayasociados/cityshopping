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
                            <h3>Modificar perfil</h3>
                        </div>
                    </div>
                </div>
                <!-- end /.col-md-12 -->
            </div>
            <!-- end /.row -->

            <div class="row">
                <div class="col-lg-6">
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
                                        <p>
                                            Completa los siguientes campos:
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Nombre</label>
                                                        <input class="text_field"
                                                               value="<?php if (!empty($usuarioData['nombre'])) {
                                                                   echo $usuarioData['nombre'];
                                                               } ?>" name="nombrePerfil" id="nombrePerfil" type="text"
                                                               placeholder="Ej. Jorge" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Apellido</label>
                                                    <input class="text_field"
                                                           value="<?php if (!empty($usuarioData['apellido'])) {
                                                               echo $usuarioData['apellido'];
                                                           } ?>" name="apellidoPerfil" id="apellidoPerfil" type="text"
                                                           placeholder="Ej. Pérez" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="text_field" value="<?php if (!empty($usuarioData['email'])) {
                                                echo $usuarioData['email'];
                                            } ?>" name="emailPerfil" id="emailPerfil" type="email"
                                                   placeholder="Ej. jorge@tumail.com" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <label>Provincia</label>
                                                <select class="form-control" name="provinciaPerfil" id="provincia" required>
                                                    <?php
                                                    if (!empty($usuarioData['provincia'])){
                                                        ?>
                                                        <option value="<?=$usuarioData['provincia']?>" selected disabled><?=$usuarioData['provincia']?></option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <option value="" selected disabled>Provincia</option>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php $funcion->provincias() ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <label>Localidad</label>
                                                <select class="form-control" name="localidadPerfil" id="localidad" required>
                                                    <?php
                                                    if (!empty($usuarioData['provincia'])){
                                                        ?>
                                                        <option value="<?=$usuarioData['localidad']?>" selected disabled><?=$usuarioData['localidad']?></option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <option value="" selected disabled>Localidad</option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Direccion</label>
                                            <input class="text_field" value="<?php if (!empty($usuarioData['direccion'])) {
                                                echo $usuarioData['direccion'];
                                            } ?>" name="direccionPerfil" id="direccionPerfil" type="text"
                                                   placeholder="Ej. Av. Urquiza 369" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <label>Teléfono</label>
                                                <div class="form-group">
                                                    <input class="text_field"
                                                           value="<?php if (!empty($usuarioData['telefono'])) {
                                                               echo $usuarioData['telefono'];
                                                           } ?>" name="telefonoPerfil" id="telefonoPerfil" type="text"
                                                           placeholder="Ej. 3564555555" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <label>Postal</label>
                                                <div class="form-group">
                                                    <input class="text_field"
                                                           value="<?php if (!empty($usuarioData['postal'])) {
                                                               echo $usuarioData['postal'];
                                                           } ?>" name="postalPerfil" id="postalPerfil" type="text"
                                                           placeholder="Ej. 2400" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dashboard_setting_btn">
                                            <button type="submit" name="modificarPerfil" class="btn btn--round btn--md">Modificar Datos
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
                <!-- end /.col-md-6 -->
                <div class="col-lg-6">
                    <form method="post" class="setting_form">
                        <div class="information_module">
                            <a class="toggle_title" href="#collapse2" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse2">
                                <h4>Modificar contraseña
                                    <span class="lnr lnr-chevron-down"></span>
                                </h4>
                            </a>
                            <div class="information__set toggle_module collapse show" id="collapse2">
                                <div class="information_wrapper form--fields">
                                <p>
                                    Completa los siguientes campos:
                                </p>
                                    <div class="form-group">
                                        <label>Contraseña actual<sup>*</sup></label>
                                        <input class="text_field" name="old_passwordPerfil" id="old_passwordPerfil"
                                               type="password" placeholder="********" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Nueva contraseña<sup>*</sup></label>
                                        <input class="text_field" name="new_passwordPerfil" id="new_passwordPerfil"
                                               type="password" placeholder="Ej. Azf45D3yU" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Confirmar nueva contraseña<sup>*</sup></label>
                                        <input class="text_field" name="new_password2Perfil" id="new_password2Perfil"
                                               type="password" placeholder="Ej. Azf45D3yU" required>
                                    </div>
                                <div class="dashboard_setting_btn ">
                                    <button type="submit" name="modificarPerfil" class="btn btn--round btn--md">Modificar contraseña
                                </div>
                                </div>
                                <!-- end /.information_wrapper -->
                            </div>
                            <!-- end /.information__set -->
                        </div>
                        <!-- end /.information_module -->
                    </form>
                </div>
                <!-- end /.col-md-6 -->
            </div>
            <!-- end /.row -->
        </div>
        <!-- end /.container -->
    </div>
    <!-- end /.dashboard_menu_area -->
</section>
<!--================================
        END DASHBOARD AREA
=================================-->