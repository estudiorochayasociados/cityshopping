<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$funciones = new Clases\PublicFunction();
$usuario = new Clases\Usuarios();
$empresa = new Clases\Empresas();
/*
$usuariosCes = $usuario->listChoto('');
foreach ($usuariosCes as $usuariosCes_) {
    $usuario->set("cod", $usuariosCes_['cod']);
    $usuario->set("nombre", $usuariosCes_['nombre']);
    $usuario->set("email", $usuariosCes_['email']);
    $usuario->set("password", $usuariosCes_['password']);
    $usuario->set("postal", '2400');
    $usuario->set("localidad", $usuariosCes_['localidad']);
    $usuario->set("provincia", $usuariosCes_['provincia']);
    $usuario->set("direccion", $usuariosCes_['direccion']);
    $usuario->set("telefono", $usuariosCes_['telefono']);
    $usuario->set("invitado", 0);
    $usuario->set("vendedor", 1);
    $usuario->set("fecha", $usuariosCes_['fecha']);
//    $usuario->add();

    $cod = substr(md5(uniqid(rand())), 0, 10);
    $empresa->set('cod', $cod);
    $empresa->set('titulo', $usuariosCes_['titulo']);
    $empresa->set('telefono', $usuariosCes_['telefono']);
    $empresa->set('email', $usuariosCes_['email']);
    $empresa->set('direccion', $usuariosCes_['direccion']);
    $empresa->set('ciudad', $usuariosCes_['localidad']);
    $empresa->set('provincia', $usuariosCes_['provincia']);
    $empresa->set('postal', 2400);
    $empresa->set('desarrollo', $usuariosCes_['descripcion']);
    $empresa->set('fecha', $usuariosCes_['fecha']);
    $empresa->set('cod_usuario', $usuariosCes_['cod']);
    $empresa->set('tiempoEntrega', 0);
    $empresa->set('delivery', 0);
    $imagen = $usuario->viewChoto();
    if (!empty($imagen)) {
        $empresa->set("logo", $imagen['ruta']);
    }
    var_dump($imagen['ruta']);
    echo"<br>";
    var_dump($empresa->logo);
//    $empresa->add();

//    var_dump($imagen);
    echo "<br>";
//    break;
}*/

var_dump($cod = substr(md5(uniqid(rand())), 0, 10));
