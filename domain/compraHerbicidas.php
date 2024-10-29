<?php
include_once "../domain/herbicidas.php";

class compraHerbicidas extends Herbicidas {
    
    private $precio;
    private $fechaCompra;

    public function __construct($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $aplicacion, $descripcion, $formula, $provedor, $precio, $fechaCompra) {
        parent::__construct($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $aplicacion, $descripcion, $formula, $provedor);
        $this->precio = $precio;
        $this->fechaCompra = $fechaCompra;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getFechaCompra() {
        return $this->fechaCompra;
    }

    public function setFechaCompra($fechaCompra) {
        $this->fechaCompra = $fechaCompra;
    }
}
?>