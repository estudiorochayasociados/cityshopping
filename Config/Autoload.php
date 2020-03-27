<?php
namespace config;
class autoload
{
    public static function runSitio()
    {
        session_start();
        $_SESSION["cod_pedido"] = isset($_SESSION["cod_pedido"]) ? $_SESSION["cod_pedido"] : substr(md5(uniqid(rand())), 0, 10);
        define('SALT',hash("sha256","salt@estudiorochayasoc.com.ar"));
        define('URL', "https://".$_SERVER['HTTP_HOST']."/CityShopping");
        define('CANONICAL', "https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        define('TITULO', "City Shopping");
        define('TELEFONO', "(03564) 420108");
        define('CIUDAD', "San Francisco");
        define('PROVINCIA', "Cordoba");
        define('PAIS', "Argentina");
        define('EMAIL', "web@estudiorochayasoc.com.ar");
        define('EMAIL_NOTIFICACION', "ces@ces-sanfco.com.ar");
        define('PASS_EMAIL', "weAr2010");
        define('SMTP_EMAIL', "cs1008.webhostbox.net");
        define('DIRECCION', "Belgrano 1585");
        define('LOGO', URL . "/assets/images/logo.png");
        define('FAVICON', URL . "/assets/images/favicon.png");
        define('APP_ID_FB', "");
        define('PLAN', isset($_SESSION["usuarios"]["plan"]) ? $_SESSION["usuarios"]["plan"] : 1);
        define('CAPTCHA_KEY','6LfwlVUUAAAAAKbrTmmJ4HCxU8bF8Ms6JjbmL1Me');
        define('CAPTCHA_SECRET','6LfwlVUUAAAAAOBjeQuKlRpsjEngOoSmaDFgXAO4');
        spl_autoload_register(
            function($clase)
            {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                include_once $ruta;
            }
        );
    }

    public static function runSitio2()
    {
        spl_autoload_register(
            function($clase)
            {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                include_once "../../".$ruta;
            }
        );
    }

    public static function runAdmin()
    {
        session_start();
        define('URLSITE',"https://".$_SERVER['HTTP_HOST']."/CityShopping");
        define('URL', "https://".$_SERVER['HTTP_HOST']."/CityShopping/admin");
        define('SALT',hash("sha256","salt@estudiorochayasoc.com.ar"));
        require_once "../Clases/Zebra_Image.php";
        spl_autoload_register(
            function ($clase)
            {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                include_once "../" . $ruta;
            }
        );
    }

    public static function runCurl()
    {
        session_start();
        require '../../vendor/autoload.php';
        define('URL', "https://".$_SERVER['HTTP_HOST']."/CityShopping");
        define('LOGO', URL . "/assets/images/logo.png");
        spl_autoload_register(function ($clase) {
            $ruta = "../../" . str_replace("\\", "/", $clase) . ".php";
            $pos = strpos($ruta, "Clases");
            if ($pos !== false) {
                include_once $ruta;
            }
        });
    }

}
