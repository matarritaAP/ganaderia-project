<?php
include_once "../domain/fincaServicio.php";
include_once "../business/fincaServicioBusiness.php";
include_once "../business/ServicioBusiness.php";
include_once "../business/sessionManager.php";
include_once "../business/fincaBusiness.php";

$fincaServicioBusiness = new fincaServicioBusiness();
$servicioBusiness = new ServicioBusiness();
$fincaBusiness = new fincaBusiness();

$option = $_POST['option'];

$productorID = getUserId();
$actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = Productor

$fincaId = $_POST['fincaId'] ?? null;

switch ($option) {
    case 1:
        // Insertar servicio en la finca
        $servicioCodigo = $_POST['servicioCodigo'];
        $servicioId = $servicioBusiness->consultarServicioPorCodigo($servicioCodigo);

        if ($servicioId !== null) {
            $fincaServicio = new fincaServicio($fincaId, $servicioId);
            $resultado = $fincaServicioBusiness->insertarFincaServicio($fincaServicio);

            if ($resultado) {
                echo "Servicio añadido a la finca";
            } else {
                echo "Este servicio ya está asignado a la finca";
            }
        } else {
            echo "El código de servicio no es válido.";
        }
        break;

    case 2:
        // Consultar servicios por finca
        $resultado = $fincaServicioBusiness->consultarServiciosPorFinca($fincaId, 1);
        echo $resultado;
        break;

    case 3:
        // Eliminar servicio de la finca
        $servicioCodigo = $_POST['servicioCodigo'];
        $servicioId = $servicioBusiness->consultarServicioPorCodigo($servicioCodigo);

        if ($servicioId !== null) {
            $resultado = $fincaServicioBusiness->eliminarFincaServicio($fincaId, $servicioId);

            if ($resultado) {
                echo "Servicio eliminado de a la finca";
            }
        } else {
            echo "El código de servicio no es válido.";
        }
        echo $resultado;
        break;

    case 4:
        // Consultar todos los servicios disponibles
        $resultado = $servicioBusiness->consultarServicio($actualUserType, $productorID, 0);
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
        // Consultar servicios inactivos por finca
        $resultado = $fincaServicioBusiness->consultarServiciosPorFinca($fincaId, 0);
        echo $resultado;
        break;

    case 8:
        // Reacctivar servicios inactivos
        $servicioCodigo = $_POST['servicioCodigo'];
        $servicioId = $servicioBusiness->consultarServicioPorCodigo($servicioCodigo);

        $fincaServicio = new fincaServicio($fincaId, $servicioId);
        $resultado = $fincaServicioBusiness->reactivarServicioFinca($fincaServicio);
        echo $resultado;
        break;

    default:
        echo "Opción no válida";
        break;
}
