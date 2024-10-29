<?php
include_once "../domain/tipoMedicamento.php";
include_once "../business/tipoMedicamentoBusiness.php";

$tipoMedicamentoBusiness = new tipoMedicamentoBusiness();
$option = $_POST['option'];

if ($option == 1) {
    $tipoMedicamentoNombre = $_POST['tipoMedicamento'];
    $tipoMedicamento = new tipoMedicamento($tipoMedicamentoNombre);
    $resultado = $tipoMedicamentoBusiness->insertarTipoMedicamento($tipoMedicamento);
    echo $resultado ? "1" : "Error al insertar";
} else if ($option == 2) {
    $resultado = $tipoMedicamentoBusiness->consultarTipoMedicamentos();
    echo $resultado;
} else if ($option == 3) {
    $tipoMedicamentoNombre = $_POST['tipoMedicamento'];
    $resultado = $tipoMedicamentoBusiness->eliminarTipoMedicamento($tipoMedicamentoNombre);
    echo $resultado ? "1" : "Error al eliminar";
} else if ($option == 4) {
    $tipoMedicamentoNombre = $_POST['tipoMedicamento'];
    $tipoMedicamento = $tipoMedicamentoBusiness->obtenerTipoMedicamentoPorNombre($tipoMedicamentoNombre);
    if ($tipoMedicamento) {
        echo json_encode(array("tipoMedicamento" => $tipoMedicamento->getTipoMedicamento()));
    } else {
        echo "Error: Tipo de medicamento no encontrado.";
    }
} else if ($option == 5) {
    $tipoMedicamentoAntiguo = $_POST['tipoMedicamentoAntiguo'];
    $tipoMedicamentoNuevo = $_POST['tipoMedicamento'];
    $resultado = $tipoMedicamentoBusiness->actualizarTipoMedicamento($tipoMedicamentoAntiguo, $tipoMedicamentoNuevo);
    echo $resultado ? "1" : "Error al actualizar";
} else if ($option == 6) {
    $tipoMedicamentoNombre = $_POST['tipoMedicamento'];
    $resultado = $tipoMedicamentoBusiness->validarTipoMedicamentoRepetido($tipoMedicamentoNombre);
    echo $resultado;
}
