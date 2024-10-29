<?php
include_once "../domain/CVO.php";
include_once "../data/database.php";

class cvoData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarCVO($CVO, $productoID)
    {
        $con = $this->conectar();

        $numero = $CVO->getNumero();
        $fechaEmision = $CVO->getFechaEmision();
        $fechaVencimiento = $CVO->getFechaVencimiento();
        $imagen = $CVO->getImagen();


        $tempsql = $con->prepare("SELECT MAX(tbcvoid) AS tbcvoid FROM tbcvo");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbcvo(tbcvoid, tbcvonumero, tbcvofechaEmision, tbcvofechaVencimiento, tbcvoimagen, tbcvoproductorid, tbcvoestado) VALUES (?,?,?,?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $numero,
            $fechaEmision,
            $fechaVencimiento,
            $imagen,
            $productoID,
            1
        ));
    }

    public function consultarCVO($productoID)
    {
        $CVOLista = array();
        $con = $this->conectar();
        if ($con) {

            $sql = $con->prepare("SELECT * FROM tbcvo WHERE tbcvoestado = 1 AND tbcvoproductorid = ?");

            $sql->execute([$productoID]);

            foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $data) {
                $CVOLista[] = array(
                    "tbcvonumero" => $data['tbcvonumero'],
                    "tbcvofechaEmision" => $data['tbcvofechaEmision'],
                    "tbcvofechaVencimiento" => $data['tbcvofechaVencimiento'],
                    "tbcvoimagen" => $data['tbcvoimagen']
                );
            }
        }
        $jsonString = json_encode($CVOLista);
        return $jsonString;
    }

    public static function consultarNumeroCVO($numero, $productoID)
    {
        $conexion = new cvoData;
        $con = $conexion->conectar();
        $CVOLista = array();
        $sql = $con->prepare("SELECT * FROM tbcvo WHERE tbcvonumero=? AND tbcvoproductorid=?");
        $sql->execute(array($numero, $productoID));
        foreach ($sql->fetchAll() as $data) {
            $CVOLista[] = array(
                "tbcvonumero" => $data['tbcvonumero'],
                "tbcvofechaEmision" => $data['tbcvofechaEmision'],
                "tbcvofechaVencimiento" => $data['tbcvofechaVencimiento'],
                "tbcvoimagen" => $data['tbcvoimagen']
            );
        }
        $jsonString = json_encode($CVOLista);
        return $jsonString;
    }

    public function actualizarCVO($CVO, $productoID)
    {
        $con = $this->conectar();

        if ($con) {
            try {
                $numero = $CVO->getNumero();
                $fechaEmision = $CVO->getFechaEmision();
                $fechaVencimiento = $CVO->getFechaVencimiento();
                $imagen = $CVO->getImagen();
                $sql = $con->prepare("UPDATE tbcvo SET tbcvofechaEmision = ?,  tbcvofechaVencimiento = ?, tbcvoimagen = ? WHERE tbcvonumero = ? AND tbcvoproductorid = ?");
                $resultado = $sql->execute(array($fechaEmision, $fechaVencimiento, $imagen, $numero, $productoID));

                return $resultado ? 1 : 0;
            } catch (PDOException $e) {
                echo "Error al actualizar el CVO: " . $e->getMessage();
                return 0;
            }
        }
        return 0;
    }

    public static function validarNumeroCVO($numero, $productoID)
    {
        $conexion = new cvoData();
        $con = $conexion->conectar();
        $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbcvo WHERE tbcvonumero = ? AND tbcvoproductorid = ?), 1, 0) AS resultado ");
        $sql->execute(array($numero, $productoID));
        return $sql->fetchColumn();
    }


    public function eliminarCVO($codigo, $productoID)
    {
        $con = $this->conectar();
        $sql = $con->prepare("UPDATE tbcvo SET tbcvoestado=? WHERE tbcvonumero=? AND tbcvoproductorid = ?");
        return $sql->execute(array(0, $codigo, $productoID));
    }
}
