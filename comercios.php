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
$producto=new Clases\Productos();
//Datos
////Gets
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : '0';
$categoria_get = isset($_GET["categoria"]) ? $_GET["categoria"] : '';
////Categorias
$categoria->set("area", "rubros");
$categorias_data = $categoria->listForArea('');
////Comercios
$cantidad = 6;
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
if (!empty($categoria_get)) {
    $categoria->set("cod", $categoria_get);
    $categoria_data_filtro = $categoria->view();
    $cod = $categoria_data_filtro['cod'];
    $producto_data=$producto->list(array("categoria='".$cod."' GROUP BY cod_empresa"),'','');

    $filter = array("categoria='$cod'");
}
$empresa_data = $empresa->list($filter, '', ($cantidad * $pagina) . ',' . $cantidad);
$numeroPaginas = $empresa->paginador($filter, $cantidad);
////
//
$template->set("title", TITULO . " | Comercios");
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
                            <h3>Comercios</h3>
                        </div>
                        <div class="search__field">
                            <form action="#">
                                <div class="field-wrapper">
                                    <input class="relative-field rounded" type="text" placeholder="Busca un comercio">
                                    <button class="btn btn--round" type="submit">Buscar</button>
                                </div>
                            </form>
                        </div>
                        <div class="breadcrumb">
                            <ul>
                                <li>
                                    <a href="<?=URL?>/index">Inicio</a>
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
                            foreach ($categorias_data as $cat){
                                ?>
                                <li>
                                    <a href="<?=URL?>/comercios?categoria=<?=$cat['cod'];?>"><?=ucfirst($cat['titulo']);?>
                                    </a>
                                </li>
                                <?php
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
            if (!empty($empresa_data)){
                foreach ($empresa_data as $emp){
                    ?>
                    <!-- start .col-md-4 -->
                    <div class="col-lg-4 col-md-6">
                        <!-- start .single-product -->
                        <div class="product product--card">
                            <a href="<?= URL . '/comercio/' . $funciones->normalizar_link($emp['titulo']) . '/' . $funciones->normalizar_link($emp['cod']); ?>">
                                <div style=" height: 200px; background: url(<?= URL . '/' . $emp['portada'] ?>) no-repeat center center/cover;">
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
            }else{
                ?>

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
                            if ($numeroPaginas != 1 && $numeroPaginas != 0) {
                                $url_final = $funciones->eliminar_get(CANONICAL, "pagina");
                                $links = '';
                                $links .= "<a class='page-numbers' href='" . $url_final . $anidador . "pagina=1'>1</a>";
                                $i = max(2, $pagina - 5);

                                if ($i > 2) {
                                    $links .= "<a class='page-numbers' href='#'>...</a>";
                                }
                                for (; $i <= min($pagina + 6, $numeroPaginas); $i++) {
                                    $links .= "<a class='page-numbers ' href='" . $url_final . $anidador . "pagina=" . $i . "'>" . $i . "</a>";
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