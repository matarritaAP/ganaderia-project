<?php

include_once "../data/estadoProductorData.php";

class estadoProductorBusiness
{

    private $estadoProductorData;

    public function __construct()
    {
        $this->estadoProductorData = new estadoProductorData();
    }

    public function insertarEstadoProductor($estadoProductor)
    {
        return $this->estadoProductorData->insertarEstadoProductor($estadoProductor);
    }


    public function consultarEstadosPorProductor($cedProductor, $estado)
    {
        return $this->estadoProductorData->consultarEstadosPorProductor($cedProductor, $estado);
    }

    public function eliminarEstadoProductor($cedProductor, $codEstado)
    {
        return $this->estadoProductorData->eliminarEstadoProductor($cedProductor, $codEstado);
    }

    public function reactivarEstadoProductor($estadoProductor)
    {
        return $this->estadoProductorData->reactivarEstadoProductor($estadoProductor);
    }
}
