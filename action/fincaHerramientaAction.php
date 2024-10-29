<?php
include_once "../domain/fincaHerramienta.php";
include_once "../business/fincaHerramientaBusiness.php";
include_once "../business/herramientaBusiness.php";
include_once "../business/sessionManager.php";
include_once "../business/fincaBusiness.php";

$fincaHerramientaBusiness = new fincaHerramientaBusiness();
$herramientaBusiness = new herramientaBusiness();
$fincaBusiness = new fincaBusiness();

$option = $_POST['option'];

$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = productor
$productorID = getUserId();
$fincaId = $_POST['fincaId'] ?? null;

switch ($option) {
    case 1:
        // Insertar herramienta en la finca
        $herramientaCodigo = $_POST['herramientaCodigo'];
        $herramientaId = $herramientaBusiness->consultarHerramientaPorCodigo($herramientaCodigo);

        if ($herramientaId !== null) {
            $fincaHerramienta = new fincaHerramienta($fincaId, $herramientaId);
            $resultado = $fincaHerramientaBusiness->insertarFincaHerramienta($fincaHerramienta);

            if ($resultado) {
                echo "Herramienta añadida a la finca";
            } else {
                echo "Esta herramienta ya está asignada a la finca";
            }
        } else {
            echo "El código de herramienta no es válido.";
        }
        break;

    case 2:
        // Consultar herramientas por finca
        $resultado = $fincaHerramientaBusiness->consultarHerramientasPorFinca($fincaId, 1);
        echo $resultado;
        break;

    case 3:
        // Eliminar herramienta de la finca
        $herramientaCodigo = $_POST['herramientaCodigo'];
        $herramientaId = $herramientaBusiness->consultarHerramientaPorCodigo($herramientaCodigo);

        if ($herramientaId !== null) {
            $resultado = $fincaHerramientaBusiness->eliminarFincaHerramienta($fincaId, $herramientaId);

            if ($resultado) {
                echo "Herramienta eliminada de la finca";
            }
        } else {
            echo "El código de herramienta no es válido.";
        }
        break;

    case 4:
        // Consultar todas las herramientas disponibles
        $resultado = $herramientaBusiness->consultarHerramienta(1, $productorID, $actualUserType, 0);
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
        // Consultar herramientas inactivas por finca
        $resultado = $fincaHerramientaBusiness->consultarHerramientasPorFinca($fincaId, 0);
        echo $resultado;
        break;

    case 8:
        // Reacctivar herramientas inactivas
        $herramientaCodigo = $_POST['herramientaCodigo'];
        $herramientaId = $herramientaBusiness->consultarHerramientaPorCodigo($herramientaCodigo);

        $fincaHerramienta = new fincaHerramienta($fincaId, $herramientaId);
        $resultado = $fincaHerramientaBusiness->reactivarHerammientaFinca($fincaHerramienta);
        echo $resultado;
        break;

    default:
        echo "Opción no válida";
        break;
}
