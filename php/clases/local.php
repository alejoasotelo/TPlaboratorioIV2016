<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;
use AlejoASotelo\Imagen;
use AlejoASotelo\Usuario;

class Local
{
    public $id_local;
    public $nombre;
    public $direccion;

    public $imagenes;
    public $encargado;
    public $empleados;

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
            $this->empleados = $this->getEmpleados();

        } else if ($this->id_local > 0) {

            $obj = Local::traerPorId($this->id_local, 'array');

            $this->nombre = $obj['nombre'];
            $this->direccion = $obj['direccion'];
            $this->imagenes = $this->getImagenes();
            $this->encargado = $this->getEncargado();
            $this->empleados = $this->getEmpleados();

        }
    }

    public static function traerPorId($id_local, $type = 'object')
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM locales WHERE id_local =:id_local");
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
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM locales");
        $consulta->execute();
        $arrLocals = $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);

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
        $consulta->execute();        

        if ($obj->encargado->id_usuario > 0) {
            $local_has_encargado = new LocalHasEncargado();
            $local_has_encargado->id_local = $obj->id_local;
            $local_has_encargado->id_usuario = $obj->encargado->id_usuario;

            LocalHasEncargado::borrarPorIdLocal($obj->id_local);
            LocalHasEncargado::insertar($local_has_encargado);
        }

        if (count($obj->empleados) > 0) {
            LocalHasEmpleados::borrarPorIdLocal($obj->id_local);  

            foreach ($obj->empleados as $e) {
                $local_has_empleado = new LocalHasEmpleados();
                $local_has_empleado->id_local = $obj->id_local;
                $local_has_empleado->id_usuario = isset($e->id_usuario) ? $e->id_usuario : $e;

                LocalHasEmpleados::insertar($local_has_empleado);
            }

        }
    }

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO locales (`id_local`, `nombre`, `direccion`) VALUES (NULL, :nombre, :direccion)';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':direccion', $obj->direccion, \PDO::PARAM_STR);
        $consulta->execute();
        $id_local = $objetoAccesoDato->retornarUltimoIdInsertado();

        if ($obj->encargado->id_usuario > 0) {
            $local_has_encargado = new LocalHasEncargado();
            $local_has_encargado->id_local = $id_local;
            $local_has_encargado->id_usuario = $obj->encargado->id_usuario;
            LocalHasEncargado::insertar($local_has_encargado);
        }

        if (count($obj->empleados) > 0) {

            foreach ($obj->empleados as $e) {
                $local_has_empleado = new LocalHasEmpleados();
                $local_has_empleado->id_local = $id_local;
                $local_has_empleado->id_usuario = $e;
                LocalHasEmpleados::insertar($local_has_empleado);                
            }
            
        }

        return $id_local;
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
        LEFT JOIN locales_has_encargado le ON (u.id_usuario = le.id_usuario)
        WHERE le.id_local = :id_local';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_local', $this->id_local, \PDO::PARAM_STR);
        $consulta->execute();
        $encargado = $consulta->fetchObject(Usuario::class);

        return $encargado ?: new \stdClass();

    }

    public function getEmpleados() {

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
        $empleados = $consulta->fetchAll(\PDO::FETCH_CLASS, Usuario::class);

        return count($empleados) > 0 ? $empleados : array();

    }
}
