<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::runCurl();
$productos = new Clases\Productos();
$f = new Clases\PublicFunction();
$empresa = new Clases\Empresas();

$cod = $f->antihack_mysqli(isset($_POST["cod"]) ? $_POST["cod"] : '');

$productos->set("cod",$cod);
$productoData = $productos->view();

if (empty($productoData)) {
    echo json_encode(["status" => false, "message" => "Ocurrió un error, recargar la página."]);
    die();
}

$variantesTemp = [];
for ($i = 0; $i < count($_POST["variante1"]); $i++) {
    if (!empty($_POST["variante1"][$i])) {
        $variantesTemp[] = $f->antihack_mysqli($_POST["variante1"][$i]) . ',' . $f->antihack_mysqli($_POST["variante2"][$i]);
    }
}

$variantes = (!empty($variantesTemp) ? serialize($variantesTemp) : '');
$cod_usuario = $_SESSION['usuarios']['cod'];
$empresa->set("cod_usuario", $cod_usuario);
$empresaData = $empresa->viewV2();
if (!empty($empresaData)) {
    if ($empresaData['cod'] == $productoData['cod_empresa']) {
        $productos->set("cod_empresa", $empresaData['cod']);
        if ($productos->editSingle("variantes", "'".$variantes."'")) {
            echo json_encode(["status" => true, "message" => "Variaciones editadas correctamente"]);
        } else {
            echo json_encode(["status" => false, "message" => "Ocurrió un error, recargar la página."]);
        }
    } else {
        echo json_encode(["status" => false, "message" => "Este producto no corresponde a su empresa."]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Ocurrió un error, recargar la página."]);
}