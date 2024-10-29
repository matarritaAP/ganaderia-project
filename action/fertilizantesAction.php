<?php
include_once "../domain/fertilizantes.php";
include_once "../business/fertilizantesBusiness.php";

$fertilizantesBusiness = new fertilizantesBusiness();

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

    $fertilizante = new fertilizantes($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $dosificacion, $descripcion, $formula, $proveedor);
    $resultado = $fertilizantesBusiness->insertarFertilizante($fertilizante);
    echo $resultado;
    // echo "prueba";

} else if ($option == 2) {
    // echo"consultar";
    $resultado = $fertilizantesBusiness->consultarFertilizantes(1);
    echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

} else if ($option == 3) {
    $codigoid = $_POST['codigoid'];
    $resultado = $fertilizantesBusiness->eliminarFertilizante($codigoid);
    echo $resultado;

} else if ($option == 4) {
    $codigoid = $_POST['codigoid'];
    $resultado = $fertilizantesBusiness->consultarFertilizantePorCodigo($codigoid);
    echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

    //opcion de editar
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

    $fertilizante = new fertilizantes($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $dosificacion, $descripcion, $formula, $proveedor);
    $resultado = $fertilizantesBusiness->actualizarFertilizante($fertilizante);
    echo $resultado;

} else if ($option == 6) {
    $codigoid = $_POST['codigoid'];
    $resultado = $fertilizantesBusiness->validarCodigo($codigoid);
    echo $resultado;

} else if ($option == 7) {
    $nombre = $_POST['nombre'];
    $resultado = $fertilizantesBusiness->validarHerbicidasParecidos($nombre);  // Este m�todo debe adaptarse si es necesario
    echo $resultado;
} else if ($option == 8) {
    // echo"consultar";
    $resultado = $fertilizantesBusiness->consultarFertilizantes(0);
    echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario
}else if($option == 9){
    $codigoid = $_POST['codigoid'];
    $resultado = $fertilizantesBusiness->reactivar($codigoid);
    echo $resultado;
}

?>