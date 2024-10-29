<?php

include_once "../data/compraHerbicidasData.php";

class compraHerbicidasBusiness {

    private $compraHerbicidasData;

    public function __construct() {
        $this->compraHerbicidasData = new compraHerbicidasData();
    }

    public function insertarCompraHerbicida($compraHerbicida) {
        return $this->compraHerbicidasData->insertarCompraHerbicida($compraHerbicida);
    }

    public function consultarCompraHerbicidas() {
        return $this->compraHerbicidasData->consultarCompraHerbicidas();
    }

    public function eliminarCompraHerbicida($codigoid) {
        return $this->compraHerbicidasData->eliminarCompraHerbicida($codigoid);
    }

    public function consultarCompraHerbicidaPorCodigo($codigoid) {
        return $this->compraHerbicidasData->consultarCompraHerbicidaPorCodigo($codigoid);
    }

    public function actualizarCompraHerbicida($compraHerbicida) {
        return $this->compraHerbicidasData->actualizarCompraHerbicida($compraHerbicida);
    }

}

?>
