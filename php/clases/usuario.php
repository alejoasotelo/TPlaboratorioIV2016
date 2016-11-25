<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class Usuario
{
    public $id_usuario;
    public $username;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $tipo;

    public function __construct($id_usuario = null)
    {
        if ($id_usuario != null) {
            $obj = Usuario::traerPorId($id_usuario);

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
        $consulta =$objetoAccesoDato->retornarConsulta("SELECT * FROM usuarios WHERE id_usuario =:id_usuario");
        $consulta->bindValue(':id_usuario', $idParametro, PDO::PARAM_INT);
        $consulta->execute();
        $usuarioBuscada = $consulta->fetchObject(self::class);
        return $usuarioBuscada;
    }

    public static function traerTodos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta("SELECT * FROM usuarios");
        $consulta->execute();
        $arrUsuarios= $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);
        return $arrUsuarios;
    }

    public static function borrar($idParametro)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM usuarios WHERE id_usuario=:id_usuario");
        $consulta->bindValue(':id_usuario', $idParametro, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function modificar($usuario)
    {
        $sql = 'UPDATE usuarios SET username = :username, nombre = :nombre, apellido = :apellido, email = :email, tipo = :tipo, password = :password WHERE id_usuario = :id_usuario';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_usuario', $usuario->id, PDO::PARAM_INT);
        $consulta->bindValue(':username', $usuario->email, PDO::PARAM_STR);
        $consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':password', md5($usuario->password), PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $usuario->tipo, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public static function insertar($usuario)
    {
        $sql = 'INSERT INTO usuarios (`id_usuario`, `username`, `email`, `nombre`, `apellido`, `password`, `tipo`) 
                    VALUES (NULL, :username, :email, :nombre, :apellido, :password, :tipo)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':username', $usuario->username, \PDO::PARAM_STR);
        $consulta->bindValue(':email', $usuario->email, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':password', md5($usuario->password), \PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $usuario->tipo, \PDO::PARAM_STR);
        $consulta->execute();

        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function existe($username, $password)
    {
        $sql = 'SELECT * FROM usuarios WHERE username = :username AND password = :password';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':username', $username);
        $consulta->bindValue(':password', md5($password), \PDO::PARAM_STR);
        $consulta->execute();

        $user = $consulta->fetchObject(self::class);
        return isset($user->id_usuario) && $user->id_usuario > 0;
    }

    public static function traerPorUsername($username)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->retornarConsulta('SELECT * FROM usuarios WHERE username = :username');
        $consulta->bindValue(':username', $username);
        $consulta->execute();

        $user = $consulta->fetchObject(self::class);
        return $user;
    }
}
