<?php

include_once "../data/compraProductoVeterinarioData.php";

class CompraProductoVeterinarioBusiness {

    private $compraProductoVeterinarioData;

    public function __construct() {
        $this->compraProductoVeterinarioData = new CompraProductoVeterinarioData();
    }

    public function insertarCompraProductoVeterinario($compraProductoVeterinario) {
       return $this->compraProductoVeterinarioData->insertarCompraProductoVeterinario($compraProductoVeterinario);
        
    }

    public function consultarCompraProductoVeterinario() {
        return $this->compraProductoVeterinarioData->consultarCompraProductoVeterinario();
    }

    public function eliminarCompraProductoVeterinario($codigoid) {
        return $this->compraProductoVeterinarioData->eliminarCompraProductoVeterinario($codigoid);
    }

    public function consultarCompraProductoVeterinarioPorCodigo($codigoid) {
        return $this->compraProductoVeterinarioData->consultarCompraProductoVeterinarioPorCodigo($codigoid);
    }

    public function actualizarCompraProductoVeterinario($compraProductoVeterinario) {
        return $this->compraProductoVeterinarioData->actualizarCompraProductoVeterinario($compraProductoVeterinario);
    }
}

?>
