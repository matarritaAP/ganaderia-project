<?php
include_once "../domain/raza.php";
include_once "../business/razaBusiness.php";
include_once '../business/sessionManager.php';

$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = productor
$usuarioID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$razaBusiness = new razaBusiness();
$option = $_POST['option'];

switch ($option) {
    case 0: // Obtener el tipo de usuario
        echo $actualUserType;
        break;

    case 1: // Insertar una nueva raza
        $codigo = null;
        if ($actualUserType == 0) {
            $codigo = $_POST['codigo'];
        } else {
            // productor: generar código automáticamente
            $codigoGenerado = $razaBusiness->generarCodigoUnico($_POST['nombre'], $_POST['descripcion'], $usuarioID);
            $codigo = 'PRD-' . $usuarioID . '-' . $codigoGenerado;
        }
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $raza = new raza($codigo, $nombre, $descripcion);
        $resultado = $razaBusiness->insertarRaza($raza, $actualUserType);
        echo $resultado;
        break;

    case 2: // Consultar razas
        $resultado = $razaBusiness->consultarRaza($actualUserType, $usuarioID, 1);
        echo $resultado;
        break;

    case 3: // Eliminar raza
        $codigo = $_POST['codigo'];
        $resultado = $razaBusiness->eliminarRaza($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 4: // Consultar raza por código
        $codigo = $_POST['codigo'];
        $resultado = $razaBusiness->consultarcodigoraza($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 5: // Actualizar raza
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

        $raza = new raza($codigo, $nombre, $descripcion);
        $resultado = $razaBusiness->actualizarRaza($raza, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 6: // Validar código de raza
        $codigo = $_POST['codigo'];
        $resultado = $razaBusiness->ValidarCodigo($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 7: // Validar nombres de razas similares
        $nombre = $_POST['nombre'];
        $resultado = $razaBusiness->ValidarRazasParecidas($nombre, $actualUserType, $usuarioID);
        echo $resultado;
        break;
    case 8: // Consultar razas INACTIVAS
        $resultado = $razaBusiness->consultarRazasInactivas($actualUserType, $usuarioID, 1);
        echo $resultado;
        break;
    case 9: // Reactivar razas
            $codigo = $_POST['codigo'];
            $resultado = $razaBusiness->reactivarRaza($codigo);
            echo $resultado;
            break;
    default:
        echo "Opción no válida";
        break;
}
