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
//
$template->set("title", TITULO . " | Blogs");
$template->set("description", "Blogs de City Shopping");
$template->set("keywords", "Blogs de City Shopping");
$template->set("favicon", FAVICON);
$template->set("body", "blog-page2");
$template->themeInit();
////Gets
$pagina = $funciones->antihack_mysqli(isset($_GET["pagina"]) ? $_GET["pagina"] : '0');

$cantidad =3;

if ($pagina > 0) {
    $pagina = $pagina - 1;
}

if (@count($_GET) > 1) {
    $anidador = "&";
} else {
    $anidador = "?";
}

if (isset($_GET['pagina'])):
    $url = $funciones->eliminar_get(CANONICAL, 'pagina');
else:
    $url = CANONICAL;
endif;
////Datos
$novedades_data = $novedad->listWithOps("", "", $cantidad * $pagina . ',' . $cantidad);
$numeroPaginas = $novedad->paginador("", $cantidad);
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
                            <a href="#">Blogs</a>
                        </li>
                    </ul>
                </div>
                <h1 class="page-title">Blogs</h1>
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
                <?php
                foreach ($novedades_data as $nov) {
                    $imagen->set('cod', $nov['cod']);
                    $img = $imagen->view();
                    $fechas_ = explode("-", $nov['fecha']);
                    $fecha_=$fechas_[2] . '/' . $fechas_[1] . '/' . $fechas_[0];
                    ?>
                    <div class="single_blog blog--default">
                        <figure>
                            <a href="<?= URL . '/blog/' . $funciones->normalizar_link($nov['titulo']).'/'.$funciones->normalizar_link($nov['cod']); ?>">
                            <div style="height:350px;background:url(<?= $img['ruta']; ?>) no-repeat center center/cover;">
                            </div>
                            </a>

                            <figcaption>
                                <div class="blog__content">
                                    <a href="<?= URL . '/blog/' . $funciones->normalizar_link($nov['titulo']).'/'.$funciones->normalizar_link($nov['cod']); ?>" class="blog__title">
                                        <h4><?= ucfirst($nov['titulo']); ?></h4>
                                    </a>

                                    <div class="blog__meta">
                                        <div class="date_time">
                                            <span class="lnr lnr-clock"></span>
                                            <p><?=$fecha_?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn_text">
                                    <p><?= ucfirst(substr(strip_tags($nov['desarrollo']), 0, 300)); ?>...</p>
                                    <a href="<?= URL . '/blog/' . $funciones->normalizar_link($nov['titulo']).'/'.$funciones->normalizar_link($nov['cod']); ?>" class="btn btn--md btn--round">Ver más</a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                    <?php
                }
                ?>
                <div class="col-md-12">
                    <div class="pagination-area categorised_item_pagination" style="text-align: center;">
                        <nav class="navigation pagination" role="navigation">
                            <div class="nav-links">
                                <?php
                                if ($numeroPaginas != 1 && $numeroPaginas != 0) {
                                    $url_final = $funciones->eliminar_get(CANONICAL, "pagina");
                                    $links = '';
                                    $links .= "<a class='page-numbers' href='" . $url_final . $anidador . "pagina=1'>1</a>";
                                    $i = max(2, $pagina - 5);

                                    if ($i > 2) {
                                        $links .= "<a class='page-numbers' href='#'>...</a>";
                                    }
                                    for (; $i <= min($pagina + 6, $numeroPaginas); $i++) {
                                        $links .= "<a class='page-numbers' href='" . $url_final . $anidador . "pagina=" . $i . "'>" . $i . "</a>";
                                    }
                                    if ($i - 1 != $numeroPaginas) {
                                        $links .= "<a class='page-numbers' href='#'>...</a>";
                                        $links .= "<a class='page-numbers' href='" . $url_final . $anidador . "pagina=" . $numeroPaginas . "'>" . $numeroPaginas . "</a>";
                                    }
                                    echo $links;
                                    echo "";
                                }
                                ?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- end /.col-md-8 -->
            <?php include "assets/inc/blog/side.inc.php"?>

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
