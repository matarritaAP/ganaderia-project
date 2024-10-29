<?php
include_once "../data/unidadMedidaData.php";
include_once "../domain/unidadesMedida.php";

class UnidadMedidaBusiness
{
    private $unidadMedidaData;

    public function __construct()
    {
        $this->unidadMedidaData = new unidadMedidaData();
    }

    public function insertarUnidadMedida($unidadMedida)
{
    return $this->unidadMedidaData->insertarUnidadMedida($unidadMedida);
}


    public function actualizarUnidadMedida($tipoUnidadAntiguo, $tipoUnidadNuevo)
    {
        return $this->unidadMedidaData->actualizarUnidadMedida($tipoUnidadAntiguo, $tipoUnidadNuevo);
    }

    public function obtenerUnidadMedidaPorTipo($tipoUnidad)
    {
        return $this->unidadMedidaData->obtenerUnidadMedidaPorTipo($tipoUnidad);
    }

    public function consultarUnidadesMedidas()
    {
        return $this->unidadMedidaData->consultarUnidadesMedidas();
    }

    public function validarTipoUnidadRepetida($tipoUnidad)
    {
        return $this->unidadMedidaData->validarTipoUnidadRepetida($tipoUnidad);
    }

    public function eliminarUnidadMedida($tipoUnidad)
    {
        return $this->unidadMedidaData->eliminarUnidadMedida($tipoUnidad);
    }
}
?>
