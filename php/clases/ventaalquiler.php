<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class VentaAlquiler{
	
    public $id_propiedad;
    public $id_usuario;
    public $precio;
    public $tipo;
    public $fecha_desde;
    public $fecha_hasta;
    public $created;

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO ventas_alquileres (`id_propiedad`, `id_usuario`, `precio`, `tipo`, `fecha_desde`, `fecha_hasta`, `created`) VALUES (:id_propiedad, :id_usuario, :precio, :tipo, :fecha_desde, :fecha_hasta, NOW())';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_propiedad', $obj->id_propiedad, \PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $obj->id_usuario, \PDO::PARAM_STR);
        $consulta->bindValue(':precio', 0, \PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $obj->tipo, \PDO::PARAM_STR);

        if ($obj->tipo == 2) {
            $consulta->bindValue(':fecha_desde', $obj->fecha_desde, \PDO::PARAM_STR);
            $consulta->bindValue(':fecha_hasta', $obj->fecha_hasta, \PDO::PARAM_STR);
        } else {
            $consulta->bindValue(':fecha_desde', '', \PDO::PARAM_STR);
            $consulta->bindValue(':fecha_hasta', '', \PDO::PARAM_STR);
        }

        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function traerTodosPorIdUsuario($id_usuario) {

        $sql = 'SELECT va.*, p.nombre propiedad FROM ventas_alquileres va
            LEFT JOIN propiedades p ON (p.id_propiedad = va.id_propiedad)
            WHERE va.id_usuario = ' . $id_usuario;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        $arrUsuarios = $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);
        return $arrUsuarios;

    }

}