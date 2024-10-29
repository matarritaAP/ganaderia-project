<?php
class DataBase
{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $isActive;

    public function __construct()
    {
        // Obtiene el nombre del equipo
        $hostName = gethostname();

        // Configuracion del acceso a la bd
        $this->isActive = false;

        switch ($hostName) {
            case "aaron":
                $this->servername = "127.0.0.1";
                $this->username = "root";
                $this->password = "";
                $this->dbname = "dbganaderia";
                break;
            default:
                $this->servername = "127.0.1.1";
                $this->username = "root";
                $this->password = "";
                $this->dbname = "dbganaderia";
                break;
        }
    }

    public function conectar()
    {
        try {
            $con = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}
?>