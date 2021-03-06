<?php

namespace Clases;

class Categorias
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $area; 
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
        $sql   = "INSERT INTO `categorias`(`cod`, `titulo`, `area`) VALUES ('{$this->cod}', '{$this->titulo}', '{$this->area}')";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function edit()
    {
        $sql   = "UPDATE `categorias` SET cod = '{$this->cod}', titulo = '{$this->titulo}', area = '{$this->area}' WHERE `cod`='{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function delete()
    {
        $sql   = "DELETE FROM `categorias` WHERE `cod`  = '{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function view()
    {
        $sql   = "SELECT * FROM `categorias` WHERE cod = '{$this->cod}' ORDER BY id DESC";
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

        $sql = "SELECT * FROM `categorias` $filterSql  ORDER BY $orderSql $limitSql";
        $notas = $this->con->sqlReturn($sql);
        if ($notas) {
            while ($row = mysqli_fetch_assoc($notas)) {
                $array[] = $row;

            }
            return $array ;
        }
    }

    function categoriasMasUsadas(){
        $array = array();
        $sql = "SELECT c.titulo, count(p.categoria) cant FROM categorias c JOIN productos p ON p.categoria = c.cod WHERE p.cod_empresa = '$this->cod_empresa' GROUP BY c.titulo ORDER BY cant DESC LIMIT 3";
        $notas = $this->con->sqlReturn($sql);
        if ($notas) {
            while ($row = mysqli_fetch_assoc($notas)) {
                $array[] = $row;
            }
            return $array ;
        }
    }

    function listForArea($limit) {
        $array = array();
        if ($limit != '') {
            $limitSql = "LIMIT " . $limit;
        } else {
            $limitSql = '';
        }
        $sql = "SELECT * FROM `categorias` WHERE area = '{$this->area}'  ORDER BY id DESC $limitSql";
        $notas = $this->con->sqlReturn($sql);
        if ($notas) {
            while ($row = mysqli_fetch_assoc($notas)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    public function listIfHave($db)
    {
        $array = array();
        $sql = " SELECT `categorias`.`titulo`,`categorias`.`cod`, count(`" . $db . "`.`categoria`) as cantidad FROM `" . $db . "`,`categorias` WHERE `categoria` = `categorias`.`cod` GROUP BY categoria ORDER BY cantidad DESC ";
        $listIfHave = $this->con->sqlReturn($sql);
        if ($listIfHave) {
            while ($row = mysqli_fetch_assoc($listIfHave)) {
                $array[] = $row;
            }
            return $array;
        }
    }
}
