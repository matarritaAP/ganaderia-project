<?php
class TratamientoBovino {
    //private $tbbovinoId;
    private $bovinoId;
    private $fecha;
    private $enfermedadId;
    private $tipoMedicamentoId;
    private $dosis;
   
    // Constructor
    public function __construct( $bovinoId, $fecha, $enfermedadId, $tipoMedicamentoId, $dosis) {
        
       // $this->tbbovinoId = $tbbovinoId;
        $this->bovinoId = $bovinoId;
        $this->fecha = $fecha;
        $this->enfermedadId = $enfermedadId;
        $this->tipoMedicamentoId = $tipoMedicamentoId;
        $this->dosis = $dosis;
     
    }
    // Métodos Get y Set
   /* public function gettbBovinoId() {
        return $this->tbbovinoId;
    }
    public function settbBovinoId($tbbovinoId) {
        $this->tbbovinoId = $tbbovinoId;
    }
*/
    public function getBovinoId() {
        return $this->bovinoId;
    }
    public function setBovinoId($bovinoId) {
        $this->bovinoId = $bovinoId;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    public function getEnfermedadId() {
        return $this->enfermedadId;
    }
    public function setEnfermedadId($enfermedadId) {
        $this->enfermedadId = $enfermedadId;
    }
    public function getTipoMedicamentoId() {
        return $this->tipoMedicamentoId;
    }
    public function setTipoMedicamentoId($tipoMedicamentoId) {
        $this->tipoMedicamentoId = $tipoMedicamentoId;
    }
    public function getDosis() {
        return $this->dosis;
    }
    public function setDosis($dosis) {
        $this->dosis = $dosis;
    }
   
  
}
?>