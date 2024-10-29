<?php

include_once "../data/enfermedadData.php";

class EnfermedadBusiness {

    private $enfermedadData;

    public function __construct() {
        $this->enfermedadData = new EnfermedadData();
    }

    public function insertarEnfermedad($enfermedad) {
        return $this->enfermedadData->insertarEnfermedad($enfermedad);
    }

    public function consultarEnfermedad() {
        return $this->enfermedadData->consultarEnfermedad();
    }

    public function eliminarEnfermedad($codigoid) {
        return $this->enfermedadData->eliminarEnfermedad($codigoid);
    }

    public function consultarEnfermedadPorCodigo($codigoid) {
        return $this->enfermedadData->consultarEnfermedadPorCodigo($codigoid);
    }

    public function actualizarEnfermedad($enfermedad) {
        return $this->enfermedadData->actualizarEnfermedad($enfermedad);
    }
}

?>
