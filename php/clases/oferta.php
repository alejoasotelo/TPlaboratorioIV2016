<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class Oferta{
    
    public $id_oferta;
    public $id_propiedad;
    public $id_local;
    public $nombre;
    public $descripcion;
    public $precio;
    public $descuento;

    public static function traerPorId($id_imagen, $type = 'object')
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM ofertas WHERE id_oferta =:id_oferta");
        $consulta->bindValue(':id_oferta', $id_imagen, \PDO::PARAM_INT);
        $consulta->execute();

        if ($type == 'array') {
            $objBuscada = $consulta->fetch(\PDO::FETCH_ASSOC);
        } else {
            $objBuscada = $consulta->fetchObject(self::class);
        }

        return $objBuscada;
    }

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO ofertas (`id_oferta`, `id_propiedad`, `id_local`, `nombre`, `descripcion`, `precio`, `descuento`) VALUES (NULL, :id_oferta, :id_propiedad, :id_local, :nombre, :descripcion, :precio, :descuento)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_oferta', $obj->imagen, \PDO::PARAM_STR);
        $consulta->bindValue(':id_propiedad', $obj->id_propiedad, \PDO::PARAM_STR);
        $consulta->bindValue(':id_local', $obj->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', $obj->descripcion, \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $obj->precio, \PDO::PARAM_STR);
        $consulta->bindValue(':descuento', $obj->descuento, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function borrar($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM ofertas WHERE id_oferta IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

}