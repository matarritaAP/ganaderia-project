<?php
include_once "../domain/productoAlimenticio.php";
class compraProductoAlimenticio extends productoAlimenticio
{

    private $precio;
    private $fechaCompra;

    public function __construct($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor, $precio, $fechaCompra)
    {
        parent::__construct($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor);
        $this->precio = $precio;
        $this->fechaCompra = $fechaCompra;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getFechaCompra()
    {
        return $this->fechaCompra;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function setFechaCompra($fechaCompra)
    {
        $this->fechaCompra = $fechaCompra;
    }
}
