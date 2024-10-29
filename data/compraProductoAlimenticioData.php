<?php

include_once "../domain/compraProductoAlimenticio.php";
include_once "../data/database.php";

class compraProductoAlimenticioData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    private function obtenerMaxId()
    {
        $con = $this->conectar();
        $stmt = $con->prepare("SELECT MAX(tbcompraproductoalimenticioid) AS maxid FROM tbcompraproductoalimenticio");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['maxid'] + 1;
    }

    public function insertarCompraProductoAlimenticio($compraProductoAlimenticio)
    {
        $con = $this->conectar();

        $sql = $con->prepare("INSERT INTO tbcompraproductoalimenticio 
            (tbcompraproductoalimenticioid, tbcompraproductoalimenticionombre, tbcompraproductoalimenticiotipo, tbcompraproductoalimenticiocantidad, 
            tbcompraproductoalimenticiofechavencimiento, tbcompraproductoalimenticioproveedor, tbcompraproductoalimenticioproductor,
            tbcompraproductoalimenticioprecio, tbcompraproductoalimenticiofechacompra, tbcompraproductoalimenticioestado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        return $sql->execute(array(
            $this->obtenerMaxId(),
            $compraProductoAlimenticio->getNombre(),
            $compraProductoAlimenticio->getTipo(),
            $compraProductoAlimenticio->getCantidad(),
            $compraProductoAlimenticio->getFechaVencimiento(),
            $compraProductoAlimenticio->getProveedor(),
            $compraProductoAlimenticio->getProductor(),
            $compraProductoAlimenticio->getPrecio(),
            $compraProductoAlimenticio->getFechaCompra(),
            1
        ));
    }

    public function obtenerIdPorAtributos($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor, $precio, $fechaCompra)
    {
        $con = $this->conectar();

        $sql = $con->prepare("SELECT tbcompraproductoalimenticioid 
            FROM tbcompraproductoalimenticio 
            WHERE tbcompraproductoalimenticionombre=? 
            AND tbcompraproductoalimenticiotipo=? 
            AND tbcompraproductoalimenticiocantidad=? 
            AND tbcompraproductoalimenticiofechavencimiento=? 
            AND tbcompraproductoalimenticioproveedor=? 
            AND tbcompraproductoalimenticioproductor=? 
            AND tbcompraproductoalimenticioprecio=?
            AND tbcompraproductoalimenticiofechacompra=?
            AND tbcompraproductoalimenticioestado=1");

        $sql->execute(array($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor, $precio, $fechaCompra));
        $resultado = $sql->fetch();

        return $resultado ? $resultado['tbcompraproductoalimenticioid'] : null;
    }

    public function consultarCompraProductoAlimenticio($productorId)
    {
        $productoList = [];
        $con = $this->conectar();

        if ($con) {
            $sql = $con->prepare("
            SELECT DISTINCT
                p.tbcompraproductoalimenticionombre AS nombre,
                t.tbtipoproductoalimenticionombre AS tipo,
                p.tbcompraproductoalimenticiocantidad AS cantidad,
                p.tbcompraproductoalimenticiofechavencimiento AS fechavencimiento,
                prov.tbproveedornombrecomercial AS proveedor,
                p.tbcompraproductoalimenticioproductor AS productor,
                p.tbcompraproductoalimenticioprecio AS precio,
                p.tbcompraproductoalimenticiofechacompra AS fechaCompra
            FROM 
                tbcompraproductoalimenticio p
            JOIN
                tbtipoproductoalimenticio t 
            ON p.tbcompraproductoalimenticiotipo = t.tbtipoproductoalimenticioid
            JOIN 
                tbproveedor prov 
            ON p.tbcompraproductoalimenticioproveedor = prov.tbproveedorid
            WHERE 
                p.tbcompraproductoalimenticioestado = 1
            AND p.tbcompraproductoalimenticioproductor = ?;");

            $sql->execute([$productorId]);

            // Obtener todos los resultados
            foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $data) {
                $productoList[] = array(
                    "nombre" => $data['nombre'],
                    "tipo" => $data['tipo'],
                    "cantidad" => $data['cantidad'],
                    "fechavencimiento" => $data['fechavencimiento'],
                    "proveedor" => $data['proveedor'],
                    "productor" => $data['productor'],
                    "precio" => $data['precio'],
                    "fechaCompra" => $data['fechaCompra']
                );
            }
        }

        return json_encode($productoList);
    }

    public function eliminarCompraProductoAlimenticio($compraProductoAlimenticio)
    {
        $con = $this->conectar();

        $idProductoAlimenticio = $this->obtenerIdPorAtributos(
            $compraProductoAlimenticio->getNombre(),
            $compraProductoAlimenticio->getTipo(),
            $compraProductoAlimenticio->getCantidad(),
            $compraProductoAlimenticio->getFechaVencimiento(),
            $compraProductoAlimenticio->getProveedor(),
            $compraProductoAlimenticio->getProductor(),
            $compraProductoAlimenticio->getPrecio(),
            $compraProductoAlimenticio->getFechaCompra(),
        );

        if ($idProductoAlimenticio !== null) {
            $sql = $con->prepare("UPDATE tbcompraproductoalimenticio
                SET tbcompraproductoalimenticioestado = ?
                WHERE tbcompraproductoalimenticioid = ?");

            return $sql->execute(array(0, $idProductoAlimenticio));
        }

        return false;
    }

    public function actualizarCompraProductoAlimenticio($compraProductoAlimenticio, $compraProductoAlimenticioId)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
            UPDATE tbcompraproductoalimenticio 
            SET 
                tbcompraproductoalimenticionombre = ?, 
                tbcompraproductoalimenticiotipo = ?, 
                tbcompraproductoalimenticiocantidad = ?, 
                tbcompraproductoalimenticiofechavencimiento = ?, 
                tbcompraproductoalimenticioproveedor = ?, 
                tbcompraproductoalimenticioproductor = ?,
                tbcompraproductoalimenticioprecio = ?,
                tbcompraproductoalimenticiofechacompra = ?
            WHERE tbcompraproductoalimenticioid = ? AND tbcompraproductoalimenticioestado = 1");

        return $sql->execute(array(
            $compraProductoAlimenticio->getNombre(),
            $compraProductoAlimenticio->getTipo(),
            $compraProductoAlimenticio->getCantidad(),
            $compraProductoAlimenticio->getFechaVencimiento(),
            $compraProductoAlimenticio->getProveedor(),
            $compraProductoAlimenticio->getProductor(),
            $compraProductoAlimenticio->getPrecio(),
            $compraProductoAlimenticio->getFechaCompra(),
            $compraProductoAlimenticioId
        ));
    }

    public function validarCompraProductoAlimenticioParecidos($nombre, $productor)
    {
        $con = $this->conectar();

        $sql = $con->prepare("SELECT tbcompraproductoalimenticionombre 
            FROM tbcompraproductoalimenticio 
            WHERE tbcompraproductoalimenticioestado = 1 
            AND tbproductor = ?");

        $sql->execute(array($productor));
        $tiposCompraProductoAlimenticio = $sql->fetchAll(PDO::FETCH_COLUMN);

        $tiposSimilares = [];
        foreach ($tiposCompraProductoAlimenticio as $nombreCompraProductoAlimenticio) {
            $distancia = levenshtein(strtolower($nombre), strtolower($nombreCompraProductoAlimenticio));
            if ($distancia <= 2) {
                $tiposSimilares[] = $nombreCompraProductoAlimenticio;
            }
        }

        return json_encode($tiposSimilares);
    }
}
