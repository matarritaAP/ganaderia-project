<?php
include_once "../domain/finca.php";
include_once "../business/fincaBusiness.php";
include_once "../business/fincaProductorBuisness.php";
include_once "../business/sessionManager.php";

$fincaProductorID = getUserId();

$fincaBusiness = new fincaBusiness();
$fincaProductorBusiness = new fincaProductorBusiness();
$option = $_POST['option'];

if ($option == 1) {
    try {
        $numPlano = $_POST['numPlano'];
        $latitud = empty($_POST['latitud']) ? NULL : $_POST['latitud'];
        $longitud = empty($_POST['longitud']) ? NULL : $_POST['longitud'];
        $areaPastoreo = empty($_POST['areaPastoreo']) ? NULL : $_POST['areaPastoreo'];
        $areaConstruccion = empty($_POST['areaConstruccion']) ? NULL : $_POST['areaConstruccion'];
        $areaForestal = empty($_POST['areaForestal']) ? NULL : $_POST['areaForestal'];
        $areaCamino = empty($_POST['areaCamino']) ? NULL : $_POST['areaCamino'];
        $criterios = isset($_POST['criterios']) ? $_POST['criterios'] : null;

        $areaTotal = empty($_POST['areaTotal']) ? NULL : $_POST['areaTotal'];

        if (!is_null($latitud) && !is_numeric($latitud)) {
            die("Error: El valor del área de pastoreo debe ser numérico.");
        }
        if (!is_null($longitud) && !is_numeric($longitud)) {
            die("Error: El valor del área de pastoreo debe ser numérico.");
        }
        // Validaciones de datos numéricos para otras áreas
        if (!is_null($areaPastoreo) && !is_numeric($areaPastoreo)) {
            die("Error: El valor del área de pastoreo debe ser numérico.");
        }
        if (!is_null($areaConstruccion) && !is_numeric($areaConstruccion)) {
            die("Error: El valor del área de construcción debe ser numérico.");
        }
        if (!is_null($areaForestal) && !is_numeric($areaForestal)) {
            die("Error: El valor del área forestal debe ser numérico.");
        }
        if (!is_null($areaCamino) && !is_numeric($areaCamino)) {
            die("Error: El valor del área de camino debe ser numérico.");
        }

        // Crear instancia de Finca y realizar inserción
        $finca = new finca(
            $numPlano,
            null,
            $latitud,
            $longitud,
            $areaTotal,
            $areaPastoreo,
            $areaConstruccion,
            $areaForestal,
            $areaCamino,
            $criterios
        );
        $resultado = $fincaBusiness->insertarFinca($finca);

        if ($resultado) {
            $fincaID = $fincaBusiness->obtenerFincaPorPlano($numPlano);
            $fincaProductor = new fincaProductor($fincaID, $fincaProductorID);
            $resultadoIntermedia = $fincaProductorBusiness->insertarFincaProductor($fincaProductor);
        }
        echo $resultado;
    } catch (Exception $e) {
        error_log("Error al insertar finca: " . $e->getMessage());
        echo "Error al insertar finca: " . $e->getMessage();
    }
} elseif ($option == 2) {
    $resultado = $fincaBusiness->consultarFinca($fincaProductorID);
    echo $resultado;
} elseif ($option == 3) {
    $numPlano = $_POST['numPlano'];
    $fincaID = $fincaBusiness->obtenerFincaPorPlano($numPlano);

    if ($fincaID) {
        $resultadoIntermedia = $fincaProductorBusiness->eliminarFincaProductor($fincaID, $fincaProductorID);
        if ($resultadoIntermedia) {
            $resultado = $fincaBusiness->eliminarFinca($numPlano);
        }
    }
    echo $resultadoIntermedia;
} elseif ($option == 4) {
    $numPlano = $_POST['numPlano'];
    $resultado = $fincaBusiness->consultarCodigoFinca($numPlano);
    echo $resultado;
} elseif ($option == 5) {
    try {
        $numPlano = $_POST['numPlano'];
        $latitud = empty($_POST['latitud']) ? NULL : $_POST['latitud'];
        $longitud = empty($_POST['longitud']) ? NULL : $_POST['longitud'];
        $areaPastoreo = empty($_POST['areaPastoreo']) ? NULL : $_POST['areaPastoreo'];
        $areaConstruccion = empty($_POST['areaConstruccion']) ? NULL : $_POST['areaConstruccion'];
        $areaForestal = empty($_POST['areaForestal']) ? NULL : $_POST['areaForestal'];
        $areaCamino = empty($_POST['areaCamino']) ? NULL : $_POST['areaCamino'];
        $criterios = isset($_POST['criterios']) ? $_POST['criterios'] : null;

        $areaTotal = empty($_POST['areaTotal']) ? NULL : $_POST['areaTotal'];

        if (!is_null($latitud) && !is_numeric($latitud)) {
            die("Error: El valor del área de pastoreo debe ser numérico.");
        }

        if (!is_null($longitud) && !is_numeric($longitud)) {
            die("Error: El valor del área de pastoreo debe ser numérico.");
        }

        // Validaciones de datos numéricos para otras áreas
        if (!is_null($areaPastoreo) && !is_numeric($areaPastoreo)) {
            die("Error: El valor del área de pastoreo debe ser numérico.");
        }
        if (!is_null($areaConstruccion) && !is_numeric($areaConstruccion)) {
            die("Error: El valor del área de construcción debe ser numérico.");
        }
        if (!is_null($areaForestal) && !is_numeric($areaForestal)) {
            die("Error: El valor del área forestal debe ser numérico.");
        }
        if (!is_null($areaCamino) && !is_numeric($areaCamino)) {
            die("Error: El valor del área de camino debe ser numérico.");
        }

        // Crear instancia de Finca y actualizar
        $finca = new finca(
            $numPlano,
            null,
            $latitud,
            $longitud,
            $areaTotal,
            $areaPastoreo,
            $areaConstruccion,
            $areaForestal,
            $areaCamino,
            $criterios
        );
        $resultado = $fincaBusiness->actualizarFinca($finca);

        if ($resultado) {
            echo "1"; // Actualización exitosa
        } else {
            echo "0"; // Error en la actualización
        }
    } catch (Exception $e) {
        error_log("Error en actualización: " . $e->getMessage());
        echo "Error al actualizar la finca: " . $e->getMessage();
    }
} elseif ($option == 6) {
    $numPlano = $_POST['numPlano'];
    $resultado = $fincaBusiness->validarCodigo($numPlano);
    echo $resultado;
} elseif ($option == 7) {
    $numPlano = $_POST['numPlano'];
    $resultado = $fincaBusiness->validarFincaParecidos($numPlano);
    echo $resultado;
}
