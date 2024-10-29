<?php
class DataBase
{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $port;
    public $isActive;

    public function __construct()
    {
        // Configuración del acceso a la base de datos
        $this->isActive = false;

        // Conexión remota a Railway
        $this->servername = getenv('DB_HOST');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
        $this->dbname = getenv('DB_NAME');
        $this->port = getenv('DB_PORT');
    }

    public function conectar()
    {
        try {
            // Conectar usando PDO
            $con = new PDO("mysql:host={$this->servername};port={$this->port};dbname={$this->dbname}", $this->username, $this->password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}
