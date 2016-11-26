<?php
namespace AlejoASotelo;

class AccesoDatos
{
    private static $objetoAccesoDatos;
    private $objetoPDO;

    private $whitelist = array(
        '127.0.0.1', 
        "::1",
        'localhost');

    private function __construct()
    {
        try {

            if ($this->isLocalhost()) {
                $this->objetoPDO = new \PDO('mysql:host=localhost;dbname=alejo_lab4;charset=utf8', 'root', '', array(\PDO::ATTR_EMULATE_PREPARES => false, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));                
            } else {
                $this->objetoPDO = new \PDO('mysql:host=localhost;dbname=alejo_lab4;charset=utf8', 'alejo_lab4', 'Labo2016', array(\PDO::ATTR_EMULATE_PREPARES => false, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            }

            $this->objetoPDO->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    protected function isLocalhost() {

        return in_array($_SERVER['REMOTE_ADDR'], $this->whitelist);

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
