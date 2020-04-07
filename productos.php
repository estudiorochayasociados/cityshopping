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
$titulo = isset($_GET["buscar"]) ? $_GET["buscar"] : '';
$orden_pagina = isset($_GET["order"]) ? $_GET["order"] : '';
$empresa_get = isset($_GET["empresa"]) ? $_GET["empresa"] : '';
////Categorias
$filtro = array("cod!= '' GROUP BY categoria");
$productos_cat = $producto->list($filtro, '', '');
$categorias_data = array();
foreach ($productos_cat as $prod_cat) {
    $categoria->set("cod", $prod_cat['categoria']);
    array_push($categorias_data, $categoria->view());
}
////Productos
$cantidad = 12;
if ($pagina > 0) {
    $pagina = $pagina - 1;
}
if (@count($filter) == 0) {
    $filter = '';
}
if ($_GET) {
    if (@count($_GET) > 1) {
        if (isset($_GET["pagina"])) {
            $anidador = "&";
        }
    } else {
        if (isset($_GET["pagina"])) {
            $anidador = "?";
        } else {
            $anidador = "&";
        }
    }
} else {
    $anidador = "?";
}

if (isset($_GET['pagina'])) :
    $url = $funciones->eliminar_get(CANONICAL, 'pagina');
else :
    $url = CANONICAL;
endif;
//
if (!empty($categoria_get) || !empty($titulo) || !empty($empresa_get)) {
    $filter = array();
} else {
    $filter = '';
}
$filter = ["precio>0"];
if (!empty($categoria_get)) {
    $categoria->set("cod", $categoria_get);
    $categoria_data_filtro = $categoria->view();
    $cod = $categoria_data_filtro['cod'];
    array_push($filter, "categoria='$cod'");
}
if ($titulo != '') {
    $titulo_espacios = strpos($titulo, " ");
    if ($titulo_espacios) {
        $filter_title = array();
        $titulo_explode = explode(" ", $titulo);
        foreach ($titulo_explode as $titulo_) {
            array_push($filter_title, "(titulo LIKE '%$titulo_%')");
        }
        $filter_title_implode = implode(" OR ", $filter_title);
        array_push($filter, "(" . $filter_title_implode . ")");
    } else {
        array_push($filter, "(titulo LIKE '%$titulo%')");
    }
}
if (!empty($empresa_get)) {
    array_push($filter, "cod_empresa='$empresa_get'");
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
        $orden_pagina = 'ultimos';
        break;
}
$productos_data = $producto->list($filter, $order_final, ($cantidad * $pagina) . ',' . $cantidad);
if (!empty($productos_data)) {
    $numeroPaginas = $producto->paginador($filter, $cantidad);
}
////
//
$template->set("title", TITULO . " | Productos");
$template->set("description", "Todos los productos en City Shopping");
$template->set("keywords", "Todos los productos en City Shopping");
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
                                    <?php $funciones->variables_get_input("buscar"); ?>
                                    <input class="relative-field rounded" value="<?= isset($titulo) ? $titulo : ''; ?>" type="text" placeholder="Buscar un producto" name="buscar" required>
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
<section class="products section--padding2 pt-10">
    <!-- start container -->
    <div class="container">
        <!-- start .row -->
        <div class="row">
            <!-- start .col-md-3 -->
            <div class="col-lg-3">
                <!-- start aside -->
                <aside class="sidebar product--sidebar">
                    <div class="sidebar-card card--category ">
                        <a class="card-title pt-10 pb-11" href="#collapse1" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse1">
                            <h4 class="fs-15 bold">
                                ORDENAR POR
                                <span class="lnr lnr-chevron-down"></span>
                            </h4>
                        </a>
                        <div class="collapse show collapsible-content" id="collapse1" style="height: 50px;">
                            <form method="get">
                                <?php $funciones->variables_get_input("order"); ?>
                                <select name="order" class="form-control" onchange="this.form.submit()">
                                    <option value="ultimos" <?php ($orden_pagina == "ultimos") ? "selected" : ''; ?>>
                                        ÚLTIMOS
                                    </option>
                                    <option value="menor" <?php ($orden_pagina == "menor") ? "selected" : ''; ?>>
                                        MENOR A MAYOR
                                    </option>
                                    <option value="mayor" <?php ($orden_pagina == "mayor") ? "selected" : ''; ?>>
                                        MAYOR A MENOR
                                    </option>
                                </select>
                            </form>
                        </div>
                        <!-- end /.collapsible_content -->
                    </div>

                    <!-- end /.sidebar-card -->
                    <div class="sidebar-card card--category">
                        <a class="card-title pt-10 pb-11" href="#collapse2" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse2">
                            <h4 class="fs-15 bold">
                                CATEGORÍAS
                                <span class="lnr lnr-chevron-down"></span>
                            </h4>
                        </a>
                        <div class="collapsible-content categorias collapse" id="collapse2">
                            <form method="get">
                                <?php $funciones->variables_get_input("categoria"); ?>
                                <ul>
                                    <?php
                                    foreach ($categorias_data as $cat) {
                                    ?>
                                        <li>
                                            <label class="fs-14">
                                                <input type="checkbox" class="checks" value="<?= $cat['cod']; ?>" name="categoria" onclick="document.location.href='<?= URL . '/productos?categoria=' . $cat['cod'] ?>'" <?php ($categoria_get == $cat['cod']) ? "checked" : ''; ?> />
                                                <span><?= ucfirst($cat['titulo']); ?></span>
                                            </label>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </form>
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
                    if (!empty($productos_data)) {
                        foreach ($productos_data as $prod) {
                            //Empresa
                            $empresa->set("cod", $prod['cod_empresa']);
                            $empresa_data = $empresa->view();
                            //
                            $imagen->set("cod", $prod['cod']);
                            $img = $imagen->view();
                    ?>
                            <div class="col-md-4">
                                <!-- start .single-product -->
                                <div class="product product--card product--card-small">
                                    <a href="<?= URL . '/producto/' . $funciones->normalizar_link($prod['titulo']) . '/' . $funciones->normalizar_link($prod['cod']); ?>">
                                        <div style=" height: 200px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/contain;">
                                        </div>
                                    </a>
                                    <!-- end /.product__thumbnail -->
                                    <div class="product-desc">
                                        <a href="<?= URL . '/producto/' . $funciones->normalizar_link($prod['titulo']) . '/' . $funciones->normalizar_link($prod['cod']); ?>" class="product_title">
                                            <h4><?= ucfirst(substr(strip_tags($prod['titulo']), 0, 20)); ?></h4>
                                        </a>
                                        <ul class="titlebtm">
                                            <li>
                                                <p>
                                                    <a href="<?= URL . '/comercio/' . $funciones->normalizar_link($empresa_data['titulo']) . '/' . $funciones->normalizar_link($empresa_data['cod']); ?>">
                                                        <?= ucfirst(substr(strip_tags($empresa_data['titulo']), 0, 50)); ?>
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
                                                <span>$<?= number_format($prod['precioDescuento'], 2, ",", ".") ?>
                                                    <small class="tachado">$<?= number_format($prod['precio'], 2, ",", ".") ?></small></span>
                                            <?php
                                            } else {
                                            ?>
                                                <span>$<?= number_format($prod['precio'], 2, ".", ".") ?></span>
                                            <?php
                                            }
                                            ?>
                                            <p>
                                        </div>
                                    </div>
                                    <!-- end /.product-purchase -->
                                </div>
                            </div>
                            <!-- end /.single-product -->
                        <?php
                        }
                    } else {
                        ?>
                        <div class="col-md-12">
                            <div class="product product--card center">
                                <h4 style="text-align: center;">
                                    No existe ningún producto con esa descripción.
                                </h4>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-12">
                    <div class="pagination-area categorised_item_pagination" style="text-align: center;">
                        <nav class="navigation pagination" role="navigation">
                            <div class="nav-links">
                                <?php
                                if (!empty($numeroPaginas)) {
                                    if ($numeroPaginas != 1 && $numeroPaginas != 0) {
                                        $url_final = $funciones->eliminar_get(CANONICAL, "pagina");
                                        $links = '';
                                        $links .= "<a class='page-numbers' href='" . $url_final . $anidador . "pagina=1'>1</a>";
                                        $i = max(2, $pagina - 5);

                                        if ($i > 2) {
                                            $links .= "<a class='page-numbers' href='#'>...</a>";
                                        }
                                        for (; $i <= min($pagina + 6, $numeroPaginas); $i++) {
                                            if ($pagina + 1 == $i) {
                                                $current = "current";
                                            } else {
                                                $current = "";
                                            }
                                            $links .= "<a class='page-numbers $current' href='" . $url_final . $anidador . "pagina=" . $i . "'>" . $i . "</a>";
                                        }
                                        if ($i - 1 != $numeroPaginas) {
                                            $links .= "<a class='page-numbers' href='#'>...</a>";
                                            $links .= "<a class='page-numbers' href='" . $url_final . $anidador . "pagina=" . $numeroPaginas . "'>" . $numeroPaginas . "</a>";
                                        }
                                        echo $links;
                                        echo "";
                                    }
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