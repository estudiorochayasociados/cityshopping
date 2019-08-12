<?php

namespace Clases;

class Productos
{

    //Atributos
    public $id;
    public $cod;
    public $cod_producto;
    public $titulo;
    public $precio;
    public $precioDescuento;
    public $stock;
    public $desarrollo;
    public $variantes;
    public $adicionales;
    public $categoria;
    public $subcategoria;
    public $seccion;
    public $keywords;
    public $description;
    public $fecha;
    public $meli;
    public $url;
    public $cod_empresa;
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
        $sql   = "INSERT INTO `productos`(`cod`, `cod_empresa`,`titulo`,`cod_producto`, `precio`, `precioDescuento`, `stock`, `desarrollo`, `variantes`,`adicionales`,`categoria`, `subcategoria`, `seccion`, `keywords`, `description`, `fecha`, `meli`, `url`) VALUES ('{$this->cod}', '{$this->cod_empresa}', '{$this->titulo}','{$this->cod_producto}', '{$this->precio}', '{$this->precioDescuento}', '{$this->stock}', '{$this->desarrollo}', '{$this->variantes}', '{$this->adicionales}', '{$this->categoria}', '{$this->subcategoria}', '{$this->seccion}', '{$this->keywords}', '{$this->description}', '{$this->fecha}', '{$this->meli}', '{$this->url}')";
        $query = $this->con->sql($sql);
        echo $sql;
        return $query;

    }

    public function editUnico($atributo,$valor)
    {
        $sql = "UPDATE `productos` SET
        `$atributo` = '{$valor}'
        WHERE `id`='{$this->id}' || `cod`='{$this->cod}'";
        $this->con->sql($sql);
    }

    public function edit()
    {
        $sql = "UPDATE `productos` SET
        `cod` = '{$this->cod}',
        `cod_empresa` = '{$this->cod_empresa}',
        `titulo` = '{$this->titulo}',
        `precio` = '{$this->precio}',
        `cod_producto` = '{$this->cod_producto}',
        `precioDescuento` = '{$this->precioDescuento}',
        `stock` = '{$this->stock}',
        `desarrollo` = '{$this->desarrollo}',
        `variantes` = '{$this->variantes}',
        `adicionales` = '{$this->adicionales}',
        `categoria` = '{$this->categoria}',
        `subcategoria` = '{$this->subcategoria}',
        `seccion` = '{$this->seccion}',
        `keywords` = '{$this->keywords}',
        `description` = '{$this->description}',
        `fecha` = '{$this->fecha}',
        `meli` = '{$this->meli}',
        `url` = '{$this->url}'
        WHERE `id`='{$this->id}' || `cod`='{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function delete()
    {
        $sql   = "DELETE FROM `productos` WHERE `cod`  = '{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function view()
    {
        $sql   = "SELECT * FROM `productos` WHERE id = '{$this->id}' ||  cod = '{$this->cod}' ORDER BY id DESC";
        $notas = $this->con->sqlReturn($sql);
        $row   = mysqli_fetch_assoc($notas);
        return $row;
    }

    function list($filter,$order,$limit) {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }

        if ($order != '') {
            $orderSql = $order;
        } else {
            $orderSql = "id DESC";
        }

        if ($limit != '') {
            $limitSql = "LIMIT " . $limit;
        } else {
            $limitSql = '';
        }

        $sql = "SELECT * FROM `productos` $filterSql  ORDER BY $orderSql $limitSql";
        $notas = $this->con->sqlReturn($sql);
        if ($notas) {
            while ($row = mysqli_fetch_assoc($notas)) {
                $array[] = $row;
            }
            return $array ;
        } 
    }

    function paginador($filter,$cantidad) {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }
        $sql = "SELECT * FROM `productos` $filterSql";
        $contar = $this->con->sqlReturn($sql);
        $total = mysqli_num_rows($contar);
        $totalPaginas = $total / $cantidad;
        return ceil($totalPaginas);
    }

}
