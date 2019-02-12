<?php

namespace Clases;

class Pedidos
{

    //Atributos
    public $id;
    public $cod;
    public $producto;
    public $cantidad;
    public $precio;
    public $precioAdicional;
    public $estado;
    public $tipo;
    public $usuario;
    public $empresa;
    public $detalle;
    public $fecha;
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
        $sql   = "INSERT INTO `pedidos`(`cod`, `producto`,`cantidad`,`precio`,`precioAdicional`, `estado`, `tipo`, `usuario`, `empresa`, `detalle`, `fecha`) VALUES ('{$this->cod}', '{$this->producto}','{$this->cantidad}','{$this->precio}','{$this->precioAdicional}', '{$this->estado}', '{$this->tipo}', '{$this->usuario}', '{$this->empresa}', '{$this->detalle}', '{$this->fecha}')";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function edit()
    {
        $sql   = "UPDATE `pedidos` SET  `producto`='{$this->producto}',`cantidad`='{$this->cantidad}',`precio`='{$this->precio}',`precioAdicional`='{$this->precioAdicional}',`estado`='{$this->estado}',`tipo`='{$this->tipo}',`usuario`='{$this->usuario}',`empresa`='{$this->empresa}',`detalle`='{$this->detalle}',`fecha`='{$this->fecha}' WHERE `id`='{$this->id}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function cambiar_estado()
    {
        $sql   = "UPDATE `pedidos` SET `estado`='{$this->estado}' WHERE `cod`='{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function delete()
    {
        $sql   = "DELETE FROM `pedidos` WHERE `cod`  = '{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function view()
    {
        $sql   = "SELECT * FROM `pedidos` WHERE cod = '{$this->cod}' ORDER BY id DESC";
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

        $sql = "SELECT * FROM `pedidos` $filterSql  ORDER BY $orderSql $limitSql";
        $notas = $this->con->sqlReturn($sql);
        if ($notas) {
            while ($row = mysqli_fetch_assoc($notas)) {
                $array[] = $row;
            }
            return $array ;
        }
    }
}
