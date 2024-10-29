<?php

include_once "../data/productorData.php";

class ProductorBusiness
{

    private $productorData;

    public function __construct()
    {
        $this->productorData = new productorData();
    }

    public function insertarProductor($productor, $contrasenia)
    {
        return $this->productorData->insertarProductor($productor, $contrasenia);
    }

    public function consultarProductor()
    {
        return $this->productorData->consultarProductor();
    }

    public function eliminarProductor($codigo)
    {
        return $this->productorData->eliminarProductor($codigo);
    }

    public function consultarProductorPorID($productorID)
    {
        return $this->productorData->consultarProductorPorID($productorID);
    }

    public function actualizarProductor($productor)
    {
        return $this->productorData->actualizarProductor($productor);
    }

    public function ValidarDocumento($docIdentidad)
    {
        return $this->productorData->ValidarDocumento($docIdentidad);
    }

    public function ValidarEmail($email)
    {
        return $this->productorData->ValidarEmail($email);
    }
}
