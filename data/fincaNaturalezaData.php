<?php

include_once "../domain/fincaNaturaleza.php";
include_once "../data/database.php";

class fincaNaturalezaData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function verificarFincaNaturaleza($fincaNaturaleza)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT COUNT(*) as count
        FROM tbfincanaturaleza
        WHERE tbfincanaturalezafincaid = ? AND tbfincanaturalezanaturalezaid = ? AND tbfincanaturalezaestado = ?");
        $sql->execute(array($fincaNaturaleza->getFinca(), $fincaNaturaleza->getNaturaleza(), 1));

        $result = $sql->fetch();
        return $result['count'] > 0;
    }

    public function activarFincaNaturaleza($fincaNaturaleza)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        UPDATE tbfincanaturaleza
        SET tbfincanaturalezaestado = 1 
        WHERE tbfincanaturalezafincaid = ? AND tbfincanaturalezanaturalezaid = ?");
        return $sql->execute(array($fincaNaturaleza->getFinca(), $fincaNaturaleza->getNaturaleza()));
    }

    public function insertarFincaNaturaleza($fincaNaturaleza)
    {
        // Verificar si ya existe un registro activo
        if ($this->verificarFincaNaturaleza($fincaNaturaleza)) {
            return false; // Ya existe esa naturaleza en la finca
        }

        // Verificar si ya existe un registro inactivo
        if ($this->verificarFincaNaturaleza($fincaNaturaleza)) {
            return $this->activarFincaNaturaleza($fincaNaturaleza); // Activar el registro inactivo
        }

        $con = $this->conectar();

        $fincaId = $fincaNaturaleza->getFinca();
        $naturalezaId = $fincaNaturaleza->getNaturaleza();

        $tempsql = $con->prepare("SELECT MAX(tbfincanaturalezaid) AS tbfincanaturalezaid FROM tbfincanaturaleza");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbfincanaturaleza (tbfincanaturalezaid, tbfincanaturalezafincaid, tbfincanaturalezanaturalezaid, tbfincanaturalezaestado) VALUES (?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $fincaId,
            $naturalezaId,
            1
        ));
    }

    public function consultarNaturalezaPorFinca($fincaId, $estado)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
    SELECT 
        tbnaturaleza.tbnaturalezacodigo,
        tbnaturaleza.tbnaturalezanombre,
        tbnaturaleza.tbnaturalezadescripcion
    FROM tbnaturaleza
    INNER JOIN 
        tbfincanaturaleza ON tbnaturaleza.tbnaturalezaid = tbfincanaturaleza.tbfincanaturalezanaturalezaid
    WHERE
        tbfincanaturaleza.tbfincanaturalezafincaid = ?
    AND
        tbfincanaturaleza.tbfincanaturalezaestado = ?");
        $sql->execute(array($fincaId, $estado));

        $fincaNaturalezaList = array();
        foreach ($sql->fetchAll() as $data) {
            $fincaNaturalezaList[] = array(
                "codNaturaleza" => $data['tbnaturalezacodigo'],
                "descripcionNaturaleza" => $data["tbnaturalezadescripcion"],
                "nombreNaturaleza" => $data['tbnaturalezanombre']
            );
        }

        return json_encode($fincaNaturalezaList);
    }

    public function eliminarFincaNaturaleza($fincaId, $naturalezaId)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbfincanaturaleza SET tbfincanaturalezaestado=? WHERE tbfincanaturalezafincaid=? AND tbfincanaturalezanaturalezaid=?");
        return $sql->execute(array(0, $fincaId, $naturalezaId));
    }

    public function reactivarNaturalezaFinca($fincaNaturaleza)
    {
        if (!$this->verificarFincaNaturaleza($fincaNaturaleza)) {
            return $this->activarFincaNaturaleza($fincaNaturaleza);
        }
    }
}
