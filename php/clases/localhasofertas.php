<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class LocalHasOfertas{
	
    public $id_local;
	public $id_imagen;

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO locales_has_ofertas (`id_local`, `id_encargado`, `id_oferta`) VALUES (:id_local, :id_encargado, :id_oferta)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':id_encargado', $obj->id_encargado, \PDO::PARAM_STR);
        $consulta->bindValue(':id_oferta', $obj->id_oferta, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function borrarPorIdLocal($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM locales_has_ofertas WHERE id_local IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

}