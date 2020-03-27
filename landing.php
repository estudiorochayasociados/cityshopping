<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();

//Clases
$imagenes = new Clases\Imagenes();
$landing = new Clases\Landing();
$categorias = new Clases\Categorias();
$enviar = new Clases\Email();
$landingRequests = new Clases\LandingRequests();
//Productos
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';
$landing->set("cod", $cod);
$landing_ = $landing->view();
$imagenes->set("cod", $landing_['cod']);
$imagenData = $imagenes->list(array("cod = '" . $landing_['cod'] . "'"), '', '');
$categorias->set("cod", $landing_["categoria"]);
$categoria = $categorias->view();
$i = 0;
$fecha = explode("-", $landing_['fecha']);
$template->set("title", ucfirst($landing_['titulo']));
$template->set("description", $landing_['description']);
$template->set("keywords", $landing_['keywords']);
$template->set("favicon", FAVICON);

$template->themeInit();

switch ($categoria["titulo"]) {
    case "Informacion":
        $titulo_form = "Solicitá más información";
        $boton_form = "¡Pedir más info!";
        break;
    case "Compra":
        $titulo_form = "Llená el formulario y pedí online";
        $boton_form = "¡Pedir!";
        break;
    case "Sorteo":
        $titulo_form = "Participá del sorteo";
        $boton_form = "¡Participar!";
        break;
    case "Evento":
        $titulo_form = "Inscribite al evento";
        $boton_form = "¡Inscribirme!";
        break;
    default:
        $titulo_form = "Completar el formulario";
        $boton_form = "¡Enviar mis datos!";
        break;
}
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
                                <a href="#"><?= ucfirst($landing_['titulo']); ?></a>
                            </li>
                        </ul>
                    </div>
                    <h1 class="page-title"><?= ucfirst($landing_['titulo']); ?></h1>
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
    <div id="sns_wrapper" class="mb-10 mt-15">
        <div id="sns_content" class="wrap">
            <div class="container">
                <div class="row">
                    <div class="blogs-page col-md-4 col-md-push-8">
                        <div class="form-style">
                            <h3><?= $titulo_form ?></h3>
                            <hr/>
                            <?php
                            if (isset($_POST["enviar"])) {
                                // Verify the reCAPTCHA response
                                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . CAPTCHA_SECRET . '&response=' . $_POST['g-recaptcha-response']);

                                // Decode json data
                                $responseData = json_decode($verifyResponse);

                                if ($responseData->success) {
                                    if ($funciones->tel_argentino_valido($_POST["celular"])) {
                                        $nombre = $funciones->antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : '');
                                        $apellido = $funciones->antihack_mysqli(isset($_POST["apellido"]) ? $_POST["apellido"] : '');
                                        $celular = $funciones->antihack_mysqli(isset($_POST["celular"]) ? $_POST["celular"] : '');
                                        $email = $funciones->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
                                        $dni = $funciones->antihack_mysqli(isset($_POST["dni"]) ? $_POST["dni"] : '');
                                        $land = $funciones->antihack_mysqli(isset($_POST["landing"]) ? $_POST["landing"] : '');

                                        $landingRequests->set("landingCod", $cod);
                                        $landingRequests->set("nombre", $nombre);
                                        $landingRequests->set("apellido", $apellido);
                                        $landingRequests->set("celular", $celular);
                                        $landingRequests->set("email", $email);
                                        $landingRequests->set("dni", $dni);

                                        $landingCheck = $landingRequests->list(["dni='$dni'", "landing_cod='$cod'"]);
                                        if (empty($landingCheck)) {
                                            if ($landingRequests->add()) {
                                                echo '<div class="alert alert-success" role="alert">¡Formulario enviado correctamente!</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">¡No se ha podido enviar el formulario!</div>';
                                            }
                                        } else {
                                            echo '<div class="alert alert-danger" role="alert">¡Ya estás cargado en el sorteo!</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">¡Ingrese un número de celular válido!</div>';
                                    }

                                } else {
                                    echo '<div class="alert alert-danger" role="alert">¡Completar el CAPTCHA correctamente!</div>';
                                }
                            }
                            ?>
                            <form method="post" class="row" id="Formulario de Contacto">
                                <label class="col-xs-12 col-sm-12 col-md-6">
                                    Nombre <span style="color:red">(*)</span>:<br/>
                                    <input type="text" name="nombre" class="form-control" required/>
                                </label>
                                <label class="col-xs-12 col-sm-12 col-md-6">
                                    Apellido <span style="color:red">(*)</span>:<br/>
                                    <input type="text" name="apellido" class="form-control" required/>
                                </label>
                                <input type="hidden" readonly name="landing" class="form-control" value="<?= mb_strtoupper($landing_["titulo"]) ?>"/>
                                <label class="col-xs-12 col-sm-12 col-md-12">
                                    Celular <span style="color:red">(*)</span>:<br/>
                                    <input type="number" name="celular" class="form-control" required/>
                                </label>
                                <label class="col-xs-12 col-sm-12 col-md-12">
                                    Email <span style="color:red">(*)</span>:<br/>
                                    <input type="email" name="email" class="form-control" required/>
                                </label>
                                <label class="col-xs-12 col-sm-12 col-md-12">
                                    DNI <span style="color:red">(*)</span>:<br/>
                                    <input type="number" name="dni" class="form-control" required/>
                                </label>
                                <label class="col-xs-12 col-sm-12  col-md-12">
                                    <div class="g-recaptcha" data-sitekey="<?= CAPTCHA_KEY ?>"></div>
                                    <input type="submit" name="enviar" class="btn btn-block btn-success mt-5" value="<?= $boton_form ?>"/>
                                </label>
                            </form>
                            <hr/>
                        </div>
                    </div>
                    <div class="blogs-page col-md-8 col-md-pull-4">
                        <div class="postWrapper v1">

                            <div id="carouselE" class="carousel slide hidden-xs" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                    foreach ($imagenData as $key => $img) {
                                        ?>
                                        <li data-target="#carouselE" data-slide-to="<?= $key; ?>" class="<?= $key == 0 ? 'active' : '' ?>"></li>
                                        <?php
                                    }
                                    ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php
                                    foreach ($imagenData as $key => $img) {
                                        ?>
                                        <div class="carousel-item hidden-xs <?= $key == 0 ? 'active' : '' ?>"
                                             style=" height: 550px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/contain;">
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if (@count($imagenData) > 1) {
                                    ?>
                                    <a class="carousel-control-prev" href="#carouselE" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Anterior</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselE" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Siguiente</span>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="post-content fs-16">
                                <p class="fs-20">
                                    <?= $landing_['desarrollo']; ?>
                                </p>
                                <div class="mt-15">
                                    <!-- AddToAny BEGIN -->
                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                        <a class="a2a_button_facebook"></a>
                                        <a class="a2a_button_twitter"></a>
                                        <a class="a2a_button_pinterest"></a>
                                        <a class="a2a_button_whatsapp"></a>
                                        <a class="a2a_button_facebook_messenger"></a>
                                    </div>
                                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                                    <!-- AddToAny END -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$template->themeEnd();
?>