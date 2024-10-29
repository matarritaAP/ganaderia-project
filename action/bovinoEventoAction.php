<?php

include_once "../domain/bovinoEvento.php";
include_once "../business/bovinoEventoBusiness.php";
include_once "../business/sessionManager.php";

header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON

$productorID = getUserId();
$bovinoEventoBusiness = new bovinoEventoBusiness();
$option = isset($_POST['option']) ? $_POST['option'] : null;

try {
    switch ($option) {
        case 1: // Insertar un nuevo evento
            $bovino = $_POST['bovinoID'] ?? null;
            $tipoEvento = $_POST['tipoEvento'] ?? null;
            $fecha = $_POST['fechaEvento'] ?? null;
            $descripcion = $_POST['descripcion'] ?? '';

            if (is_null($bovino) || is_null($tipoEvento) || is_null($fecha)) {
                echo json_encode(array("success" => false, "message" => "Faltan datos obligatorios."));
                exit();
            }

            $bovinoEvento = new BovinoEvento(
                $bovino,
                $tipoEvento,
                $fecha,
                $descripcion,
                $productorID,
                1
            );

            $resultado = $bovinoEventoBusiness->insertarEvento($bovinoEvento);
            echo json_encode(array("success" => $resultado, "message" => $resultado ? "Evento insertado correctamente." : "No se pudo insertar el evento."));
            break;

        case 2: // Consultar eventos del productor (activos)
            $resultado = $bovinoEventoBusiness->consultarEvento($productorID, 1);
            echo $resultado;
            break;

        case 3: // Obtener bovinos del productor
            $resultado = $bovinoEventoBusiness->obtenerBovinosPorProductor($productorID);
            echo $resultado;
            break;

        case 4: //consultar bovino por id

            $bovinoid = $_POST['bovinoid'] ?? null;

            if (empty($bovinoid)) {
                echo json_encode(array("success" => false, "message" => "El ID del bovino es obligatorio."));
                exit();
            }

            $resultado = $bovinoEventoBusiness->consultarEventoPorBovinoId($bovinoid);
            echo $resultado;
            break;
        case 5: //Actualizar evento
            try {
                $bovino = $_POST['bovinoID'] ?? null;
                $tipoEvento = $_POST['tipoEvento'] ?? null;
                $fecha = $_POST['fechaEvento'] ?? null;
                $descripcion = $_POST['descripcion'] ?? '';
                $eventoid = $_POST['eventoid'] ?? null;  // Asegúrate de que `eventoid` sea enviado desde el frontend

                // Verificar que todos los datos obligatorios estén presentes
                if (is_null($bovino) || is_null($tipoEvento) || is_null($fecha) || is_null($eventoid)) {
                    echo json_encode(array("success" => false, "message" => "Faltan datos obligatorios."));
                    exit();
                }

                // Crear instancia del evento con los nuevos datos
                $bovinoEvento = new BovinoEvento(
                    $bovino,
                    $tipoEvento,
                    $fecha,
                    $descripcion,
                    $productorID,
                    1
                );

                // Llamar al método de actualización con el ID del evento
                $resultado = $bovinoEventoBusiness->actualizarEvento($bovinoEvento, $eventoid, $productorID);

                echo json_encode(array("success" => $resultado, "message" => $resultado ? "Evento actualizado correctamente." : "No se pudo actualizar el evento."));
            } catch (Exception $e) {
                error_log("Error al actualizar bovino: " . $e->getMessage());
                echo json_encode(array("success" => false, "message" => "Error al actualizar el bovino: " . $e->getMessage()));
            }
            break;


        case 6: //Eliminar Evento
            $eventoid = $_POST['eventoid'] ?? null;

            if (!$eventoid) {
                echo json_encode(array("success" => false, "message" => "El ID del evento es obligatorio para eliminar."));
                exit();
            }

            $resultado = $bovinoEventoBusiness->eliminarEvento($eventoid, $productorID);
            echo json_encode($resultado);
            break;
        default:
            echo json_encode(array("success" => false, "message" => "Opción no válida"));
            break;
    }
} catch (Exception $e) {
    error_log("Error en bovinoEventoAction.php: " . $e->getMessage());
    echo json_encode(array("success" => false, "message" => "Ha ocurrido un error inesperado."));
}
