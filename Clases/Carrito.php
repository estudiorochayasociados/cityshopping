<?php

namespace Clases;

class Carrito
{
    //Atributos
    public $id;
    public $titulo;
    public $cantidad;
    public $precio;
    public $precioAdicional;
    public $opciones;
    public $stock;
    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
    }

    public function set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }

    public function add()
    {
        $condition = '';

        $add = array('id' => $this->id, 'titulo' => $this->titulo, 'cantidad' => $this->cantidad, 'precio' => $this->precio, 'stock' => $this->stock, 'opciones' => $this->opciones);

        if (count($_SESSION["carrito"]) == 0) {
            array_push($_SESSION["carrito"], $add);
            return true;
        } else {
            for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
                if ($_SESSION["carrito"][$i]["id"] == $this->id) {
                    $condition = $i;
                }
            }

            if (is_numeric($condition)) {
                $stock_carrito = $_SESSION["carrito"][$condition]["cantidad"] + $add["cantidad"];
                if($stock_carrito <= $add["stock"]) {
                    $_SESSION["carrito"][$condition]["cantidad"] = $_SESSION["carrito"][$condition]["cantidad"] + $this->cantidad;
                    return true;
                } else {
                    return false;
                }
            } else {
                array_push($_SESSION["carrito"], $add);
                return true;
            }
        }
    }

    public function return()
    {
        if (!isset($_SESSION["carrito"])) {
            $_SESSION["carrito"] = array();
            return $_SESSION["carrito"];
        } else {
            return $_SESSION["carrito"];
        }
    }

    public function precioFinal()
    {
        $precio = 0;
        for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
            $precio += $_SESSION["carrito"][$i]["precio"];
        }
        return $precio;
    }

    public function delete($key)
    {
        unset($_SESSION["carrito"][$key]);
        $_SESSION["carrito"] = array_values($_SESSION["carrito"]);
    }

    public function edit($key)
    {
        if (array_key_exists($key, $_SESSION["carrito"])) {
            $_SESSION["carrito"][$key]["precio"] = $this->precio;
        }
    }

    public function destroy()
    {
        unset($_SESSION["carrito"]);
        $_SESSION["carrito"] = array();
    }

    public function checkEnvio()
    {
        foreach ($_SESSION["carrito"] as $key => $val) {
            if ($val['id'] === "Envio-Seleccion") {
                return $key;
            }
        }
        return null;
    }
}
