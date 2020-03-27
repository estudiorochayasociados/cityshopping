<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$funciones = new Clases\PublicFunction();
$productos = new Clases\Productos();
$comercios = new Clases\Empresas();
$contenidos = new Clases\Contenidos();
$novedades = new Clases\Novedades();
$categorias = new Clases\Categorias();
$otras = array("panel", "panel?op=perfil", "panel?op=empresa", "panel?op=productos", "panel?op=nuevo","panel?op=compra","panel?op=venta","index", "productos", "blogs","comercios","contacto");

$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';


foreach (($data = $novedades->list("")) as $novedad) {
    $cod = $novedad["cod"];
    $titulo = $funciones->normalizar_link($novedad["titulo"]);
    $xml .= '<url><loc>' . URL . '/blog/' . $titulo . '/' . $cod . '</loc><lastmod>' . $novedad["fecha"] . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $productos->list("", "titulo desc", '')) as $producto) {
    $cod = $producto["cod"];
    $titulo = $funciones->normalizar_link($producto["titulo"]);
    $xml .= '<url><loc>' . URL . '/productos/' . $titulo . '/' . $cod . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $comercios->list("", "titulo desc", '')) as $comercio) {
    $cod = $comercio["id"];
    $titulo = $funciones->normalizar_link($comercio["titulo"]);
    $xml .= '<url><loc>' . URL . '/comercio/' . $titulo . '/' . $cod . '</loc><lastmod>' . $comercio["fecha"] . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $categorias->list("", "titulo desc", '')) as $categoria) {
    $cod = $categoria["cod"];
    $xml .= '<url><loc>' . URL . '/comercios?ck=3&amp;categoria=' . $cod .'</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $contenidos->list("")) as $contenido) {
    $titulo = $funciones->normalizar_link($contenido["cod"]);
    $xml .= '<url><loc>' . URL . '/c/' . $titulo . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach ($otras as $otro) {
    $xml .= '<url><loc>' . URL . '/' . $otro . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>1</priority></url>';
}



$xml .= '</urlset>';

// Opcion 2
header("Content-Type: text/xml;");
echo $xml;


