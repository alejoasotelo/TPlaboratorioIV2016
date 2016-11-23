<?php
namespace AlejoASotelo;

class AccesoDatos
{
    private static $objetoAccesoDatos;
    private $objetoPDO;

    private function __construct()
    {
        try {
            $this->objetoPDO = new \PDO('mysql:host=localhost;dbname=tp_laboratorio_4;charset=utf8', 'root', '', array(\PDO::ATTR_EMULATE_PREPARES => false, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            $this->objetoPDO->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    public function retornarConsulta($sql)
    {
        return $this->objetoPDO->prepare($sql);
    }
    
    public function retornarUltimoIdInsertado()
    {
        return $this->objetoPDO->lastInsertId();
    }

    public static function dameUnObjetoAcceso()
    {
        if (!isset(self::$objetoAccesoDatos)) {
            self::$objetoAccesoDatos = new self;
        }
        return self::$objetoAccesoDatos;
    }

     // Evita que el objeto se pueda clonar
    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
}
