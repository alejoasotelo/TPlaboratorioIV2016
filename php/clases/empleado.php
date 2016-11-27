<?php
namespace AlejoASotelo;

use AlejoASotelo\Usuario;
use AlejoASotelo\AccessoDatos;

class Empleado extends Usuario
{

    public function __construct($id_usuario = null)
    {
        if ($id_usuario != null) {
            $obj = self::traerPorId($id_usuario);

            $this->id_usuario = $id_usuario;
            $this->username = $obj->username;
            $this->nombre = $obj->nombre;
            $this->apellido = $obj->apellido;
            $this->email = $obj->email;
            $this->password = $obj->password;
            $this->tipo = $obj->tipo;
        }
    }

    public static function traerPorId($idParametro)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta('SELECT * FROM usuarios WHERE tipo = \'empleado\' AND id_usuario =:id_usuario');
        $consulta->bindValue(':id_usuario', $idParametro, \PDO::PARAM_INT);
        $consulta->execute();
        $usuarioBuscada = $consulta->fetchObject(self::class);
        return $usuarioBuscada;
    }

    public static function traerTodos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta('SELECT * FROM usuarios WHERE tipo = \'empleado\'');
        $consulta->execute();
        $arrUsuarios= $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);
        return $arrUsuarios;
    }
}
