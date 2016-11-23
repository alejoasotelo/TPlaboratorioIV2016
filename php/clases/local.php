<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class Local
{
    public $id;
    public $username;
    public $nombre;
    public $apellido;
    public $email;
    public $clave;
    public $tipo;

    public function __construct($id = null)
    {
        if ($id != null) {
            $obj = Local::traerPorId($id);

            $this->id = $id;
            $this->username = $obj->username;
            $this->nombre = $obj->nombre;
            $this->apellido = $obj->apellido;
            $this->email = $obj->email;
            $this->clave = $obj->clave;
            $this->tipo = $obj->tipo;
        }
    }

    public static function traerPorId($idParametro)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta("SELECT * FROM misusuarios WHERE id =:id");
        $consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
        $consulta->execute();
        $usuarioBuscada = $consulta->fetchObject('usuario');
        return $usuarioBuscada;
    }

    public static function traerTodos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta("SELECT * FROM misusuarios");
        $consulta->execute();
        $arrLocals= $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");
        return $arrLocals;
    }

    public static function borrar($idParametro)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM misusuarios WHERE id=:id");
        $consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function modificar($usuario)
    {
        $sql = 'UPDATE misusuarios SET username = :username, nombre = :nombre, apellido = :apellido, email = :email, tipo = :tipo, clave = :clave WHERE id = :id';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id', $usuario->id, PDO::PARAM_INT);
        $consulta->bindValue(':username', $usuario->email, PDO::PARAM_STR);
        $consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave', md5($usuario->clave), PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $usuario->tipo, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public static function insertarLocal($usuario)
    {
        $sql = 'INSERT INTO misusuarios (`id`, `username`, `email`, `nombre`, `apellido`, `clave`, `tipo`) VALUES (NULL, :username, :email, :nombre, :apellido, :clave, :tipo)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':username', $usuario->email, PDO::PARAM_STR);
        $consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave', md5($usuario->clave), PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $usuario->tipo, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function traerPorUsername($username)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta('SELECT * FROM misusuarios WHERE username = :username');
        $consulta->bindValue(':username', $username);
        $consulta->execute();

        $user = $consulta->fetchObject('usuario');
        return $user;
    }
}
