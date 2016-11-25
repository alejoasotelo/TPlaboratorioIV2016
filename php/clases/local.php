<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;
use AlejoASotelo\Imagen;

class Local
{
    public $id_local;
    public $nombre;
    public $direccion;

    public $imagenes;
    public $encargado;

    protected $data;

    public function __construct($id_local = null)
    {
        $this->data = array();

        if ($id_local != null) {

            $obj = Local::traerPorId($id_local);

            $this->id_local = $id_local;
            $this->nombre = $obj->nombre;
            $this->direccion = $obj->direccion;
            $this->imagenes = $this->getImagenes();
            $this->encargado = $this->getEncargado();

        } else if ($this->id_local > 0) {

            $obj = Local::traerPorId($this->id_local, 'array');

            $this->nombre = $obj['nombre'];
            $this->direccion = $obj['direccion'];
            $this->imagenes = $this->getImagenes();
            $this->encargado = $this->getEncargado();

        }
    }

    /*public function __get($name) {

        if (isset($this->data[$name]) && $this->data[$name] != null) {
            return $this->data[$name];
        }

        switch ($name) {
            case 'imagenes':
                
                $this->data[$name] = $this->getImagenes();
                $this->{$name} = $this->data[$name];

                return $this->data[$name];

                break;

            case 'encargado':
                
                $this->data[$name] = $this->getEncargado();
                $this->{$name} = $this->data[$name];

                return $this->data[$name];

                break;
            
            default:
                # code...
                break;
        }

    }*/

    public static function traerPorId($id_local, $type = 'object')
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta("SELECT * FROM locales WHERE id_local =:id_local");
        $consulta->bindValue(':id_local', $id_local, \PDO::PARAM_INT);
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
        $consulta =$objetoAccesoDato->retornarConsulta("SELECT * FROM locales");
        $consulta->execute();
        $arrLocals = $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);

        /*foreach ($arrLocals as &$r) {
            $r->imagenes = $r->getImagenes();
            $r->encargado = $r->getEncargado();
        }*/

        return $arrLocals;
    }

    public static function borrar($id_local)
    {
        if (is_numeric($id_local)) {
            $id_local = array($id_local);
        }

        $sql = 'DELETE FROM locales WHERE id_local IN ('.implode(',', $id_local).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function modificar($obj)
    {
        $sql = 'UPDATE locales SET nombre = :nombre, direccion = :direccion WHERE id_local = :id_local';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $obj->id_local, \PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':direccion', $obj->direccion, \PDO::PARAM_STR);
        return $consulta->execute();
    }

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO locales (`id_local`, `nombre`, `direccion`) VALUES (NULL, :nombre, :direccion)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':direccion', $obj->direccion, \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public function getImagenes() {

        if ($this->id_local == null)
        {
            return false;
        }

        $sql = 'SELECT i.* FROM imagenes i
        LEFT JOIN locales_has_imagenes li ON (li.id_imagen = i.id_imagen)
        WHERE li.id_local = :id_local';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $this->id_local, \PDO::PARAM_STR);
        $consulta->execute();
        $imagenes = $consulta->fetchAll(\PDO::FETCH_CLASS, Imagen::class);

        return $imagenes;

    }

    public function getEncargado() {

        if ($this->id_local == null)
        {
            return false;
        }

        $sql = 'SELECT u.* FROM `usuarios` u
        LEFT JOIN locales_has_empleados le ON (u.id_usuario = le.id_usuario)
        WHERE le.id_local = :id_local';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $this->id_local, \PDO::PARAM_STR);
        $consulta->execute();
        $encargado = $consulta->fetchObject(Usuario::class);

        return $encargado;

    }
}
