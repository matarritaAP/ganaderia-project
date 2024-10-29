<?php

include_once "../data/razaData.php";

class razaBusiness
{

    private $razaData;

    public function __construct()
    {
        $this->razaData = new razaData();
    }

    public function generarCodigoUnico($nombre, $descripcion, $usuarioID)
    {
        return $this->razaData->generarCodigoUnico($nombre, $descripcion, $usuarioID);
    }

    public function insertarRaza($raza, $actualUserType)
    {
        return $this->razaData->insertarRaza($raza, $actualUserType);
    }

    public function consultarRaza($actualUserType, $usuarioID, $manejoActual)
    {
        return $this->razaData->consultarRaza($actualUserType, $usuarioID, $manejoActual);
    }

    public function consultarRazasInactivas($actualUserType, $usuarioID, $manejoActual)
    {
        return $this->razaData->consultarRazasInactivas($actualUserType, $usuarioID, $manejoActual);
    }

    public function eliminarRaza($codigo, $actualUserType, $usuarioID)
    {
        return $this->razaData->eliminarRaza($codigo, $actualUserType, $usuarioID);
    }

    public function consultarcodigoraza($codigo, $actualUserType, $usuarioID)
    {
        return $this->razaData->consultarcodigoraza($codigo, $actualUserType, $usuarioID);
    }

    public function actualizarRaza($raza, $actualUserType, $usuarioID)
    {
        return $this->razaData->actualizarRaza($raza, $actualUserType, $usuarioID);
    }

    public function ValidarCodigo($codigo, $actualUserType, $usuarioID)
    {
        return $this->razaData->ValidarCodigo($codigo, $actualUserType, $usuarioID);
    }

    public function ValidarRazasParecidas($nombre, $actualUserType, $usuarioID)
    {
        return $this->razaData->ValidarRazasParecidas($nombre, $actualUserType, $usuarioID);
    }

    public function reactivarRaza($codigo)
    {
        return $this->razaData->reactivarRaza($codigo);
    }
}
