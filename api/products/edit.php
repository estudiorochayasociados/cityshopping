<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::runCurl();
$productos = new Clases\Productos();
$empresa = new Clases\Empresas();

$attr = isset($_POST["attr"]) ? $_POST["attr"] : '';
$value = isset($_POST["value"]) ? $_POST["value"] : '';
$cod = isset($_POST["cod"]) ? $_POST["cod"] : '';


if (!empty($attr) && !empty($value) && !empty($cod)) {
    $productos->set("cod", $cod);
    $productoData = $productos->view();

    if (!empty($productoData)) {
        $cod_usuario = $_SESSION['usuarios']['cod'];
        $empresa->set("cod_usuario", $cod_usuario);
        $empresaData = $empresa->viewV2();
        if (!empty($empresaData)) {

            if ($empresaData['cod'] == $productoData['cod_empresa']) {
                $productos->set("cod_empresa",$empresaData['cod']);
                echo $productos->editSingle($attr, $value);
            }
        }
    }
}