<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::runCurl();
$productos = new Clases\Productos();
$f = new Clases\PublicFunction();

$cod = $f->antihack_mysqli(isset($_POST["cod"]) ? $_POST["cod"] : '');

$productos->set("cod", $cod);
$productoData = $productos->view();

if (empty($productoData)) {
    echo json_encode(["status" => false, "message" => "No existe un producto con dicho código"]);
    die();
}

if (empty($productoData['variantes'])) {
    echo json_encode(["status" => false, "message" => "Este producto no posee variantes."]);
    die();
}

$variantesMostrar = unserialize($productoData['variantes']);

$variations = '';
foreach ($variantesMostrar as $key => $value) {
    $valor = explode(",", $value);
    $variations .= "<input type='hidden' name='cod' value='$cod'>";
    $variations .= "<div class='col-md-4'>";
    $variations .= "<div class='input-group mb-3'>";
    $variations .= "<div class='input-group-prepend'>";
    $variations .= "<span class='input-group-text'>$</span>";
    $variations .= "</div>";
    $variations .= "<input type='text' value='$valor[0]' class='form-control' name='variante1[]'>";
    $variations .= "</div>";
    $variations .= "</div>";

    $variations .= "<div class='col-md-8'>";
    $variations .= "<div class='form-group'>";
    $variations .= "<input type='text' name='variante2[]' value='$valor[1]' class='text_field'>";
    $variations .= "</div>";
    $variations .= "</div>";
}

echo json_encode(["status" => true, "title" => $productoData['titulo'], "variations" => $variations]);