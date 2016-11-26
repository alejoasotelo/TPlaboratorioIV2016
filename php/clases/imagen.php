<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class Imagen{
	
	public $id_imagen;
	public $imagen;

    public static function traerPorId($id_imagen, $type = 'object')
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM imagenes WHERE id_imagen =:id_imagen");
        $consulta->bindValue(':id_imagen', $id_imagen, \PDO::PARAM_INT);
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
        $sql = 'INSERT INTO imagenes (`id_imagen`, `imagen`) VALUES (NULL, :imagen)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':imagen', $obj->imagen, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function borrar($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        foreach ($id as $id_imagen) {
            $imagen = self::traerPorId($id_imagen);
            unlink(__DIR__.'/../../'.$imagen->imagen);
        }

        $sql = 'DELETE FROM imagenes WHERE id_imagen IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

}