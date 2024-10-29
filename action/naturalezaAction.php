<?php
include_once "../domain/naturaleza.php";
include_once "../business/naturalezaBusiness.php";
include_once '../business/sessionManager.php';

$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = productor
$usuarioID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$naturalezaBusiness = new naturalezaBusiness();
$option = $_POST['option'];

switch ($option) {
    case 0: // Obtener el tipo de usuario
        echo $actualUserType;
        break;

    case 1: // Insertar una nueva naturaleza
        $codigo = null;
        if ($actualUserType == 0) {
            $codigo = $_POST['codigo'];
        } else {
            // productor: generar código automáticamente
            $codigoGenerado = $naturalezaBusiness->generarCodigoUnico($_POST['nombre'], $_POST['descripcion'], $usuarioID);
            $codigo = 'PRD-' . $usuarioID . '-' . $codigoGenerado;
        }
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $naturaleza = new naturaleza($codigo, $nombre, $descripcion);
        $resultado = $naturalezaBusiness->insertarNaturaleza($naturaleza, $actualUserType);
        echo $resultado;
        break;

    case 2: // Consultar naturaleza
        $resultado = $naturalezaBusiness->consultarNaturaleza($actualUserType, $usuarioID, 1);
        echo $resultado;
        break;

    case 3: // Eliminar naturaleza
        $codigo = $_POST['codigo'];
        $resultado = $naturalezaBusiness->eliminarNaturaleza($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 4: // Consultar naturaleza por código
        $codigo = $_POST['codigo'];
        $resultado = $naturalezaBusiness->consultarCodigoNaturaleza($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 5: // Actualizar naturaleza
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

        $naturaleza = new naturaleza($codigo, $nombre, $descripcion);
        $resultado = $naturalezaBusiness->actualizarNaturaleza($naturaleza, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 6: // Validar código de naturaleza
        $codigo = $_POST['codigo'];
        $resultado = $naturalezaBusiness->ValidarCodigo($codigo, $actualUserType, $usuarioID);
        echo $resultado;
        break;

    case 7: // Validar nombres de naturalezas similares
        $nombre = $_POST['nombre'];
        $resultado = $naturalezaBusiness->validarNaturalezaParecidos($nombre, $actualUserType, $usuarioID);
        echo $resultado;
        break;
    case 8: // Consultar naturalezas INACTIVAS
        $resultado = $naturalezaBusiness->consultarNaturalezasInactivas($actualUserType, $usuarioID, 1);
        echo $resultado;
        break;
    case 9: // Reactivar naturalezas
            $codigo = $_POST['codigo'];
            $resultado = $naturalezaBusiness->reactivarNaturaleza($codigo);
            echo $resultado;
            break;
    default:
        echo "Opción no válida";
        break;
}