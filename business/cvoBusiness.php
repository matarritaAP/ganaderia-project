<?php
include_once "../data/cvoData.php";

class cvoBusiness
{
    private $cvoData;

    public function __construct()
    {
        $this->cvoData = new cvoData();
    }

    public function insertarCVO($CVO, $productoID)
    {
        return $this->cvoData->insertarCVO($CVO, $productoID);
    }

    public function consultarCVO($productoID)
    {
        return $this->cvoData->consultarCVO($productoID);
    }

    public function consultarNumeroCVO($numero, $productoID)
    {
        return $this->cvoData->consultarNumeroCVO($numero, $productoID);
    }

    public function actualizarCVO($CVO, $productoID)
    {
        return $this->cvoData->actualizarCVO($CVO, $productoID);
    }

    public function validarNumeroCVO($numero, $productoID)
    {
        return $this->cvoData->validarNumeroCVO($numero, $productoID);
    }

    public function eliminarCVO($numero, $productoID)
    {
        return $this->cvoData->eliminarCVO($numero, $productoID);
    }
}
