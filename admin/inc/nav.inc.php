<?php
$pages = ["contenidos", "configuracion","usuarios","empresas","multimedia"];
$subpages = ["banners","sliders","novedades"];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-30">
    <div class="col-md-12">
        <a class="navbar-brand" href="#">
            City Shopping | Administrador Web
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        Home
                    </a>
                </li>
                <li class="nav-item dropdown <?php if (!in_array('contenidos', $pages)) {echo 'd-none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Contenidos
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=contenidos&accion=ver">
                            Ver Contenidos
                        </a>
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=contenidos&accion=agregar">
                            Agregar Contenidos
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if (!in_array('multimedia', $pages)) {echo 'd-none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Multimedia
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item <?php if (!in_array('banners', $subpages)) {echo 'd-none';}?>" href="<?=URL?>/index.php?op=banners&accion=ver">
                            Banners
                        </a>
                        <a class="dropdown-item <?php if (!in_array('sliders', $subpages)) {echo 'd-none';}?>" href="<?=URL?>/index.php?op=sliders&accion=ver">
                            Sliders
                        </a>
                        <a class="dropdown-item <?php if (!in_array('novedades', $subpages)) {echo 'd-none';}?>" href="<?=URL?>/index.php?op=novedades&accion=ver">
                            Novedades
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if (!in_array('productos', $pages)) {echo 'd-none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Productos
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=productos&accion=ver">
                            Ver Productos
                        </a>
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=productos&accion=agregar">
                            Agregar Productos
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if (!in_array('portfolio', $pages)) {echo 'd-none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Portfolio
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=portfolio&accion=ver">
                            Ver Portfolio
                        </a>
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=portfolio&accion=agregar">
                            Agregar Portfolio
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if (!in_array('servicios', $pages)) {echo 'd-none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Servicios
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=servicios">
                            Ver Servicios
                        </a>
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=servicios&accion=agregar">
                            Agregar Servicios
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if (!in_array('usuarios', $pages)) {echo 'd-none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Usuarios
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=usuarios&accion=verCompradores">
                            Ver Usuarios Compradores
                        </a>
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=usuarios&accion=verVendedores">
                            Ver Usuarios Vendedores
                        </a>
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=usuarios&accion=verPendientes">
                            Ver Usuarios Pendientes
                        </a>
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=usuarios&accion=agregar">
                            Agregar Usuarios
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if (!in_array('empresas', $pages)) {echo 'd-none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Restaurantes
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=empresas&accion=ver">
                            Ver Restaurantes
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if (!in_array('categorias', $pages)) {echo 'd-none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Categorias
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=categorias">
                            Ver Categorias
                        </a>
                        <a class="dropdown-item" href="<?=URL?>/index.php?op=categorias&accion=agregar">
                            Agregar Categorias
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=URL?>/index.php?op=salir">
                        Salir
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>