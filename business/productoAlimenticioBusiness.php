<?php

include_once "../data/productoAlimenticioData.php";

class productoAlimenticioBusiness
{

    private $productoAlimenticioData;

    public function __construct()
    {
        $this->productoAlimenticioData = new productoAlimenticioData();
    }

    public function insertarProductoAlimenticio($productoAlimenticio)
    {
        return $this->productoAlimenticioData->insertarProductoAlimenticio($productoAlimenticio);
    }

    public function consultarProductoAlimenticio($productorId, $estado)
    {
        return $this->productoAlimenticioData->consultarProductoAlimenticio($productorId, $estado);
    }

    public function eliminarProductoAlimenticio($productoAlimenticio)
    {
        return $this->productoAlimenticioData->eliminarProductoAlimenticio($productoAlimenticio);
    }

    public function actualizarProductoAlimenticio($productoAlimenticioMod, $productoAlimenticioId)
    {
        return $this->productoAlimenticioData->actualizarProductoAlimenticio($productoAlimenticioMod, $productoAlimenticioId);
    }

    public function validarProductoAlimenticioParecidos($nombre, $productor)
    {
        return $this->productoAlimenticioData->validarProductoAlimenticioParecidos($nombre, $productor);
    }

    public function obtenerIdPorAtributos($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor)
    {
        return $this->productoAlimenticioData->obtenerIdPorAtributos($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor);
    }

    public function reactivarProductoAlimenticio($nombre, $proveedorId, $productorId)
    {
        return $this->productoAlimenticioData->reactivarProductoAlimenticio($nombre, $proveedorId, $productorId);
    }
}
