<?php
include_once '../data/database.php';

class ManejoSesionData {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function verificarUsuario($username) {
        $sql = $this->con->prepare("SELECT tbsesionrol, tbsesionproductorid, tbsesionadministradorid, tbsesionusuariocontrasenia FROM tbsesion WHERE tbsesionusuarionombre = ?");
        $sql->execute([$username]);
        return $sql->fetch();
    }
}
?>
