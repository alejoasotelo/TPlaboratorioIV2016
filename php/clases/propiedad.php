<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class Propiedad{
    
    public $id_propiedad;
    public $id_local;
    public $nombre;
    public $direccion;
    public $precio;

    public static function traerPorId($id_propiedad, $type = 'object')
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM propiedades WHERE id_propiedad =:id_propiedad");
        $consulta->bindValue(':id_propiedad', $id_propiedad, \PDO::PARAM_INT);
        $consulta->execute();

        if ($type == 'array') {
            $objBuscada = $consulta->fetch(\PDO::FETCH_ASSOC);
        } else {
            $objBuscada = $consulta->fetchObject(self::class);
        }

        return $objBuscada;
    }

    public static function traerTodos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM propiedades");
        $consulta->execute();
        $arrLocals = $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);

        return $arrLocals;
    }

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO propiedades (`id_propiedad`, `id_local`, `nombre`, `direccion`, `precio`) VALUES (NULL, :id_local, :nombre, :direccion, :precio)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':direccion', $obj->direccion, \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $obj->precio, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function borrar($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM propiedades WHERE id_propiedad IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

}