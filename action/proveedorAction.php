<?php
include_once "../domain/proveedor.php";
include_once "../business/proveedorBusiness.php";
include_once "../business/sessionManager.php";

$proveedorBusiness = new proveedorBusiness();
$option = $_POST['option'];

$tbproductorid = getUserId();

if ($option == 1) {
    $nombrecomercial = $_POST['nombrecomercial'];
    $propietario = $_POST['propietario'];
    $telefonowhatsapp = $_POST['telefonowhatsapp'];
    $correo = $_POST['correo'];
    $sinpe = $_POST['sinpe'];
    $telefonofijo = $_POST['telefonofijo'];

    $proveedor = new proveedor($nombrecomercial, $propietario, $telefonowhatsapp, $correo, $sinpe, $telefonofijo);
    $resultado = $proveedorBusiness->insertarProveedor($proveedor, $tbproductorid);
    echo $resultado;
} else if ($option == 2) {
    $resultado = $proveedorBusiness->consultarProveedor($tbproductorid, 1);
    echo $resultado;
} else if ($option == 3) {
    $correo = $_POST['correo'];

    //var_dump($correo, $tbproductorid);
    //error_log("Correo recibido: $correo, Productor ID: $tbproductorid"); // Registrar los valores en los logs

    $resultado = $proveedorBusiness->eliminarProveedor($correo, $tbproductorid);
    echo $resultado ? "1" : "0";
} else if ($option == 4) {
    $correo = $_POST['correo'];
    $resultado = $proveedorBusiness->consultarProveedorPorCorreo($correo, $tbproductorid);
    echo $resultado;
} else if ($option == 5) {
    $nombrecomercial = $_POST['nombrecomercial'];
    $propietario = $_POST['propietario'];
    $telefonowhatsapp = $_POST['telefonowhatsapp'];
    $correo = $_POST['correo'];
    $sinpe = $_POST['sinpe'];
    $telefonofijo = $_POST['telefonofijo'];
    $correoAnterior = $_POST['correoAnterior'];

    $proveedor = new proveedor($nombrecomercial, $propietario, $telefonowhatsapp, $correo, $sinpe, $telefonofijo);
    $resultado = $proveedorBusiness->actualizarProveedor($proveedor, $correoAnterior, $tbproductorid);
    echo $resultado;
} else if ($option == 6) {
    $correo = $_POST['correo'];
    $resultado = $proveedorBusiness->ValidarCorreo($correo, $tbproductorid);
    echo $resultado;
} else if ($option == 7) {
    $nombrecomercial = $_POST['nombrecomercial'];
    $resultado = $proveedorBusiness->ValidarNombresComercialesSimilares($nombrecomercial, $tbproductorid);
    echo $resultado;
} else if ($option == 8) {
    $resultado = $proveedorBusiness->consultarProveedor($tbproductorid, 0);
    echo $resultado;
} else if ($option == 9) {
    $correo = $_POST['correo'];
    $resultado = $proveedorBusiness->reactivarProveedor($correo,  $tbproductorid);
    echo $resultado;
}
