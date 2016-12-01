<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;
use AlejoASotelo\Local;

class Usuario
{
    public $id_usuario;
    public $username;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $tipo;
    public $estado;

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
            $this->estado = $obj->estado;
            $this->local = $this->getLocal();
        }
    }

    public static function traerPorId($idParametro)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta('SELECT * FROM usuarios WHERE id_usuario =:id_usuario');
        $consulta->bindValue(':id_usuario', $idParametro, \PDO::PARAM_INT);
        $consulta->execute();
        $usuarioBuscada = $consulta->fetchObject(self::class);
        return $usuarioBuscada;
    }

    public static function traerTodos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta('SELECT * FROM usuarios');
        $consulta->execute();
        $arrUsuarios= $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);
        return $arrUsuarios;
    }

    public static function borrar($id_usuario)
    {
        if (is_numeric($id_usuario)) {
            $id_usuario = array($id_usuario);
        }

        $sql = 'DELETE FROM usuarios WHERE id_usuario IN ('.implode(',', $id_usuario).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function cambiarEstado($id, $nuevo_estado) {
        
        $sql = 'UPDATE usuarios SET estado = :estado WHERE id_usuario = :id_usuario';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':estado', $nuevo_estado, \PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $id, \PDO::PARAM_INT);
        return $consulta->execute();
    }

    public static function modificar($usuario)
    {
        if (!empty($usuario->password)) {
            $sql = 'UPDATE usuarios SET username = :username, nombre = :nombre, apellido = :apellido, email = :email, tipo = :tipo, estado = :estado, password = :password WHERE id_usuario = :id_usuario';
        } else {
            $sql = 'UPDATE usuarios SET username = :username, nombre = :nombre, apellido = :apellido, email = :email, tipo = :tipo, estado = :estado WHERE id_usuario = :id_usuario';
        }

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_usuario', $usuario->id_usuario, \PDO::PARAM_INT);
        $consulta->bindValue(':username', $usuario->username, \PDO::PARAM_STR);
        $consulta->bindValue(':email', $usuario->email, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->apellido, \PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $usuario->tipo, \PDO::PARAM_STR);
        $consulta->bindValue(':estado', $usuario->estado, \PDO::PARAM_STR);

        if (!empty($usuario->password)) {
            $consulta->bindValue(':password', md5($usuario->password), \PDO::PARAM_STR);
        }

        return $consulta->execute();
    }

    public static function insertar($usuario)
    {
        $sql = 'INSERT INTO usuarios (`id_usuario`, `username`, `email`, `nombre`, `apellido`, `password`, `tipo`, `estado`) 
        VALUES (NULL, :username, :email, :nombre, :apellido, :password, :tipo, :estado)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':username', $usuario->username, \PDO::PARAM_STR);
        $consulta->bindValue(':email', $usuario->email, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->apellido, \PDO::PARAM_STR);
        $consulta->bindValue(':password', md5($usuario->password), \PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $usuario->tipo, \PDO::PARAM_STR);
        $consulta->bindValue(':estado', $usuario->tipo, \PDO::PARAM_STR);
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

    public function getLocal() {

        if ($this->id_usuario == null)
        {
            return false;
        }

        $sql = '';

        if ($this->tipo == 'encargado') {

            $sql = 'SELECT l.* FROM `locales` l
            LEFT JOIN locales_has_encargado le ON (le.id_local = l.id_local)
            WHERE le.id_usuario = :id_usuario';

        } else if($this->tipo == 'empleado') {

            $sql = 'SELECT l.* FROM `locales` l
            LEFT JOIN locales_has_empleados le ON (le.id_local = l.id_local)
            WHERE le.id_usuario = :id_usuario';

        } else {
            return new \stdClass();
        }

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_usuario', $this->id_usuario, \PDO::PARAM_STR);
        $consulta->execute();
        $local = $consulta->fetchObject(Local::class);

        return $local ? (object)$local : new \stdClass();
    }
}
