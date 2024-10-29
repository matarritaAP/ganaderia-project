<?php
include_once "../domain/unidadesMedida.php";
include_once "../business/unidadMedidaBusiness.php";

$unidadMedidaBusiness = new unidadMedidaBusiness(); // Asegúrate de que el nombre de la clase es correcto
$option = $_POST['option'];

if ($option == 1) { // Insertar nueva unidad
    $tipoUnidad = $_POST['tipoUnidad'];
    $unidadMedida = new unidadesMedida($tipoUnidad, 1);
    $resultado = $unidadMedidaBusiness->insertarUnidadMedida($unidadMedida);
    echo $resultado ? "1" : "Error al insertar";
} else if ($option == 2) { // Consultar todas las unidades
    $resultado = $unidadMedidaBusiness->consultarUnidadesMedidas();
    echo $resultado;
} else if ($option == 3) { // Eliminar una unidad
    $tipoUnidad = $_POST['tipoUnidad'];
    $resultado = $unidadMedidaBusiness->eliminarUnidadMedida($tipoUnidad);
    echo $resultado ? "1" : "Error al eliminar";
} else if ($option == 4) { // Obtener unidad por tipo
    $tipoUnidad = $_POST['tipoUnidad'];
    $unidadMedida = $unidadMedidaBusiness->obtenerUnidadMedidaPorTipo($tipoUnidad);
    if ($unidadMedida) {
        echo json_encode(array("tipoUnidad" => $unidadMedida->getTipoUnidad()));
    } else {
        echo "Error: Unidad de medida no encontrada.";
    }
} else if ($option == 5) { // Actualizar una unidad
    $tipoUnidadAntiguo = $_POST['tipoUnidadAntiguo'];
    $tipoUnidadNuevo = $_POST['tipoUnidad'];
    $resultado = $unidadMedidaBusiness->actualizarUnidadMedida($tipoUnidadAntiguo, $tipoUnidadNuevo);
    echo $resultado ? "1" : "Error al actualizar";
} else if ($option == 6) { // Validar si la unidad ya existe
    $tipoUnidad = $_POST['tipoUnidad']; 
    $resultado = $unidadMedidaBusiness->validarTipoUnidadRepetida($tipoUnidad);
    echo $resultado; // Ajusta según cómo tu método `validarTipoUnidadRepetida` devuelve el resultado
}
?>

