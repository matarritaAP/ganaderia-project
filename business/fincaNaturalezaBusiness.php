<?php
include_once "../data/fincaNaturalezaData.php";

class fincaNaturalezaBusiness
{
    private $fincaNaturalezaData;

    public function __construct()
    {
        $this->fincaNaturalezaData = new fincaNaturalezaData();
    }

    public function insertarFincaNaturaleza($fincaNaturaleza)
    {
        return $this->fincaNaturalezaData->insertarFincaNaturaleza($fincaNaturaleza);
    }

    public function consultarNaturalezaPorFinca($fincaId, $estado)
    {
        return $this->fincaNaturalezaData->consultarNaturalezaPorFinca($fincaId, $estado);
    }

    public function eliminarFincaNaturaleza($finca, $productor)
    {
        return $this->fincaNaturalezaData->eliminarFincaNaturaleza($finca, $productor);
    }

    public function reactivarNaturalezaFinca($fincaNaturaleza)
    {
        return $this->fincaNaturalezaData->reactivarNaturalezaFinca($fincaNaturaleza);
    }
}
