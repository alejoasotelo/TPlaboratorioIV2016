<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class LocalHasImagen{
	
    public $id_local;
	public $id_imagen;

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO locales_has_imagenes (`id_local`, `id_imagen`) VALUES (:id_local, :id_imagen)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':id_imagen', $obj->id_imagen, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function borrarPorIdImagen($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM locales_has_imagenes WHERE id_imagen IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

}