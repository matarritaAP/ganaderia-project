<?php

include_once "../data/razaProductorData.php";

class RazaProductorBusiness
{

    private $razaProductorData;

    public function __construct()
    {
        $this->razaProductorData = new razaProductorData();
    }

    public function insertarRazaProductor($razaProductor)
    {
        return $this->razaProductorData->insertarRazaProductor($razaProductor);
    }


    public function consultarRazasPorProductor($cedProductor, $estado)
    {
        return $this->razaProductorData->consultarRazasPorProductor($cedProductor, $estado);
    }

    public function eliminarRazaProductor($codRaza, $cedProductor)
    {
        return $this->razaProductorData->eliminarRazaProductor($codRaza, $cedProductor);
    }

    public function reactivarRazaProductor($razaProductor)
    {
        return $this->razaProductorData->reactivarRazaProductor($razaProductor);
    }
}
