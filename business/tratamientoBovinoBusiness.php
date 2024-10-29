<?php
include_once "../data/tratamientoBovinoData.php";
class tratamientoBovinoBusiness {
    private $tratamientoBovinoData;
    public function __construct() {
        $this->tratamientoBovinoData = new tratamientoBovinoData();
    }
     //hace el llamado de la funcion insertar a la BD
    public function insertarTratamientoBovino($tratamientoBovino) {
     return $this->tratamientoBovinoData->insertarTratamientoBovino($tratamientoBovino);
    }
      //hace el llamado de la funcion consultar todos los datos de la tabla en a la BD
    public function consultarTratamientosBovinos() {
        return $this->tratamientoBovinoData->consultarTratamientosBovinos();
    }
    //hace la consulta especifica por un ID en la tabla de la BD
    public function eliminarTratamientoBovino($tbbovinoId) {
        return $this->tratamientoBovinoData->eliminarTratamientoBovino($tbbovinoId);
    }
    public function consultarTratamientoBovinoPorId($tbbovinoId) {
        return $this->tratamientoBovinoData->consultarTratamientoBovinoPorId($tbbovinoId);
    }
    public function actualizarTratamientoBovino($tratamientoBovino,$tbbovinoId) {
        return $this->tratamientoBovinoData->actualizarTratamientoBovino($tratamientoBovino,$tbbovinoId);
    }
    //opcion 8
    //consulta los tratamientos inactivos en la BD
    public function consultarTratamientosBovinosInactivos() {
        return $this->tratamientoBovinoData->consultarTratamientosBovinosInactivos();
    }
 //opcion 9
    //consulta los tratamientos inactivos en la BD
    public function reactivarTratamientoBovino($tbbovinoId) {
        return $this->tratamientoBovinoData->reactivarTratamientoBovino($tbbovinoId);
    }
}
?>