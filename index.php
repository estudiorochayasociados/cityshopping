<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
//Clases
$template = new Clases\TemplateSite();
$banner = new Clases\Banner();
$imagen = new Clases\Imagenes();
$categoria = new Clases\Categorias();
$slider = new Clases\Sliders();
$producto = new Clases\Productos();
$empresa = new Clases\Empresas();
$funciones = new Clases\PublicFunction();
//Datos
////Banners
$categoria->set("area", "banners");
$categorias_banners = $categoria->listForArea('');
foreach ($categorias_banners as $categorias) {
    if ($categorias['titulo'] == "Superior Largo") {
        $banner->set("categoria", $categorias['cod']);
        $banner_data_largo = $banner->listForCategory('RAND()', 1);
    }
}
////Sliders
$categoria->set("area", "sliders");
$categorias_sliders = $categoria->listForArea('');
foreach ($categorias_sliders as $categorias) {
    if ($categorias['titulo'] == "Principal") {
        $slider->set("categoria", $categorias['cod']);
        $slider_data_principal = $slider->listForCategory('', '');
    }
    if ($categorias['titulo'] == "Mobile") {
        $slider->set("categoria", $categorias['cod']);
        $slider_data_principal_mobile = $slider->listForCategory('', '');
    }

}
////Productos
$productos_data = $producto->list('', '', 6);
////
//
$template->set("title", TITULO . " | Inicio");
$template->set("description", "Inicio City Shopping");
$template->set("keywords", "City Shopping");
$template->set("favicon", FAVICON);
$template->set("body", "home3");
$template->themeInit();
?>
<!--================================
        START HERO AREA
    =================================-->
<section class="hidden-xs">
    <div id="carouselE1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            foreach ($slider_data_principal as $sli => $key) {
                $imagen->set("cod", $key['cod']);
                $img = $imagen->view();
                ?>
                <div class="carousel-item <?php if ($sli == 0) {
                    echo "active";
                } ?>">
                    <img class="d-block" src="<?= URL . '/' . $img['ruta']; ?>" alt="<?= $sli['titulo']; ?>">
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        if (@count($slider_data_principal) > 1) {
            ?>
            <a class="carousel-control-prev" href="#carouselE1" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselE1" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <?php
        }
        ?>
    </div>
</section>
<section class="d-md-none">
    <div id="carouselEM" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            foreach ($slider_data_principal_mobile as $sli => $key) {
                $imagen->set("cod", $key['cod']);
                $img = $imagen->view();
                ?>
                <div class="carousel-item <?php if ($sli == 0) {
                    echo "active";
                } ?>">
                    <img class="d-block" src="<?= URL . '/' . $img['ruta']; ?>" alt="<?= $sli['titulo']; ?>">
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        if (@count($slider_data_principal_mobile) > 1) {
            ?>
            <a class="carousel-control-prev" href="#carouselEM" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselEM" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <?php
        }
        ?>
    </div>
</section>
<div class="clearfix"></div>
<!--================================
    END HERO AREA
=================================-->

<!--================================
    START PRODUCTS AREA
=================================-->
<section class="products pad">
    <!-- start container -->
    <div class="container">
        <div class="mb-10 hidden-xs">
            <?php
//
//            foreach ($banner_data_largo as $ban) {
//                $imagen->set("cod", $ban['cod']);
//                $img = $imagen->view();
//                $banner->set("id", $ban['id']);
//                $value = $ban['vistas'] + 1;
//                $banner->set("vistas", $value);
//                $banner->increaseViews();
//
/*                <img src="<?= URL . '/' . $img['ruta'] ?>">*/
//
//            }

            ?>
            <img src="<?=URL?>/assets/GIF-CON-ICONOS.gif">
        </div>
        <div class="mb-10 d-md-none">
            <img src="<?=URL?>/assets/GIF-CON-ICONOS-MOVIL.gif">
        </div>
        <!-- start row -->
        <div class="row">
            <!-- start col-md-12 -->
            <div class="col-md-12">
                <div class="product-title-area">
                    <div class="product__title">
                        <h2>Últimos productos</h2>
                    </div>
                </div>
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row -->

        <!-- start .row -->
        <div class="row">
            <?php
            foreach ($productos_data as $prod) {
                //Empresa
                $empresa->set("cod", $prod['cod_empresa']);
                $empresa_data = $empresa->view();
                //
                $imagen->set("cod", $prod['cod']);
                $img = $imagen->view();
                ?>
                <!-- start .col-md-4 -->
                <div class="col-lg-4 col-md-6">
                    <!-- start .single-product -->
                    <div class="product product--card product--card3">
                        <div class="">
                            <a href="<?= URL . '/producto/' . $funciones->normalizar_link($prod['titulo']) . '/' . $funciones->normalizar_link($prod['cod']); ?>">
                                <div style=" height: 200px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/contain;">
                                </div>
                            </a>
                            <!-- end /.prod_btn -->
                        </div>
                        <!-- end /.product__thumbnail -->

                        <div class="product-desc">
                            <a href="<?= URL . '/producto/' . $funciones->normalizar_link($prod['titulo']) . '/' . $funciones->normalizar_link($prod['cod']); ?>" class="product_title">
                                <h4><?= ucfirst(substr(strip_tags($prod['titulo']), 0, 25)); ?></h4>
                            </a>
                            <ul class="titlebtm">
                                <li>
                                    <p>
                                        <a href="<?= URL . '/producto/' . $funciones->normalizar_link($empresa_data['titulo']) . '/' . $funciones->normalizar_link($empresa_data['cod']); ?>">
                                            <?= ucfirst(substr(strip_tags($empresa_data['titulo']), 0, 25)); ?>
                                        </a>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <!-- end /.product-desc -->

                        <div class="product-purchase">
                            <div class="price_love">
                                <?php
                                if (!empty($prod['precioDescuento'])) {
                                    ?>
                                    <span>$<?= $prod['precioDescuento'] ?>
                                        <small class="tachado">$<?= $prod['precio'] ?></small></span>
                                    <?php
                                } else {
                                    ?>
                                    <span>$<?= $prod['precio'] ?></span>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="sell">
                                <p>
                                    <span class="lnr lnr-layers"></span>
                                    <span><?= $prod['stock']; ?></span>
                                </p>
                            </div>
                        </div>
                        <!-- end /.product-purchase -->
                    </div>
                    <!-- end /.single-product -->
                </div>
                <!-- end /.col-md-4 -->
                <?php
            }
            ?>
        </div>

        <!-- start .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="more-product">
                    <a href="<?= URL ?>/productos" class="btn btn--lg btn--round">Ver más productos</a>
                </div>
            </div>
            <!-- end ./col-md-12 -->
        </div>
        <!-- end /.row -->
        <div class="row mt-20">
            <div class="col-md-12 hidden-xs">
                <img src="<?= URL . '/assets/GIF-CITY-SHOPPING.gif' ?>">
            </div>
            <div class="col-md-12 d-md-none">
                <img src="<?= URL?>/assets/GIF-CITY-MOVIL.gif">
            </div>
        </div>
    </div>
    <!-- end /.container -->
</section>
<?php
if (!empty($_SESSION['usuarios'])) {
    if ($_SESSION['usuarios']['vendedor'] != 1) {
        ?>
        <!--================================
    START CALL TO ACTION AREA
=================================-->
        <section class="call-to-action bgimage">
            <div class="bg_image_holder">
                <img src="<?= URL ?>/assets/images/calltobg.jpg" alt="">
            </div>
            <div class="container content_above">
                <div class="row">
                    <div class="col-md-12">
                        <div class="call-to-wrap">
                            <h1 class="text--white">¿Te gustaría ser vendedor?</h1>
                            <?php if (empty($_SESSION["usuarios"])): ?>
                                <a href="#" data-toggle="modal" data-target="#register" onclick="Cambb()" class="btn btn--lg btn--round btn--white callto-action-btn">Registrate</a>
                            <?php else: ?>
                                <a href="#" data-toggle="modal" data-target="#vendedor" class="btn btn--lg btn--round btn--white callto-action-btn">Registrate</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================================
            END CALL TO ACTION AREA
        =================================-->
        <?php
    }
} else {
    ?>
    <!--================================
    START CALL TO ACTION AREA
=================================-->
    <section class="call-to-action bgimage">
        <div class="bg_image_holder">
            <img src="<?= URL ?>/assets/images/calltobg.jpg" alt="">
        </div>
        <div class="container content_above">
            <div class="row">
                <div class="col-md-12">
                    <div class="call-to-wrap">
                        <h1 class="text--white">¿Te gustaría ser vendedor?</h1>
                        <?php if (empty($_SESSION["usuarios"])): ?>
                            <a href="#" data-toggle="modal" data-target="#register" onclick="Cambb()" class="btn btn--lg btn--round btn--white callto-action-btn">Registrate</a>
                        <?php else: ?>
                            <a href="#" data-toggle="modal" data-target="#vendedor" class="btn btn--lg btn--round btn--white callto-action-btn">Registrate</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================================
        END CALL TO ACTION AREA
    =================================-->
    <?php
}
?>

<?php
$template->themeEnd();
?>
