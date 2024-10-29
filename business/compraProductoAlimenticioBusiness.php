<?php

include_once "../data/compraProductoAlimenticioData.php";

class compraProductoAlimenticioBusiness
{

    private $compraProductoAlimenticioData;

    public function __construct()
    {
        $this->compraProductoAlimenticioData = new compraProductoAlimenticioData();
    }

    public function insertarCompraProductoAlimenticio($compraProductoAlimenticio)
    {
        return $this->compraProductoAlimenticioData->insertarCompraProductoAlimenticio($compraProductoAlimenticio);
    }

    public function consultarCompraProductoAlimenticio($productorId)
    {
        return $this->compraProductoAlimenticioData->consultarCompraProductoAlimenticio($productorId);
    }

    public function eliminarCompraProductoAlimenticio($compraProductoAlimenticio)
    {
        return $this->compraProductoAlimenticioData->eliminarCompraProductoAlimenticio($compraProductoAlimenticio);
    }

    public function actualizarCompraProductoAlimenticio($compraProductoAlimenticioMod, $compraProductoAlimenticioId)
    {
        return $this->compraProductoAlimenticioData->actualizarCompraProductoAlimenticio($compraProductoAlimenticioMod, $compraProductoAlimenticioId);
    }

    public function validarCompraProductoAlimenticioParecidos($nombre, $productor)
    {
        return $this->compraProductoAlimenticioData->validarCompraProductoAlimenticioParecidos($nombre, $productor);
    }

    public function obtenerIdPorAtributos($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor, $precio, $fechaCompra){
        return $this->compraProductoAlimenticioData->obtenerIdPorAtributos($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor, $precio, $fechaCompra);
    }
}
