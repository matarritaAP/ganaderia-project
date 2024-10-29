<?php

include_once "../data/fincaServicioData.php";

class fincaServicioBusiness
{

    private $fincaServicioData;

    public function __construct()
    {
        $this->fincaServicioData = new fincaServicioData();
    }

    public function insertarFincaServicio($fincaServicio)
    {
        return $this->fincaServicioData->insertarFincaServicio($fincaServicio);
    }

    public function consultarServiciosPorFinca($fincaId, $estado)
    {
        return $this->fincaServicioData->consultarServiciosPorFinca($fincaId, $estado);
    }

    public function eliminarFincaServicio($fincaId, $servicioId)
    {
        return $this->fincaServicioData->eliminarFincaServicio($fincaId, $servicioId);
    }

    public function reactivarServicioFinca($fincaHerramienta)
    {
        return $this->fincaServicioData->reactivarServicioFinca($fincaHerramienta);
    }
}
