<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$funciones = new Clases\PublicFunction();
$imagen = new Clases\Imagenes();
$productos = new Clases\Productos();
$empresa = new Clases\Empresas();
$xml = "<?xml version=\"1.0\"?><rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\"><channel><title>CityShopping</title><link>" . URL . "</link><description>Tienda</description>";
foreach ($data = $productos->list('', '', '') as $product) {
    //Empresa
    $empresa->set("cod", $product['cod_empresa']);
    $empresa_data = $empresa->view();
    //
    $imagen->set("cod", $product['cod']);
    $img = $imagen->view();

    $cod = $product["cod"];
    $titulo_producto = $funciones->normalizar_link($product["titulo"]);
    $link_ = URL . '/producto/' . $titulo_producto . '/' . $product['cod'];
    //$link = utf8_encode($funciones->normalizar_link($titulo_producto));
    if (!empty($titulo_producto)) {
        $xml .= "<item>";
        $xml .= "<g:id>" . $product['cod'] . "</g:id>";
        $xml .= "<g:title>" . htmlspecialchars(ucfirst(strtolower($product["titulo"]))) . "</g:title>";
        $xml .= "<g:description>" . htmlspecialchars(ucfirst(strtolower($product["desarrollo"]))) . "</g:description>";
        $xml .= "<g:link>" . $link_ . "</g:link>";
        $xml .= "<g:image_link>" . URL."/".$img["ruta"] . "</g:image_link>";
        $xml .= "<g:brand>".htmlspecialchars(ucfirst(strtolower($empresa_data['titulo'])))."</g:brand>";
        $xml .= "<g:product_type></g:product_type>";
        $xml .= "<g:condition>new</g:condition>";
        $xml .= "<g:availability>in stock</g:availability>";
        $xml .= "<g:inventory>" . $product['stock'] . "</g:inventory>";
        $xml .= "<g:price>" . $product['precio'] . " ARS</g:price>";
        $xml .= "<g:sale_price>" . $product['precio'] . " ARS</g:sale_price>";
        $xml .= "</item>";
    }
}

$xml .= "</channel></rss>";

// Opcion 2
header("Content-Type: text/xml;");
echo $xml;