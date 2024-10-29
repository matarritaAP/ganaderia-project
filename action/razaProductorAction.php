<?php
include_once "../domain/razaProductor.php";
include_once "../business/razaProductorBusiness.php";
include_once "../business/razaBusiness.php";
include_once "../business/sessionManager.php";

$razaProductorBusiness = new RazaProductorBusiness();
$razaBusiness = new RazaBusiness();
$option = $_POST['option'];

$usuarioID = getUserId();
$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = Productor

if ($option == 1) {
    $codRaza = $_POST['codRaza'];
    $razaProductor = new RazaProductor($codRaza, $usuarioID);
    $resultado = $razaProductorBusiness->insertarRazaProductor($razaProductor);

    if ($resultado) {
        echo "Raza añadida a tus favoritas";
    } else {
        echo "Esta raza ya está en tus favoritas";
    }
} else if ($option == 2) {
    $resultado = $razaProductorBusiness->consultarRazasPorProductor($usuarioID, 1);
    echo $resultado;
} else if ($option == 3) {
    $codRaza = $_POST['codRaza'];
    $resultado = $razaProductorBusiness->eliminarRazaProductor($usuarioID, $codRaza);
    echo $resultado;
} else if ($option == 4) {
    $resultado = $razaBusiness->consultarRaza($actualUserType, $usuarioID, 0);
    echo $resultado;
}  else if ($option == 5) {
    $resultado = $razaProductorBusiness->consultarRazasPorProductor($usuarioID, 0);
    echo $resultado;
} else if ($option == 6) {
    $codigo = $_POST['codigo'];
    $razaProductor = new RazaProductor($codigo, $usuarioID);
    $resultado = $razaProductorBusiness->reactivarRazaProductor($razaProductor);
    echo $resultado;
}

