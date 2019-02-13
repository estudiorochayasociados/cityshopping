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
////Gets
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : '0';
$categoria_get = isset($_GET["categoria"]) ? $_GET["categoria"] : '';
$titulo = isset($_GET["titulo"]) ? $_GET["titulo"] : '';
$orden_pagina = isset($_GET["order"]) ? $_GET["order"] : '';
////Categorias
$categoria->set("area", "productos");
$categorias_data = $categoria->listForArea('');
////Productos
$cantidad = 3;
if ($pagina > 0) {
    $pagina = $pagina - 1;
}

if (@count($filter) == 0) {
    $filter = '';
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
//
$filter;
if (!empty($categoria_get)) {
    $categoria->set("id", $id);
    $categoria_data_filtro = $categoria->view();
    $cod = $categoria_data_filtro['cod'];
    $filter = array("categoria='$cod'");
}
if ($titulo != '') {
    $titulo_espacios = strpos($titulo, " ");
    if ($titulo_espacios) {
        $filter_title = array();
        $titulo_explode = explode(" ", $titulo);
        foreach ($titulo_explode as $titulo_) {
            array_push($filter_title, "(titulo LIKE '%$titulo_%'  || desarrollo LIKE '%$titulo_%')");
        }
        $filter_title_implode = implode(" OR ", $filter_title);
        array_push($filter, "(" . $filter_title_implode . ")");
    } else {
        $filter = array("(titulo LIKE '%$titulo%' || desarrollo LIKE '%$titulo%')");
    }
}

switch ($orden_pagina) {
    case "mayor":
        $order_final = "precio DESC";
        break;
    case "menor":
        $order_final = "precio ASC";
        break;
    case "ultimos":
        $order_final = "id DESC";
        break;
    default:
        $order_final = "id DESC";
        break;
}
$productos_data = $producto->list($filter, $order_final, ($cantidad * $pagina) . ',' . $cantidad);
$numeroPaginas = $producto->paginador($filter, $cantidad);
////
//
$template->set("title", TITULO . " | Inicio");
$template->set("description", "");
$template->set("keywords", "");
$template->set("favicon", FAVICON);
$template->set("body", "home3");
$template->themeInit();
?>
    <!--================================
            START SEARCH AREA
        =================================-->
    <section class="search-wrapper">
        <div class="search-area2 bgimage">
            <div class="bg_image_holder">
                <img src="images/search.jpg" alt="">
            </div>
            <div class="container content_above">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="search">
                            <div class="search__title">
                                <h3>Todos los productos</h3>
                            </div>
                            <div class="search__field">
                                <form method="get" id="buscar">
                                    <div class="field-wrapper">
                                        <input class="relative-field rounded" value="<?= isset($titulo) ? $titulo : ''; ?>" type="text" placeholder="Buscar un producto" name="titulo"
                                               required>
                                        <button class="btn btn--round" type="submit">Buscar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="breadcrumb">
                                <ul>
                                    <li>
                                        <a href="<?= URL ?>/index">Inicio</a>
                                    </li>
                                    <li class="active">
                                        <a href="#">Productos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end /.row -->
            </div>
            <!-- end /.container -->
        </div>
        <!-- end /.search-area2 -->
    </section>
    <!--================================
        END SEARCH AREA
    =================================-->

    <!--================================
        START PRODUCTS AREA
    =================================-->
    <section class="products section--padding2">
        <!-- start container -->
        <div class="container">
            <!-- start .row -->
            <div class="row">
                <!-- start .col-md-3 -->
                <div class="col-lg-3">
                    <!-- start aside -->
                    <aside class="sidebar product--sidebar">
                        <div class="sidebar-card card--filter">
                            <a class="card-title" href="#collapse2" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse2">
                                <h4>Ordenamiento
                                    <span class="lnr lnr-chevron-down"></span>
                                </h4>
                            </a>
                            <div class="collapse show collapsible-content" id="collapse2">

                                <div class="filter__option filter--select">
                                    <div class="select-wrap">
                                        <select name="order">
                                            <option value="low">Precio : menor a mayor</option>
                                            <option value="high">Precio : mayor a menor</option>
                                        </select>
                                        <span class="lnr lnr-chevron-down"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end /.sidebar-card -->
                        <div class="sidebar-card card--category">
                            <a class="card-title" href="#collapse1" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse1">
                                <h4>Categorias
                                    <span class="lnr lnr-chevron-down"></span>
                                </h4>
                            </a>
                            <div class="collapse show collapsible-content" id="collapse1">
                                <ul class="card-content">
                                    <?php
                                    foreach ($categorias_data as $cat) {
                                        ?>
                                        <li>
                                            <a href="<?= URL . '/productos?categoria=' . $cat['cod']; ?>">
                                                <span class="lnr lnr-chevron-right"></span><?= ucfirst($cat['titulo']); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <!-- end /.collapsible_content -->
                        </div>
                        <!-- end /.sidebar-card -->
                    </aside>
                    <!-- end aside -->
                </div>
                <!-- end /.col-md-3 -->

                <!-- start col-md-9 -->
                <div class="col-lg-9">
                    <div class="row">
                        <?php
                        foreach ($productos_data as $prod) {
                            //Empresa
                            $empresa->set("cod", $prod['cod_empresa']);
                            $empresa_data = $empresa->view();
                            //
                            ?>
                            <div class="col-lg-4 col-md-6">
                                <!-- start .single-product -->
                                <div class="product product--card product--card-small">
                                    <div class="product__thumbnail">
                                        <img src="images/p1.jpg" alt="Product Image">
                                        <div class="prod_btn">
                                            <a href="<?= URL . '/' . $funciones->normalizar_link($prod['titulo']).'/'.$funciones->normalizar_link($prod['cod']); ?>" class="transparent btn--sm btn--round">
                                                Ver más
                                            </a>
                                        </div>
                                        <!-- end /.prod_btn -->
                                    </div>
                                    <!-- end /.product__thumbnail -->

                                    <div class="product-desc">
                                        <a href="<?= URL . '/' . $funciones->normalizar_link($prod['titulo']) . '/' . $funciones->normalizar_link($prod['cod']); ?>" class="product_title">
                                            <h4><?= ucfirst($prod['titulo']); ?></h4>
                                        </a>
                                        <ul class="titlebtm">
                                            <li>
                                                <p>
                                                    <a href="<?= URL . '/' . $funciones->normalizar_link($empresa_data['titulo']) . '/' . $funciones->normalizar_link($empresa_data['cod']); ?>">
                                                        <?= ucfirst($empresa_data['titulo']) ?>
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
                                </div>
                                <!-- end /.single-product -->
                            <?php
                        }
                        ?>
                            </div>
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
                </div>
                <!-- end /.col-md-9 -->
            </div>
        </div>
        <!-- end /.container -->
    </section>
    <!--================================
        END PRODUCTS AREA
    =================================-->
<?php
$template->themeEnd();
?>