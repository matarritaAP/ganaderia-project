<?php
include_once "../data/fincaData.php";

class fincaBusiness
{
    private $fincaData;

    public function __construct()
    {
        $this->fincaData = new fincaData();
    }

    public function insertarFinca($finca)
    {
        return $this->fincaData->insertarFinca($finca);
    }

    public function consultarFinca($productor)
    {
        return $this->fincaData->consultarFinca($productor);
    }

    public function eliminarFinca($numPlano)
    {
        return $this->fincaData->eliminarFinca($numPlano);
    }

    public function consultarCodigoFinca($numPlano)
    {
        return $this->fincaData->consultarCodigoFinca($numPlano);
    }

    public function actualizarFinca($finca)
    {
        return $this->fincaData->actualizarFinca($finca);
    }

    public function validarCodigo($numPlano)
    {
        return $this->fincaData->validarCodigo($numPlano);
    }

    public function validarFincaParecidos($numPlano)
    {
        return $this->fincaData->validarFincaParecidos($numPlano);
    }

    public function obtenerFincaPorPlano($numPlano)
    {
        return $this->fincaData->obtenerFincaPorPlano($numPlano);
    }
}
