<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funcion = new Clases\PublicFunction();
$template->set("title", TITULO . " | Panel");
$template->set("description", "");
$template->set("keywords", "");
$template->set("favicon", LOGO);
$template->set("body", "dashboard-edit");
$template->themeInit();
//Clases
$usuario = new Clases\Usuarios();
$imagenes = new Clases\Imagenes();
$empresa = new Clases\Empresas();
$producto = new Clases\Productos();
$envio = new Clases\Envios();
$categoria = new Clases\Categorias();
$zebra = new Clases\Zebra_Image();
$pedido = new Clases\Pedidos();
$op = isset($_GET["op"]) ? $_GET["op"] : '';
if (empty($op)) {
    $funcion->headerMove(URL . '/panel?op=perfil');
}
if (empty($_SESSION['usuarios'])) {
    $funcion->headerMove(URL);
}
$cod_usuario = $_SESSION['usuarios']['cod'];
$empresa->set("cod_usuario", $cod_usuario);
$empresaData = $empresa->viewV2();

$filterEmpresa = array("cod = '$empresaData[cod]'");
$imagenesArrayEmpresa = $imagenes->list($filterEmpresa, "", "");
$usuario->set("cod", $cod_usuario);
$usuarioData = $usuario->view();

$filterEnvios = array("cod_empresa = '" . $empresaData['cod'] . "'");
$enviosArray = $envio->list($filterEnvios, "", "");
//
if (empty($enviosArray)) {
    $enviosArray = array(0 => array("titulo" => "", "precio" => ""));
}
if ($_SESSION['usuarios']['vendedor'] == 0) {
    $displayTab = false;
} else {
    $displayTab = true;
}
?>
<?php switch ($op) {
        //Seccion de crear empresa
    case "crear-empresa":
        $mensaje = "Crear empresa: Paso 1";
        break;
    case "crear-empresa-2":
        $mensaje = "Crear empresa: Paso 2";
        break;
    case "crear-empresa-3":
        $mensaje = "Crear empresa: Paso 3";
        break;
        //
    case "perfil":
        $mensaje = "Perfil usuario";
        break;
    case "empresa":
        $mensaje = "Perfil empresa";
        break;
    case "productos":
        $mensaje = "Listado de productos";
        break;
    case "nuevo":
        $mensaje = "Nuevo producto";
        break;
    case "editar":
        $mensaje = "Editar producto";
        break;
    case "venta":
        $mensaje = "Listado de ventas";
        break;
    case "compra":
        $mensaje = "Listado de compra";
        break;
    case "mercadopago":
        $mensaje = "Mercado Pago";
        break;
} ?>
<!--================================
    START BREADCRUMB AREA
=================================-->
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?= URL ?>/index">Inicio</a>
                        </li>
                        <li class="active">
                            <a href="#">Panel de usuario</a>
                        </li>
                    </ul>
                </div>
                <h1 class="page-title"><?= $mensaje ?></h1>
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<!--================================
    END BREADCRUMB AREA
=================================-->
<!-- Content ================================================== -->
<section class="dashboard-area">
    <div class="dashboard_menu_area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hidden-xs">
                        <ul class="dashboard_menu">
                            <li class="<?= ($_GET['op'] == "perfil") ? "active" : '' ?>">
                                <a href="<?= URL ?>/panel?op=perfil">
                                    <span class="lnr lnr-home"></span>Perfil</a>
                            </li>
                            <?php
                            if ($displayTab) {
                            ?>
                                <li class="<?= ($_GET['op'] == "empresa") ? "active" : '' ?>">
                                    <a href="<?= URL ?>/panel?op=empresa">
                                        <span class="lnr lnr-cog"></span>Empresa</a>
                                </li>
                                <?php
                                if (!empty($empresaData)) {
                                ?>
                                    <li class="<?= ($_GET['op'] == "productos") ? "active" : '' ?>">
                                        <a href="<?= URL ?>/panel?op=productos">
                                            <span class="lnr lnr-inbox"></span>Productos</a>
                                    </li>
                                    <li class="<?= ($_GET['op'] == "nuevo") ? "active" : '' ?>">
                                        <a href="<?= URL ?>/panel?op=nuevo">
                                            <span class="lnr lnr-upload"></span>Nuevo producto</a>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                            <li class="<?= ($_GET['op'] == "compra") ? "active" : '' ?>">
                                <a href="<?= URL ?>/panel?op=compra">
                                    <span class="lnr lnr-briefcase"></span>Compra</a>
                            </li>
                            <?php
                            if ($displayTab) {
                            ?>
                                <li class="<?= ($_GET['op'] == "venta") ? "active" : '' ?>">
                                    <a href="<?= URL ?>/panel?op=venta">
                                        <span class="lnr lnr-tag"></span>Venta</a>
                                </li>

                                <li class="<?= ($_GET['op'] == "mercadopago") ? "active" : '' ?>">
                                    <a href="<?= URL ?>/panel?op=mercadopago">
                                        <span class="lnr lnr-smartphone"></span>Mercado Pago</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- end /.dashboard_menu -->
                    <div class="visible-xs" style="text-align: center;">
                        <button class="btn btn btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" ">
                            Menu
                        </button>
                        <div class=" collapse" id="collapseExample" style="text-align: left;">
                            <ul class="dashboard_menu">
                                <li style="width: 100%;" class="<?= ($_GET['op'] == "perfil") ? "active" : '' ?>">
                                    <a href="<?= URL ?>/panel?op=perfil">
                                        <span class="lnr lnr-home"></span>Perfil</a>
                                </li>
                                <?php
                                if ($displayTab) {
                                ?>
                                    <li style="width: 100%;" class="<?= ($_GET['op'] == "empresa") ? "active" : '' ?>">
                                        <a href="<?= URL ?>/panel?op=empresa">
                                            <span class="lnr lnr-cog"></span>Empresa</a>
                                    </li>
                                    <li style="width: 100%;" class="<?= ($_GET['op'] == "productos") ? "active" : '' ?>">
                                        <a href="<?= URL ?>/panel?op=productos">
                                            <span class="lnr lnr-inbox"></span>Productos</a>
                                    </li>
                                    <li style="width: 100%;" class="<?= ($_GET['op'] == "nuevo") ? "active" : '' ?>">
                                        <a href="<?= URL ?>/panel?op=nuevo">
                                            <span class="lnr lnr-upload"></span>Nuevo producto</a>
                                    </li>
                                <?php
                                }
                                ?>
                                <li style="width: 100%;" class="<?= ($_GET['op'] == "compra") ? "active" : '' ?>">
                                    <a href="<?= URL ?>/panel?op=compra">
                                        <span class="lnr lnr-briefcase"></span>Compra</a>
                                </li>
                                <?php
                                if ($displayTab) {
                                ?>
                                    <li style="width: 100%;" class="<?= ($_GET['op'] == "venta") ? "active" : '' ?>">
                                        <a href="<?= URL ?>/panel?op=venta">
                                            <span class="lnr lnr-tag"></span>Venta</a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                    </div>
                </div>
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
    </div>
    <!-- end /.dashboard_menu_area -->
    <?php switch ($op) {
            //Seccion de crear empresa
        case "crear-empresa":
            include("assets/inc/panel/crearEmpresaPaso1.php");
            break;
        case "crear-empresa-2":
            include("assets/inc/panel/crearEmpresaPaso2.php");
            break;
        case "crear-empresa-3":
            include("assets/inc/panel/crearEmpresaPaso3.php");
            break;
            //
        case "crearMenu":
            include("assets/inc/panel/crearMenu.php");
            break;
        case "modificarMenu":
            include("assets/inc/panel/modificarMenu.php");
            break;
        case "verSecciones":
            include("assets/inc/panel/verSecciones.php");
            break;
        case "verPedidosEmpresa":
            include("assets/inc/panel/verPedidosEmpresa.php");
            break;
        case "verPedidosUsuario":
            include("assets/inc/panel/verPedidosUsuario.php");
            break;
        case "logout":
            $usuario->logout();
            break;
        case "perfil":
            include("assets/inc/panel/tabs/modificarPerfil.php");
            break;
        case "empresa":
            include("assets/inc/panel/tabs/modificarEmpresa.php");
            break;
        case "productos":
            include("assets/inc/panel/tabs/verMenus.php");
            break;
        case "nuevo":
            include("assets/inc/panel/crearMenu.php");
            break;
        case "editar":
            include("assets/inc/panel/modificarMenu.php");
            break;
        case "compra":
            include("assets/inc/panel/verPedidosUsuario.php");
            break;
        case "venta":
            include("assets/inc/panel/verPedidosEmpresa.php");
            break;
        case "mercadopago":
            include("assets/inc/panel/tabs/modificarMercadoPago.php");
            break;
    } ?>
</section><!-- End container  -->
<!-- End Content =============================================== -->

<?php $template->themeEnd() ?>
<script src="<?= URL ?>/assets/js/tabs.js"></script>

<script>
    document.getElementById('link0').addEventListener('click', function() {
        document.getElementById('horariosEmpresa').style.display = 'block';
        document.getElementById('link0').style.display = 'none';
    }, false);
    document.getElementById('link1').addEventListener('click', function() {
        document.getElementById('enviosEmpresa').style.display = 'block';
        document.getElementById('link1').style.display = 'none';
    }, false);
    document.getElementById('link2').addEventListener('click', function() {
        document.getElementById('ubicacionEmpresa').style.display = 'block';
        document.getElementById('link2').style.display = 'none';
    }, false);
    document.getElementById('link3').addEventListener('click', function() {
        document.getElementById('imagenesEmpresa').style.display = 'block';
        document.getElementById('link3').style.display = 'none';
    }, false);
</script>

<script>
    //Script para que el usuario genere nuevos campos
    jQuery.fn.generaNuevosCampos = function(nombreCampo1, nombreCampo2) {
        $(this).each(function() {
            elem = $(this);
            elem.data("nombreCampo1", nombreCampo1);
            elem.data("nombreCampo2", nombreCampo2);

            elem.click(function(e) {
                e.preventDefault();
                elem = $(this);
                nombreCampo1 = elem.data("nombreCampo1");
                nombreCampo2 = elem.data("nombreCampo2");
                texto_insertar = '<div class="col-sm-6"><div class="form-group"><input type="text" name="' + nombreCampo1 + '" class="text_field" /></div></div><div class="col-sm-6"><div class="form-group"><input type="text" name="' + nombreCampo2 + '" class="text_field" /></div></div>';
                nuevo_campo = $(texto_insertar);
                elem.before(nuevo_campo);
            });
        });
        return this;
    }

    $(document).ready(function() {
        $("#mascamposEnvios").generaNuevosCampos("enviosEmpresa1[]", "enviosEmpresa2[]");
    });
</script>

<!-- SPECIFIC SCRIPTS -->
<script src="<?= URL ?>/assets/js/theia-sticky-sidebar.js"></script>
<script>
    jQuery('#sidebar').theiaStickySidebar({
        additionalMarginTop: 80
    });
</script>

<script>
    //Script para que el usuario genere nuevos campos """VarianteAdicional"""
    jQuery.fn.generaNuevosCamposVarianteAdicional = function(nombreCampo1, nombreCampo2) {
        $(this).each(function() {
            elem = $(this);
            elem.data("nombreCampo1", nombreCampo1);
            elem.data("nombreCampo2", nombreCampo2);

            elem.click(function(e) {
                e.preventDefault();
                elem = $(this);
                nombreCampo1 = elem.data("nombreCampo1");
                nombreCampo2 = elem.data("nombreCampo2");
                texto_insertar = '<div class="col-md-4"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="text" class="form-control" name="' + nombreCampo1 + '"></div></div><div class="col-md-8"><div class="form-group"><input type="text" name="' + nombreCampo2 + '" class="text_field" /></div></div>';
                nuevo_campo = $(texto_insertar);
                elem.before(nuevo_campo);
            });
        });
        return this;
    }

    $(document).ready(function() {
        $("#mascamposVariante").generaNuevosCamposVarianteAdicional("variante1[]", "variante2[]");
    });

    $(document).ready(function() {
        $("#mascamposAdicional").generaNuevosCamposVarianteAdicional("adicional1[]", "adicional2[]");
    });
</script>