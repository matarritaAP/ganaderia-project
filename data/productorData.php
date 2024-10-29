<?php

include_once "../domain/Productor.php";
include_once "../data/database.php";
include_once "../data/sesionData.php";
class ProductorData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarProductor($productor, $contrasenia)
    {
        $sesionData = new SesionData();
        $con = $this->conectar();

        $docIdentidad = $productor->getDocIdentidad();
        $nombreGanaderia = $productor->getNombreGanaderia();
        $nombre = $productor->getNombre();
        $primerApellido = $productor->getPrimerApellido();
        $segundoApellido = $productor->getSegundoApellido();
        $fechaNacimiento = $productor->getFechaNacimiento();
        $email = $productor->getEmail();
        $telefono = $productor->getTelefono();
        $direccion = $productor->getDireccion();

        $tempsql = $con->prepare("SELECT MAX(tbproductorid) AS tbproductorid FROM tbproductor");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbproductor(tbproductorid, tbproductordocidentidad, tbproductornombreganaderia, tbproductornombre, tbproductorprimerapellido,
            tbproductorsegundoapellido, tbproductorfechanac, tbproductoremail, tbproductorcelular, tbproductordireccion, tbproductorcontrasenia, tbproductorestado) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");


        $nuevoProductor = $tempid[0] + 1;
        $sesionData->insertarSesionProductor($productor, $contrasenia, $nuevoProductor);
        return $sql->execute(array(
            $tempid[0] + 1,
            $docIdentidad,
            $nombreGanaderia,
            $nombre,
            $primerApellido,
            $segundoApellido,
            $fechaNacimiento,
            $email,
            $telefono,
            $direccion,
            $contrasenia,
            1,
        ));
    }

    public function consultarProductor()
    {
        $productorList = array();
        $con = $this->conectar();
        if ($con) {
            $sql = $con->query("SELECT * FROM  tbproductor WHERE tbproductorestado=1");
            foreach ($sql->fetchAll() as $data) {
                $productorList[] = array(
                    "tbproductordocidentidad" => $data['tbproductordocidentidad'],
                    "tbproductornombreganaderia" => $data['tbproductornombreganaderia'],
                    "tbproductornombre" => $data['tbproductornombre'],
                    "tbproductorprimerapellido" => $data['tbproductorprimerapellido'],
                    "tbproductorsegundoapellido" => $data['tbproductorsegundoapellido'],
                    "tbproductorfechanac" => $data['tbproductorfechanac'],
                    "tbproductoremail" => $data['tbproductoremail'],
                    "tbproductorcelular" => $data['tbproductorcelular'],
                    "tbproductordireccion" => $data['tbproductordireccion']
                );
            }
        }
        $jsonString = json_encode($productorList);
        return $jsonString;
    }


    public function eliminarProductor($codigo)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbproductor SET tbproductorestado=? WHERE tbproductordocidentidad=?");
        return $sql->execute(array(0, $codigo));
    }

    public function consultarProductorPorID($productorID)
    {
        $con = $this->conectar();
        if ($con) {
            $sql = $con->prepare("SELECT * FROM tbproductor WHERE tbproductorid=?");
            $sql->execute(array($productorID));
            $data = $sql->fetch();

            $productor = array(
                "tbproductordocidentidad" => $data['tbproductordocidentidad'],
                "tbproductornombreganaderia" => $data['tbproductornombreganaderia'],
                "tbproductornombre" => $data['tbproductornombre'],
                "tbproductorprimerapellido" => $data['tbproductorprimerapellido'],
                "tbproductorsegundoapellido" => $data['tbproductorsegundoapellido'],
                "tbproductorfechanac" => $data['tbproductorfechanac'],
                "tbproductoremail" => $data['tbproductoremail'],
                "tbproductorcelular" => $data['tbproductorcelular'],
                "tbproductordireccion" => $data['tbproductordireccion']
            );

            return json_encode($productor);
        }
    }


    public function actualizarProductor($productor)
    {
        $con = $this->conectar();

        $docIdentidad = $productor->getDocIdentidad();
        $nombreGanaderia = $productor->getNombreGanaderia();
        $nombre = $productor->getNombre();
        $primerApellido = $productor->getPrimerApellido();
        $segundoApellido = $productor->getSegundoApellido();
        $fechaNacimiento = $productor->getFechaNacimiento();
        $email = $productor->getEmail();
        $telefono = $productor->getTelefono();
        $direccion = $productor->getDireccion();

        $sql = $con->prepare("UPDATE tbproductor SET tbproductornombreganaderia=?, tbproductornombre=?, tbproductorprimerapellido=?,
         tbproductorsegundoapellido=?, tbproductorfechanac=?, tbproductoremail=?, tbproductorcelular=?, tbproductordireccion=? 
         WHERE tbproductordocidentidad=?");
        return $sql->execute(array(
            $nombreGanaderia,
            $nombre,
            $primerApellido,
            $segundoApellido,
            $fechaNacimiento,
            $email,
            $telefono,
            $direccion,
            $docIdentidad
        ));
    }

    public  function ValidarDocumento($docIdentidad)
    {
        $con = $this->conectar();
        $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbproductor WHERE tbproductordocidentidad = ?), 1, 0) AS resultado");
        $sql->execute(array($docIdentidad));
        return $sql->fetchColumn();
    }

    public  function ValidarEmail($email)
    {
        $con = $this->conectar();
        $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbproductor WHERE tbproductoremail = ?), 1, 0) AS resultado");
        $sql->execute(array($email));
        return $sql->fetchColumn();
    }
}
