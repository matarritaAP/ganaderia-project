<?php

include_once "../data/fertilizantesData.php";

class fertilizantesBusiness {

    private $fertilizantesData;

    public function __construct() {
        $this->fertilizantesData = new fertilizantesData();
    }

    public function insertarFertilizante($fertilizante) {
        return $this->fertilizantesData->insertarFertilizante($fertilizante);
    }

    public function consultarFertilizantes($estado) {
        return $this->fertilizantesData->consultarFertilizantes($estado);
    }

    public function eliminarFertilizante($codigoid) {
        return $this->fertilizantesData->eliminarFertilizante($codigoid);
    }

    public function consultarFertilizantePorCodigo($codigoid) {
        return $this->fertilizantesData->consultarFertilizantePorCodigo($codigoid);
    }

    public function actualizarFertilizante($fertilizante) {
        return $this->fertilizantesData->actualizarFertilizante($fertilizante);
    }

    public function reactivar($codigo){
        return $this->fertilizantesData->reactivar($codigo);
    }
    // Puedes implementar m�todos de validaci�n espec�ficos si es necesario,
    // adaptando los m�todos de HerbicidasData como validarCodigo y validarHerbicidasParecidos.
}