<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", TITULO . " | Cierre de compra");
$template->set("description", "Finalizá tu compra eligiendo tu medio de pago y la forma de envío");
$template->set("keywords", "");
$template->set("favicon", LOGO);
$template->themeInit();

$pedidos = new Clases\Pedidos();
$carrito = new Clases\Carrito();
$usuarios = new Clases\Usuarios();
$productos = new Clases\Productos();

$factura = $funciones->antihack_mysqli(isset($_GET["fact"]) ? $_GET["fact"] : '');

$cod_pedido = $_SESSION["cod_pedido"];
//$tipo_pedido = isset($_GET["tipo_pedido"]) ? $_GET["tipo_pedido"] : '1';

$pedidos->set("cod", $cod_pedido);
$pedido = $pedidos->view();

$usuarioSesion = $_SESSION['usuarios'];
$carro = $carrito->return();

$timezone = -3;
$fecha = gmdate("Y-m-j H:i:s", time() + 3600 * ($timezone + date("I")));
?>
    <body id="bd" class="cms-index-index2 header-style2 prd-detail sns-products-detail1 cms-simen-home-page-v2 default cmspage">
    <div id="sns_wrapper">
    </div>
    <?php
    if (is_array($pedido)) {
        $pedidos->set("cod", $cod_pedido);
        $pedidos->delete();
    }

    $cod_empresa = '';

    foreach ($carro as $carroItem) {

        $productos->set("cod", $carroItem["id"]);
        $productosData = $productos->view();
        if (!empty($productosData)) {
            $cod_empresa = $productosData["cod_empresa"];
        }

        if (empty($carroItem["opciones"])) {
            $opciones = '';
        } else {
            $opciones = '|||' . serialize($carroItem["opciones"]);
        }

        $pedidos->set("cod", $cod_pedido);
        $pedidos->set("producto", $carroItem["titulo"] . $opciones);
        $pedidos->set("cantidad", $carroItem["cantidad"]);
        $pedidos->set("precio", $carroItem["precio"]);
        $pedidos->set("estado", 1);
        $pedidos->set("tipo", 1);
        $pedidos->set("usuario", $usuarioSesion["cod"]);
        $pedidos->set("empresa", $cod_empresa);
        $pedidos->set("detalle", "");
        $pedidos->set("fecha", $fecha);
        $pedidos->add();
    }
    if (!empty($factura)) {
        $funciones->headerMove(URL . "/compra-finalizada.php?fact=1");
    } else {
        $funciones->headerMove(URL . "/compra-finalizada.php");
    }

    //switch ($pago["tipo"]) {
    //    case 0:
    //        $pedidos->set("cod", $cod_pedido);
    //        $pedidos->set("estado", $pago["defecto"]);
    //        $pedidos->cambiar_estado();
    //        break;
    //    case 1:
    //        include("vendor/mercadopago/sdk/lib/mercadopago.php");
    //        $mp = new MP ("7077260206047943", "ocqTWXCjVekoxQRf2cVkrZWX1m5QCHj9");
    //        $preference_data = array(
    //            "items" => array(
    //                array(
    //                    "id" => $cod_pedido,
    //                    "title" => "COMPRA CÓDIGO N°:" . $cod_pedido,
    //                    "quantity" => 1,
    //                    "currency_id" => "ARS",
    //                    "unit_price" => $precio
    //                )
    //            ),
    //            "payer" => array(
    //                "name" => $usuarioSesion["nombre"],
    //                "surname" => $usuarioSesion["apellido"],
    //                "email" => $usuarioSesion["email"]
    //            ),
    //            "back_urls" => array(
    //                "success" => URL . "/compra-finalizada.php?estado=2",
    //                "pending" => URL . "/compra-finalizada.php?estado=1",
    //                "failure" => URL . "/compra-finalizada.php?estado=0"
    //            ),
    //            "external_reference" => $cod_pedido,
    //            "auto_return" => "all",
    //            //"client_id" => $usuarioSesion["cod"],
    //            "payment_methods" => array(
    //                "excluded_payment_methods" => array(),
    //                "excluded_payment_types" => array(
    //                    array("id" => "ticket"),
    //                    array("id" => "atm")
    //                )
    //            )
    //        );
    //        $preference = $mp->create_preference($preference_data);
    //        //$funciones->headerMove($preference["response"]["sandbox_init_point"]);
    //        echo "<iframe src='" . $preference["response"]["sandbox_init_point"] . "' width='100%' height='700px' style='border:0;margin:0'></iframe>";
    //        break;
    //}
    ?>
    </body>
<?php
$template->themeEnd();
?>