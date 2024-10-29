<?php
include_once "../domain/Servicio.php";
include_once "../business/ServicioBusiness.php";
include_once '../business/sessionManager.php';

$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = productor
$usuarioID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$servicioBusiness = new ServicioBusiness();
$option = $_POST['option'];


switch ($option) {
    case 0: // Obtener el tipo de usuario
        echo $actualUserType;
        break;

    case 1: // Insertar un nuevo servicio
        $codigo = null;
        if ($actualUserType == 0) {
            $codigo =  $_POST['codigo'];
        } else {
            // productor: generar código automáticamente
            $codigoGenerado = $servicioBusiness->generarCodigoUnico($_POST['nombre'], $_POST['descripcion'], $usuarioID);
            $codigo = 'PRD-' . $usuarioID . '-' . $codigoGenerado;
        }
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $servicio = new Servicio($codigo, $nombre, $descripcion);
        $resultado = $servicioBusiness->insertarServicio($servicio, $actualUserType);
        echo $resultado;
        break;

    case 2: // Consultar servicios
        $resultado = $servicioBusiness->consultarServicio($actualUserType, $usuarioID, 1);
        echo $resultado;
        break;

    case 3: // Eliminar un servicio
        $codigo = $_POST['codigo'];
        $resultado = $servicioBusiness->eliminarServicio($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 4: // Consultar servicio por código
        $codigo = $_POST['codigo'];
        $resultado = $servicioBusiness->consultarCodigoServicio($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 5: // Actualizar un servicio
        $codigo = null;
        if ($actualUserType == 0) {
            // Administrador: usar código recibido
            $codigo = $_POST['codigo'];
        } else {
            // productor: solo verificar si se ha cambiado el código
            $codigo = $_POST['codigo'];
        }
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $servicio = new Servicio($codigo, $nombre, $descripcion);
        $resultado = $servicioBusiness->actualizarServicio($servicio, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 6: // Validar código de servicio
        $codigo = $_POST['codigo'];
        $resultado = $servicioBusiness->validarCodigo($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 7: // Validar nombres de servicios similares
        $nombre = $_POST['nombre'];
        $resultado = $servicioBusiness->validarServicioParecidos($nombre, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 8: // Consultar servicios INACTIVOS
        $resultado = $servicioBusiness->consultarServicioInactivo($actualUserType, $usuarioID, 1);
        echo $resultado;
        break;

    case 9: // Reactivar servicios
        $codigo = $_POST['codigo'];
        $resultado = $servicioBusiness->reactivarServicio($codigo);
        echo $resultado;
        break;
    default:
        echo "Opción no válida";
        break;
}