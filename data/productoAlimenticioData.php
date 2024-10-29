<?php

include_once "../domain/productoAlimenticio.php";
include_once "../data/database.php";

class productoAlimenticioData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    private function obtenerMaxId()
    {
        $con = $this->conectar();
        $stmt = $con->prepare("SELECT MAX(tbproductoalimenticioid) AS maxid FROM tbproductoalimenticio");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['maxid'] + 1;
    }

    public function insertarProductoAlimenticio($productoAlimenticio)
    {
        $con = $this->conectar();

        $sql = $con->prepare("INSERT INTO tbproductoalimenticio 
            (tbproductoalimenticioid, tbproductoalimenticionombre, tbproductoalimenticiotipo, tbproductoalimenticiocantidad, 
            tbproductoalimenticiofechavencimiento, tbproductoalimenticioproveedor, tbproductoalimenticioproductor, tbproductoalimenticioestado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        return $sql->execute(array(
            $this->obtenerMaxId(),
            $productoAlimenticio->getNombre(),
            $productoAlimenticio->getTipo(),
            $productoAlimenticio->getCantidad(),
            $productoAlimenticio->getFechaVencimiento(),
            $productoAlimenticio->getProveedor(),
            $productoAlimenticio->getProductor(),
            1
        ));
    }

    public function obtenerIdPorAtributos($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor)
    {
        $con = $this->conectar();

        $sql = $con->prepare("SELECT tbproductoalimenticioid 
            FROM tbproductoalimenticio 
            WHERE tbproductoalimenticionombre=? 
            AND tbproductoalimenticiotipo=? 
            AND tbproductoalimenticiocantidad=? 
            AND tbproductoalimenticiofechavencimiento=? 
            AND tbproductoalimenticioproveedor=? 
            AND tbproductoalimenticioproductor=? 
            AND tbproductoalimenticioestado=1");

        $sql->execute(array($nombre, $tipo, $cantidad, $fechavencimiento, $proveedor, $productor));
        $resultado = $sql->fetch();

        return $resultado ? $resultado['tbproductoalimenticioid'] : null;
    }

    public function consultarProductoAlimenticio($productorId, $estado)
    {
        $productoList = [];
        $con = $this->conectar();

        if ($con) {
            $sql = $con->prepare("
            SELECT DISTINCT
                p.tbproductoalimenticionombre AS nombre,
                t.tbtipoproductoalimenticionombre AS tipo,
                p.tbproductoalimenticiocantidad AS cantidad,
                p.tbproductoalimenticiofechavencimiento AS fechavencimiento,
                prov.tbproveedornombrecomercial AS proveedor,
                p.tbproductoalimenticioproductor AS productor
            FROM 
                tbproductoalimenticio p
            JOIN
                tbtipoproductoalimenticio t 
            ON p.tbproductoalimenticiotipo = t.tbtipoproductoalimenticioid
            JOIN 
                tbproveedor prov 
            ON p.tbproductoalimenticioproveedor = prov.tbproveedorid
            WHERE 
                p.tbproductoalimenticioestado = ?
            AND p.tbproductoalimenticioproductor = ?;");

            $sql->execute([$estado, $productorId]);

            // Obtener todos los resultados
            foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $data) {
                $productoList[] = array(
                    "nombre" => $data['nombre'],
                    "tipo" => $data['tipo'],
                    "cantidad" => $data['cantidad'],
                    "fechavencimiento" => $data['fechavencimiento'],
                    "proveedor" => $data['proveedor'],
                    "productor" => $data['productor']
                );
            }
        }

        return json_encode($productoList);
    }

    public function eliminarProductoAlimenticio($productoAlimenticio)
    {
        $con = $this->conectar();

        $idProductoAlimenticio = $this->obtenerIdPorAtributos(
            $productoAlimenticio->getNombre(),
            $productoAlimenticio->getTipo(),
            $productoAlimenticio->getCantidad(),
            $productoAlimenticio->getFechaVencimiento(),
            $productoAlimenticio->getProveedor(),
            $productoAlimenticio->getProductor()
        );

        if ($idProductoAlimenticio !== null) {
            $sql = $con->prepare("UPDATE tbproductoalimenticio
                SET tbproductoalimenticioestado = ?
                WHERE tbproductoalimenticioid = ?");

            return $sql->execute(array(0, $idProductoAlimenticio));
        }

        return false;
    }

    public function actualizarProductoAlimenticio($productoAlimenticio, $productoAlimenticioId)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
            UPDATE tbproductoalimenticio 
            SET 
                tbproductoalimenticionombre = ?, 
                tbproductoalimenticiotipo = ?, 
                tbproductoalimenticiocantidad = ?, 
                tbproductoalimenticiofechavencimiento = ?, 
                tbproductoalimenticioproveedor = ?, 
                tbproductoalimenticioproductor = ?
            WHERE tbproductoalimenticioid = ? AND tbproductoalimenticioestado = 1");

        return $sql->execute(array(
            $productoAlimenticio->getNombre(),
            $productoAlimenticio->getTipo(),
            $productoAlimenticio->getCantidad(),
            $productoAlimenticio->getFechaVencimiento(),
            $productoAlimenticio->getProveedor(),
            $productoAlimenticio->getProductor(),
            $productoAlimenticioId
        ));
    }

    public function validarProductoAlimenticioParecidos($nombre, $productor)
    {
        $con = $this->conectar();

        $sql = $con->prepare("SELECT tbproductoalimenticionombre 
            FROM tbproductoalimenticio 
            WHERE tbproductoalimenticioestado = 1 
            AND tbproductor = ?");

        $sql->execute(array($productor));
        $tiposProductoAlimenticio = $sql->fetchAll(PDO::FETCH_COLUMN);

        $tiposSimilares = [];
        foreach ($tiposProductoAlimenticio as $nombreProductoAlimenticio) {
            $distancia = levenshtein(strtolower($nombre), strtolower($nombreProductoAlimenticio));
            if ($distancia <= 2) {
                $tiposSimilares[] = $nombreProductoAlimenticio;
            }
        }

        return json_encode($tiposSimilares);
    }

    public function reactivarProductoAlimenticio($nombre, $proveedorId, $productorId)
    {
        $con = $this->conectar();
        $sql = $con->prepare("
            UPDATE tbproductoalimenticio
            SET tbproductoalimenticioestado = 1
            WHERE tbproductoalimenticionombre = ? AND tbproductoalimenticioproveedor = ? AND tbproductoalimenticioproductor = ?
        ");
        return $sql->execute(array($nombre, $proveedorId, $productorId));
    }
}
