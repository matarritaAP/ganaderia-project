<?php

include_once "../domain/tipoProductoAlimenticio.php";
include_once "../business/tipoProductoAlimenticioBusiness.php";

$tipoProductoAlimenticioBusiness = new tipoProductoAlimenticioBusiness();
$option = $_POST['option'];

if ($option == 1) {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $tipoProductoAlimenticio = new tipoProductoAlimenticio($nombre, $descripcion);

    $resultado = $tipoProductoAlimenticioBusiness->insertarTipoProductoAlimenticio($tipoProductoAlimenticio);

    if ($resultado) {
        echo "1";
    } else {
        echo "0";
    }
} else if ($option == 2) {
    $resultado = $tipoProductoAlimenticioBusiness->consultarTipoProductoAlimenticio();
    echo $resultado;
} else if ($option == 3) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $resultado = $tipoProductoAlimenticioBusiness->eliminarTipoProductoAlimenticio($nombre, $descripcion);

    if ($resultado) {
        echo "1";
    } else {
        echo "0";
    }
} else if ($option == 4) {
    $nombreAntiguo = isset($_POST['nombreAntiguo']) ? $_POST['nombreAntiguo'] : '';
    $descripcionAntigua = isset($_POST['descripcionAntigua']) ? $_POST['descripcionAntigua'] : '';
    $nombreNuevo = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $descripcionNueva = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

    if ($nombreAntiguo && $nombreNuevo) {
        $tipoProductoAlimenticioNuevo = new tipoProductoAlimenticio($nombreNuevo, $descripcionNueva);
        $resultado = $tipoProductoAlimenticioBusiness->actualizarTipoProductoAlimenticio($nombreAntiguo, $descripcionAntigua, $tipoProductoAlimenticioNuevo);

        if ($resultado) {
            echo "1";
        } else {
            echo "0";
        }
    } else {
        echo "0";
    }
} else if ($option == 5) {
    $nombre = $_POST['nombre'];
    $resultado = $tipoProductoAlimenticioBusiness->validarTiposProductoAlimenticioParecidos($nombre);
    echo $resultado;
}
