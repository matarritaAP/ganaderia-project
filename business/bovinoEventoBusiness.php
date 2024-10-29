<?php

include_once "../data/bovinoEventoData.php";

class bovinoEventoBusiness{
    private $bovinoEventoData;

    public function __construct()
    {
        $this->bovinoEventoData = new bovinoEventoData();
    }

    public function insertarEvento($bovinoEvento){
        try {
            return $this->bovinoEventoData->insertarEvento($bovinoEvento);
        } catch (Exception $e) {
            return array("success" => false, "message" => $e->getMessage());
        }
    }

    public function consultarEvento($usuarioID, $manejoActual){
        try {
            return $this->bovinoEventoData->consultarEvento($usuarioID, $manejoActual);
        } catch (Exception $e) {
            return array("success" => false, "message" => $e->getMessage());
        }
    }

    public function eliminarEvento($eventoid, $usuarioID){
        try {
            return $this->bovinoEventoData->eliminarEvento($eventoid, $usuarioID);
        } catch (Exception $e) {
            return array("success" => false, "message" => $e->getMessage());
        }
    }

    public function obtenerBovinosPorProductor($usuarioID){
        try {
            return $this->bovinoEventoData->obtenerBovinosPorProductor($usuarioID);
        } catch (Exception $e) {
            return array("success" => false, "message" => $e->getMessage());
        }
    }

    public function actualizarEvento($bovinoEvento, $eventoid, $usuarioID) {
        return $this->bovinoEventoData->actualizarEvento($bovinoEvento, $eventoid, $usuarioID);
    }
    

    public function consultarEventoPorBovinoId($bovinoid) {
        return $this->bovinoEventoData->consultarEventoPorBovinoId($bovinoid);
    }
    
}