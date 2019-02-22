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
$carrito = new Clases\Carrito();
$envio = new Clases\Envios();
//Datos
$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
//Carrito
$url_limpia = CANONICAL;
$url_limpia = str_replace("?success", "", $url_limpia);
$url_limpia = str_replace("?error", "", $url_limpia);
//
$producto->set("cod", $cod);
$producto_data = $producto->view();
$imagen->set("cod", $producto_data['cod']);
$imagen_data = $imagen->listForProduct();
$empresa->set('cod', $producto_data['cod_empresa']);
$empresa_data = $empresa->view();
$filterEnvios = array("cod_empresa = '" . $empresa_data['cod'] . "'");
$enviosArray = $envio->list($filterEnvios, "", "");
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
                        <?php
                        @$variantesMostrar = unserialize($producto_data['variantes']);
                        ?>
                        <!-- end /.purchase-button -->
                        <?php
                        var_dump($_SESSION['carrito']);
                        //Proceso de compra
                        if (isset($_POST["enviarCarrito"])) {
                            $id = $funciones->antihack_mysqli($producto_data['cod']);
                            $cantidad = $funciones->antihack_mysqli(isset($_POST['cantidad']) ? $_POST['cantidad'] : '');
                            $precio = $funciones->antihack_mysqli(isset($_POST['precio']) ? $_POST['precio'] : '');
                            $tipoEnvio= $funciones->antihack_mysqli(isset($_POST['tipoEnvio']) ? $_POST['tipoEnvio'] : '');
                            $producto_ = explode("---", $precio);
                            $envio_=explode("---",$tipoEnvio);

                            $carrito->set("id", $id);
                            $carrito->set("cantidad", $cantidad);
                            $carrito->set("titulo", $producto_[1]);
                            $carrito->set("precio", $producto_[0]);
                            $carrito->set("stock", $producto_data['stock']);
                            $carrito->add();

                            //Envio
                            $carrito->set("id","Envio-Seleccion");
                            $carrito->set("cantidad",1);
                            $carrito->set("titulo",$envio_[0]);
                            $carrito->set("precio",$envio_[1]);
                            $carrito->add();

                            //Metodo
                            $carrito->set("id","Metodo-Pago");
                            $carrito->set("cantidad",1);
                            $carrito->set("titulo","Método de pago: Efectivo");
                            $carrito->set("precio",0);
                            $carrito->add();

                            $funciones->headerMove(URL.'/carrito');
                        }
                        //
                        ?>
                        <form method="post" onsubmit="return confirm('Do you really want to submit the form?');">
                            <div class="sidebar-card card-pricing card--pricing2">
                                <ul class="pricing-options">
                                    <?php
                                    if (!empty($producto_data['precioDescuento']) && $producto_data['precioDescuento'] > 0) {
                                        ?>
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="opt1" value="<?= $producto_data['precioDescuento'] ?>---<?=$producto_data['titulo']?>" name="precio" checked>
                                                <label for="opt1" data-price="<?= $producto_data['precioDescuento'] ?>">
                                                    <span class="circle"></span>Producto con descuento</label>
                                            </div>
                                        </li>
                                        <?php
                                    } else {
                                        ?>
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="opt1" value="<?= $producto_data['precio'] ?>---<?= $producto_data['titulo'] ?>" name="precio" checked>
                                                <label for="opt1" data-price="<?= $producto_data['precio'] ?>">
                                                    <span class="circle"></span>Producto</label>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($variantesMostrar)) {
                                        $opt = 2;
                                        foreach ($variantesMostrar as $key => $value) {
                                            $valor = explode(",", $value);
                                            ?>
                                            <li>
                                                <div class="custom-radio">
                                                    <input type="radio" id="opt<?= $opt; ?>" class="" value="<?= $valor[0] ?>---<?= $producto_data['titulo'].' + '.$valor[1] ?>" name="precio">
                                                    <label for="opt<?= $opt; ?>" data-price="<?= $valor[0]; ?>">
                                                        <span class="circle"></span><?= ucfirst($valor[1]); ?></label>
                                                </div>
                                                <p>
                                                    <?=ucfirst($producto_data['titulo'])?> + <?= ucfirst($valor[1]); ?>.
                                                </p>
                                            </li>
                                            <?php
                                            $opt++;
                                        }
                                    }
                                    ?>
                                    <li>
                                        <h6>Cantidad:</h6>
                                        <input max="<?= $producto_data['stock'] ?>" min="1" type="number" name="cantidad" id="sst" maxlength="12" value="1" title="Ingresar valores con respecto al stock" class="input-text qty mt-5" oninvalid="this.setCustomValidity('Stock disponible: <?= $producto_data['stock'] ?>')" oninput="this.setCustomValidity('')">
                                    </li>
                                    <li>
                                        <h6>Envío:</h6>
                                        <select name="tipoEnvio" class="form-control" required>
                                            <?php
                                            foreach ($enviosArray as $env){
                                                ?>
                                                <option value="<?='Envío: '.$env['titulo']?>---<?=$env['precio']?>">
                                                    <?php
                                                    if ($env['precio']==0){
                                                        echo ucfirst($env['titulo']).' | Gratis';
                                                    }else{
                                                        echo ucfirst($env['titulo']).' | $'.$env['precio'];
                                                    }
                                                    ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </li>
                                </ul>
                                <!-- end /.pricing-options -->
                                <div class="purchase-button">
                                    <button type="submit" name="enviarCarrito" class="btn btn--lg btn--round">Comprar</button>
                                </div>
                                <!-- end /.purchase-button -->
                            </div>
                        </form>
                        <!-- end /.sidebar--card -->
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
