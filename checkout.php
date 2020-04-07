<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", TITULO . " | Cierre de pedido");
$template->set("description", "Finalizá tu pedido eligiendo tu medio de pago y la forma de envío");
$template->set("keywords", "");
$template->set("favicon", LOGO);
$template->themeInit();

$pedidos = new Clases\Pedidos();
$carrito = new Clases\Carrito();
$usuarios = new Clases\Usuarios();
$empresas = new Clases\Empresas();
$productos = new Clases\Productos();

$factura = $funciones->antihack_mysqli(isset($_GET["fact"]) ? $_GET["fact"] : '');

$cod_pedido = $_SESSION["cod_pedido"];

$pedidos->set("cod", $cod_pedido);
$pedido = $pedidos->view();

$usuarioSesion = $_SESSION['usuarios'];
$carro = $carrito->return();

$timezone = -3;
$fecha = gmdate("Y-m-j H:i:s", time() + 3600 * ($timezone + date("I")));

$precio = 0;

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
        if ($carroItem["id"] == "Metodo-Pago") {
            $mp = ($carroItem["titulo"] == "Método de pago: MercadoPago") ? true : false;
        }

        $precio += $carroItem["precio"];

        $productos->set("cod", $carroItem["id"]);
        $productosData = $productos->view();

        if (!empty($productosData)) {
            $cod_empresa = $productosData["cod_empresa"];
        }

        $opciones = !empty($carroItem["opciones"]) ?  '|||' . serialize($carroItem["opciones"]) : '';

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

    if ($mp) {
        include("vendor/mercadopago/sdk/lib/mercadopago.php");
        $empresas->set("cod", $cod_empresa);
        $empresa = $empresas->view();
        $mp = new MP($empresa["clientID"], $empresa["clientSecret"]);

        $preference_data = array(
            "items" => array(
                array(
                    "id" => $cod_pedido,
                    "title" => "COMPRA CÓDIGO N°:" . $cod_pedido,
                    "quantity" => 1,
                    "currency_id" => "ARS",
                    "unit_price" => $precio
                )
            ),
            "payer" => array(
                "name" => $usuarioSesion["nombre"],
                "surname" => $usuarioSesion["apellido"],
                "email" => $usuarioSesion["email"]
            ),
            "back_urls" => array(
                "success" => URL . "/compra-finalizada.php",
                "pending" => URL . "/compra-finalizada.php",
                "failure" => URL . "/compra-finalizada.php"
            ),
            "external_reference" => $cod_pedido,
            "auto_return" => "all",
            "payment_methods" => array(
                "excluded_payment_methods" => array(),
                "excluded_payment_types" => array(
                    array("id" => "ticket"),
                    array("id" => "atm")
                )
            )
        );

        try {
            $preference = $mp->create_preference($preference_data);
        } catch (Exception $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
            die();
        }

        // $funciones->headerMove($preference["response"]["init_point"]);
        $funciones->headerMove($preference["response"]["sandbox_init_point"]);
    } else {
        (!empty($factura)) ? $funciones->headerMove(URL . "/compra-finalizada.php?fact=1") : $funciones->headerMove(URL . "/compra-finalizada.php");
    }
    ?>
</body>
<?php
$template->themeEnd();
?>