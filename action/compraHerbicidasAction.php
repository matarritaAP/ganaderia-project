<?php
include_once "../domain/compraHerbicidas.php";
include_once "../business/compraHerbicidasBusiness.php";

$compraHerbicidasBusiness = new compraHerbicidasBusiness();
$option = $_POST['option'];

if ($option == 1) {
    $codigoid = $_POST['codigoid'];
    $nombre = $_POST['nombre'];
    $nombrecomun = $_POST['nombrecomun'];
    $presentacion = $_POST['presentacion'];
    $casacomercial = $_POST['casacomercial'];
    $cantidad = $_POST['cantidad'];
    $funcion = $_POST['funcion'];
    $aplicacion = $_POST['aplicacion'];
    $descripcion = $_POST['descripcion'];
    $formula = $_POST['formula'];
    $provedor = $_POST['provedor'];
    $precio = $_POST['precio'];
    $fechaCompra = $_POST['fechaCompra'];

    $compraHerbicida = new compraHerbicidas($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $aplicacion, $descripcion, $formula, $provedor, $precio, $fechaCompra);
    $resultado = $compraHerbicidasBusiness->insertarCompraHerbicida($compraHerbicida);
    echo $resultado;
} else if ($option == 2) {
    $resultado = $compraHerbicidasBusiness->consultarCompraHerbicidas();
    echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

} else if ($option == 3) {
    $codigoid = $_POST['codigoid'];
    $resultado = $compraHerbicidasBusiness->eliminarCompraHerbicida($codigoid);
    echo $resultado;
} else if ($option == 4) {
    $codigoid = $_POST['codigoid'];
    $resultado = $compraHerbicidasBusiness->consultarCompraHerbicidaPorCodigo($codigoid);
    echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

} else if ($option == 5) {
    $codigoid = $_POST['codigoid'];
    $nombre = $_POST['nombre'];
    $nombrecomun = $_POST['nombrecomun'];
    $presentacion = $_POST['presentacion'];
    $casacomercial = $_POST['casacomercial'];
    $cantidad = $_POST['cantidad'];
    $funcion = $_POST['funcion'];
    $aplicacion = $_POST['aplicacion'];
    $descripcion = $_POST['descripcion'];
    $formula = $_POST['formula'];
    $provedor = $_POST['provedor'];
    $precio = $_POST['precio'];
    $fechaCompra = $_POST['fechaCompra'];

    $compraHerbicida = new compraHerbicidas($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $aplicacion, $descripcion, $formula, $provedor, $precio, $fechaCompra);
    $resultado = $compraHerbicidasBusiness->actualizarCompraHerbicida($compraHerbicida);
    echo $resultado;
}
