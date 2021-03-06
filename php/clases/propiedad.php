<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;
use AlejoASotelo\Local;

class Propiedad{
    
    const TIPO_VENTA = 1;
    const TIPO_ALQUILER = 2;

    public $id_propiedad;
    public $id_local;
    public $id_usuario;
    public $nombre;
    public $direccion;
    public $precio;
    public $local;
    public $usuario;
    public $tipo;
    public $imagenes;

    public function __construct($id_propiedad = null)
    {
        if ($id_propiedad != null) {

            $obj = self::traerPorId($id_propiedad);

            $this->id_propiedad = $obj->id_propiedad;
            $this->id_local = $obj->id_local;
            $this->id_usuario = $obj->id_usuario;
            $this->nombre = $obj->nombre;
            $this->direccion = $obj->direccion;
            $this->precio = $obj->precio;
            $this->local = $this->getLocal();
            $this->usuario = $this->getUsuario();
            $this->imagenes = $this->getImagenes();

        } else if ($this->id_local > 0) {

            $obj = self::traerPorId($this->id_propiedad, 'array');

            $this->id_propiedad = $obj['id_propiedad'];
            $this->id_local = $obj['id_local'];
            $this->id_usuario = $obj['id_usuario'];
            $this->nombre = $obj['nombre'];
            $this->direccion = $obj['direccion'];
            $this->precio = $obj['precio'];
            $this->local = $this->getLocal();
            $this->usuario = $this->getUsuario();
            $this->imagenes = $this->getImagenes();
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
        $sql = 'SELECT p.*, IF(p.tipo = :tipo_venta AND va.id_venta_alquiler > 0, 1, 0) esta_vendida FROM propiedades p 
                LEFT JOIN ventas_alquileres va ON (p.id_propiedad = va.id_propiedad) GROUP BY p.id_propiedad';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':tipo_venta', self::TIPO_VENTA, \PDO::PARAM_INT);
        $consulta->execute();
        $arrLocals = $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);

        return $arrLocals;
    }

    public static function traerTodosSinVender() {

        $sql = 'SELECT * FROM propiedades WHERE id_propiedad NOT IN (SELECT id_propiedad FROM ventas_alquileres where tipo = :tipo)';

        $con = AccesoDatos::dameUnObjetoAcceso();
        $query = $con->retornarConsulta($sql);
        $con->bindValue(':tipo', self::TIPO_VENTA, \PDO::PARAM_INT);
        $con->execute();
        return $con->fetchAll(\PDO::FETCHA_CLASS, self::class);

    }

    public static function traerTodosSinAlquilar() {

        $sql = 'SELECT * FROM propiedades WHERE id_propiedad NOT IN (SELECT id_propiedad FROM ventas_alquileres where tipo = :tipo)';

        $con = AccesoDatos::dameUnObjetoAcceso();
        $query = $con->retornarConsulta($sql);
        $con->bindValue(':tipo', self::TIPO_ALQUILER, \PDO::PARAM_INT);
        $con->execute();
        return $con->fetchAll(\PDO::FETCHA_CLASS, self::class);

    }

    public static function traerTodoSinAlquilarOVender() {

        $sql = 'SELECT * FROM propiedades WHERE id_propiedad NOT IN (SELECT id_propiedad FROM ventas_alquileres where tipo IN(:tipo_alquiler, :tipo_venta))';

        $con = AccesoDatos::dameUnObjetoAcceso();
        $query = $con->retornarConsulta($sql);
        $con->bindValue(':tipo_alquiler', self::TIPO_ALQUILER, \PDO::PARAM_INT);
        $con->bindValue(':tipo_venta', self::TIPO_ALQUILER, \PDO::PARAM_INT);
        $con->execute();
        return $con->fetchAll(\PDO::FETCHA_CLASS, self::class);

    }

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO propiedades (`id_propiedad`, `id_local`, `id_usuario`, `nombre`, `direccion`, `precio`, `tipo`) VALUES (NULL, :id_local, :id_usuario, :nombre, :direccion, :precio, :tipo)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->local->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $obj->usuario->id_usuario, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':direccion', $obj->direccion, \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $obj->precio, \PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $obj->tipo, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function modificar($obj)
    {
        $sql = 'UPDATE propiedades SET id_local = :id_local, `id_usuario` = :id_usuario, nombre = :nombre, direccion = :direccion, precio = :precio, tipo = :tipo WHERE id_propiedad = :id_propiedad';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->local->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $obj->usuario->id_usuario, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':direccion', $obj->direccion, \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $obj->precio, \PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $obj->tipo, \PDO::PARAM_STR);
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

    public function getUsuario() {

        if ($this->id_usuario == null)
        {
            return false;
        }

        $sql = 'SELECT u.* FROM `usuarios` u WHERE u.id_usuario = :id_usuario';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_usuario', $this->id_usuario, \PDO::PARAM_STR);
        $consulta->execute();
        $usuario = $consulta->fetch(\PDO::FETCH_ASSOC);

        return $usuario ?: new \stdClass();

    }

    public function getImagenes() {

        if ($this->id_propiedad == null)
        {
            return false;
        }

        $sql = 'SELECT i.* FROM imagenes i
        LEFT JOIN propiedades_has_imagenes pi ON (pi.id_imagen = i.id_imagen)
        WHERE pi.id_propiedad = :id_propiedad';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_propiedad', $this->id_propiedad, \PDO::PARAM_STR);
        $consulta->execute();
        $imagenes = $consulta->fetchAll(\PDO::FETCH_CLASS, Imagen::class);

        return $imagenes;

    }

}
