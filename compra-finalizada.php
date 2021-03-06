<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", TITULO . " | Pedido finalizado");
$template->set("description", "Pedido finalizado");
$template->set("keywords", "Pedido finalizado");
$template->set("favicon", FAVICON);
$template->themeInit();
$pedidos = new Clases\Pedidos();
$carritos = new Clases\Carrito();
$contenido = new Clases\Contenidos();
$correo = new Clases\Email();
$producto = new Clases\Productos();
$usuarios = new Clases\Usuarios();
$empresa = new Clases\Empresas();

$cod_pedido = $_SESSION["cod_pedido"];
$pedidos->set("cod", $cod_pedido);
$mp_estado = isset($_GET["collection_status"]) ? $funciones->MPStatus($_GET["collection_status"]) : '';

if (is_array($mp_estado)) {
    $estado = $mp_estado["estado"];
    $pedidos->set("estado", $mp_estado["num"]);
    $pedidos->cambiar_estado();
    $metodoPago = "MERCADOPAGO";
} else {
    $estado = "PENDIENTE";
    $metodoPago = "EFECTIVO";
    $factura = $funciones->antihack_mysqli(isset($_GET["fact"]) ? $_GET["fact"] : '');
}

$pedido_info = $pedidos->info();

if (count($_SESSION["carrito"]) == 0) {
    $funciones->headerMove(URL . "/index");
}

$usuarios->set("cod", $_SESSION["usuarios"]["cod"]);
$usuario_data = $usuarios->view();

$carro = $carritos->return();
$carroTotal = 0;

$cod_empresa = '';

//MENSAJE = ARMADO CARRITO
$mensaje_carro = '<table border="1" style="text-align:left;width:100%;font-size:13px !important"><thead><th>Nombre producto</th><th>Cantidad</th><th>Precio</th><th>Total</th></thead>';
foreach ($carro as $carroItemEmail) {
    $producto->set("cod", $carroItemEmail["id"]);
    $productosData = $producto->view();
    if (!empty($productosData)) {
        $cod_empresa = $productosData["cod_empresa"];
    }
    $carroTotal += $carroItemEmail["cantidad"] * $carroItemEmail["precio"];
    $mensaje_carro .= '<tr><td>' . $carroItemEmail["titulo"] . '</td><td>' . $carroItemEmail["cantidad"] . '</td><td>' . number_format($carroItemEmail["precio"], 2, ",", ".") . '</td><td>' . number_format($carroItemEmail["cantidad"] * $carroItemEmail["precio"], 2, ",", ".") . '</td></tr>';
}
$mensaje_carro .= '<tr><td></td><td></td><td></td><td>' . number_format($carroTotal, 2, ",", ".") . '</td></tr>';
$mensaje_carro .= '</table>';

//MENSAJE = DATOS USUARIO COMPRADOR
$datos_usuario = "<b>Nombre y apellido:</b> " . $_SESSION["usuarios"]["nombre"] . "<br/>";
$datos_usuario .= "<b>Email:</b> " . $_SESSION["usuarios"]["email"] . "<br/>";
$datos_usuario .= "<b>Provincia:</b> " . $_SESSION["usuarios"]["provincia"] . "<br/>";
$datos_usuario .= "<b>Localidad:</b> " . $_SESSION["usuarios"]["localidad"] . "<br/>";
$datos_usuario .= "<b>Dirección:</b> " . $_SESSION["usuarios"]["direccion"] . "<br/>";
$datos_usuario .= "<b>Teléfono:</b> " . $_SESSION["usuarios"]["telefono"] . "<br/>";

if (!empty($factura)) {
    if (!empty($_SESSION['usuarios']['doc'])) {
        $datos_usuario .= "<b>SOLICITÓ FACTURA A CON EL CUIT:</b> " . $_SESSION["usuarios"]["doc"] . "<br/>";
        $pedidos->set("detalle", "<b>SOLICITÓ FACTURA A CON EL CUIT:</b> " . $_SESSION["usuarios"]["doc"]);
        $pedidos->cambiar_valor("detalle");
    }
}

//USUARIO EMAIL
$mensajeCompraUsuario = '¡Muchas gracias por tu nuevo pedido!<br/>En el transcurso de las 24 hs un operador se estará contactando con usted para pactar la entrega y/o pago del pedido. A continuación te dejamos el pedido que nos realizaste.<hr/> <h3>Pedido realizado:</h3>';
$mensajeCompraUsuario .= $mensaje_carro;
$mensajeCompraUsuario .= '<br/><hr/>';
$mensajeCompraUsuario .= '<h3>MÉTODO DE PAGO ELEGIDO: ' . $metodoPago . '</h3>';
$mensajeCompraUsuario .= '<br/><hr/>';
$mensajeCompraUsuario .= '<h3>Tus datos:</h3>';
$mensajeCompraUsuario .= $datos_usuario;

$correo->set("asunto", "Muchas gracias por tu nuevo pedido");
$correo->set("receptor", $_SESSION["usuarios"]["email"]);
$correo->set("emisor", EMAIL);
$correo->set("mensaje", $mensajeCompraUsuario);

$statusSend = $correo->emailEnviar();
$statusEmail = isset($_SESSION["usuarios"]["email"]) && !empty($_SESSION["usuarios"]["email"]) ? true : false;

if ($statusSend && $statusEmail) {
    $fecha = new DateTime();
    $file = fopen("./log-email.txt", "a+");
    fwrite($file, $fecha->format('d-m-Y') . " | " . $cod_pedido . " | Email enviado a usuario comprador " . $_SESSION["usuarios"]["email"] . " correctamente." . PHP_EOL);
    fclose($file);
}
if (!$statusSend && $statusEmail) {
    $fecha = new DateTime();
    $file = fopen("./log-email.txt", "a+");
    fwrite($file, $fecha->format('d-m-Y') . " | " . $cod_pedido . " | Email enviado a usuario comprador " . $_SESSION["usuarios"]["email"] . " fallido." . PHP_EOL);
    fclose($file);
}

if (!empty($cod_empresa)) {
    $empresa->set("cod", $cod_empresa);
    $empresaData = $empresa->view();
    if (!empty($empresaData)) {
        //ADMIN EMAIL
        $mensajeCompra = '¡Nuevo pedido desde la web!<br/>A continuación te dejamos el detalle del pedido.<hr/> <h3>Pedido realizado:</h3>';
        $mensajeCompra .= $mensaje_carro;
        $mensajeCompra .= '<br/><hr/>';
        $mensajeCompra .= '<h3>MÉTODO DE PAGO ELEGIDO: ' . $metodoPago . '</h3>';
        $mensajeCompra .= '<br/><hr/>';
        $mensajeCompra .= '<h3>Datos de usuario:</h3>';
        $mensajeCompra .= $datos_usuario;

        $correo->set("asunto", "NUEVO PEDIDO ONLINE");
        $correo->set("receptor", $empresaData['email']);
        $correo->set("emisor", EMAIL);
        $correo->set("mensaje", $mensajeCompra);

        $statusSend = $correo->emailEnviar();
        $statusEmail = isset($empresaData['email']) && !empty($empresaData['email']) ? true : false;

        if ($statusSend && $statusEmail) {
            $fecha = new DateTime();
            $file = fopen("./log-email.txt", "a+");
            fwrite($file, $fecha->format('d-m-Y') . " | " . $cod_pedido . " | Email enviado a la empresa " . $empresaData['email'] . " correctamente." . PHP_EOL);
            fclose($file);
        }
        if (!$statusSend && $statusEmail) {
            $fecha = new DateTime();
            $file = fopen("./log-email.txt", "a+");
            fwrite($file, $fecha->format('d-m-Y') . " | " . $cod_pedido . " | Email enviado a la empresa " . $empresaData['email'] . " fallido." . PHP_EOL);
            fclose($file);
        }
    }
}

?>
<!--================================
    START BREADCRUMB AREA
=================================-->
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">¡Pedido finalizado!</h1>
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
<div id="sns_content" class="wrap layout-m">
    <div class="container">
        <div class="ps-404">
            <div class="">
                <div class="well well-lg pt-50 pb-50 text-uppercase">
                    <h2> CÓDIGO: <span> <?= $cod_pedido ?></span></h2>
                    <p>
                        <b>Estado:</b> <?= $estado ?><br />
                        <b>Método de pago:</b> <?= $metodoPago ?>
                    </p>
                    <table class="table table-hover text-left">
                        <thead>
                            <th><b>PRODUCTO</b></th>
                            <th class="hidden-xs"><b>PRECIO UNITARIO</b></th>
                            <th class="hidden-xs"><b>CANTIDAD</b></th>
                            <th><b>TOTAL</b></th>
                        </thead>
                        <tbody>
                            <?php
                            $precio = 0;
                            foreach ($carro as $carroItem) {
                                $precio += ($carroItem["precio"] * $carroItem["cantidad"]);
                                if ($carroItem["id"] == "Envio-Seleccion" || $carroItem["id"] == "Metodo-Pago") {
                                    $clase = "text-bold";
                                    $none = "hidden";
                                } else {
                                    $producto->set("cod", $carroItem['id']);
                                    $producto_data = $producto->view();
                                    if ($pedido_info["estado"] == 1 || $pedido_info["estado"] == 2 || $pedido_info["estado"] == 3) {
                                        $producto->editUnico("stock", $producto_data['stock'] - $carroItem['cantidad']);
                                    }
                                    $clase = '';
                                    $none = '';
                                }
                            ?>
                                <tr class="<?= $clase ?>">
                                    <td>
                                        <div class="media hidden-xs">
                                            <div class="media-body">
                                                <?= mb_strtoupper($carroItem["titulo"]); ?>
                                            </div>
                                        </div>
                                        <div class="d-md-none text-left">
                                            <?= mb_strtoupper($carroItem["titulo"]); ?>
                                            <p class="<?= $none ?>">Precio: <?= "$" . number_format($carroItem["precio"], 2, ",", "."); ?></p>
                                            <p class="<?= $none ?>">Cantidad: <?= $carroItem["cantidad"]; ?></p>
                                        </div>
                                    </td>
                                    <td class="hidden-xs">
                                        <p class="<?= $none ?>"><?= "$" . number_format($carroItem["precio"], 2, ",", "."); ?></p>
                                    </td>
                                    <td class="hidden-xs">
                                        <p class="<?= $none ?>"><?= $carroItem["cantidad"]; ?></p>
                                    </td>
                                    <?php
                                    if ($carroItem["precio"] != 0) {
                                    ?>
                                        <td><?= "$" . number_format($carroItem["precio"] * $carroItem["cantidad"], 2, ",", "."); ?></td>
                                    <?php
                                    } else {
                                        echo "<td></td>";
                                    }
                                    ?>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td>
                                    <h3>TOTAL</h3>
                                </td>
                                <td class="hidden-xs"></td>
                                <td class="hidden-xs"></td>
                                <td>
                                    <h3>$<?= number_format($precio, "2", ",", ".") ?></h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$carritos->destroy();
unset($_SESSION["cod_pedido"]);
if ($usuario_data["invitado"] == 1 || $_SESSION['usuarios']['invitado'] == 1) {
    unset($_SESSION["usuarios"]);
}
$template->themeEnd();
?>