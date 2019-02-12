<?php

namespace Clases;

class Envios
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $precio;
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
        $sql   = "INSERT INTO `envios`(`cod`, `titulo`, `precio`, `cod_empresa`) VALUES ('{$this->cod}', '{$this->titulo}', '{$this->precio}', '{$this->cod_empresa}')";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function edit()
    {
        $sql = "UPDATE `envios` SET
        `cod` = '{$this->cod}',
        `titulo` = '{$this->titulo}',
        `precio` = '{$this->telefono}',
        `cod_empresa` = '{$this->email}',
        WHERE `id`='{$this->id}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function delete()
    {
        $sql   = "DELETE FROM `envios` WHERE `cod` = '{$this->cod}' || `cod_empresa` = '{$this->cod_empresa}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function deleteAll(){
        $sql   = "TRUNCATE TABLE `envios`";
        $this->con->sql($sql);
    }

    public function view()
    {
        $sql   = "SELECT * FROM `envios` WHERE id = '{$this->id}' ||  cod = '{$this->cod}' ||  cod_empresa = '{$this->cod_empresa}' ORDER BY id DESC";
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

        $sql = "SELECT * FROM `envios` $filterSql  ORDER BY $orderSql $limitSql";
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
        $sql = "SELECT * FROM `envios` $filterSql";
        $contar = $this->con->sqlReturn($sql);
        $total = mysqli_num_rows($contar);
        $totalPaginas = $total / $cantidad;
        return floor($totalPaginas);       
    }

}