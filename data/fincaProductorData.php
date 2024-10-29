<?php
include_once "../domain/fincaProductor.php";
include_once "../data/database.php";

class fincaProductorData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarFincaProductor($fincaProductor)
    {
        $con = $this->conectar();

        $finca = $fincaProductor->getFinca();
        $productor = $fincaProductor->getProductor();

        $tempsql = $con->prepare("SELECT MAX(tbfincaproductorid) AS tbfincaproductorid FROM tbfincaproductor");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbfincaproductor(tbfincaproductorid,tbfincaproductorproductorid,
            tbfincaproductorfincaid,tbfincaproductorestado) VALUES (?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $finca,
            $productor,
            1
        ));
    }

    public function eliminarFincaProductor($finca, $productor)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        UPDATE 
            tbfincaproductor 
        SET 
            tbfincaproductorestado=? 
        WHERE 
            tbfincaproductorfincaid=? AND tbfincaproductorproductorid=?");
        return $sql->execute(array(0, $finca, $productor));
    }
}
