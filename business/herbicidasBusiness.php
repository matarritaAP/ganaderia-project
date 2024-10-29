<?php

include_once "../data/herbicidasData.php";

class herbicidasBusiness {

    private $herbicidasData;

    public function __construct() {
        $this->herbicidasData = new HerbicidasData();
    }

    public function insertarHerbicida($herbicida) {
        return $this->herbicidasData->insertarHerbicida($herbicida);
    }

    public function consultarHerbicidas($estado) {
        return $this->herbicidasData->consultarHerbicidas($estado);
    }

    public function eliminarHerbicida($codigoid) {
        return $this->herbicidasData->eliminarHerbicida($codigoid);
    }

    public function consultarHerbicidaPorCodigo($codigoid) {
        return $this->herbicidasData->consultarHerbicidaPorCodigo($codigoid);
    }

    public function actualizarHerbicida($herbicida) {
        return $this->herbicidasData->actualizarHerbicida($herbicida);
    }

    public function reactivar($codigo){
        return $this->herbicidasData->reactivar($codigo);
    }

    public function validarCodigo($codigoid) {
        return $this->herbicidasData->validarCodigo($codigoid);
    }

    public function validarHerbicidasParecidos($nombre) {
        return $this->herbicidasData->validarHerbicidasParecidos($nombre);
    }
}

?>
