<?php
namespace AlejoASotelo;

use AlejoASotelo\AccessoDatos;

class Oferta{
    
    public $id_oferta;
    public $id_propiedad;
    public $id_local;
    public $nombre;
    public $descripcion;
    public $precio;
    public $descuento;

    public function __construct($id_oferta = null)
    {
        if ($id_oferta != null) {

            $obj = self::traerPorId($id_oferta);

            $this->id_oferta = $id_oferta;
            $this->id_propiedad = $obj->id_propiedad;
            $this->id_local = $obj->id_local;
            $this->nombre = $obj->nombre;
            $this->descripcion = $obj->descripcion;
            $this->precio = $obj->precio;
            $this->descuento = $obj->descuento;
            $this->propiedad = $this->getPropiedad();

        } else if ($this->id_local > 0) {

            $obj = self::traerPorId($this->id_oferta, 'array');

            $this->id_oferta = $obj['id_oferta'];
            $this->id_propiedad = $obj['id_propiedad'];
            $this->id_local = $obj['id_local'];
            $this->nombre = $obj['nombre'];
            $this->descripcion = $obj['descripcion'];
            $this->precio = $obj['precio'];
            $this->descuento = $obj['descuento'];
            $this->propiedad = $this->getPropiedad();
        }
    }

    public static function traerPorId($id_oferta, $type = 'object')
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM ofertas WHERE id_oferta =:id_oferta");
        $consulta->bindValue(':id_oferta', $id_oferta, \PDO::PARAM_INT);
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
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM ofertas");
        $consulta->execute();
        $arrLocals = $consulta->fetchAll(\PDO::FETCH_CLASS, self::class);

        return $arrLocals;
    }

    public static function insertar($obj)
    {
        $sql = 'INSERT INTO ofertas (`id_oferta`, `id_propiedad`, `id_local`, `nombre`, `descripcion`, `precio`, `descuento`) VALUES (NULL, :id_propiedad, :id_local, :nombre, :descripcion, :precio, :descuento)';

        $propiedad = Propiedad::traerPorId($obj->propiedad->id_propiedad);
        $precio = isset($obj->precio) ? (float)$obj->precio : 0;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_propiedad', $propiedad->id_propiedad, \PDO::PARAM_STR);
        $consulta->bindValue(':id_local', $propiedad->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', !empty($obj->descripcion) ? $obj->descripcion : '', \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $precio, \PDO::PARAM_STR);
        $consulta->bindValue(':descuento', (float)$obj->descuento, \PDO::PARAM_STR);
        $consulta->execute();

        return $objetoAccesoDato->retornarUltimoIdInsertado();
    }

    public static function modificar($obj)
    {
        $sql = 'UPDATE ofertas SET id_propiedad = :id_propiedad, id_local = :id_local, nombre = :nombre, descripcion = :descripcion, precio = :precio, descuento = :descuento WHERE id_oferta = :id_oferta';

        $propiedad = Propiedad::traerPorId($obj->propiedad->id_propiedad);
        $precio = isset($obj->precio) ? (float)$obj->precio : 0;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_propiedad', $propiedad->id_propiedad, \PDO::PARAM_STR);
        $consulta->bindValue(':id_local', $propiedad->id_local, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $obj->nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', !empty($obj->descripcion) ? $obj->descripcion : '', \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $precio, \PDO::PARAM_STR);
        $consulta->bindValue(':descuento', $obj->descuento, \PDO::PARAM_STR);
        $consulta->bindValue(':id_oferta', $obj->id_oferta, \PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function borrar($id)
    {
        if (is_numeric($id)) {
            $id = array($id);
        }

        $sql = 'DELETE FROM ofertas WHERE id_oferta IN ('.implode(',', $id).')';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->retornarConsulta($sql);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function getPropiedad() {

        if ($this->id_propiedad == null)
        {
            return false;
        }

        $sql = 'SELECT p.* FROM `propiedades` p WHERE p.id_propiedad = :id_propiedad';

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta($sql);
        $consulta->bindValue(':id_propiedad', $this->id_propiedad, \PDO::PARAM_STR);
        $consulta->execute();
        $encargado = $consulta->fetchObject(Propiedad::class);

        return $encargado ?: new \stdClass();

    }

}