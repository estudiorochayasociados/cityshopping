<?php
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : '0';
$cantidad = 9;

if ($pagina > 0) {
    $pagina = $pagina - 1;
}

if (@count($_GET) >= 1) {
    $anidador = "&";
} else {
    $anidador = "?";
}

if (isset($_GET['pagina'])):
    $url = $funcion->eliminar_get(CANONICAL, 'pagina');
else:
    $url = CANONICAL;
endif;

$filterMenu = array("cod_empresa = '" . $empresaData['cod'] . "'");
$productoArray = $producto->list($filterMenu, "", $cantidad * $pagina . ',' . $cantidad);
$numeroPaginas = $producto->paginador($filterMenu, $cantidad);

if (isset($_GET["borrar"])) {
    $cod = $funcion->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : '');
    $producto->set("cod", $cod);
    $imagenes->set("cod", $cod);
    $producto->delete();
    $imagenes->deleteAll();
    $funcion->headerMove(URL . "/panel?op=productos");
}
?>
<div class="dashboard-edit">
    <div class="dashboard-area">
        <div class="dashboard_contents">
            <div class="container">
                <?php
                if (!empty($empresaData)) {
                    if (!empty($productoArray)) {
                        ?>
                        <div class="row">
                            <?php
                            foreach ($productoArray as $prod) {
                                $imagenes->set("cod",$prod['cod']);
                                $img=$imagenes->view();
                                ?>
                                <!-- start .col-md-4 -->
                                <div class="col-lg-4 col-md-6">
                                    <!-- start .single-product -->
                                    <div class="product product--card product--card3">
                                        <div class="product__thumbnail">
                                                <div style=" height: 200px; background: url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                                </div>
                                            <div class="prod_option">
                                                <a href="#" id="drop2" class="dropdown-trigger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <span class="lnr lnr-cog setting-icon"></span>
                                                </a>

                                                <div class="options dropdown-menu" aria-labelledby="drop2">
                                                    <ul>
                                                        <li>
                                                            <a href="<?= URL; ?>/panel?op=editar&cod=<?= $prod['cod'] ?>">
                                                                <span class="lnr lnr-pencil"></span>Editar</a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= URL . '/producto/' . $funcion->normalizar_link($prod['titulo']) . '/' . $funcion->normalizar_link($prod['cod']); ?>">
                                                                <span class="lnr lnr-eye"></span>Ver</a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= CANONICAL; ?>&borrar=<?= $prod['cod'] ?>" class="delete">
                                                                <span class="lnr lnr-trash"></span>Borrar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end /.product__thumbnail -->

                                        <div class="product-desc">
                                            <a class="product_title">
                                                <h4> <?= ucfirst(substr(strip_tags($prod['titulo']), 0, 50)); ?></h4>
                                            </a>
                                            <ul class="titlebtm">
                                                <li>
                                                    <p>
                                                        <a href="">

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
                                        </div>
                                            <div class="sell">
                                                <p>
                                                    <span class="lnr lnr-layers"></span>
                                                    <span><?=$prod['stock'];?></span>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pagination-area">
                                    <nav class="navigation pagination" role="navigation">
                                        <div class="nav-links">
                                    <?php if (($pagina + 1) > 1): ?>
                                        <a class="page-numbers" href="<?= $url ?><?= $anidador ?>pagina=<?= $pagina ?>"></a>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $numeroPaginas; $i++): ?>
                                        <a class="page-numbers" href="<?= $url ?><?= $anidador ?>pagina=<?= $i ?>"><?= $i ?></a>
                                    <?php endfor; ?>

                                    <?php if (($pagina + 2) <= $numeroPaginas): ?>
                                        <a class="page-numbers" href="<?= $url ?><?= $anidador ?>pagina=<?= ($pagina + 2) ?>"></a>
                                    <?php endif; ?>
                                        </div>
                                    </nav>
                                </div>
                                <!-- end /.pagination-area -->
                            </div>
                            <!-- end /.col-md-12 -->
                        </div>
                        <!-- end /.row -->
                        <?php
                    } else {
                        ?>
                        <div class="dashboard_title_area">
                            <div class="dashboard__title">
                                <h3>¡Añadí los productos que ofrece tu empresa y empezá a vender!</h3>
                                <a href="<?= URL ?>/panel?op=nuevo" class="btn_full">Nuevo producto</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="dashboard_title_area">
                        <div class="dashboard__title">
                            <h3>¡Antes de crear un producto, necesitamos que crees tu empresa!</h3>
                            <a href="<?= URL ?>/panel?op=crear-empresa" class="btn_full">Crear Empresa</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- end /.container -->
        </div>
    </div>
</div>
