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
        $this->servername = "junction.proxy.rlwy.net"; // Host de Railway
        $this->username = "root"; // Usuario de Railway
        $this->password = "IpYmzAvIOqOggTlQmbBFNouhuizHvYWz"; // Contraseña de Railway
        $this->dbname = "dbganaderia"; // Nombre de la base de datos en Railway
        $this->port = 32169; // Puerto de Railway
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
