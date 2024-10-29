<?php
include_once "../data/naturalezaData.php";

class naturalezaBusiness
{
    private $naturalezaData;

    public function __construct()
    {
        $this->naturalezaData = new naturalezaData();
    }
    public function generarCodigoUnico($nombre, $descripcion, $usuarioID)
    {
        return $this->naturalezaData->generarCodigoUnico($nombre, $descripcion, $usuarioID);
    }

    public function insertarNaturaleza($naturaleza, $actualUserType)
    {
        return $this->naturalezaData->insertarNaturaleza($naturaleza, $actualUserType);
    }

    public function consultarNaturaleza($estado, $usuarioID, $manejoActual)
    {
        return $this->naturalezaData->consultarNaturaleza($estado, $usuarioID, $manejoActual);
    }

    public function consultarNaturalezasInactivas($actualUserType, $usuarioID, $manejoActual)
    {
        return $this->naturalezaData->consultarNaturalezasInactivas($actualUserType, $usuarioID, $manejoActual);
    }

    public function eliminarNaturaleza($codigo, $actualUserType, $usuarioID)
    {
        return $this->naturalezaData->eliminarNaturaleza($codigo, $actualUserType, $usuarioID);
    }

    public function consultarCodigoNaturaleza($codigo, $actualUserType, $usuarioID)
    {
        return $this->naturalezaData->consultarCodigoNaturaleza($codigo, $actualUserType, $usuarioID);
    }

    public function actualizarNaturaleza($naturaleza, $actualUserType, $usuarioID)
    {
        return $this->naturalezaData->actualizarNaturaleza($naturaleza, $actualUserType, $usuarioID);
    }

    public function validarCodigo($codigo, $actualUserType, $usuarioID)
    {
        return $this->naturalezaData->validarCodigo($codigo, $actualUserType, $usuarioID);
    }

    public function validarNaturalezaParecidos($nombre, $actualUserType, $usuarioID)
    {
        return $this->naturalezaData->validarNaturalezaParecidos($nombre, $actualUserType, $usuarioID);
    }

    public function consultarNaturalezaPorCodigo($codigo)
    {
        return $this->naturalezaData->consultarNaturalezaPorCodigo($codigo);
    }

    public function reactivarNaturaleza($codigo)
    {
        return $this->naturalezaData->reactivarNaturaleza($codigo);
    }
}