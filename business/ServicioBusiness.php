<?php
include_once "../data/servicioData.php";

class ServicioBusiness
{
    private $servicioData;

    public function __construct()
    {
        $this->servicioData = new servicioData();
    }

    public function generarCodigoUnico($nombre, $descripcion, $usuarioID)
    {
        return $this->servicioData->generarCodigoUnico($nombre, $descripcion, $usuarioID);
    }

    public function insertarServicio($servicio, $actualUserType)
    {
        return $this->servicioData->insertarServicio($servicio, $actualUserType);
    }

    public function consultarServicio($actualUserType, $usuarioID, $manejoActual)
    {
        return $this->servicioData->consultarServicio($actualUserType, $usuarioID, $manejoActual);
    }

    public function consultarServicioInactivo($actualUserType, $usuarioID, $manejoActual)
    {
        return $this->servicioData->consultarServicioInactivo($actualUserType, $usuarioID, $manejoActual);
    }

    public function eliminarServicio($codigo, $actualUserType, $usuarioID)
    {
        return $this->servicioData->eliminarServicio($codigo, $actualUserType, $usuarioID);
    }

    public function consultarCodigoServicio($codigo, $actualUserType, $usuarioID)
    {
        return $this->servicioData->consultarCodigoServicio($codigo, $actualUserType, $usuarioID);
    }

    public function actualizarServicio($servicio, $actualUserType, $usuarioID)
    {
        return $this->servicioData->actualizarServicio($servicio, $actualUserType, $usuarioID);
    }

    public function validarCodigo($codigo, $actualUserType, $usuarioID)
    {
        return $this->servicioData->validarCodigo($codigo, $actualUserType, $usuarioID);
    }

    public function consultarServicioPorCodigo($codigo)
    {
        return $this->servicioData->consultarServicioPorCodigo($codigo);
    }

    public function validarServicioParecidos($nombre, $actualUserType, $usuarioID)
    {
        return $this->servicioData->validarServicioParecidos($nombre, $actualUserType, $usuarioID);
    }

    public function reactivarServicio($codigo)
    {
        return $this->servicioData->reactivarServicio($codigo);
    }
}
