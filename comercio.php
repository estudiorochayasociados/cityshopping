<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
//Clases
$template = new Clases\TemplateSite();
$banner = new Clases\Banner();
$imagen = new Clases\Imagenes();
$categoria = new Clases\Categorias();
$funciones = new Clases\PublicFunction();
$producto = new Clases\Productos();
$empresa = new Clases\Empresas();
//Datos
$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
//
$empresa->set("cod", $cod);
$empresa_data = $empresa->view();
if (empty($empresa_data)) {
    $funciones->headerMove(URL . '/index');
}
$imagen->set("cod", $empresa_data['cod']);
$imagen_data = $imagen->listForProduct();
$filter = array("cod_empresa='" . $empresa_data['cod'] . "'");
$producto_data = $producto->list($filter, '', 3);
//
if (!empty($empresa_data['portada'])) {
    $ruta_ = URL . "/" . $empresa_data['portada'];
} else {
    $ruta_ = '';
}
$template->set("title", TITULO . " | " . ucfirst(strip_tags($empresa_data['titulo'])));
$template->set("description", ucfirst(substr(strip_tags($empresa_data['desarrollo']), 0, 160)));
$template->set("keywords", ucfirst(strip_tags($empresa_data['titulo'])));
$template->set("imagen", $ruta_);
$template->set("favicon", FAVICON);
$template->set("body", "single_prduct2");
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
                            <a href="#"><?= ucfirst($empresa_data['titulo']); ?></a>
                        </li>
                    </ul>
                </div>
                <h1 class="page-title"><?= ucfirst($empresa_data['titulo']); ?></h1>
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
    START AUTHOR AREA
=================================-->
<section class="author-profile-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <aside class="sidebar sidebar_author">
                    <div class="author-card sidebar-card">
                        <div class="author-infos">
                            <div class="author_avatar">
                                <img src="<?= URL . '/' . $empresa_data['logo']; ?>" alt="">
                            </div>

                            <div class="author">
                                <h4><?= ucfirst($empresa_data['titulo']); ?></h4>
                            </div>
                            <!-- end /.author -->
                                <div class="social social--color--filled">
                                    <ul>
                                        <?php
                                        if (!empty($empresa_data['redes'])) {
                                            ?>
                                            <li>
                                                <a target="_blank" href="<?= $empresa_data['redes'] ?>">
                                                    <span class="fa fa-facebook"></span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($empresa_data['redes2'])) {
                                            ?>
                                            <li>
                                                <a target="_blank" href="<?= $empresa_data['redes2'] ?>">
                                                    <span class="fa fa-twitter"></span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if (!empty($empresa_data['redes3'])) {
                                            ?>
                                            <li>
                                                <a target="_blank" href="<?= $empresa_data['redes3'] ?>">
                                                    <span class="fa fa-instagram"></span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <!-- end /.social -->
                            <!-- end /.author-btn -->
                        </div>
                        <!-- end /.author-infos -->
                    </div>
                    <!-- end /.author-card -->

                    <div class="sidebar-card freelance-status">
                        <h2>Contacto</h2>
                        <ul class="mt-10">
                            <li>
                                <p><span class="lnr lnr-phone-handset"></span> Teléfono: <br><?= $empresa_data['telefono']; ?></p>
                            </li>
                            <li>
                                <p><span class="lnr lnr-envelope"></span> Email: <br> <?= $empresa_data['email']; ?></p>
                            </li>
                        </ul>
                    </div>
                    <!-- end /.author-card -->
                </aside>
            </div>
            <!-- end /.sidebar -->

            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <?php
                    if (!empty($empresa_data)) {
                        ?>
                        <div class="col-md-12">
                            <div id="carousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $activo = 0;
                                    foreach ($imagen_data as $img) {
                                        ?>
                                        <div class="carousel-item <?php if ($activo == 0) {
                                            echo "active";
                                            $activo++;
                                        } ?>" style=" height: 400px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if (@count($imagen_data) > 1) {
                                    ?>
                                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Anterior</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Siguiente</span>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-md-12 col-sm-12">

                        <div class="author_module about_author">
                            <h2>Sobre la empresa:</h2>
                            <p><?= ucfirst(strip_tags($empresa_data['desarrollo'])); ?></p>
                        </div>
                    </div>
                </div>
                <!-- end /.row -->

            </div>
            <!-- end /.col-md-8 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="product-title-area hidden-xs">
                    <div class="product__title">
                        <h2>Productos recientes</h2>
                    </div>
                    <?php
                    if (!empty($producto_data)) {
                        ?>
                        <a href="<?= URL ?>/productos?empresa=<?= $empresa_data['cod']; ?>" class="btn btn--sm">Ver todos</a>
                        <?php
                    }
                    ?>
                </div>
                <!-- end /.product-title-area -->
                <div class="product-title-area visible-xs">
                    <div class="product__title" style="width: 100%;text-align: center;">
                        <h2>Productos</h2>
                    </div>
                    <?php
                    if (!empty($producto_data)) {
                        ?>
                        <a href="<?= URL ?>/productos?empresa=<?= $empresa_data['cod']; ?>" class="btn btn--sm" style="width: 100%">Ver todos</a>
                        <?php
                    }
                    ?>
                </div>
                <!-- end /.product-title-area -->
            </div>
            <!-- end /.col-md-12 -->
            <?php
            if (!empty($producto_data)) {
                foreach ($producto_data as $prod) {
                    $imagen->set("cod", $prod['cod']);
                    $img = $imagen->view();
                    ?>
                    <!-- start .col-md-4 -->
                    <div class="col-lg-4 col-md-4 hidden-xs">
                        <!-- start .single-product -->
                        <div class="product product--card">
                            <a href="<?= URL . '/producto/' . $funciones->normalizar_link($prod['titulo']) . '/' . $funciones->normalizar_link($prod['cod']); ?>">
                                <div style=" height: 200px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                </div>
                            </a>
                            <!-- end /.product__thumbnail -->
                            <div class="product-desc">
                                <a href="<?= URL . '/producto/' . $funciones->normalizar_link($prod['titulo']) . '/' . $funciones->normalizar_link($prod['cod']); ?>" class="product_title">
                                    <h4><?= ucfirst(substr(strip_tags($prod['titulo']), 0, 20)); ?></h4>
                                </a>
                                <p><?= ucfirst(substr(strip_tags($prod['desarrollo']), 0, 150)); ?></p>
                            </div>
                            <!-- end /.product-desc -->
                            <div class="product-purchase">
                                <div class="price_love">
                                    <?php
                                    if (!empty($prod['precioDescuento'])) {
                                        ?>
                                        <span>$<?= $prod['precioDescuento'] ?> <small class="tachado">$<?= $prod['precio'] ?></small></span>
                                        <?php
                                    } else {
                                        ?>
                                        <span>$<?= $prod['precio'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <p>
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
            } else {
                ?>
                <div class="col-md-12">
                    <div class="product product--card center">
                        <h4 style="text-align: center;">
                            Esta empresa aún no cargo ningún producto.
                        </h4>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
        <!-- end /.row -->
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<!--================================
    END AUTHOR AREA
=================================-->
<?php
$template->themeEnd();
?>
