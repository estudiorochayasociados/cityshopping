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
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <th class="hidden-xs hidden-sm">TÍTULO</th>
                                    <th class="d-md-none">PRODUCTO</th>
                                    <th class="hidden-xs hidden-sm">PRECIO</th>
                                    <th class="hidden-xs hidden-sm">PRECIO DESCUENTO</th>
                                    <th class="hidden-xs hidden-sm">STOCK</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($productoArray as $producto_) {
                                        $cod = $producto_["cod"];
                                        ?>
                                        <tr>
                                            <td>
                                                <input class="form-control" style='width:90%' onchange='editProduct("titulo-<?= $cod ?>","<?= URL ?>")' id='titulo-<?= $cod ?>' name='titulo' value='<?= $producto_["titulo"] ?>'/>
                                                <div class="d-md-none">
                                                    <div class="input-group mb-3 mt-3" style="width:90%">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control" min="0" onchange='editProduct("precio-<?= $cod ?>-m","<?= URL ?>")' id='precio-<?= $cod ?>-m' name='precio' value='<?= $producto_["precio"] ?>'>
                                                    </div>
                                                    <div class="input-group mb-3 mt-3" style="width:90%">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control" min="0" onchange='editProduct("precioDescuento-<?= $cod ?>-m","<?= URL ?>")' id='precioDescuento-<?= $cod ?>-m' name='precio_descuento' value='<?= $producto_["precioDescuento"] ?>'>
                                                    </div>
                                                    <div class="input-group mb-3 mt-3" style="width:90%">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control" min="0" onchange='editProduct("stock-<?= $cod ?>-m","<?= URL ?>")' id='stock-<?= $cod ?>-m' name='stock' value='<?= $producto_["stock"] ?>'>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="hidden-xs hidden-sm">
                                                <div class="input-group mb-3" style="width:90%">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control" min="0" onchange='editProduct("precio-<?= $cod ?>","<?= URL ?>")' id='precio-<?= $cod ?>' name='precio' value='<?= $producto_["precio"] ?>'>
                                                </div>
                                            </td>
                                            <td class="hidden-xs hidden-sm">
                                                <div class="input-group mb-3" style="width:90%">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control" min="0" onchange='editProduct("precioDescuento-<?= $cod ?>","<?= URL ?>")' id='precioDescuento-<?= $cod ?>' name='precio_descuento' value='<?= $producto_["precioDescuento"] ?>'>
                                                </div>
                                            </td>
                                            <td class="hidden-xs hidden-sm">
                                                <div class="input-group mb-3" style="width:90%">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control" min="0" onchange='editProduct("stock-<?= $cod ?>","<?= URL ?>")' id='stock-<?= $cod ?>' name='stock' value='<?= $producto_["stock"] ?>'>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="width: 90%">
                                                    <?php if (!empty($producto_['variantes'])) { ?>
                                                        <button style="color:white" class="btn btn-info variations-button fs-20 mt-5" data-toggle="tooltip" data-placement="top" onclick="openVariantions('<?= URL ?>','<?= $cod ?>')" title="Modificar variantes">
                                                            <i class="fa fa-pencil" style="margin:5px"></i>
                                                        </button>
                                                    <?php } ?>
                                                    <a style="" class="btn btn-info fs-20 mt-5" data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL; ?>/panel?op=editar&cod=<?= $producto_['cod'] ?>">
                                                        <i class="fa fa-gear" style="margin:5px"></i>
                                                    </a>
                                                    <a style="" class="btn btn-success fs-20 mt-5" data-toggle="tooltip" data-placement="top" title="Ver" href="<?= URL . '/producto/' . $funcion->normalizar_link($producto_['titulo']) . '/' . $funcion->normalizar_link($producto_['cod']); ?>">
                                                        <i class="fa fa-eye" style="margin:5px"></i>
                                                    </a>
                                                    <a style="" class="btn btn-danger fs-20 mt-5" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= CANONICAL; ?>&borrar=<?= $producto_['cod'] ?>">
                                                        <i class="fa fa-trash" style="margin:5px"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
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
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#variationsModal">
    Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="variationsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding:10px">
                <h5 class="modal-title" style="margin-bottom: 0px" id="variationsModalTitle">Modal title</h5>
                <!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                <!--                    <span aria-hidden="true">&times;</span>-->
                <!--                </button>-->
            </div>
            <div class="modal-body">
                <form id="variationsModalForm" class="row" onsubmit="event.preventDefault();updateVariations('<?=URL?>')">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-sm btn-success" form="variationsModalForm">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>