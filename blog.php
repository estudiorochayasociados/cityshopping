<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
//Clases
$template = new Clases\TemplateSite();
$banner = new Clases\Banner();
$imagen = new Clases\Imagenes();
$categoria = new Clases\Categorias();
$funciones = new Clases\PublicFunction();
$novedad = new Clases\Novedades();
//Datos
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';
$novedad->set("cod", $cod);
$novedad_data = $novedad->view();
$imagen->set("cod", $novedad_data['cod']);
$imagen_data = $imagen->listForProduct();
$fechas_ = explode("-", $novedad_data['fecha']);
$fecha_=$fechas_[2] . '/' . $fechas_[1] . '/' . $fechas_[0];
//
$template->set("title", TITULO . " | " . ucfirst(strip_tags($novedad_data['titulo'])));
$template->set("description", ucfirst(substr(strip_tags($novedad_data['desarrollo']), 0, 160)));
$template->set("keywords", ucfirst(strip_tags($novedad_data['titulo'])));
$template->set("favicon", FAVICON);
$template->set("body", "single-blog-page");
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
                            <a href="<?= URL ?>/index">Inicio</a>
                        </li>
                        <li class="active">
                            <a href="#"><?= ucfirst($novedad_data['titulo']); ?></a>
                        </li>
                    </ul>
                </div>
                <h1 class="page-title"><?= ucfirst($novedad_data['titulo']); ?></h1>
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
        START LOGIN AREA
=================================-->
<section class="blog_area section--padding2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="single_blog blog--default">
                    <article>
                        <?php
                        if (!empty($imagen_data)) {
                            ?>
                            <figure>
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php
                                        foreach ($imagen_data as $img) {
                                            ?>
                                            <div class="carousel-item active" >
                                                <img class="d-block w-100" src="<?= URL.'/'.$img['ruta']; ?>" alt="<?=ucfirst($novedad_data['titulo']);?>">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if (@count($imagen_data) > 1) {
                                        ?>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </figure>
                            <?php
                        }
                        ?>
                        <div class="blog__content">
                            <a href="#" class="blog__title">
                                <h4><?= ucfirst($novedad_data['titulo']); ?></h4>
                            </a>

                            <div class="blog__meta">
                                <div class="date_time">
                                    <span class="lnr lnr-clock"></span>
                                    <p><?=$fecha_;?></p>
                                </div>
                            </div>
                        </div>

                        <div class="single_blog_content">
                            <?=ucfirst($novedad_data['desarrollo']);?>
                            <div class="share_tags">
                                <div class="share">
                                    <div class="social_share active">
                                        <ul class="social_icons">
                                            <li>
                                                <a href="#">
                                                    <span class="fa fa-facebook"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="fa fa-twitter"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="fa fa-google-plus"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="fa fa-linkedin"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- end social_share -->
                                </div>
                                <!-- end bog_share_ara  -->
                            </div>
                        </div>
                    </article>
                </div>
                <!-- end /.single_blog -->
            </div>
            <!-- end /.col-md-8 -->

            <?php include "assets/inc/blog/side.inc.php" ?>
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<!--================================
        END LOGIN AREA
=================================-->
<?php
$template->themeEnd();
?>
