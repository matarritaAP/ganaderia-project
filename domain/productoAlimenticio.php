<?php

class productoAlimenticio {

    private $nombre;
    private $tipo;
    private $cantidad;
    private $fechavencimiento;
    private $proveedor;
    private $productor;

    public function __construct($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor){
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        $this->fechavencimiento = $fechavencimiento;
        $this->proveedor = $proveedor;
        $this->productor = $productor;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getFechaVencimiento() {
        return $this->fechavencimiento;
    }

    public function getProveedor() {
        return $this->proveedor;
    }

    public function getProductor() {
        return $this->productor;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setFechaVencimiento($fechavencimiento) {
        $this->fechavencimiento = $fechavencimiento;
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function setProductor($productor) {
        $this->productor = $productor;
    }
}
