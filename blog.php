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
$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
$novedad->set("cod", $cod);
$novedad_data = $novedad->view();
$imagen->set("cod", $novedad_data['cod']);
$imagen_data = $imagen->listForProduct();
$fechas_ = explode("-", $novedad_data['fecha']);
$fecha_=$fechas_[2] . '/' . $fechas_[1] . '/' . $fechas_[0];
//
if (!empty($novedad_data['imagenes'][0]['ruta'])) {
    $ruta_ = URL . "/" . $novedad_data['imagenes'][0]['ruta'];
} else {
    $ruta_ = '';
}
$template->set("title", TITULO . " | " . ucfirst(strip_tags($novedad_data['titulo'])));
$template->set("description", ucfirst(substr(strip_tags($novedad_data['desarrollo']), 0, 160)));
$template->set("keywords", ucfirst(strip_tags($novedad_data['titulo'])));
$template->set("imagen", $ruta_);
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
                        <li>
                            <a href="<?= URL ?>/blogs">Blogs</a>
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
            <div class="col-lg-12">
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
                            <div class="share_tags" style="background: none">
                                <div class="share" style="float:right;">
                                    <!-- AddToAny BEGIN -->
                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                        <a class="a2a_button_facebook"></a>
                                        <a class="a2a_button_twitter"></a>
                                        <a class="a2a_button_google_plus"></a>
                                        <a class="a2a_button_pinterest"></a>
                                        <a class="a2a_button_google_gmail"></a>
                                        <a class="a2a_button_whatsapp"></a>
                                    </div>
                                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                                    <!-- AddToAny END -->
                                </div>
                                <!-- end bog_share_ara  -->
                            </div>
                        </div>
                    </article>
                </div>
                <!-- end /.single_blog -->
            </div>
            <!-- end /.col-md-8 -->
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
