<?php
include_once 'database.php';

class SesionData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarSesionProductor($productor, $contrasenia, $nuevoProductor)
    {
        $con = $this->conectar();

        $email = $productor->getEmail();
        
        $tempsql = $con->prepare("SELECT MAX(tbsesionid) AS tbsesionid FROM tbsesion");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("
        INSERT INTO tbsesion
            (tbsesionid, tbsesionrol, tbsesionproductorid, tbsesionadministradorid, tbsesionusuarionombre, tbsesionusuariocontrasenia, tbsesionusuarioestado) 
        VALUES (?, ?, ?, ?, ?, ?, ?) 
        ");

        return $sql->execute(array(
            $tempid[0] + 1,
            'PRODUCTOR',
            $nuevoProductor,
            null,
            $email,
            $contrasenia,
            1,
        ));
    }

    public function verificarUsuario($username)
    {
        $con = $this->conectar();
        if ($con) {
            $sqlSesion = $con->prepare("SELECT tbsesionid, tbsesionrol, tbsesionproductorid, tbsesionusuariocontrasenia, tbsesionusuarioestado 
                                        FROM tbsesion WHERE tbsesionusuarionombre = ?");
            $sqlSesion->execute([$username]);
            return $sqlSesion->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }
}
