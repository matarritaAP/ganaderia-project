<?php
include_once "../domain/fincaNaturaleza.php";
include_once "../business/fincaNaturalezaBusiness.php";
include_once "../business/NaturalezaBusiness.php";
include_once "../business/sessionManager.php";
include_once "../business/fincaBusiness.php";

$fincaNaturalezaBusiness = new fincaNaturalezaBusiness();
$naturalezaBusiness = new NaturalezaBusiness();
$fincaBusiness = new fincaBusiness();

$option = $_POST['option'];

$productorID = getUserId();
$fincaId = $_POST['fincaId'] ?? null;

$usuarioID = getUserId();
$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = Productor

switch ($option) {
    case 1:
        // Insertar naturaleza en la finca
        $naturalezaCodigo = $_POST['naturalezaCodigo'];
        $naturalezaId = $naturalezaBusiness->consultarNaturalezaPorCodigo($naturalezaCodigo);

        if ($naturalezaId !== null) {
            $fincaNaturaleza = new fincaNaturaleza($fincaId, $naturalezaId);
            $resultado = $fincaNaturalezaBusiness->insertarFincaNaturaleza($fincaNaturaleza);

            if ($resultado) {
                echo "Naturaleza añadida a la finca";
            } else {
                echo "Esta naturaleza ya está asignada a la finca";
            }
        } else {
            echo "El código de naturaleza no es válido.";
        }
        break;

    case 2:
        // Consultar naturalezas por finca
        $resultado = $fincaNaturalezaBusiness->consultarNaturalezaPorFinca($fincaId, 1);
        echo $resultado;
        break;

    case 3:
        // Eliminar naturaleza de la finca
        $naturalezaCodigo = $_POST['naturalezaCodigo'];
        $naturalezaId = $naturalezaBusiness->consultarNaturalezaPorCodigo($naturalezaCodigo);

        if ($naturalezaId !== null) {
            $resultado = $fincaNaturalezaBusiness->eliminarFincaNaturaleza($fincaId, $naturalezaId);

            if ($resultado) {
                echo "Naturaleza eliminada de la finca";
            }
        } else {
            echo "El código de naturaleza no es válido.";
        }
        break;

    case 4:
        // Consultar todas las naturalezas disponibles
        $resultado = $naturalezaBusiness->consultarNaturaleza(1, $usuarioID, 0);
        echo $resultado;
        break;

    case 5:
        // Consultar Fincas del Producto Actual
        $fincas = $fincaBusiness->consultarFinca($productorID);
        echo $fincas;
        break;

    case 6:
        // Obtener el ID de la finca basada en el número de plano
        $numPlano = $_POST['numPlano'];
        $fincaId = $fincaBusiness->obtenerFincaPorPlano($numPlano);
        echo json_encode($fincaId);
        break;
    case 7:
        // Consultar naturalezas inactivas por finca
        $resultado = $fincaNaturalezaBusiness->consultarNaturalezaPorFinca($fincaId, 0);
        echo $resultado;
        break;

    case 8:
        // Reacctivar herramientas inactivas
        $naturalezaCodigo = $_POST['naturalezaCodigo'];
        $naturalezaId = $naturalezaBusiness->consultarNaturalezaPorCodigo($naturalezaCodigo);

        $fincaNaturaleza = new fincaNaturaleza($fincaId, $naturalezaId);
        $resultado = $fincaNaturalezaBusiness->reactivarNaturalezaFinca($fincaNaturaleza);
        echo $resultado;
        break;
    default:
        echo "Opción no válida";
        break;
}