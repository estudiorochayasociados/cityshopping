<?php
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : '0';
$cantidad = 10;

if ($pagina > 0) {
    $pagina = $pagina - 1;
}

if (@count($_GET) > 1) {
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
                            <!-- start .col-md-4 -->
                            <div class="col-lg-4 col-md-6">
                                <!-- start .single-product -->
                                <div class="product product--card product--card3">
                                    <div class="product__thumbnail">
                                        <img src="images/p1.jpg" alt="Product Image">

                                        <div class="prod_option">
                                            <a href="#" id="drop2" class="dropdown-trigger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <span class="lnr lnr-cog setting-icon"></span>
                                            </a>

                                            <div class="options dropdown-menu" aria-labelledby="drop2">
                                                <ul>
                                                    <li>
                                                        <a href="edit-item.html">
                                                            <span class="lnr lnr-pencil"></span>Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span class="lnr lnr-eye"></span>Hide</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-toggle="modal" data-target="#myModal2" class="delete">
                                                            <span class="lnr lnr-trash"></span>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end /.product__thumbnail -->

                                    <div class="product-desc">
                                        <a  class="product_title">
                                            <h4></h4>
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
                                        <!--
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
                                        </div>-->
                                        <div class="sell">
                                            <p>
                                                <span class="lnr lnr-layers"></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- end /.product-purchase -->
                                </div>
                                <!-- end /.single-product -->
                            </div>
                            <!-- end /.col-md-4 -->
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="pagination-area">
                                    <nav class="navigation pagination" role="navigation">
                                        <div class="nav-links">
                                            <a class="prev page-numbers" href="#">
                                                <span class="lnr lnr-arrow-left"></span>
                                            </a>
                                            <a class="page-numbers current" href="#">1</a>
                                            <a class="page-numbers" href="#">2</a>
                                            <a class="page-numbers" href="#">3</a>
                                            <a class="next page-numbers" href="#">
                                                <span class="lnr lnr-arrow-right"></span>
                                            </a>
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


<div <?= $mostrardivMenu2 ?>>
    <div class="indent_title_in">
        <i class="icon_document_alt"></i>
        <h3>Modificar Menús</h3>
        <p>Especifique a continuación los detalles del menú.</p>
    </div>
    <div class="wrapper_indent">

        <a href="<?= URL; ?>/panel?op=crearMenu" class="btn_1"><i class="icon-plus"></i> Añadir menú</a>
        <a href="<?= URL; ?>/panel?op=verSecciones" class="btn_1"><i class="icon-th-thumb-empty"></i> Administrar secciones</a><br/>
        <?php foreach ($menuArray as $key => $value):
            $imagenesMenu->set("cod", $value['cod']);
            $imagenMenuData = $imagenesMenu->view();
            $categoria->set("cod", $value['categoria']);
            $categoriaData = $categoria->view();
            $seccion->set("cod", $value['seccion']);
            $seccionData = $seccion->view(); ?>
            <div class="strip_list wow fadeIn" data-wow-delay="0.1s">
                <div class="row">
                    <div class="col-md-9 col-sm-9">
                        <div class="desc">
                            <div class="thumb_strip">
                                <a href="<?= URL; ?>/modificar-menu/<?= $value['cod'] ?>"><img
                                            src="<?= URL; ?>/<?= $imagenMenuData['ruta'] ?>" alt=""></a>
                            </div>
                            <h3><?= $value['titulo'] ?></h3>
                            <div class="type">
                                <?= $categoriaData['titulo']; ?>
                            </div>
                            <div class="location">
                                Stock: <?= $value['stock'] ?><br/>
                                Sección: <?= $seccionData['titulo'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="go_to">
                            <div>
                                <a href="<?= URL; ?>/panel?op=modificarMenu&cod=<?= $value['cod'] ?>" class="btn_1"><i class="icon-cog"></i></a>
                                <a href="<?= URL; ?>/panel?borrar=<?= $value['cod'] ?>" class="btn_1"><i class="icon-cancel-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End row-->
            </div><!-- End strip_list-->
        <?php endforeach; ?>
        <div class="text_center">
            <ul class="pagination">
                <?php if (($pagina + 1) > 1): ?>
                    <li class="page-item"><a class="page-link"
                                             href="<?= $url ?><?= $anidador ?>pagina=<?= $pagina ?>"><span
                                    aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Anterior</span></a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $numeroPaginas; $i++): ?>
                    <li class="page-item"><a class="page-link"
                                             href="<?= $url ?><?= $anidador ?>pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if (($pagina + 2) <= $numeroPaginas): ?>
                    <li class="page-item"><a class="page-link"
                                             href="<?= $url ?><?= $anidador ?>pagina=<?= ($pagina + 2) ?>"><span
                                    aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php
if (isset($_GET["borrar"])) {
    $cod = $funcion->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : '');
    $menu->set("cod", $cod);
    $imagenes->set("cod", $cod);
    $menu->delete();
    $imagenes->deleteAll();
    $funcion->headerMove(URL . "/panel#seccion-2");
}
?>
