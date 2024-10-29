<?php
include_once "../data/CVOProductorData.php";

class CVOProductorBusiness
{
    private $CVOProductorData;

    public function __construct() {
        $this->CVOProductorData = new CVOProductorData();
    }

    public function insertarCVOProductor($CVOProductor)
    {
        return $this->CVOProductorData->insertarCVOProductor($CVOProductor);
    }

    public function consultarCVOPorProductor($cedProductor)
    {
        return $this->CVOProductorData->consultarCVOPorProductor($cedProductor);
    }

    public function eliminarCVOProductor($numCVO, $cedProductor)
    {
        return $this->CVOProductorData->eliminarCVOProductor($numCVO, $cedProductor);
    }
}
