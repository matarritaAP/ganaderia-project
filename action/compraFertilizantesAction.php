<?php
include_once "../domain/compraFertilizantes.php";
include_once "../business/compraFertilizantesBusiness.php";

$compraFertilizantesBusiness = new compraFertilizantesBusiness();

$option = $_POST['option'];

if ($option == 1) {
    $codigoid = $_POST['codigoid'];
    $nombre = $_POST['nombre'];
    $nombrecomun = $_POST['nombrecomun'];
    $presentacion = $_POST['presentacion'];
    $casacomercial = $_POST['casacomercial'];
    $cantidad = $_POST['cantidad'];
    $funcion = $_POST['funcion'];
    $dosificacion = $_POST['dosificacion'];
    $descripcion = $_POST['descripcion'];
    $formula = $_POST['formula'];
    $proveedor = $_POST['proveedor'];
    $precio = $_POST['precio'];
    $fechaCompra = $_POST['fechaCompra'];

    $compraFertilizante = new compraFertilizantes($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $dosificacion, $descripcion, $formula, $proveedor, $precio, $fechaCompra);
    $resultado = $compraFertilizantesBusiness->insertarCompraFertilizante($compraFertilizante);
    echo $resultado;

} else if ($option == 2) {
    $resultado = $compraFertilizantesBusiness->consultarCompraFertilizantes();
    echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

} else if ($option == 3) {
    $codigoid = $_POST['codigoid'];
    $resultado = $compraFertilizantesBusiness->eliminarCompraFertilizante($codigoid);
    echo $resultado;

} else if ($option == 4) {
    $codigoid = $_POST['codigoid'];
    $resultado = $compraFertilizantesBusiness->consultarCompraFertilizantePorCodigo($codigoid);
    echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

// Opción de editar
} else if ($option == 5) {
    $codigoid = $_POST['codigoid'];
    $nombre = $_POST['nombre'];
    $nombrecomun = $_POST['nombrecomun'];
    $presentacion = $_POST['presentacion'];
    $casacomercial = $_POST['casacomercial'];
    $cantidad = $_POST['cantidad'];
    $funcion = $_POST['funcion'];
    $dosificacion = $_POST['dosificacion'];
    $descripcion = $_POST['descripcion'];
    $formula = $_POST['formula'];
    $proveedor = $_POST['proveedor'];
    $precio = $_POST['precio'];
    $fechaCompra = $_POST['fechaCompra'];

    $compraFertilizante = new compraFertilizantes($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $dosificacion, $descripcion, $formula, $proveedor, $precio, $fechaCompra);
    $resultado = $compraFertilizantesBusiness->actualizarCompraFertilizante($compraFertilizante);
    echo $resultado;

} else if ($option == 6) {
    $codigoid = $_POST['codigoid'];
    $resultado = $compraFertilizantesBusiness->consultarCompraFertilizantePorCodigo($codigoid);
    echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

}