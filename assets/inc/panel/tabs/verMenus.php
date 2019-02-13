<?php $filterCrearMenu = array("cod_empresa = '" . $empresaData['cod'] . "'");
$existeMenu = $menu->list($filterCrearMenu, "", "");
if (!empty($existeMenu)):
    $mostrardivMenu = 'style = "display: none;"';
    $mostrardivMenu2 = '';
else:
    $mostrardivMenu = '';
    $mostrardivMenu2 = 'style = "display: none;"';
endif; ?>

<div class="col-md-offset-3 col-md-6" <?= $mostrardivEmpresa ?>>
    <div class="box_style_2">
        <div id="confirm">
            <i class="icon-shop-1"></i>
            <h3>¡Antes de crear un menú, necesitamos que crees tu empresa!</h3>
        </div>
        <a href="<?= URL ?>/crear_empresa" class="btn_full">Crear Empresa</a>
    </div>
</div>

<div class="col-md-offset-3 col-md-6" <?= $mostrardivEmpresa2 ?> <?= $mostrardivMenu ?>>
    <div class="box_style_2">
        <div id="confirm">
            <i class="icon-food"></i>
            <h3>¡Añadí los menús que ofrece tu restaurante / negocio y empezá a vender!</h3>
        </div>
        <a href="<?= URL ?>/crear-menu" class="btn_full">Crear Menú</a>
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
