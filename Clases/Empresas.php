<?php

namespace Clases;

class Empresas
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $telefono;
    public $email;
    public $provincia;
    public $ciudad;
    public $barrio;
    public $direccion;
    public $postal;
    public $coordenadas;
    public $desarrollo;
    public $redes;
    public $redes2;
    public $redes3;
    public $logo;
    public $portada;
    public $categoria;
    public $subcategoria;
    public $keywords;
    public $description;
    public $fecha;
    public $cod_usuario;
    public $tiempoEntrega;
    public $delivery;
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
        $sql = "INSERT INTO `empresas`(`cod`, `titulo`, `telefono`, `email`, `provincia`, `ciudad`, `barrio`, `direccion`, `postal`, `coordenadas`, `desarrollo`, `redes`, `redes2`, `redes3`, `logo`, `portada`, `categoria`, `subcategoria`, `keywords`, `description`, `fecha`, `cod_usuario`, `tiempoEntrega`, `delivery`) VALUES ('{$this->cod}', '{$this->titulo}', '{$this->telefono}', '{$this->email}', '{$this->provincia}', '{$this->ciudad}', '{$this->barrio}', '{$this->direccion}', '{$this->postal}', '{$this->coordenadas}', '{$this->desarrollo}', '{$this->redes}', '{$this->redes2}', '{$this->redes3}','{$this->logo}','{$this->portada}', '{$this->categoria}', '{$this->subcategoria}', '{$this->keywords}', '{$this->description}', '{$this->fecha}', '{$this->cod_usuario}', '{$this->tiempoEntrega}', '{$this->delivery}')";
        $query = $this->con->sql($sql);

//        return $query;
    }

    public function edit()
    {
        $sql = "UPDATE `empresas` SET
        `cod` = '{$this->cod}',
        `titulo` = '{$this->titulo}',
        `telefono` = '{$this->telefono}',
        `email` = '{$this->email}',
        `provincia` = '{$this->provincia}',
        `ciudad` = '{$this->ciudad}',
        `barrio` = '{$this->barrio}',
        `direccion` = '{$this->direccion}',
        `postal` = '{$this->postal}',
        `coordenadas` = '{$this->coordenadas}',
        `desarrollo` = '{$this->desarrollo}',
        `redes` = '{$this->redes}',
        `redes2` = '{$this->redes2}',
        `redes3` = '{$this->redes3}',
        `logo` = '{$this->logo}',
        `portada` = '{$this->portada}',
        `categoria` = '{$this->categoria}',
        `subcategoria` = '{$this->subcategoria}',
        `keywords` = '{$this->keywords}',
        `description` = '{$this->description}',
        `fecha` = '{$this->fecha}',
        `tiempoEntrega` = '{$this->tiempoEntrega}',
        `delivery` = '{$this->delivery}'
        WHERE `id`={$this->id}";
        $query = $this->con->sql($sql);

        return $query;
    }

    public function delete()
    {
        $sql = "DELETE FROM `empresas` WHERE `cod`  = '{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function view()
    {
        $sql = "SELECT * FROM `empresas` WHERE cod = '{$this->cod}' ORDER BY id DESC";
        $notas = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($notas);
        return $row;
    }

    public function viewByUserCod()
    {
        $sql = "SELECT * FROM `empresas` WHERE cod_usuario = '{$this->cod_usuario}' ORDER BY id DESC";
        $notas = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($notas);
        return $row;
    }

    function list($filter, $order, $limit)
    {
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

        $sql = "SELECT * FROM `empresas` $filterSql  ORDER BY $orderSql $limitSql";
        $notas = $this->con->sqlReturn($sql);
        if ($notas) {
            while ($row = mysqli_fetch_assoc($notas)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    function paginador($filter, $cantidad)
    {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }
        $sql = "SELECT * FROM `empresas` $filterSql";
        $contar = $this->con->sqlReturn($sql);
        $total = mysqli_num_rows($contar);
        $totalPaginas = $total / $cantidad;
        return ceil($totalPaginas);
    }

    //Agregado 15/08/19
    public function viewV2()
    {
        $sql = "SELECT * FROM `empresas` WHERE cod_usuario = '{$this->cod_usuario}' ORDER BY id DESC";
        $notas = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($notas);
        return $row;
    }
}