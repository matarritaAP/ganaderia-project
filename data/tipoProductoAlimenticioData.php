<?php

include_once "../domain/tipoProductoAlimenticio.php";
include_once "../data/database.php";

class tipoProductoAlimenticioData extends DataBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertarTipoProductoAlimenticio($tipoProductoAlimenticio)
    {
        $con = $this->conectar();

        $nombre = $tipoProductoAlimenticio->getNombre();
        $descripcion = $tipoProductoAlimenticio->getDescripcion();

        $tempsql = $con->prepare("SELECT MAX(tbtipoproductoalimenticioid) AS tbtipoproductoalimenticioid FROM tbtipoproductoalimenticio");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbtipoproductoalimenticio(tbtipoproductoalimenticioid, tbtipoproductoalimenticionombre, tbtipoproductoalimenticiodescripcion, tbtipoproductoalimenticioestado) VALUES (?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $nombre,
            $descripcion,
            1
        ));
    }

    public function consultarTipoProductoAlimenticio()
    {
        $TipoProdList = array();
        $con = $this->conectar();
        if ($con) {
            $sql = $con->query("SELECT * FROM tbtipoproductoalimenticio WHERE tbtipoproductoalimenticioestado=1");
            foreach ($sql->fetchAll() as $data) {
                $TipoProdList[] = array(
                    "nombre" => $data['tbtipoproductoalimenticionombre'],
                    "descripcion" => $data['tbtipoproductoalimenticiodescripcion']
                );
            }
        }
        $jsonString = json_encode($TipoProdList);
        return $jsonString;
    }

    public function obtenerIdPorNombreYDescripcion($nombre, $descripcion)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT tbtipoproductoalimenticioid 
        FROM tbtipoproductoalimenticio 
        WHERE tbtipoproductoalimenticionombre=? 
        AND tbtipoproductoalimenticiodescripcion=? 
        AND tbtipoproductoalimenticioestado=1");

        $sql->execute(array($nombre, $descripcion));
        $resultado = $sql->fetch();

        if ($resultado) {
            return $resultado['tbtipoproductoalimenticioid'];
        } else {
            return null;
        }
    }

    public function eliminarTipoProductoAlimenticio($nombre, $descripcion)
    {
        $con = $this->conectar();
        $id = $this->obtenerIdPorNombreYDescripcion($nombre, $descripcion);

        if ($id !== null) {
            $sql = $con->prepare("
            UPDATE tbtipoproductoalimenticio 
            SET tbtipoproductoalimenticioestado=? 
            WHERE tbtipoproductoalimenticioid=?");
            return $sql->execute(array(0, $id));
        } else {
            return false;
        }
    }

    public static function actualizarTipoProductoAlimenticio($nombreAntiguo, $descripcionAntigua, $tipoProductoAlimenticioNuevo)
    {
        $conexion = new tipoProductoAlimenticioData();
        $con = $conexion->conectar();
        $id = $conexion->obtenerIdPorNombreYDescripcion($nombreAntiguo, $descripcionAntigua);

        if ($id !== null) {
            $sql = $con->prepare("
            UPDATE tbtipoproductoalimenticio SET 
                tbtipoproductoalimenticionombre=?, 
                tbtipoproductoalimenticiodescripcion=?
            WHERE tbtipoproductoalimenticioid=?");

            return $sql->execute(array(
                $tipoProductoAlimenticioNuevo->getNombre(),
                $tipoProductoAlimenticioNuevo->getDescripcion(),
                $id
            ));
        } else {
            return false;
        }
    }

    public static function validarTiposProductoAlimenticioParecidos($nombre)
    {
        $conexion = new tipoProductoAlimenticioData();
        $con = $conexion->conectar();

        $sql = $con->prepare("SELECT tbtipoproductoalimenticionombre FROM tbtipoproductoalimenticio WHERE tbtipoproductoalimenticioestado = 1");
        $sql->execute();
        $tiposProductoAlimenticio = $sql->fetchAll(PDO::FETCH_COLUMN); // Obtener toda la columna de nombres

        $tiposSimilares = [];
        foreach ($tiposProductoAlimenticio as $nombreProductoAlimenticio) {
            $distancia = levenshtein(strtolower($nombre), strtolower($nombreProductoAlimenticio));

            if ($distancia <= 2) {
                $tiposSimilares[] = $nombreProductoAlimenticio;
            }
        }
        return json_encode($tiposSimilares);
    }
}
