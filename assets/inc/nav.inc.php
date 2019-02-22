<?php
$usuario = new Clases\Usuarios();
$carrito = new Clases\Carrito();
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
                        <?php
                        if (!empty($_SESSION['usuarios'])) {
                            ?>
                            <div class="author__notification_area">
                                <ul>
                                    <li class="has_dropdown">
                                        <div class="icon_wrap">
                                            <span class="lnr lnr-alarm"></span>
                                            <span class="notification_count noti">25</span>
                                        </div>

                                        <div class="dropdown notification--dropdown">

                                            <div class="dropdown_module_header">
                                                <h4>My Notifications</h4>
                                                <a href="notification.html">View All</a>
                                            </div>

                                            <div class="notifications_module">
                                                <div class="notification">
                                                    <div class="notification__info">
                                                        <div class="info_avatar">
                                                            <img src="<?= URL ?>/assets/images/notification_head.png" alt="">
                                                        </div>
                                                        <div class="info">
                                                            <p>
                                                                <span>Anderson</span> added to Favourite
                                                                <a href="#">Mccarther Coffee Shop</a>
                                                            </p>
                                                            <p class="time">Just now</p>
                                                        </div>
                                                    </div>
                                                    <!-- end /.notifications -->

                                                    <div class="notification__icons ">
                                                        <span class="lnr lnr-heart loved noti_icon"></span>
                                                    </div>
                                                    <!-- end /.notifications -->
                                                </div>
                                                <!-- end /.notifications -->

                                                <div class="notification">
                                                    <div class="notification__info">
                                                        <div class="info_avatar">
                                                            <img src="<?= URL ?>/assets/images/notification_head2.png" alt="">
                                                        </div>
                                                        <div class="info">
                                                            <p>
                                                                <span>Michael</span> commented on
                                                                <a href="#">MartPlace Extension Bundle</a>
                                                            </p>
                                                            <p class="time">Just now</p>
                                                        </div>
                                                    </div>
                                                    <!-- end /.notifications -->

                                                    <div class="notification__icons ">
                                                        <span class="lnr lnr-bubble commented noti_icon"></span>
                                                    </div>
                                                    <!-- end /.notifications -->
                                                </div>
                                                <!-- end /.notifications -->

                                                <div class="notification">
                                                    <div class="notification__info">
                                                        <div class="info_avatar">
                                                            <img src="<?= URL ?>/assets/images/notification_head3.png" alt="">
                                                        </div>
                                                        <div class="info">
                                                            <p>
                                                                <span>Khamoka </span>purchased
                                                                <a href="#"> Visibility Manager Subscriptions</a>
                                                            </p>
                                                            <p class="time">Just now</p>
                                                        </div>
                                                    </div>
                                                    <!-- end /.notifications -->

                                                    <div class="notification__icons ">
                                                        <span class="lnr lnr-cart purchased noti_icon"></span>
                                                    </div>
                                                    <!-- end /.notifications -->
                                                </div>
                                                <!-- end /.notifications -->

                                                <div class="notification">
                                                    <div class="notification__info">
                                                        <div class="info_avatar">
                                                            <img src="<?= URL ?>/assets/images/notification_head4.png" alt="">
                                                        </div>
                                                        <div class="info">
                                                            <p>
                                                                <span>Anderson</span> added to Favourite
                                                                <a href="#">Mccarther Coffee Shop</a>
                                                            </p>
                                                            <p class="time">Just now</p>
                                                        </div>
                                                    </div>
                                                    <!-- end /.notifications -->

                                                    <div class="notification__icons ">
                                                        <span class="lnr lnr-star reviewed noti_icon"></span>
                                                    </div>
                                                    <!-- end /.notifications -->
                                                </div>
                                                <!-- end /.notifications -->
                                            </div>
                                            <!-- end /.dropdown -->
                                        </div>
                                    </li>
                                    <?php
                                    if ($countCarrito != 0) {
                                        ?>
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
                                                            <div class="cart_product">
                                                                <div class="product__info">
                                                                    <div class="thumbn">
                                                                        <img src="<?= URL ?>/assets/images/capro1.jpg" alt="cart product thumbnail">
                                                                    </div>

                                                                    <div class="info">
                                                                        <a class="title" href="single-product.html"><?=ucfirst($car['titulo'])?></a>
                                                                    </div>
                                                                </div>

                                                                <div class="product__action">
                                                                    <a href="#">
                                                                        <span class="lnr lnr-trash"></span>
                                                                    </a>
                                                                    <p>$60</p>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="total">
                                                            <p>
                                                                <span>Total :</span>$80</p>
                                                        </div>
                                                        <div class="cart_action">
                                                            <a class="go_cart" href="<?= URL ?>/carrito">Ver</a>
                                                            <a class="go_checkout" href="checkout.html">Pagar</a>
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
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
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
                                            <?php
                                        }
                                        ?>
                                        <li>
                                            <a href="<?= URL ?>/?logout=0">
                                                <span class="lnr lnr-exit"></span>Salir</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end /.author-author__info-->

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
                                        <div class="autor__info v_middle">
                                            <p class="name">
                                                Jhon Doe
                                            </p>
                                        </div>
                                    </div>
                                    <!--end /.author-author__info-->

                                    <div class="author__notification_area">
                                        <ul>
                                            <li>
                                                <a href="notification.html">
                                                    <div class="icon_wrap">
                                                        <span class="lnr lnr-alarm"></span>
                                                        <span class="notification_count noti">25</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="message.html">
                                                    <div class="icon_wrap">
                                                        <span class="lnr lnr-envelope"></span>
                                                        <span class="notification_count msg">6</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="cart.html">
                                                    <div class="icon_wrap">
                                                        <span class="lnr lnr-cart"></span>
                                                        <span class="notification_count purch">2</span>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--start .author__notification_area -->

                                    <div class="dropdown dropdown--author">
                                        <ul>
                                            <li>
                                                <a href="author.html">
                                                    <span class="lnr lnr-user"></span>Profile</a>
                                            </li>

                                        </ul>
                                    </div>

                                    <div class="text-center">
                                        <a href="signup.html" class="author-area__seller-btn inline">Become a Seller</a>
                                    </div>
                                </div>
                            </div>
                            <!-- end /.mobile_content -->
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
                                        <div class="autor__info v_middle">
                                            <p class="name">
                                                Jhon Doe
                                            </p>
                                            <p class="ammount">$20.45</p>
                                        </div>
                                    </div>
                                    <!--end /.author-author__info-->

                                    <div class="author__notification_area">
                                        <ul>
                                            <li>
                                                <a href="notification.html">
                                                    <div class="icon_wrap">
                                                        <span class="lnr lnr-alarm"></span>
                                                        <span class="notification_count noti">25</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="message.html">
                                                    <div class="icon_wrap">
                                                        <span class="lnr lnr-envelope"></span>
                                                        <span class="notification_count msg">6</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="cart.html">
                                                    <div class="icon_wrap">
                                                        <span class="lnr lnr-cart"></span>
                                                        <span class="notification_count purch">2</span>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--start .author__notification_area -->

                                    <div class="dropdown dropdown--author">
                                        <ul>
                                            <li>
                                                <a href="author.html">
                                                    <span class="lnr lnr-user"></span>Profile</a>
                                            </li>
                                            <li>
                                                <a href="dashboard.html">
                                                    <span class="lnr lnr-home"></span> Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="dashboard-setting.html">
                                                    <span class="lnr lnr-cog"></span> Setting</a>
                                            </li>
                                            <li>
                                                <a href="cart.html">
                                                    <span class="lnr lnr-cart"></span>Purchases</a>
                                            </li>
                                            <li>
                                                <a href="favourites.html">
                                                    <span class="lnr lnr-heart"></span> Favourite</a>
                                            </li>
                                            <li>
                                                <a href="dashboard-add-credit.html">
                                                    <span class="lnr lnr-dice"></span>Add Credits</a>
                                            </li>
                                            <li>
                                                <a href="dashboard-statement.html">
                                                    <span class="lnr lnr-chart-bars"></span>Sale Statement</a>
                                            </li>
                                            <li>
                                                <a href="dashboard-upload.html">
                                                    <span class="lnr lnr-upload"></span>Upload Item</a>
                                            </li>
                                            <li>
                                                <a href="dashboard-manage-item.html">
                                                    <span class="lnr lnr-book"></span>Manage Item</a>
                                            </li>
                                            <li>
                                                <a href="dashboard-withdrawal.html">
                                                    <span class="lnr lnr-briefcase"></span>Withdrawals</a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="lnr lnr-exit"></span>Logout</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="text-center">
                                        <a href="signup.html" class="author-area__seller-btn inline">Become a Seller</a>
                                    </div>
                                </div>
                            </div>
                            <!-- end /.mobile_content -->
                            <?php
                        }
                        ?>


                    </div>
                    <!-- end .author-area -->


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
                                    <input type="text" name="titulo" placeholder="Buscar un producto">
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