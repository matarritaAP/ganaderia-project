<?php

include_once "../domain/razaProductor.php";
include_once "../data/database.php";

class razaProductorData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function verificarRazaProductor($razaProductor, $estadoRaza)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT COUNT(*) as count
        FROM tbrazaproductor
        WHERE tbrazaproductorcedproductor = ? AND tbrazaproductorcodraza = ? AND tbrazaproductorestado = ?");
        $sql->execute(array($razaProductor->getCedProductor(), $razaProductor->getCodRaza(), $estadoRaza));

        $result = $sql->fetch();
        return $result['count'] > 0;
    }

    public function activarRazaProductor($razaProductor)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        UPDATE tbrazaproductor
        SET tbrazaproductorestado = 1 
        WHERE  tbrazaproductorcedproductor = ? AND tbrazaproductorcodraza = ?");
        return $sql->execute(array($razaProductor->getCedProductor(), $razaProductor->getCodRaza()));
    }

    public function insertarRazaProductor($razaProductor)
    {
        // Verificar si ya existe un registro activo
        if ($this->verificarRazaProductor($razaProductor, 1)) {
            return false; // Ya existe esa raza como favorita
        }

        // Verificar si ya existe un registro inactivo
        if ($this->verificarRazaProductor($razaProductor, 0)) {
            return $this->activarRazaProductor($razaProductor); // Activar el registro inactivo
        }

        $con = $this->conectar();

        $codRaza = $razaProductor->getCodRaza();
        $cedProductor = $razaProductor->getCedProductor();

        $tempsql = $con->prepare("SELECT MAX(tbrazaproductorid) AS tbrazaproductorid FROM tbrazaproductor");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbrazaproductor (tbrazaproductorid, tbrazaproductorcodraza, tbrazaproductorcedproductor, tbrazaproductorestado) VALUES (?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $codRaza,
            $cedProductor,
            1
        ));
    }

    public function consultarRazasPorProductor($cedProductor, $estado)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT 
            tbraza.tbrazacodigo,
            tbraza.tbrazanombre,
            tbraza.tbrazadescripcion
        FROM tbraza
        INNER JOIN 
            tbrazaproductor ON tbraza.tbrazacodigo = tbrazaproductor.tbrazaproductorcodraza
        WHERE
            tbrazaproductor.tbrazaproductorcedproductor = ?
        AND
            tbrazaproductor.tbrazaproductorestado = ?");
        $sql->execute(array($cedProductor, $estado));

        $razaProductorList = array();
        foreach ($sql->fetchAll() as $data) {
            $razaProductorList[] = array(
                "codRaza" => $data['tbrazacodigo'],
                "descripcionRaza" => $data["tbrazadescripcion"],
                "nombreRaza" => $data['tbrazanombre']
            );
        }

        $jsonString = json_encode($razaProductorList);
        return $jsonString;
    }


    public function eliminarRazaProductor($cedProductor, $codRaza)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbrazaproductor SET tbrazaproductorestado=? WHERE tbrazaproductorcedproductor=? AND tbrazaproductorcodraza=?");
        return $sql->execute(array(0, $cedProductor, $codRaza));
    }

    public function reactivarRazaProductor($razaProductor)
    {
        if ($this->verificarRazaProductor($razaProductor, 0)) {
            return $this->activarRazaProductor($razaProductor);
        }
    }

    public function obtenerIdRaza($codRaza)
    {
        $con = $this->conectar();

        $sql = $con->prepare("SELECT tbrazaproductorid FROM tbrazaproductor WHERE tbrazaproductorcodraza = ?");
        $sql->execute(array($codRaza));

        $result = $sql->fetch();
        return $result ? $result['tbrazaproductorid'] : null; // Devuelve el ID o null si no se encuentra
    }
}
