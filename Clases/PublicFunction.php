<?php

namespace Clases;


class PublicFunction
{

    public function antihack_mysqli($str)
    {
        $con = new Conexion();
        $conexion = $con->con();
        $str = mysqli_real_escape_string($conexion, $str);
        return $str;
    }

    public function antihack($str)
    {
        $str = stripslashes($str);
        $str = strip_tags($str);
        $str = htmlentities($str);
        return $str;
    }

    public function headerMove($location)
    {
        echo "<script> document.location.href='" . $location . "';</script>";
    }

    public function send_email($asunto, $email, $mensaje)
    {

        $mail = new PHPMailer; //moved here
        var_dump($mail);
    }

    public function MPStatus($status)
    {
        switch ($status) {
            case "approved":
                return ["estado" => "Aprobado", "num" => 2];
                break;
            case "pending":
                return ["estado" => "Pendiente", "num" => 1];
                break;
            case "in_process":
                return ["estado" => "Pendiente", "num" => 1];
                break;
            case "rejected":
                return ["estado" => "Rechazado", "num" => 4];
                break;
            case "null":
                return ["estado" => "Carrito no cerrado", "num" => 0];
                break;
        }
    }


    public function normalizar_link($string)
    {
        $string = str_replace("á", "a", $string);
        $string = str_replace("Á", "A", $string);
        $string = str_replace("ä", "a", $string);
        $string = str_replace("Ä", "A", $string);
        $string = str_replace("é", "e", $string);
        $string = str_replace("ë", "e", $string);
        $string = str_replace("Ë", "E", $string);
        $string = str_replace("É", "E", $string);
        $string = str_replace("í", "i", $string);
        $string = str_replace("ï", "i", $string);
        $string = str_replace("Í", "I", $string);
        $string = str_replace("Ï", "I", $string);
        $string = str_replace("Ì", "I", $string);
        $string = str_replace("ó", "o", $string);
        $string = str_replace("Ó", "O", $string);
        $string = str_replace("ö", "o", $string);
        $string = str_replace("Ö", "O", $string);
        $string = str_replace("ú", "u", $string);
        $string = str_replace("Ú", "U", $string);
        $string = str_replace("Ü", "U", $string);
        $string = str_replace("ü", "u", $string);
        $string = str_replace(" ", "-", $string);
        $string = str_replace("!", "", $string);
        $string = str_replace("ñ", "n", $string);
        $string = str_replace("Ñ", "N", $string);
        $string = str_replace("!", "", $string);
        $string = str_replace("?", "", $string);
        $string = str_replace("¿", "", $string);
        $string = str_replace("&", "", $string);
        $string = str_replace("*", "", $string);
        $string = str_replace("#", "", $string);
        $string = str_replace("~", "", $string);
        $string = str_replace("_", "", $string);
        $string = str_replace("'", "", $string);
        $string = str_replace("\"", "", $string);
        $string = str_replace("¡", "", $string);
        $string = str_replace("/", "", $string);
        $string = str_replace(",", "", $string);
        $string = str_replace(";", "", $string);
        $string = str_replace("(", "", $string);
        $string = str_replace(")", "", $string);
        $string = str_replace("+", "", $string);
        $string = str_replace(".", "", $string);
        $string = str_replace("°", "", $string);
        $string = str_replace("%", "", $string);
        $string = str_replace("&", "", $string);
        $string = str_replace("º", "", $string);
        $string = str_replace("$", "", $string);
        $string = str_replace("´", "", $string);
        $string = str_replace("^", "", $string);
        $string = str_replace("}", "", $string);
        $string = str_replace("{", "", $string);
        $string = str_replace("_", "", $string);
        $string = str_replace(":", "", $string);
        $string = strtolower($string);
        //para ampliar los caracteres a reemplazar agregar lineas de este tipo:
        //$string = str_replace("caracter - que - queremos - cambiar","caracter - por - el - cual - lo - vamos - a - cambiar",$string);
        return $string;
    }


    public function eliminar_get($url, $varname)
    {
        $parsedUrl = parse_url($url);
        $query = array();

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
            unset($query[$varname]);
        }

        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $query = !empty($query) ? '?' . http_build_query($query) : '';

        return $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $path . $query;
    }

    public function localidades()
    {
        $con = new Conexion();
        $palabra = ($_GET["elegido"]);
        $sql = "SELECT  distinct `_provincias`.`nombre`,`_localidades`.`nombre` FROM  `_localidades` , `_provincias` WHERE  `_localidades`.`provincia_id` =  `_provincias`.`id` AND `_provincias`.`nombre`  LIKE '%$palabra%' AND `_localidades`.`nombre` != '' ORDER BY `_localidades`.`nombre`";
        $notas = $con->sqlReturn($sql);
        while ($row = mysqli_fetch_assoc($notas)) {
            echo strtoupper($row["nombre"]) . ";";
        }
    }

    public function provincias()
    {
        $con = new Conexion();
        $sql = "SELECT `nombre` FROM  `_provincias` ORDER BY nombre";
        $provincias = $con->sqlReturn($sql);
        while ($row = mysqli_fetch_assoc($provincias)) {
            echo '<option value="' . $row['nombre'] . '">' . mb_strtoupper($row['nombre']) . '</option>';
        }
    }

    public function anidador($url, $get, $contador)
    {
        if ($contador > 1) :
            $anidador = "&";
        elseif ($contador == 1) :
            if (strpos($url, $get)) :
                $anidador = "?";
            else :
                $anidador = "&";
            endif;
        elseif ($contador == 0) :
            $anidador = "?";
        endif;

        return $anidador;
    }

    public function variables_get_input($hidden)
    {
        foreach ($_GET as $key => $val) {
            if ($key == "pagina") {
            } else {
                if ($key != $hidden) {
                    echo "<input type='hidden' name='" . $key . "' value='" . $val . "' />";
                }
            }
        }
    }

    public function tel_argentino_valido($tel)
    {
        //eliminamos todo lo que no es dígito
        $num = preg_replace('/\D+/', '', $tel);
        //devolver si coincidió con el regex
        return preg_match(
            '/^(?:(?:00)?549?)?0?(?:11|[2368]\d)(?:(?=\d{0,2}15)\d{2})??\d{8}$/D',
            $num
        );
    }
}
