<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
//Clases
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();
//
$template->set("title", TITULO . " | Contacto");
$template->set("description", "Contacto City Shopping");
$template->set("keywords", "Contacto City Shopping");
$template->set("favicon", FAVICON);
$template->set("body", "contact-page");
$template->themeInit();
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
                            <a href="<?=URL?>/index">Inicio</a>
                        </li>
                        <li class="active">
                            <a href="#">Contacto</a>
                        </li>
                    </ul>
                </div>
                <h1 class="page-title">Contacto</h1>
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

<!--================================
    START AFFILIATE AREA
=================================-->
<section class="contact-area pt-15">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <!-- start col-md-12 -->
                    <div class="col-md-12">
                        <div class="section-title">
                            <h1>¿CÓMO PODEMOS
                                <span class="highlighted">AYUDARTE?</span>
                            </h1>
                        </div>
                    </div>
                    <!-- end /.col-md-12 -->
                </div>
                <!-- end /.row -->

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="contact_tile contacto">
                            <span class="tiles__icon lnr lnr-map-marker"></span>
                            <div class="tiles__content">
                                <p><?=DIRECCION .', '.CIUDAD.', Cba.'?></p>
                            </div>
                        </div>
                    </div>
                    <!-- end /.col-lg-4 col-md-6 -->

                    <div class="col-lg-4 col-md-6">
                        <div class="contact_tile contacto">
                            <span class="tiles__icon lnr lnr-phone"></span>
                            <div class="tiles__content">
                                <p><?=TELEFONO?></p>
                            </div>
                        </div>
                        <!-- end /.contact_tile -->
                    </div>
                    <!-- end /.col-lg-4 col-md-6 -->

                    <div class="col-lg-4 col-md-6">
                        <div class="contact_tile contacto">
                            <span class="tiles__icon lnr lnr-inbox"></span>
                            <div class="tiles__content">
                                <p><?=EMAIL_NOTIFICACION?></p>
                            </div>
                        </div>
                        <!-- end /.contact_tile -->
                    </div>
                    <!-- end /.col-lg-4 col-md-6 -->

                    <div class="col-md-12">
                        <div class="contact_form cardify">
                            <div class="contact_form__title">
                                <h3>Déjanos tu mensaje</h3>
                            </div>

                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="contact_form--wrapper">
                                        <?php
                                        if (isset($_POST["enviar"])) {
                                            $nombre = $funciones->antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : '');
                                            $email = $funciones->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
                                            $telefono = $funciones->antihack_mysqli(isset($_POST["telefono"]) ? $_POST["telefono"] : '');
                                            $asunto = $funciones->antihack_mysqli(isset($_POST["asunto"]) ? $_POST["asunto"] : '');
                                            $consulta = $funciones->antihack_mysqli(isset($_POST["mensaje"]) ? $_POST["mensaje"] : '');

                                            $mensajeFinal = "<b>Nombre</b>: " . $nombre . " <br/>";
                                            $mensajeFinal .= "<b>Email</b>: " . $email . "<br/>";
                                            $mensajeFinal .= "<b>Teléfono</b>: " . $telefono . "<br/>";
                                            $mensajeFinal .= "<b>Asunto</b>: " . $asunto . "<br/>";
                                            $mensajeFinal .= "<b>Consulta</b>: " . $consulta . "<br/>";

                                            //USUARIO
                                            $enviar->set("asunto", "Realizaste tu consulta");
                                            $enviar->set("receptor", $email);
                                            $enviar->set("emisor", EMAIL);
                                            $enviar->set("mensaje", $mensajeFinal);
                                            if ($enviar->emailEnviar() == 1) {
                                                echo '<div class="alert alert-success" role="alert">¡Consulta enviada correctamente!</div>';
                                            }

                                            $mensajeFinalAdmin = "<b>Nombre</b>: " . $nombre . " <br/>";
                                            $mensajeFinalAdmin .= "<b>Email</b>: " . $email . "<br/>";
                                            $mensajeFinalAdmin .= "<b>Teléfono</b>: " . $telefono . "<br/>";
                                            $mensajeFinalAdmin .= "<b>Asunto</b>: " . $asunto . "<br/>";
                                            $mensajeFinalAdmin .= "<b>Consulta</b>: " . $consulta . "<br/>";
                                            //ADMIN
                                            $enviar->set("asunto", "Consulta Web");
                                            $enviar->set("receptor", EMAIL);
                                            $enviar->set("mensaje", $mensajeFinalAdmin);
                                            if ($enviar->emailEnviar() == 0) {
                                                echo '<div class="alert alert-danger" role="alert">¡No se ha podido enviar la consulta!</div>';
                                            }
                                        }
                                        ?>
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="nombre" placeholder="Nombre" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" name="email" placeholder="Email" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" name="telefono" placeholder="Teléfono" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="asunto" placeholder="Asunto" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <textarea cols="30" rows="10" name="mensaje" placeholder="Su mensaje" required></textarea>

                                            <div class="sub_btn">
                                                <button type="submit" name="enviar" class="btn btn--round btn--default">Enviar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end /.col-md-8 -->
                            </div>
                            <!-- end /.row -->
                        </div>
                        <!-- end /.contact_form -->
                    </div>
                    <!-- end /.col-md-12 -->
                </div>
                <!-- end /.row -->
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
<?php
$template->themeEnd();
?>
