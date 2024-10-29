<?php
include_once "../domain/CVO.php";
include_once "../business/cvoBusiness.php";
include_once "../business/sessionManager.php";
$productoID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$cvoBusiness = new cvoBusiness();
$option = $_POST['option'];

if ($option == 1) {

    $directory = "../docs/imagenCVO/";
    $numero = $_POST['numeroCVO'];
    $ruta = $directory . basename($numero) . '.jpg';
    $fEmision = $_POST['fechaEmisionCVO'];
    $fVencimiento = $_POST['fechaVencimientoCVO'];



    $cvo = new CVO($numero, $fEmision, $fVencimiento, $ruta);
    $resultado = $cvoBusiness->insertarCVO($cvo, $productoID);
    if ($resultado == 1) {
        move_uploaded_file($_FILES['imagenCVO']['tmp_name'], $ruta);
    }

    echo $resultado;
} else if ($option == 2) {
    $resultado = $cvoBusiness->consultarCVO($productoID);
    echo $resultado;
} else if ($option == 3) {
    $codigo = $_POST['codigo'];
    $resultado = $cvoBusiness->eliminarCVO($codigo, $productoID);
    echo $resultado;
} else if ($option == 4) {
    $codigo = $_POST['codigo'];
    $resultado = $cvoBusiness->consultarNumeroCVO($codigo, $productoID);
    echo $resultado;
} else if ($option == 5) {
    $directory = "../docs/imagenCVO/";
    $numero = $_POST['numeroCVOHidden'];
    $ruta = $directory . basename($numero) . '.jpg';
    $fEmision = $_POST['fechaEmisionCVO'];
    $fVencimiento = $_POST['fechaVencimientoCVO'];
    $file = $_FILES['imagenCVO']['name'];

    $cvo = new CVO($numero, $fEmision, $fVencimiento, $ruta);
    $resultado = $cvoBusiness->actualizarCVO($cvo, $productoID);
    if ($resultado == 1) {
        move_uploaded_file($_FILES['imagenCVO']['tmp_name'], $ruta);
    }
    echo $resultado;
} else if ($option == 6) {
    $numeroCVO = $_POST['numeroCVO'];
    $resultado = $cvoBusiness->validarNumeroCVO($numeroCVO, $productoID);
    echo $resultado;
}
