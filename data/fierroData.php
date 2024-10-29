<?php

include_once "../domain/fierro.php";
include_once "../data/database.php";

class fierroData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarFierro($fierro, $user_id)
    {
        $con = $this->conectar();

        $numero = $fierro->getNumeroFierro();
        $fEmision = $fierro->getFechaEmision();
        $fVencimiento = $fierro->getFechaVencimiento();
        $imagen = $fierro->getImagen();

        $tempsql = $con->prepare("SELECT MAX(tbfierroid) AS tbfierroid FROM tbfierro");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbfierro(tbfierroid, tbfierronumero, tbfierrofechaemision, tbfierrofechavencimiento,
         tbfierroimagen, tbestado) 
         VALUES (?,?,?,?,?,?)");
        $x = $sql->execute(array(
            $tempid[0] + 1,
            $numero,
            $fEmision,
            $fVencimiento,
            $imagen,
            1
        ));
        //return $x;
        if($x == "1"){
            $tempsql = $con->prepare("SELECT MAX(tbproductorfierroid) AS tbproductorfierroid FROM tbproductorfierro");
            $tempsql->execute();
            $tempid = $tempsql->fetch();
            $sql = $con->prepare("INSERT INTO tbproductorfierro(tbproductorfierroid, tbproductorid, tbfierroid, tbproductorfierroestado) 
            VALUES (?,?,?,?)");
            return $sql->execute(array(
                $tempid[0] + 1,
                $user_id,
                $numero,
                1
            ));
        }
    }

    public function consultarFierro($user_id)
    {
        $fierroList = array();
        $con = $this->conectar();
        if ($con) {
            $sql = $con->prepare("
            SELECT f.tbfierronumero, f.tbfierrofechaemision, f.tbfierrofechavencimiento, f.tbfierroimagen
            FROM tbfierro f
            INNER JOIN tbproductorfierro p ON f.tbfierronumero = p.tbfierroid
            WHERE p.tbproductorid = ? AND f.tbestado = 1
        ");
            $sql->execute([$user_id]);
            foreach ($sql->fetchAll() as $data) {
                $fierroList[] = array(
                    "tbfierronumero" => $data['tbfierronumero'],
                    "tbfierrofechaemision" => $data['tbfierrofechaemision'],
                    "tbfierrofechavencimiento" => $data['tbfierrofechavencimiento'],
                    "tbfierroimagen" => $data['tbfierroimagen']
                );
            }
        }
        $jsonString = json_encode($fierroList);
        return $jsonString;
    }


    public function eliminarFierro($codigo)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbfierro SET tbestado=? WHERE tbfierronumero=?");
        return $sql->execute(array(0, $codigo));
    }

    public function consultarcodigoFierro($codigo)
    {
        $productorList = array();
        $con = $this->conectar();
        if ($con) {
            $sql = $con->prepare("SELECT * FROM tbfierro WHERE tbfierronumero=?");
            $sql->execute(array($codigo));
            foreach ($sql->fetchAll() as $data) {
                $productorList[] = array(
                    "tbfierronumero" => $data['tbfierronumero'],
                    "tbfierrofechaemision" => $data['tbfierrofechaemision'],
                    "tbfierrofechavencimiento" => $data['tbfierrofechavencimiento'],
                    "tbfierroimagen" => $data['tbfierroimagen']
                );
            }
        }
        $jsonString = json_encode($productorList);
        return $jsonString;
    }

    public function actualizarFierro($fierro, $renovar)
    {
        $con = $this->conectar();

        $numero = $fierro->getNumeroFierro();
        $fEmision = $fierro->getFechaEmision();
        $fVencimiento = $fierro->getFechaVencimiento();
        $imagen = $fierro->getImagen();
        
        if($renovar == "1"){
            
            $tempsql = $con->prepare("SELECT MAX(tbhistoricoid ) AS tbhistoricoid FROM tbhistoricofierro");
            $tempsql->execute();
            $tempid = $tempsql->fetch();
            $newId = $tempid[0] + 1;

            $sqlInsert = $con->prepare("INSERT INTO tbhistoricofierro (tbhistoricoid, tbhistoriconumero, tbhistoricofechaemision, tbhistoricofechavencimiento)
            SELECT ?, tbfierronumero, tbfierrofechaemision, tbfierrofechavencimiento
            FROM tbfierro WHERE tbfierronumero=?");
            
            $sqlInsert->execute(array(
                $tempid[0] + 1,
                $numero,
            ));

            $sql = $con->prepare("UPDATE tbfierro SET tbfierrofechaemision=?, tbfierrofechavencimiento=?, tbfierroimagen=? 
            WHERE tbfierronumero=?");
            return $sql->execute(array(         
                $fEmision,
                $fVencimiento,
                $imagen,
                $numero
            ));
        }
        if($renovar == "0"){
            $sql = $con->prepare("UPDATE tbfierro SET tbfierrofechaemision=?, tbfierrofechavencimiento=?, tbfierroimagen=? 
            WHERE tbfierronumero=?");
            return $sql->execute(array(         
                $fEmision,
                $fVencimiento,
                $imagen,
                $numero
            ));
        }   
    }

    public  function ValidarDocumento($docIdentidad)
    {
       $con = $this->conectar();
         $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbfierro WHERE tbproductordocidentidad = ?), 1, 0) AS resultado");
        $sql->execute(array($docIdentidad));
        return $sql->fetchColumn();
    }

}

