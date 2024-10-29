<?php

include_once "../data/fincaHerramientaData.php";

class fincaHerramientaBusiness
{

    private $fincaHerramientaData;

    public function __construct()
    {
        $this->fincaHerramientaData = new fincaHerramientaData();
    }

    public function insertarFincaHerramienta($fincaServicio)
    {
        return $this->fincaHerramientaData->insertarFincaHerramienta($fincaServicio);
    }

    public function consultarHerramientasPorFinca($fincaId, $estado)
    {
        return $this->fincaHerramientaData->consultarHerramientasPorFinca($fincaId, $estado);
    }

    public function eliminarFincaHerramienta($fincaId, $servicioId)
    {
        return $this->fincaHerramientaData->eliminarFincaHerramienta($fincaId, $servicioId);
    }

    public function reactivarHerammientaFinca($fincaHerramienta)
    {
        return $this->fincaHerramientaData->reactivarHerammientaFinca($fincaHerramienta);
    }
}
