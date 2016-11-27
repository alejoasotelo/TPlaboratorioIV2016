<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class LocalHasEncargado{
	
    public $id_local;
    public $id_usuario;

    public function exists()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT count(*) FROM locales_has_encargado WHERE id_local = :id_local");
        $consulta->bindValue(':id_local', $this->id_local, \PDO::PARAM_INT);
        $consulta->bindValue(':id_usuario', $this->id_usuario, \PDO::PARAM_INT);
        $consulta->execute();

        $count = $consulta->fetchColumn();

        return $count > 0;

    }

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO locales_has_encargado (`id_local`, `id_usuario`) VALUES (:id_local, :id_usuario)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $obj->id_usuario, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function modificar($obj)
    {
        $sql = 'UPDATE locales_has_encargado SET id_usuario = :id_usuario WHERE id_local = :id_local';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_usuario', $obj->id_usuario, \PDO::PARAM_STR);
        $consulta->bindValue(':id_local', $obj->id_local, \PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarPorIdLocal($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM locales_has_encargado WHERE id_local IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

}