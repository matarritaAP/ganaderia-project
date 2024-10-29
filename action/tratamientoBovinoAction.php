<?php
include_once "../domain/tratamientoBovino.php";
include_once "../business/tratamientoBovinoBusiness.php";
$tratamientoBovinoBusiness = new tratamientoBovinoBusiness();
$option = $_POST['option'];
// Insertar en la base de datos 
if ($option == 1) {
    $bovinoId = $_POST['bovinoId'];
    $fecha = $_POST['fechaAplicacion'];
    $enfermedadId = $_POST['enfermedadId'];
    $tipoMedicamentoTexto = $_POST['tipoMedicamento'];
    $dosis = $_POST['dosis'];
 
    $tratamiento = new TratamientoBovino($bovinoId, $fecha, $enfermedadId, $tipoMedicamentoTexto, $dosis);
    $resultado = $tratamientoBovinoBusiness->insertarTratamientoBovino($tratamiento);
    echo $resultado;
// Consultar tratamientos activos
} else if ($option == 2) {
    $resultado = $tratamientoBovinoBusiness->consultarTratamientosBovinos(1);
    echo json_encode($resultado);
// Eliminar tratamiento
} else if ($option == 3) {
    $tbbovinoId = $_POST['tbtratamientobovinoId'];
    $resultado = $tratamientoBovinoBusiness->eliminarTratamientoBovino($tbbovinoId);
    echo $resultado;
// Consultar tratamiento por ID
} else if ($option == 4) {
    $tbbovinoId = $_POST['tbtratamientobovinoId'];
    $resultado = $tratamientoBovinoBusiness->consultarTratamientoBovinoPorId($tbbovinoId);
    echo json_encode($resultado);
// Actualizar tratamiento
} else if ($option == 5) {
    $tbbovinoId = $_POST['tbtratamientobovinoId']; // Asegúrate de obtener el ID del tratamiento
    $bovinoId = $_POST['bovinoId'];
    $fecha = $_POST['fechaAplicacion'];
    $enfermedadId = $_POST['enfermedadId'];
    $tipoMedicamentoTexto = $_POST['tipoMedicamento'];
    $dosis = $_POST['dosis'];
    $tratamiento = new TratamientoBovino($bovinoId, $fecha, $enfermedadId, $tipoMedicamentoTexto, $dosis);
    $resultado = $tratamientoBovinoBusiness->actualizarTratamientoBovino($tratamiento, $tbbovinoId);
    echo $resultado;
// Consultar tratamientos inactivos
} else if ($option == 8) {
    $resultado = $tratamientoBovinoBusiness->consultarTratamientosBovinosInactivos(0);
    echo json_encode($resultado);
// Reactivar tratamiento
} else if ($option == 9) {
    $codigoid = $_POST['tbtratamientobovinoId']; // Asegúrate de usar el ID correcto
    $resultado = $tratamientoBovinoBusiness->reactivarTratamientoBovino($codigoid);
    echo $resultado;
}
?>