<!--================================
    START FOOTER AREA
=================================-->
<footer class="footer-area">
    <div class="footer-big section--padding">
        <!-- start .container -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-7">
                    <div class="info-footer">
                        <div class="info__logo">
                            <img src="<?=LOGO?>" alt="<?=TITULO?>">
                        </div>
                        <p class="info--text">¡Bienvenido/a a la nueva plataforma del Centro Empresarial y de Servicios de San Francisco creada específicamente para sus socios! Comprá y vendé desde San Francisco... ¡a todo el país! </p>
                        <ul class="info-contact">
                            <li>
                                <span class="lnr lnr-phone info-icon"></span>
                                <span class="info"><?=TELEFONO?></span>
                            </li>
                            <li>
                                <span class="lnr lnr-envelope info-icon"></span>
                                <span class="info"><?=EMAIL_NOTIFICACION?></span>
                            </li>
                            <li>
                                <span class="lnr lnr-map-marker info-icon"></span>
                                <span class="info"><?=DIRECCION.', '.CIUDAD?></span>
                            </li>
                        </ul>
                    </div>
                    <!-- end /.info-footer -->
                </div>
                <!-- end /.col-md-3 -->

                <div class="col-lg-4 col-md-5 ">
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fces.sanfrancisco%2F&tabs&small_header=false&hide_cover=false&show_facepile=true&appId=474156319660121" width="100%" height="180" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>                                    
                </div>
                <!-- end /.col-md-5 -->

                <div class="col-lg-4 col-md-12">
                    <div class="newsletter">
                        <h4 class="footer-widget-title text--white">Newsletter</h4>
                        <p>¡Suscribite y conocé todas las promociones de la ciudad! Obtené descuentos especiales.</p>
                        <div class="newsletter__form">
                            <form action="#">
                                <div class="field-wrapper">
                                    <input class="relative-field rounded" type="text" placeholder="CORREO ELECTRÓNICO">
                                    <button class="btn btn--round" type="submit">ENVIAR</button>
                                </div>
                            </form>
                        </div>

                        <!-- start .social -->
                        <div class="social social--color--filled">
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/ces.sanfrancisco/" target="_blank">
                                        <span class="fa fa-facebook"></span>
                                    </a>
                                </li> 
                                <li>
                                    <a href="https://www.instagram.com/ces.sanfrancisco/" target="_blank">
                                        <span class="fa fa-instagram"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- end /.social -->
                    </div>
                    <!-- end /.newsletter -->
                </div>
                <!-- end /.col-md-4 -->
            </div>
            <!-- end /.row -->
        </div>
        <!-- end /.container -->
    </div>
    <!-- end /.footer-big -->

    <div class="mini-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright-text">
                        <p>&copy; 2019
                            <a href="#"><?=TITULO?></a>. Todos los derechos reservados. Copyright by
                            <a href="http://www.estudiorochayasoc.com">Estudio Rocha & Asociados</a>
                        </p>
                    </div>

                    <div class="go_top">
                        <span class="lnr lnr-chevron-up"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--================================
END FOOTER AREA
=================================-->

<!--//////////////////// JS GOES HERE ////////////////-->

<!-- inject:js -->
<script src="<?=URL?>/assets/js/vendor/jquery/jquery-1.12.3.js"></script>
<script src="<?=URL?>/assets/js/vendor/jquery/uikit.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/jquery/popper.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/bootstrap.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/chart.bundle.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/grid.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/jquery-ui.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/jquery.barrating.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/jquery.countdown.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/jquery.counterup.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/jquery.easing1.3.js"></script>
<script src="<?=URL?>/assets/js/vendor/owl.carousel.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/slick.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/tether.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/trumbowyg.min.js"></script>
<script src="<?=URL?>/assets/js/vendor/waypoints.min.js"></script>
<script src="<?=URL?>/assets/js/dashboard.js"></script>
<script src="<?=URL?>/assets/js/main.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- endinject -->
<script>
    $("#provincia").change(function () {
        $("#provincia option:selected").each(function () {
            elegido = $(this).val();
            $.ajax({
                type: "GET",
                url: "<?=URL ?>/assets/inc/localidades.inc.php",
                data: "elegido=" + elegido,
                dataType: "html",
                success: function (data) {
                    $('#localidad option').remove();
                    var substr = data.split(';');
                    for (var i = 0; i < substr.length; i++) {
                        var value = substr[i];
                        $("#localidad").append(
                            $("<option></option>").attr("value", value).text(value)
                        );
                    }
                }
            });
        });
    })
</script>
<script src="<?= URL ?>/assets/js/theia-sticky-sidebar.js"></script>
<?php include 'assets/inc/login.inc.php'; ?>
