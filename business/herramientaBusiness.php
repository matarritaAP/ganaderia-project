<?php

include_once "../data/herramientaData.php";

class herramientaBusiness
{

    private $herramientaData;

    public function __construct()
    {
        $this->herramientaData = new herramientaData();
    }

    public function insertarHerramienta($herramienta)
    {
        return $this->herramientaData->insertarHerramienta($herramienta);
    }

    public function consultarHerramienta($estado, $usuarioID, $actualUserType, $herramientaPropia)
    {
        return $this->herramientaData->consultarHerramienta($estado, $usuarioID, $actualUserType, $herramientaPropia);
    }

    public function eliminarHerramienta($codigo)
    {
        return $this->herramientaData->eliminarHerramienta($codigo);
    }

    public function consultarcodigoherramienta($codigo)
    {
        return $this->herramientaData->consultarcodigoherramienta($codigo);
    }

    public function actualizarHerramienta($herramienta)
    {
        return $this->herramientaData->actualizarHerramienta($herramienta);
    }

    public function ValidarCodigo($codigo)
    {
        return $this->herramientaData->ValidarCodigo($codigo);
    }

    public function ValidarHerramientasParecidas($nombre)
    {
        return $this->herramientaData->ValidarHerramientasParecidas($nombre);
    }

    public function generarCodigoUnico($nombre, $descripcion){
        return $this->herramientaData->generarCodigoUnico($nombre, $descripcion);
    }

    public function consultarHerramientaPorCodigo($codigo)
    {
        return $this->herramientaData->consultarHerramientaPorCodigo($codigo);
    }

    public function reactivarHerramienta($codigo){
        return $this->herramientaData->reactivarHerramienta($codigo);
    }
}
