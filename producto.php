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
$producto->set("cod", $cod);
$producto_data = $producto->view();
$imagen->set("cod", $producto_data['cod']);
$imagen_data = $imagen->listForProduct();
$empresa->set('cod', $producto_data['cod_empresa']);
$empresa_data = $empresa->view();
////Productos relacionados
$filter = array("categoria='" . $producto_data['categoria'] . "'");
$productos_relacionados = $producto->list($filter, "RAND()", 3);
//
if (!empty($producto_data['imagenes'][0]['ruta'])) {
    $ruta_ = URL . "/" . $producto_data['imagenes'][0]['ruta'];
} else {
    $ruta_ = '';
}
$template->set("title", TITULO . " | " . ucfirst(strip_tags($producto_data['titulo'])));
$template->set("description", ucfirst(substr(strip_tags($producto_data['desarrollo']), 0, 160)));
$template->set("keywords", ucfirst(strip_tags($producto_data['titulo'])));
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
                        <li>
                            <a href="<?= URL ?>/productos">Productos</a>
                        </li>
                        <li class="active">
                            <a href="#"><?= ucfirst($producto_data['titulo']); ?></a>
                        </li>
                    </ul>
                </div>
                <h1 class="page-title"><?= ucfirst($producto_data['titulo']); ?></h1>
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


<!--============================================
    START SINGLE PRODUCT DESCRIPTION AREA
==============================================-->
<section class="single-product-desc single-product-desc2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="item-preview item-preview2">
                    <?php
                    if (!empty($imagen_data)) {
                        ?>
                        <div class="item-preview">
                            <div class="item__preview-slider">
                                <?php
                                foreach ($imagen_data as $img) {
                                    ?>
                                    <div class="prev-slide">
                                        <div style=" height: 500px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/contain;">
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <!-- end /.item--preview-slider -->
                            <?php
                            if (@count($imagen_data) > 1) {
                                ?>
                                <div class="item__preview-thumb">
                                    <div class="prev-thumb">
                                        <div class="thumb-slider">
                                            <?php
                                            foreach ($imagen_data as $img) {
                                                ?>
                                                <div class="item-thumb">
                                                    <div style=" height: 80px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <!-- end /.thumb-slider -->

                                        <div class="prev-nav thumb-nav">
                                            <span class="lnr nav-left lnr-arrow-left"></span>
                                            <span class="lnr nav-right lnr-arrow-right"></span>
                                        </div>
                                        <!-- end /.prev-nav -->
                                    </div>
                                    <!-- end /.item__action -->
                                </div>
                                <!-- end /.item__preview-thumb-->
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="tab tab2">
                        <div class="item-navigation">
                            <ul class="nav nav-tabs nav--tabs2">
                                <li>
                                    <a href="#product-details" class="active" aria-controls="product-details" role="tab" data-toggle="tab">Detalle</a>
                                </li>
                                <li>
                                    <a href="#product-comment" aria-controls="product-comment" role="tab" data-toggle="tab">Comentarios </a>
                                </li>
                            </ul>
                        </div>
                        <!-- end /.item-navigation -->

                        <div class="tab-content">
                            <div class="tab-pane product-tab fade show active" id="product-details">
                                <h1>Detalle</h1>
                                <p><?= ucfirst(strip_tags($producto_data['desarrollo'])); ?></p>

                                <div class="item_social_share">
                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                        <a class="a2a_button_facebook"></a>
                                        <a class="a2a_button_twitter"></a>
                                        <a class="a2a_button_google_plus"></a>
                                        <a class="a2a_button_pinterest"></a>
                                        <a class="a2a_button_google_gmail"></a>
                                        <a class="a2a_button_whatsapp"></a>
                                    </div>
                                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                                </div>
                            </div>
                            <!-- end /.tab-content -->

                            <div class="tab-pane product-tab fade" id="product-comment">
                                <div class="thread">
                                    <ul class="media-list thread-list">
                                        <li class="single-thread">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object" src="<?= URL ?>/assets/images/m1.png" alt="Commentator Avatar">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <div>
                                                        <div class="media-heading">
                                                            <a href="author.html">
                                                                <h4>Themexylum</h4>
                                                            </a>
                                                            <span>9 Hours Ago</span>
                                                        </div>
                                                        <span class="comment-tag buyer">Purchased</span>
                                                        <a href="#" class="reply-link">Reply</a>
                                                    </div>
                                                    <p>Nunc placerat mi id nisi interdum mollis. Praesent pharetra, justo
                                                        ut sceleris que the mattis, leo quam aliquet congue placerat
                                                        mi id nisi interdum mollis. </p>
                                                </div>
                                            </div>

                                            <!-- nested comment markup -->
                                            <ul class="children">
                                                <li class="single-thread depth-2">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <a href="#">
                                                                <img class="media-object" src="images/m2.png" alt="Commentator Avatar">
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="media-heading">
                                                                <h4>AazzTech</h4>
                                                                <span>6 Hours Ago</span>
                                                            </div>
                                                            <span class="comment-tag author">Author</span>
                                                            <p>Nunc placerat mi id nisi interdum mollis. Praesent pharetra,
                                                                justo ut sceleris que the mattis, leo quam aliquet congue
                                                                placerat mi id nisi interdum mollis. </p>
                                                        </div>
                                                    </div>

                                                </li>
                                                <li class="single-thread depth-2">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <a href="#">
                                                                <img class="media-object" src="images/m1.png" alt="Commentator Avatar">
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="media-heading">
                                                                <h4>Themexylum</h4>
                                                                <span>9 Hours Ago</span>
                                                            </div>
                                                            <span class="comment-tag buyer">Purchased</span>
                                                            <p>Nunc placerat mi id nisi interdum mollis. Praesent pharetra,
                                                                justo ut sceleris que the mattis, leo quam aliquet congue
                                                                placerat mi id nisi interdum mollis. </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>

                                            <!-- comment reply -->
                                            <div class="media depth-2 reply-comment">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object" src="images/m2.png" alt="Commentator Avatar">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <form action="#" class="comment-reply-form">
                                                        <textarea class="bla" name="reply-comment" placeholder="Write your comment..."></textarea>
                                                        <button class="btn btn--md btn--round">Post Comment</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- comment reply -->
                                        </li>
                                        <!-- end single comment thread /.comment-->
                                    </ul>
                                    <!-- end /.media-list -->

                                    <div class="pagination-area pagination-area2 text-right">
                                        <nav class="navigation pagination " role="navigation">
                                            <div class="nav-links">
                                                <a class="page-numbers current" href="#">1</a>
                                                <a class="page-numbers" href="#">2</a>
                                                <a class="page-numbers" href="#">3</a>
                                                <a class="next page-numbers" href="#">
                                                    <span class="lnr lnr-arrow-right"></span>
                                                </a>
                                            </div>
                                        </nav>
                                    </div>
                                    <!-- end /.comment pagination area -->

                                    <div class="comment-form-area">
                                        <h4>Leave a comment</h4>
                                        <!-- comment reply -->
                                        <div class="media comment-form">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object" src="images/m7.png" alt="Commentator Avatar">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <form action="#" class="comment-reply-form">
                                                    <textarea name="reply-comment" placeholder="Write your comment..."></textarea>
                                                    <button class="btn btn--sm btn--round">Post Comment</button>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- comment reply -->
                                    </div>
                                    <!-- end /.comment-form-area -->
                                </div>
                                <!-- end /.comments -->
                            </div>
                            <!-- end /.product-comment -->
                        </div>
                        <!-- end /.tab-content -->
                    </div>
                    <!-- end /.item-info -->
                </div>
                <!-- end /.item-preview-->
            </div>
            <!-- end /.col-md-8 -->

            <div class="col-lg-4">
                <aside class="sidebar sidebar--single-product">
                    <div class="sidebar-card card-pricing">
                        <div class="price">
                            <h1>
                                <?php
                                if (!empty($producto_data['precioDescuento'])) {
                                    ?>
                                    <span>$<?= $producto_data['precioDescuento'] ?> <small class="tachado">$<?= $producto_data['precio'] ?></small></span>
                                    <?php
                                } else {
                                    ?>
                                    <span>$<?= $producto_data['precio'] ?></span>
                                    <?php
                                }
                                ?>
                            </h1>
                        </div>
                        <div class="purchase-button">
                            <button type="submit" href="#" class="btn btn--lg btn--round">Comprar</button>
                        </div>
                        <!-- end /.purchase-button -->
                    </div>
                    <!-- end /.sidebar--card -->
                    <div class="author-card sidebar-card ">
                        <div class="card-title">
                            <h4>Comercio</h4>
                        </div>

                        <div class="author-infos">
                            <div class="author_avatar">
                                <div style=" height: 85px; background: url(<?= URL . '/' . $empresa_data['logo'] ?>) no-repeat center center/cover;">
                                </div>
                            </div>

                            <div class="author">
                                <h4><?= ucfirst($empresa_data['titulo']); ?></h4>
                            </div>
                            <!-- end /.author -->
                            <div class="author-btn mt-10">
                                <a href="<?= URL . '/comercio/' . $funciones->normalizar_link($empresa_data['titulo']) . '/' . $funciones->normalizar_link($empresa_data['cod']); ?>" class="btn btn--sm btn--round">Ver</a>
                            </div>
                            <!-- end /.author-btn -->
                        </div>
                        <!-- end /.author-infos -->
                    </div>
                    <!-- end /.author-card -->
                </aside>
                <!-- end /.aside -->
            </div>
            <!-- end /.col-md-4 -->
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<!--===========================================
    END SINGLE PRODUCT DESCRIPTION AREA
===============================================-->
<!--============================================
    START MORE PRODUCT ARE
==============================================-->
<?php
if (!empty($productos_relacionados)) {
    ?>
    <section class="more_product_area section--padding">
        <div class="container">
            <div class="row">
                <!-- start col-md-12 -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h1>Productos
                            <span class="highlighted">relacionados</span>
                        </h1>
                    </div>
                </div>
                <!-- end /.col-md-12 -->
                <?php
                foreach ($productos_relacionados as $prod_rel) {
                    //Empresa
                    $empresa->set("cod", $prod_rel['cod_empresa']);
                    $empresa_data_rel = $empresa->view();
                    //
                    $imagen->set("cod", $prod_rel['cod']);
                    $img = $imagen->view();
                    ?>
                    <!-- start .col-lg-4 col-md-6 -->
                    <div class="col-lg-4 col-md-6">
                        <!-- start .single-product -->
                        <div class="product product--card product--card-small">
                            <a href="<?= URL . '/producto/' . $funciones->normalizar_link($prod_rel['titulo']) . '/' . $funciones->normalizar_link($prod_rel['cod']); ?>">
                                <div style=" height: 250px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                </div>
                            </a>
                            <!-- end /.product__thumbnail -->
                            <div class="product-desc">
                                <a href="<?= URL . '/producto/' . $funciones->normalizar_link($prod_rel['titulo']) . '/' . $funciones->normalizar_link($prod_rel['cod']); ?>" class="product_title">
                                    <h4><?= ucfirst(substr(strip_tags($prod_rel['titulo']), 0, 50)); ?></h4>
                                </a>
                                <ul class="titlebtm">
                                    <li>
                                        <p>
                                            <a href="<?= URL . '/producto/' . $funciones->normalizar_link($empresa_data_rel['titulo']) . '/' . $funciones->normalizar_link($empresa_data_rel['cod']); ?>">
                                                <?= ucfirst(substr(strip_tags($empresa_data_rel['titulo']), 0, 50)); ?>
                                            </a>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <!-- end /.product-desc -->

                            <div class="product-purchase">
                                <div class="price_love">
                                    <?php
                                    if (!empty($prod_rel['precioDescuento'])) {
                                        ?>
                                        <span>$<?= $prod_rel['precioDescuento'] ?> <small class="tachado">$<?= $prod_rel['precio'] ?></small></span>
                                        <?php
                                    } else {
                                        ?>
                                        <span>$<?= $prod_rel['precio'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <p>
                                </div>
                                <div class="sell">
                                    <p>
                                        <span class="lnr lnr-layers"></span>
                                        <span><?= $prod_rel['stock']; ?></span>
                                    </p>
                                </div>
                            </div>
                            <!-- end /.product-purchase -->
                        </div>
                    </div>
                    <!-- end /.col-lg-4 col-md-6 -->
                    <?php
                }
                ?>

            </div>
            <!-- end /.container -->
        </div>
        <!-- end /.container -->
    </section>
    <?php
}
?>
<!--============================================
    END MORE PRODUCT AREA
==============================================-->
<?php
$template->themeEnd();
?>
