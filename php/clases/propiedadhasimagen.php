<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class PropiedadHasImagen{
	
    public $id_propiedad;
	public $id_imagen;

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO propiedades_has_imagenes (`id_propiedad`, `id_imagen`) VALUES (:id_propiedad, :id_imagen)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_propiedad', $obj->id_propiedad, \PDO::PARAM_STR);
        $consulta->bindValue(':id_imagen', $obj->id_imagen, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function borrarPorIdImagen($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM propiedades_has_imagenes WHERE id_imagen IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function borrarPorIdPropiedad($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM propiedades_has_imagenes WHERE id_propiedad IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

}