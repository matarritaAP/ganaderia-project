<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once "../domain/estado.php";
include_once "../business/estadoBusiness.php";
include_once '../business/sessionManager.php';

$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = productor
$usuarioID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$estadoBusiness = new estadoBusiness();
$option = $_POST['option'];

switch ($option) {
    case 0:
        echo $actualUserType;
        break;

    case 1: //insertar un nuevo estado
        $codigo = null;
        if ($actualUserType == 0) {
            $codigo = $_POST['codigo'];
        } else {
            // productor: generar código automáticamente
            $codigoGenerado = $estadoBusiness->generarCodigoUnico($_POST['nombre'], $_POST['descripcion'], $usuarioID);
            $codigo = 'PRD-' . $usuarioID . '-' . $codigoGenerado;
        }
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $estado = new estado($codigo, $nombre, $descripcion);
        $resultado = $estadoBusiness->insertarEstado($estado, $actualUserType);
        echo $resultado;
        break;

    case 2: //Consultar estados
        $resultado = $estadoBusiness->consultarEstado($actualUserType, $usuarioID, 1);
        echo $resultado;
        break;

    case 3: // Eliminar estados
        $codigo = $_POST['codigo'];
        $resultado = $estadoBusiness->eliminarEstado($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 4: // Consultar estado por codigo
        $codigo = $_POST['codigo'];
        $resultado = $estadoBusiness->consultarcodigoestado($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 5:
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

        $estado = new estado($codigo, $nombre, $descripcion);
        $resultado = $estadoBusiness->actualizarEstado($estado, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 6: // Validar codigo de estado
        $codigo = $_POST['codigo'];
        $resultado = $estadoBusiness->ValidarCodigo($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 7: // Validar nombres de estados similares
        $nombre = $_POST['nombre'];
        $resultado = $estadoBusiness->validarEstadoSimilar($nombre, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 8: // Consultar estados INACTIVOS
        $resultado = $estadoBusiness->consultarEstadosInactivos($actualUserType, $usuarioID, 1);
        echo $resultado;
        break;
        
    case 9: // Reactivar estados
        $codigo = $_POST['codigo'];
        $resultado = $estadoBusiness->reactivarEstado($codigo);
        echo $resultado;
        break;
    
    default:
        echo "Opción no válida";
        break;
}
