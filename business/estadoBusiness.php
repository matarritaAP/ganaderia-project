<?php

include_once "../data/estadoData.php";

class estadoBusiness
{
    private $estadoData;

    public function __construct()
    {
        $this->estadoData = new estadoData();
    }

    public function generarCodigoUnico($nombre, $descripcion, $usuarioID)
    {
        return $this->estadoData->generarCodigoUnico($nombre, $descripcion, $usuarioID);
    }

    public function insertarEstado($estado, $actualUserType)
    {
        return $this->estadoData->insertarEstado($estado, $actualUserType);
    }

    public function consultarEstado($actualUserType, $usuarioID, $manejoActual)
    {
        return $this->estadoData->consultarEstado($actualUserType, $usuarioID, $manejoActual);
    }

    public function consultarEstadosInactivos($actualUserType, $usuarioID, $manejoActual){
        
        return $this->estadoData->consultarEstadosInactivos($actualUserType, $usuarioID, $manejoActual);
    
    }

    public function eliminarEstado($codigo, $actualUserType, $usuarioID)
    {
        return $this->estadoData->eliminarEstado($codigo, $actualUserType, $usuarioID);
    }

    public function consultarcodigoestado($codigo, $actualUserType, $usuarioID)
    {
        return $this->estadoData->consultarcodigoestado($codigo, $actualUserType, $usuarioID);
    }

    public function actualizarEstado($estado, $actualUserType, $usuarioID)
    {
        return $this->estadoData->actualizarEstado($estado, $actualUserType, $usuarioID);
    }

    public function ValidarCodigo($codigo, $actualUserType, $usuarioID){
        return $this->estadoData->ValidarCodigo($codigo, $actualUserType, $usuarioID);
    }

    public function validarEstadoSimilar($nombre, $actualUserType, $usuarioID)
    {
        return $this->estadoData->validarEstadoSimilar($nombre, $actualUserType, $usuarioID);
    }

    public function reactivarEstado($codigo)
    {
        return $this->estadoData->reactivarEstado($codigo);
    }
}
