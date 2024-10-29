<?php
include_once "../data/fincaProductorData.php";

class fincaProductorBusiness
{
    private $fincaProductorData;

    public function __construct()
    {
        $this->fincaProductorData = new fincaProductorData();
    }

    public function insertarFincaProductor($fincaProductor)
    {
        return $this->fincaProductorData->insertarFincaProductor($fincaProductor);
    }

    public function eliminarFincaProductor($finca, $productor)
    {
        return $this->fincaProductorData->eliminarFincaProductor($finca, $productor);
    }
}
