<?php

include_once "../domain/compraProductoAlimenticio.php";
include_once "../business/compraProductoAlimenticioBusiness.php";
include_once "../business/tipoProductoAlimenticioBusiness.php";
include_once "../business/proveedorBusiness.php";
include_once "../business/sessionManager.php";

$compraProductoAlimenticioBusiness = new compraProductoAlimenticioBusiness();
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

            return new compraProductoAlimenticio(
                $datos['nombre'],
                $tipoId,
                $datos['cantidad'],
                $datos['fechaVencimiento'],
                $proveedorId,
                $productor,
                $datos['precio'],
                $datos['fechaCompra'],
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
        // Insertar compra producto alimenticio
        try {
            $datos = [
                'nombre' => $_POST['nombre'],
                'tipoNombre' => $_POST['tipoNombre'],
                'tipoDescripcion' => $_POST['tipoDescripcion'],
                'cantidad' => $_POST['cantidad'],
                'fechaVencimiento' => $_POST['fechaVencimiento'],
                'proveedorCorreo' => $_POST['proveedorCorreo'],
                'precio' => $_POST['precio'],
                'fechaCompra' => $_POST['fechaCompra']
            ];

            $compraProductoAlimenticio = procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor);
            $resultado = $compraProductoAlimenticioBusiness->insertarCompraProductoAlimenticio($compraProductoAlimenticio);

            if ($resultado) {
                echo "Compra del Producto alimenticio insertada correctamente.";
            } else {
                echo "Error al insertar la compra del producto alimenticio.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 2:
        // Consultar productos alimenticios
        $resultado = $compraProductoAlimenticioBusiness->consultarCompraProductoAlimenticio($productor);
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
                'proveedorCorreo' => $_POST['proveedorCorreo'],
                'precio' => $_POST['precio'],
                'fechaCompra' => $_POST['fechaCompra']
            ];

            $compraProductoAlimenticio = procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor);
            $resultado = $compraProductoAlimenticioBusiness->eliminarCompraProductoAlimenticio($compraProductoAlimenticio);

            if ($resultado) {
                echo "Compra del Producto alimenticio eliminada correctamente.";
            } else {
                echo "Error al eliminar la compra del producto alimenticio.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 4:
        // Obtener el id de la compra producto a modificar
        try {
            $datos = [
                'nombre' => $_POST['nombre'],
                'tipoNombre' => $_POST['tipoNombre'],
                'tipoDescripcion' => $_POST['tipoDescripcion'],
                'cantidad' => $_POST['cantidad'],
                'fechaVencimiento' => $_POST['fechaVencimiento'],
                'proveedorCorreo' => $_POST['proveedorCorreo'],
                'precio' => $_POST['precio'],
                'fechaCompra' => $_POST['fechaCompra']
            ];

            $compraProductoAlimenticio = procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor);
            $tipoId = $tipoProductoAlimenticioBusiness->obtenerIdPorNombreYDescripcion($datos['tipoNombre'], $datos['tipoDescripcion']);

            $compraProductoAlimenticioId = $compraProductoAlimenticioBusiness->obtenerIdPorAtributos(
                $compraProductoAlimenticio->getNombre(),
                $compraProductoAlimenticio->getTipo(),
                $compraProductoAlimenticio->getCantidad(),
                $compraProductoAlimenticio->getFechaVencimiento(),
                $compraProductoAlimenticio->getProveedor(),
                $compraProductoAlimenticio->getProductor(),
                $compraProductoAlimenticio->getPrecio(),
                $compraProductoAlimenticio->getFechaCompra(),
            );
            
            if ($compraProductoAlimenticioId) {
                echo $compraProductoAlimenticioId;
            } else {
                echo "Compra del Producto alimenticio no encontrada.";
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
                'proveedorCorreo' => $_POST['proveedorCorreo'],
                'precio' => $_POST['precio'],
                'fechaCompra' => $_POST['fechaCompra']
            ];

            $compraProductoAlimenticioMod = procesarDatosProducto($datos, $tipoProductoAlimenticioBusiness, $proveedorBusiness, $productor);
            $resultado = $compraProductoAlimenticioBusiness->actualizarCompraProductoAlimenticio($compraProductoAlimenticioMod, $productoID);

            if ($resultado) {
                echo "Compra del Producto alimenticio modificada correctamente.";
            } else {
                echo "Error al actualizar la compra del producto alimenticio.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    default:
        echo "Opción no válida.";
        break;
}
