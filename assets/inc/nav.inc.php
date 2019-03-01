<?php
$usuario = new Clases\Usuarios();
$carrito = new Clases\Carrito();
$producto_nav = new Clases\Productos();
$countCarrito = count($carrito->return());
$carro = $carrito->return();
if (isset($_GET['logout'])) {
    $usuario->logout();
}
?>
<!-- ================================
START MENU AREA
================================= -->
<!-- start menu-area -->
<div class="menu-area">
    <!-- start .top-menu-area -->
    <div class="top-menu-area">
        <!-- start .container -->
        <div class="container">
            <!-- start .row -->
            <div class="row">
                <!-- start .col-md-3 -->
                <div class="col-lg-3 col-md-3 col-6 v_middle">
                    <div class="logo">
                        <a href="index.html">
                            <img src="<?= LOGO ?>" alt="<?= TITULO ?>" class="img-fluid">
                        </a>
                    </div>
                </div>
                <!-- end /.col-md-3 -->

                <!-- start .col-md-5 -->
                <div class="col-lg-8 offset-lg-1 col-md-9 col-6 v_middle">
                    <!-- start .author-area -->
                    <div class="author-area">
                        <div class="author__notification_area">
                            <ul>
                                <?php
                                if ($countCarrito != 0) {
                                    ?>
                                    <a href="<?= URL ?>/carrito">
                                        <li class="has_dropdown">
                                            <div class="icon_wrap">
                                                <span class="lnr lnr-cart"></span>
                                                <?php
                                                if (!empty($carro)) {
                                                    ?>
                                                    <span class="notification_count purch"><?= @count($carro) ?></span>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <div class="dropdown dropdown--cart">
                                                <div class="cart_area">
                                                    <?php
                                                    if (!empty($carro)) {
                                                        foreach ($carro as $car) {
                                                            ?>
                                                                <div class=" row cart_product">
                                                                    <div class="col-md-9">
                                                                        <div class="product__info">
                                                                            <div class="info">
                                                                                <a class="title"><?= ucfirst($car['titulo']) ?></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="product__action">
                                                                            <?php
                                                                            if ($car['precio'] > 0) {
                                                                                ?>
                                                                                <p>$<?= $car['precio'] ?></p>
                                                                                <?php
                                                                            } else {
                                                                                if ($car['id'] != 'Metodo-Pago') {
                                                                                    ?>
                                                                                    <p>Gratis!</p>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="total">
                                                            <p>
                                                                <span>Total :</span>$<?= $carrito->precioFinal(); ?></p>
                                                        </div>
                                                        <div class="cart_action">
                                                            <a class="go_cart" href="<?= URL ?>/carrito?remover">Vaciar</a>
                                                            <a class="go_checkout" href="<?= URL ?>/carrito">Ver</a>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="cart_product">
                                                            <div class="product__info" style="text-align: center;">
                                                                <p>El carrito se encuentra vacio.</p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </li>
                                    </a>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                        if (!empty($_SESSION['usuarios'])) {
                            ?>

                            <!--start .author__notification_area -->

                            <!--start .author-author__info-->
                            <div class="author-author__info inline has_dropdown">
                                <div class="author__avatar">
                                    <img src="<?= URL ?>/assets/images/usr_avatar.png" alt="user avatar">

                                </div>
                                <div class="autor__info">
                                    <p class="name">
                                        <?= $_SESSION['usuarios']['nombre'] ?>
                                    </p>
                                </div>

                                <div class="dropdown dropdown--author">
                                    <ul>
                                        <li>
                                            <a href="<?= URL ?>/panel?op=perfil">
                                                <span class="lnr lnr-user"></span>Perfil</a>
                                        </li>
                                        <?php
                                        if ($_SESSION['usuarios']['vendedor'] == 1) {
                                            ?>
                                            <li>
                                                <a href="<?= URL ?>/panel?op=empresa">
                                                    <span class="lnr lnr-users"></span>Empresa</a>
                                            </li>
                                            <li>
                                                <a href="<?= URL ?>/panel?op=venta">
                                                    <span class="lnr lnr-tag"></span>Venta</a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <li>
                                            <a href="<?= URL ?>/panel?op=compra">
                                                <span class="lnr lnr-briefcase"></span>Compra</a>
                                        </li>
                                        <li>
                                            <a href="<?= URL ?>/?logout=0">
                                                <span class="lnr lnr-exit"></span>Salir</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end /.author-author__info-->
                            <?php
                        } else {
                            ?>
                            <!--start .author-author__info-->
                            <div class="author-author__info inline has_dropdown">
                                <div class="author__avatar">
                                    <img src="<?= URL ?>/assets/images/usr_avatar.png" alt="user avatar">

                                </div>
                                <div class="dropdown dropdown--author">
                                    <ul>
                                        <li>
                                            <a data-toggle="modal" data-target="#login_2" href="#">
                                                <span class="lnr lnr-user"></span>Ingresar</a>
                                        </li>
                                        <li>
                                            <a data-toggle="modal" data-target="#register" href="#">
                                                <span class="lnr lnr-license"></span>Registrar</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end /.author-author__info-->
                            <?php
                        }
                        ?>

                    </div>
                    <!-- end .author-area -->
                    <!-- author area restructured for mobile -->
                    <div class="mobile_content ">
                        <span class="lnr lnr-user menu_icon"></span>

                        <!-- offcanvas menu -->
                        <div class="offcanvas-menu closed">
                            <span class="lnr lnr-cross close_menu"></span>
                            <div class="author-author__info">
                                <div class="author__avatar v_middle">
                                    <img src="<?= URL ?>/assets/images/usr_avatar.png" alt="user avatar">
                                </div>
                                <?php
                                if (!empty($_SESSION['usuarios'])) {
                                    ?>
                                    <div class="autor__info v_middle">
                                        <p class="name">
                                            <?= $_SESSION['usuarios']['nombre'] ?>
                                        </p>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <!--end /.author-author__info-->
                            <?php
                            if ($countCarrito != 0) {
                                ?>
                                <div class="author__notification_area">
                                    <ul>
                                        <li>
                                            <a href="<?= URL ?>/carrito">
                                                <div class="icon_wrap">
                                                    <span class="lnr lnr-cart"></span>
                                                    <?php
                                                    if (!empty($carro)) {
                                                        ?>
                                                        <span class="notification_count purch"><?= @count($carro) ?></span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                            <!--start .author__notification_area -->

                            <div class="dropdown dropdown--author">
                                <ul>
                                    <?php
                                    if (!empty($_SESSION['usuarios'])) {
                                        ?>
                                        <li>
                                            <a href="<?= URL ?>/panel?op=perfil">
                                                <span class="lnr lnr-user"></span>Perfil</a>
                                        </li>
                                        <?php
                                        if ($_SESSION['usuarios']['vendedor'] == 1) {
                                            ?>
                                            <li>
                                                <a href="<?= URL ?>/panel?op=empresa">
                                                    <span class="lnr lnr-users"></span>Empresa</a>
                                            </li>
                                            <li>
                                                <a href="<?= URL ?>/panel?op=venta">
                                                    <span class="lnr lnr-tag"></span>Venta</a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <li>
                                            <a href="<?= URL ?>/panel?op=compra">
                                                <span class="lnr lnr-briefcase"></span>Compra</a>
                                        </li>
                                        <li>
                                            <a href="<?= URL ?>/?logout=0">
                                                <span class="lnr lnr-exit"></span>Salir</a>
                                        </li>
                                        <?php
                                    } else {
                                        ?>
                                        <li>
                                            <a data-toggle="modal" data-target="#login_2" href="#">
                                                <span class="lnr lnr-user"></span>Ingresar</a>
                                        </li>
                                        <li>
                                            <a data-toggle="modal" data-target="#register" href="#">
                                                <span class="lnr lnr-license"></span>Registrar</a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end /.mobile_content -->
                </div>
                <!-- end /.col-md-5 -->
            </div>
            <!-- end /.row -->
        </div>
        <!-- end /.container -->
    </div>
    <!-- end  -->

    <!-- start .mainmenu_area -->
    <div class="mainmenu">
        <!-- start .container -->
        <div class="container">
            <!-- start .row-->
            <div class="row">
                <!-- start .col-md-12 -->
                <div class="col-md-12">
                    <div class="navbar-header">
                        <!-- start mainmenu__search -->
                        <div class="mainmenu__search">
                            <form method="get" action="<?= URL . '/productos' ?>">
                                <div class="searc-wrap">
                                    <input type="text" name="buscar" placeholder="Buscar producto">
                                    <button type="submit" class="search-wrap__btn">
                                        <span class="lnr lnr-magnifier"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- start mainmenu__search -->
                    </div>

                    <nav class="navbar navbar-expand-md navbar-light mainmenu__menu">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li>
                                    <a href="<?= URL ?>/index.php">Inicio</a>
                                </li>
                                <li>
                                    <a href="<?= URL ?>/productos">Productos</a>
                                </li>
                                <li>
                                    <a href="<?= URL ?>/comercios">Comercios</a>
                                </li>
                                <li>
                                    <a href="<?= URL ?>/blogs">Blog</a>
                                </li>
                                <li>
                                    <a href="<?= URL ?>/contacto">Contacto</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </nav>
                </div>
                <!-- end /.col-md-12 -->
            </div>
            <!-- end /.row-->
        </div>
        <!-- start .container -->
    </div>
    <!-- end /.mainmenu-->
</div>
<!-- end /.menu-area -->
<!--================================
END MENU AREA
=================================-->