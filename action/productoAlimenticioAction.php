<?php

include_once "../domain/productoAlimenticio.php";
include_once "../business/productoAlimenticioBusiness.php";
include_once "../business/tipoProductoAlimenticioBusiness.php";
include_once "../business/proveedorBusiness.php";
include_once "../business/sessionManager.php";

$productoAlimenticioBusiness = new productoAlimenticioBusiness();
$tipoProductoAlimenticioBusiness = new tipoProductoAlimenticioBusiness();
$proveedorBusiness = new proveedorBusiness();

$option = isset($_POST['option']) ? $_POST['option'] : '';
$productor = getUserId();

function procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor)
{
    $tipoId = $tipoProductoAlimenticioBusiness->obtenerIdPorNombreYDescripcion($datos['tipoNombre'], $datos['tipoDescripcion']);

    if ($tipoId !== null) {
        $proveedorId = $proveedorBusiness->consultarProveedorPorCorreo($datos['proveedorCorreo'], $productor);
        $proveedorLista = json_decode($proveedorId, true);

        if (count($proveedorLista) > 0) {
            $proveedorId = $proveedorLista[0]['id'];

            return new productoAlimenticio(
                $datos['nombre'],
                $tipoId,
                $datos['cantidad'],
                $datos['fechaVencimiento'],
                $proveedorId,
                $productor
            );
        } else {
            throw new Exception("Proveedor no encontrado.");
        }
    } else {
        throw new Exception("Tipo de producto alimenticio no encontrado.");
    }
}

switch ($option) {
    case 1:
        // Insertar producto alimenticio
        try {
            $datos = [
                'nombre' => $_POST['nombre'],
                'tipoNombre' => $_POST['tipoNombre'],
                'tipoDescripcion' => $_POST['tipoDescripcion'],
                'cantidad' => $_POST['cantidad'],
                'fechaVencimiento' => $_POST['fechaVencimiento'],
                'proveedorCorreo' => $_POST['proveedorCorreo']
            ];

            $productoAlimenticio = procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor);
            $resultado = $productoAlimenticioBusiness->insertarProductoAlimenticio($productoAlimenticio);

            if ($resultado) {
                echo "Producto alimenticio insertado correctamente.";
            } else {
                echo "Error al insertar el producto alimenticio.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 2:
        // Consultar productos alimenticios
        $resultado = $productoAlimenticioBusiness->consultarProductoAlimenticio($productor, 1);
        echo $resultado;
        break;

    case 3:
        // Eliminar producto alimenticio
        try {
            $datos = [
                'nombre' => $_POST['nombre'],
                'tipoNombre' => $_POST['tipoNombre'],
                'tipoDescripcion' => $_POST['tipoDescripcion'],
                'cantidad' => $_POST['cantidad'],
                'fechaVencimiento' => $_POST['fechaVencimiento'],
                'proveedorCorreo' => $_POST['proveedorCorreo']
            ];

            $productoAlimenticio = procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor);
            $resultado = $productoAlimenticioBusiness->eliminarProductoAlimenticio($productoAlimenticio);

            if ($resultado) {
                echo "Producto alimenticio eliminado correctamente.";
            } else {
                echo "Error al eliminar el producto alimenticio.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 4:
        // Obtener el id del producto a modificar
        try {
            $datos = [
                'nombre' => $_POST['nombre'],
                'tipoNombre' => $_POST['tipoNombre'],
                'tipoDescripcion' => $_POST['tipoDescripcion'],
                'cantidad' => $_POST['cantidad'],
                'fechaVencimiento' => $_POST['fechaVencimiento'],
                'proveedorCorreo' => $_POST['proveedorCorreo']
            ];

            $productoAlimenticio = procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor);

            $productoAlimenticioId = $productoAlimenticioBusiness->obtenerIdPorAtributos(
                $productoAlimenticio->getNombre(),
                $productoAlimenticio->getTipo(),
                $productoAlimenticio->getCantidad(),
                $productoAlimenticio->getFechaVencimiento(),
                $productoAlimenticio->getProveedor(),
                $productor
            );

            if ($productoAlimenticioId) {
                echo $productoAlimenticioId;
            } else {
                echo "Producto alimenticio no encontrado.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    case 5:
        // Actualizar el producto alimenticio
        try {
            $productoID = $_POST['productoID']; // ID del producto a modificar

            $datos = [
                'nombre' => $_POST['nombre'],
                'tipoNombre' => $_POST['tipoNombre'],
                'tipoDescripcion' => $_POST['tipoDescripcion'],
                'cantidad' => $_POST['cantidad'],
                'fechaVencimiento' => $_POST['fechaVencimiento'],
                'proveedorCorreo' => $_POST['proveedorCorreo']
            ];

            $productoAlimenticioMod = procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor);
            $resultado = $productoAlimenticioBusiness->actualizarProductoAlimenticio($productoAlimenticioMod, $productoID);

            if ($resultado) {
                echo "Producto alimenticio modificado correctamente.";
            } else {
                echo "Error al actualizar el producto alimenticio.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    case 6:
        // Consultar productos alimenticios INACTIVOS
        $resultado = $productoAlimenticioBusiness->consultarProductoAlimenticio($productor, 0);
        echo $resultado;
        break;
    case 7:
        $nombre = $_POST['nombre'];
        $proveedorCorreo = $_POST['proveedorCorreo'];
        $proveedorIdJson = $proveedorBusiness->consultarProveedorPorCorreo($proveedorCorreo, $productor);
        $proveedorLista = json_decode($proveedorIdJson, true); // Decodifica el JSON

        if (is_array($proveedorLista) && isset($proveedorLista[0]['id'])) {
            $proveedorId = $proveedorLista[0]['id']; // Obtiene el 'id'
        } else {
            throw new Exception("No se pudo obtener el ID del proveedor o formato incorrecto.");
        }

        $resultado = $productoAlimenticioBusiness->reactivarProductoAlimenticio($nombre, $proveedorId, $productor);
        echo $resultado;
        break;

    default:
        echo "Opción no válida.";
        break;
}
