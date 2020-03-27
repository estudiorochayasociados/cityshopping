<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
//Clases
$template = new Clases\TemplateSite();
$banner = new Clases\Banner();
$imagen = new Clases\Imagenes();
$categoria = new Clases\Categorias();
$empresa = new Clases\Empresas();
$funciones = new Clases\PublicFunction();
$producto = new Clases\Productos();
$usuario = new Clases\Usuarios();
//Datos
////Gets
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : '0';
$categoria_get = isset($_GET["categoria"]) ? $_GET["categoria"] : '';
$titulo = isset($_GET["buscar"]) ? $_GET["buscar"] : '';
//
////Categorias
$categoria->set("area", "rubros");
$categorias_data = $categoria->listIfHave('empresas');
////Comercios
$cantidad = 6;
if ($pagina > 0) {
    $pagina = $pagina - 1;
}
if (@count($filter) == 0) {
    $filter = $usuario->validarvendedor2();
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
if (isset($_GET['pagina'])):
    $url = $funciones->eliminar_get(CANONICAL, 'pagina');
else:
    $url = CANONICAL;
endif;
//
if (!empty($categoria_get) || !empty($titulo)) {
    $input_cat = "<input type='hidden' name='categoria' value='$categoria_get'>";
    $filter = array();
} else {
    $filter = '';
}

if (!empty($categoria_get)) {
    $categoria->set("cod", $categoria_get);
    $categoria_data_filtro = $categoria->view();
    $cod = $categoria_data_filtro['cod'];
    $empresaData = $empresa->list(array("categoria='" . $cod . "' GROUP BY cod"), '', '1');
    if (!empty($empresaData)) {
        array_push($filter, "categoria='" . $cod . "'");
    }
    if (empty($empresaData)) {
        $titulo = '';
    }
}
if ($titulo != '') {
    array_push($filter, "(titulo LIKE '%$titulo%')");
}
$empresa_data = $empresa->list($filter, '', ($cantidad * $pagina) . ',' . $cantidad);

if (!empty($empresa_data)) {
    $numeroPaginas = $empresa->paginador($filter, $cantidad);
}
////
//
$template->set("title", TITULO . " | Comercios");
$template->set("description", "Comercios en City Shopping");
$template->set("keywords", "Comercios en City Shopping");
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
                                <h3>Comercios</h3>
                            </div>
                            <div class="search__field">
                                <form method="get">
                                    <div class="field-wrapper">
                                        <input class="relative-field rounded" value="<?= isset($titulo) ? $titulo : ''; ?>" type="text" placeholder="Buscar un comercio" name="buscar"
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
                                        <a href="#">Comercios</a>
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
        START FILTER AREA
    =================================-->
    <div class="filter-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="filter-bar">
                        <div class="filter__option filter--dropdown" style="width: 100%;">
                            <a href="#" id="drop1" class="dropdown-trigger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-align: center;width: 100%;">Categorias
                                <span class="lnr lnr-chevron-down"></span>
                            </a>
                            <ul class="custom_dropdown custom_drop2 dropdown-menu" aria-labelledby="drop1" style="overflow-y: scroll;width: 100%;height: 200px;">
                                <?php
                                if (!empty($categorias_data)) {
                                    foreach ($categorias_data as $cat) {
                                        ?>
                                        <li>
                                            <a href="<?= URL ?>/comercios?categoria=<?= $cat['cod']; ?>"><?= ucfirst($cat['titulo']); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <!-- end /.filter__option -->
                    </div>
                    <!-- end /.filter-bar -->
                </div>
                <!-- end /.col-md-12 -->
            </div>
            <!-- end filter-bar -->
        </div>
    </div>
    <!-- end /.filter-area -->
    <!--================================
        END FILTER AREA
    =================================-->


    <!--================================
        START PRODUCTS AREA
    =================================-->
    <section class="products">
        <!-- start container -->
        <div class="container">

            <!-- start .row -->
            <div class="row">
                <?php
                if (!empty($empresa_data)) {
                    foreach ($empresa_data as $emp) {
                        $usuario->set("cod", $emp['cod_usuario']);

                            ?>
                            <!-- start .col-md-4 -->
                            <div class="col-lg-4 col-md-6">
                                <!-- start .single-product -->
                                <div class="product product--card">
                                    <a href="<?= URL . '/comercio/' . $funciones->normalizar_link($emp['titulo']) . '/' . $funciones->normalizar_link($emp['cod']); ?>">
                                        <div style=" height: 200px; background: url(<?= URL . '/' . $emp['logo'] ?>) no-repeat center center/contain;">
                                        </div>
                                    </a>
                                    <!-- end /.product__thumbnail -->

                                    <div class="product-desc">
                                        <a href="<?= URL . '/comercio/' . $funciones->normalizar_link($emp['titulo']) . '/' . $funciones->normalizar_link($emp['cod']); ?>" class="product_title">
                                            <h4><?= ucfirst(substr(strip_tags($emp['titulo']), 0, 25)); ?></h4>
                                        </a>

                                        <p><?= ucfirst(substr(strip_tags($emp['desarrollo']), 0, 150)); ?></p>
                                    </div>
                                    <!-- end /.product-desc -->
                                </div>
                                <!-- end /.single-product -->
                            </div>
                            <!-- end /.col-md-4 -->
                            <?php
                        }

                } else {
                    ?>
                    <div class="col-md-12">
                        <div class="dashboard_title_area">
                            <div class="dashboard__title" style="text-align: center;">
                                <h3>No hay comercios.</h3>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <!-- end /.row -->

            <div class="row">
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
            <!-- end /.row -->
        </div>
        <!-- end /.container -->
    </section>
    <!--================================
        END PRODUCTS AREA
    =================================-->
<?php
$template->themeEnd();
?>