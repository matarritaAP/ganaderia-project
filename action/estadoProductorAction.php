<?php
include_once "../domain/estadoProductor.php";
include_once "../business/estadoProductorBusiness.php";
include_once "../business/estadoBusiness.php";
include_once "../business/sessionManager.php";

$estadoProductorBusiness = new estadoProductorBusiness();
$estadoBusiness = new estadoBusiness();
$option = $_POST['option'];

$usuarioID = getUserId();
$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = Productor

if ($option == 1) {
    $codEstado = $_POST['codEstado'];
    $estadoProductor = new estadoProductor($codEstado, $usuarioID);
    $resultado = $estadoProductorBusiness->insertarEstadoProductor($estadoProductor);
    if ($resultado) {
        echo "Estado añadido a tus favoritos";
    } else {
        echo "Este Estado ya está en tus favoritos";
    }
} else if ($option == 2) {
    $resultado = $estadoProductorBusiness->consultarEstadosPorProductor($usuarioID, 1);
    echo $resultado;
} else if ($option == 3) {
    $codEstado = $_POST['codEstado'];
    $resultado = $estadoProductorBusiness->eliminarEstadoProductor($usuarioID, $codEstado);
    echo $resultado;
} else if ($option == 4) {
    $resultado = $estadoBusiness->consultarEstado($actualUserType, $usuarioID, 0);
    echo $resultado;
} else if ($option == 5) {
    $resultado = $estadoProductorBusiness->consultarEstadosPorProductor($usuarioID, 0);
    echo $resultado;
}else if ($option == 6) {
    $codigo= $_POST['codigo'];
    $estadoProductor = new estadoProductor($codigo, $usuarioID);
    $resultado = $estadoProductorBusiness->reactivarEstadoProductor($estadoProductor);
    echo $resultado;
}