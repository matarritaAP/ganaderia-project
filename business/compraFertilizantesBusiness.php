<?php

include_once "../data/compraFertilizantesData.php";

class compraFertilizantesBusiness {

    private $fertilizantesData;

    public function __construct() {
        $this->fertilizantesData = new compraFertilizantesData();
    }

    public function insertarCompraFertilizante($fertilizante) {
        return $this->fertilizantesData->insertarCompraFertilizante($fertilizante);
    }

    public function consultarCompraFertilizantes() {
        return $this->fertilizantesData->consultarCompraFertilizantes();
    }

    public function eliminarCompraFertilizante($codigoid) {
        return $this->fertilizantesData->eliminarCompraFertilizante($codigoid);
    }

    public function actualizarCompraFertilizante($fertilizante) {
        return $this->fertilizantesData->actualizarCompraFertilizante($fertilizante);
    }

    public function consultarCompraFertilizantePorCodigo($codigoid) {
        return $this->fertilizantesData->consultarCompraFertilizantePorCodigo($codigoid);
    }
}

?>
