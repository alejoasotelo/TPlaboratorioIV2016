<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;
use AlejoASotelo\Local;

class Propiedad{
    
    public $id_propiedad;
    public $id_local;
    public $nombre;
    public $direccion;
    public $precio;
    public $local;

    public function __construct($id_propiedad = null)
    {
        if ($id_propiedad != null) {

            $obj = self::traerPorId($id_propiedad);

            $this->id_propiedad = $obj->id_propiedad;
            $this->id_local = $obj->id_local;
            $this->nombre = $obj->nombre;
            $this->direccion = $obj->direccion;
            $this->precio = $obj->precio;
            $this->local = $this->getLocal();

        } else if ($this->id_local > 0) {

            $obj = self::traerPorId($this->id_propiedad, 'array');

            $this->id_propiedad = $obj['id_propiedad'];
            $this->id_local = $obj['id_local'];
            $this->nombre = $obj['nombre'];
            $this->direccion = $obj['direccion'];
            $this->precio = $obj['precio'];
            $this->local = $this->getLocal();
        }
    }

    public static function traerPorId($id_propiedad, $type = 'object')
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM propiedades WHERE id_propiedad =:id_propiedad");
        $consulta->bindValue(':id_propiedad', $id_propiedad, \PDO::PARAM_INT);
        $consulta->execute();

        if ($type == 'array') {
            $objBuscada = $consulta->fetch(\PDO::FETCH_ASSOC);
        } else {
            $objBuscada = $consulta->fetchObject(self::class);
        }

        return $objBuscada;
    }

    public static function traerTodos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM propiedades");
        $consulta->execute();
        $arrLocals = $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);

        return $arrLocals;
    }

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO propiedades (`id_propiedad`, `id_local`, `nombre`, `direccion`, `precio`) VALUES (NULL, :id_local, :nombre, :direccion, :precio)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->local->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':direccion', $obj->direccion, \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $obj->precio, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function modificar($obj)
    {
        $sql = 'UPDATE propiedades SET id_local = :id_local, nombre = :nombre, direccion = :direccion, precio = :precio WHERE id_propiedad = :id_propiedad';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->local->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':direccion', $obj->direccion, \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $obj->precio, \PDO::PARAM_STR);
        $consulta->bindValue(':id_propiedad', $obj->id_propiedad, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function borrar($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM propiedades WHERE id_propiedad IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function getLocal() {

        if ($this->id_local == null)
        {
            return false;
        }

        $sql = 'SELECT l.* FROM `locales` l WHERE l.id_local = :id_local';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $this->id_local, \PDO::PARAM_STR);
        $consulta->execute();
        $local = $consulta->fetch(\PDO::FETCH_ASSOC);

        return $local ?: new \stdClass();

    }

}
