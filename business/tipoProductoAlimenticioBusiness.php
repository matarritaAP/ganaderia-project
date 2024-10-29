<?php

include_once "../data/tipoProductoAlimenticioData.php";

class tipoProductoAlimenticioBusiness
{

    private $tipoProductoAlimenticioData;

    public function __construct()
    {
        $this->tipoProductoAlimenticioData = new tipoProductoAlimenticioData();
    }

    public function insertarTipoProductoAlimenticio($tipoProductoAlimenticio)
    {
        return $this->tipoProductoAlimenticioData->insertarTipoProductoAlimenticio($tipoProductoAlimenticio);
    }

    public function consultarTipoProductoAlimenticio()
    {
        return $this->tipoProductoAlimenticioData->consultarTipoProductoAlimenticio();
    }

    public function eliminarTipoProductoAlimenticio($nombre, $descripcion)
    {
        return $this->tipoProductoAlimenticioData->eliminarTipoProductoAlimenticio($nombre, $descripcion);
    }

    public function actualizarTipoProductoAlimenticio($nombreAntiguo, $descripcionAntigua, $tipoProductoAlimenticioNuevo)
    {
        return $this->tipoProductoAlimenticioData->actualizarTipoProductoAlimenticio($nombreAntiguo, $descripcionAntigua, $tipoProductoAlimenticioNuevo);
    }

    public function validarTiposProductoAlimenticioParecidos($nombre)
    {
        return $this->tipoProductoAlimenticioData->validarTiposProductoAlimenticioParecidos($nombre);
    }

    public function obtenerIdPorNombreYDescripcion($nombre, $descripcion)
    {
        return  $this->tipoProductoAlimenticioData->obtenerIdPorNombreYDescripcion($nombre, $descripcion);
    }
}
