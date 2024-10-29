<?php
include_once "../data/tipoMedicamentoData.php";
include_once "../domain/tipoMedicamento.php";

class tipoMedicamentoBusiness
{
    private $tipoMedicamentoData;

    public function __construct()
    {
        $this->tipoMedicamentoData = new tipoMedicamentoData();
    }

    public function insertarTipoMedicamento($tipoMedicamento)
    {
       return $this->tipoMedicamentoData->insertarTipoMedicamento($tipoMedicamento);
    }

    public function actualizarTipoMedicamento($tipoMedicamentoAntiguo, $tipoMedicamentoNuevo)
    {
        return $this->tipoMedicamentoData->actualizarTipoMedicamento($tipoMedicamentoAntiguo, $tipoMedicamentoNuevo);
    }

    public function obtenerTipoMedicamentoPorNombre($tipoMedicamentoNombre)
    {
        return $this->tipoMedicamentoData->obtenerTipoMedicamentoPorNombre($tipoMedicamentoNombre);
    }

    public function consultarTipoMedicamentos()
    {
        return $this->tipoMedicamentoData->consultarTipoMedicamentos();
    }

    public function validarTipoMedicamentoRepetido($tipoMedicamentoNombre)
    {
        return $this->tipoMedicamentoData->validarTipoMedicamentoRepetido($tipoMedicamentoNombre);
    }

    public function eliminarTipoMedicamento($tipoMedicamentoNombre)
    {
        return $this->tipoMedicamentoData->eliminarTipoMedicamento($tipoMedicamentoNombre);
    }
}
?>
