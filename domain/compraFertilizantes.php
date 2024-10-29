<?php
include_once '../domain/fertilizantes.php';

class compraFertilizantes extends Fertilizantes
{
    private $precio;
    private $fechaCompra;

    public function __construct($codigo, $nombre, $nombreComun, $presentacion, $casaComercial, $cantidad, $funcion, $dosificacion, $descripcion, $formula, $proveedor, $precio, $fechaCompra)
    {
        parent::__construct($codigo, $nombre, $nombreComun, $presentacion, $casaComercial, $cantidad, $funcion, $dosificacion, $descripcion, $formula, $proveedor);
        $this->precio = $precio;
        $this->fechaCompra = $fechaCompra;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function getFechaCompra()
    {
        return $this->fechaCompra;
    }

    public function setFechaCompra($fechaCompra)
    {
        $this->fechaCompra = $fechaCompra;
    }
}
