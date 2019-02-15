<?php
$novedades_side = $novedad->listWithOps('', '', 4);
////Banners
$categoria->set("area", "banners");
$categorias_banners = $categoria->listForArea('');
foreach ($categorias_banners as $categorias) {
    if ($categorias['titulo'] == "Superior Cuadrado") {
        $banner->set("categoria", $categorias['cod']);
        $banner_data_cuadrado = $banner->listForCategory('RAND()', 2);
    }
}
?>
<div class="col-lg-4">
    <aside class="sidebar sidebar--blog">

        <div class="sidebar-card sidebar--post card--blog_sidebar">
            <div class="card-title">
                <!-- Nav tabs -->
                <ul class="nav post-tab" role="tablist">
                    <li>
                        <a class="active" id="popular-tab">Últimos blogs</a>
                    </li>
                </ul>
            </div>
            <!-- end /.card-title -->

            <div class="card_content">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active fade show" id="popular" aria-labelledby="popular-tab">
                        <ul class="post-list">
                            <?php
                            if (!empty($novedades_side)) {
                                foreach ($novedades_side as $nov_side) {
                                    $imagen->set("cod", $nov_side['cod']);
                                    $img = $imagen->view();
                                    $fechas_ = explode("-", $nov_side['fecha']);
                                    $fecha_ = $fechas_[2] . '/' . $fechas_[1] . '/' . $fechas_[0];
                                    ?>
                                    <li>
                                        <div class="thumbnail_img" style="height:80px;background:url(<?= $img['ruta']; ?>) no-repeat center center/cover;">
                                        </div>
                                        <div class="title_area">
                                            <a href="<?= URL . '/blog/' . $funciones->normalizar_link($nov_side['titulo']).'/'.$funciones->normalizar_link($nov_side['cod']); ?>">
                                                <h4><?= ucfirst(substr(strip_tags($nov_side['titulo']), 0, 60)); ?>...</h4>
                                            </a>
                                            <div class="date_time">
                                                <span class="lnr lnr-clock"></span>
                                                <p><?= $fecha_ ?></p>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?>

                        </ul>
                        <!-- end /.post-list -->
                    </div>
                    <!-- end /.tabpanel -->
                </div>
                <!-- end /.tab-content -->
            </div>
            <!-- end /.card_content -->
        </div>
        <!-- end /.sidebar-card -->
        <?php
        if (!empty($banner_data_cuadrado)) {
            foreach ($banner_data_cuadrado as $ban) {
                $imagen->set("cod",$ban['cod']);
                $img = $imagen->view();
                ?>
                <div class="mb-10" style="height:300px;background:url(<?= $img['ruta']; ?>) no-repeat center center/cover;">
                </div>
                <?php
            }
        }
        ?>
        <!-- end /.banner -->
    </aside>
    <!-- end /.aside -->
</div>
<!-- end /.col-md-4 -->
