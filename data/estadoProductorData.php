<?php

include_once "../domain/estadoProductor.php";
include_once "../data/database.php";

class estadoProductorData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function verificarEstadoProductor($estadoProductor, $estadoRaza)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT COUNT(*) as count
        FROM tbestadoproductor
        WHERE tbestadoproductorcedproductor = ? AND tbestadoproductorcodestado = ? AND tbestadoproductorestado = ?");
        $sql->execute(array($estadoProductor->getCedProductor(), $estadoProductor->getCodEstado(), $estadoRaza));

        $result = $sql->fetch();
        return $result['count'] > 0;
    }

    public function activarEstadoProductor($estadoProductor)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        UPDATE tbestadoproductor
        SET tbestadoproductorestado = 1 
        WHERE  tbestadoproductorcedproductor = ? AND tbestadoproductorcodestado = ?");
        return $sql->execute(array($estadoProductor->getCedProductor(), $estadoProductor->getCodEstado()));
    }

    public function insertarEstadoProductor($estadoProductor)
    {
        // Verificar si ya existe un registro activo
        if ($this->verificarEstadoProductor($estadoProductor, 1)) {
            return false; // Ya existe ese estado como favorita
        }

        // Verificar si ya existe un registro inactivo
        if ($this->verificarEstadoProductor($estadoProductor, 0)) {
            return $this->activarEstadoProductor($estadoProductor); // Activar el registro inactivo
        }

        $con = $this->conectar();

        $codEstado = $estadoProductor->getCodEstado();
        $cedProductor = $estadoProductor->getCedProductor();

        $tempsql = $con->prepare("SELECT MAX(tbestadoproductorid) AS tbestadoproductorid FROM tbestadoproductor");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbestadoproductor (tbestadoproductorid, tbestadoproductorcodestado, tbestadoproductorcedproductor, tbestadoproductorestado) VALUES (?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $codEstado,
            $cedProductor,
            1
        ));
    }

    public function consultarEstadosPorProductor($cedProductor, $estado)
    {
        $con = $this->conectar();

        $sql = $con->prepare("

        SELECT 
            tbestado.tbestadocodigo,
            tbestado.tbestadonombre,
            tbestado.tbestadodescripcion
        FROM tbestado
        INNER JOIN 
            tbestadoproductor ON tbestado.tbestadocodigo = tbestadoproductor.tbestadoproductorcodestado
        WHERE 
            tbestadoproductor.tbestadoproductorcedproductor = ?
        AND 
            tbestadoproductor.tbestadoproductorestado = ?");
        $sql->execute(array($cedProductor, $estado));

        $estadoProductorList = array();
        foreach ($sql->fetchAll() as $data) {
            $estadoProductorList[] = array(
                "codEstado" => $data["tbestadocodigo"],
                "descripcionEstado" => $data['tbestadodescripcion'],
                "nombreEstado" => $data['tbestadonombre']
            );
        }

        $jsonString = json_encode($estadoProductorList);
        return $jsonString;
    }


    public function eliminarEstadoProductor($cedProductor, $codEstado)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbestadoproductor SET tbestadoproductorestado=? WHERE tbestadoproductorcedproductor=? AND tbestadoproductorcodestado=?");
        return $sql->execute(array(0, $cedProductor, $codEstado));
    }

    public function reactivarEstadoProductor($estadoProductor)
    {
        if ($this->verificarEstadoProductor($estadoProductor, 0)) {
            return $this->activarEstadoProductor($estadoProductor);
        }
    }

    public function obtenerIdEstado($codEstado)
    {
        $con = $this->conectar();

        $sql = $con->prepare("SELECT tbestadoproductorid FROM tbestadoproductor WHERE tbestadoproductorcodestado = ?");
        $sql->execute(array($codEstado));

        $result = $sql->fetch();
        return $result ? $result['tbestadoproductorid'] : null; // Devuelve el ID o null si no se encuentra
    }
}
