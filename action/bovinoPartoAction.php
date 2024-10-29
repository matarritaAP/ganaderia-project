<?php
include_once "../domain/bovino.php";
include_once "../business/bovinoPartoBusiness.php";
include_once "../business/sessionManager.php";

$productorID = getUserId();

$bovinoPartoBusiness = new bovinoPartoBusiness();
$option = $_POST['option'];

switch ($option) {

    case 1: // Insertar nuevo bovino
        try {
            $numero = $_POST['numero'];
            $nombre = empty($_POST['nombre']) ? NULL : $_POST['nombre'];
            $padreID = empty($_POST['padreID']) ? NULL : $_POST['padreID'];
            $madreID = empty($_POST['madreID']) ? NULL : $_POST['madreID'];
            $fechaNacimiento = empty($_POST['fechaNacimiento']) ? NULL : $_POST['fechaNacimiento'];
            $peso = $_POST['peso'];
            $razaID =  empty($_POST['razaID']) ? NULL : $_POST['razaID'];
            $estadoID = empty($_POST['estadoID']) ? NULL : $_POST['estadoID'];
            $genero = $_POST['genero'];
            $fincaID = empty($_POST['fincaID']) ? NULL : $_POST['fincaID'];
            $detalle = empty($_POST['detalle']) ? NULL : $_POST['detalle'];
            $activo = 1;

            if (is_null($fincaID)) {
                die("Debe seleccionar la finca en la cual asignará al bovino.");
            }

            if (is_null($estadoID)) {
                die("Debe seleccionar un estado para el bovino.");
            }

            if (is_null($razaID)) {
                die("Debe seleccionar la raza del bovino.");
            }

            if (!in_array($genero, ['Vaca', 'Toro'])) {
                die("El género del bovino debe ser 'Vaca' o 'Toro'.");
            }

            // Verificar si el número ya existe
            if ($bovinoPartoBusiness->verificarNumeroBovino($numero, $productorID)) {
                die("El número de bovino '$numero' ya está registrado en su cuenta. Por favor, verifique sus datos.");
            }

            // Crear instancia de Bovino y realizar inserción
            $bovino = new bovino(
                $numero,
                $nombre,
                $padreID,
                $madreID,
                $fechaNacimiento,
                null,
                null,
                $peso,
                null,
                $razaID,
                $estadoID,
                $genero,
                $fincaID,
                $detalle,
                $productorID
            );
            $resultado = $bovinoPartoBusiness->insertarBovino($bovino);
            echo $resultado ? "1" : "0";
        } catch (Exception $e) {
            error_log("Error al insertar bovino: " . $e->getMessage());
            echo "Error al insertar bovino: " . $e->getMessage();
        }
        break;

    case 2: // Consultar bovino ACTIVOS por productor
        $resultado = $bovinoPartoBusiness->consultarBovino($productorID, 1);
        echo $resultado;
        break;

    case 3: // Eliminar bovino
        $bovinoID = $_POST['bovinoID'];
        $resultado = $bovinoPartoBusiness->eliminarBovino($bovinoID, $productorID);
        echo $resultado;
        break;

    case 4: // Consultar bovino por número
        $numero = $_POST['numero'];
        $resultado = $bovinoPartoBusiness->consultarBovinoPorNumero($numero, $productorID);
        echo $resultado;
        break;

    case 5: // Actualizar bovino
        try {
            $numero = $_POST['numero'];
            $nombre = empty($_POST['nombre']) ? NULL : $_POST['nombre'];
            $padreID = empty($_POST['padreID']) ? NULL : $_POST['padreID'];
            $madreID = empty($_POST['madreID']) ? NULL : $_POST['madreID'];
            $fechaNacimiento = empty($_POST['fechaNacimiento']) ? NULL : $_POST['fechaNacimiento'];
            $peso = $_POST['peso'];
            $razaID =  empty($_POST['razaID']) ? NULL : $_POST['razaID'];
            $estadoID = empty($_POST['estadoID']) ? NULL : $_POST['estadoID'];
            $genero = $_POST['genero'];
            $fincaID = empty($_POST['fincaID']) ? NULL : $_POST['fincaID'];
            $detalle = empty($_POST['detalle']) ? NULL : $_POST['detalle'];
            // $activo = $_POST['activo'];

            if (is_null($fincaID)) {
                die("Debe seleccionar la finca en la cual asignará al bovino.");
            }

            if (is_null($estadoID)) {
                die("Debe seleccionar un estado para el bovino.");
            }

            if (is_null($razaID)) {
                die("Debe seleccionar la raza del bovino.");
            }

            if (!in_array($genero, ['Vaca', 'Toro'])) {
                die("El género del bovino debe ser 'Vaca' o 'Toro'.");
            }

            // Crear instancia de Bovino y actualizar
            $bovino = new bovino(
                $numero,
                $nombre,
                $padreID,
                $madreID,
                $fechaNacimiento,
                null,
                null,
                $peso,
                null,
                $razaID,
                $estadoID,
                $genero,
                $fincaID,
                $detalle,
                $productorID
            );
            $resultado = $bovinoPartoBusiness->actualizarBovino($bovino, $productorID);
            echo $resultado ? "1" : "0";
        } catch (Exception $e) {
            error_log("Error al actualizar bovino: " . $e->getMessage());
            echo "Error al actualizar el bovino: " . $e->getMessage();
        }
        break;
    case 6: // Consultar bovino INACTIVOS por productor
        $resultado = $bovinoPartoBusiness->consultarBovino($productorID, 0);
        echo $resultado;
        break;
    case 7: // Reactivar bovino
        $numero = $_POST['numero'];
        $resultado = $bovinoPartoBusiness->reactivarBovino($numero);
        echo $resultado;
        break;
    case 8: // Obtener bovinos toros
        $resultado = $bovinoPartoBusiness->consultarBovinoPorGenero(1, $productorID);
        echo $resultado;
        break;
    case 9: // Obtener bovinos toros
        $resultado = $bovinoPartoBusiness->consultarBovinoPorGenero(2, $productorID);
        echo $resultado;
        break;
    default:
        echo "Opción no válida";
        break;
}
