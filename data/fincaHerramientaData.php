<?php

include_once "../domain/fincaHerramienta.php";
include_once "../data/database.php";

class fincaHerramientaData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function verificarFincaHerramienta($fincaHerramienta)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT COUNT(*) as count
        FROM tbfincaherramienta
        WHERE tbfincaherramientafincaid = ? AND tbfincaherramientaherramientaid = ? AND tbfincaherramientaestado = ?");
        $sql->execute(array($fincaHerramienta->getFinca(), $fincaHerramienta->getHerramienta(), 1));

        $result = $sql->fetch();
        return $result['count'] > 0;
    }

    public function activarFincaHerramienta($fincaHerramienta)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        UPDATE tbfincaherramienta
        SET tbfincaherramientaestado = 1 
        WHERE tbfincaherramientafincaid = ? AND tbfincaherramientaherramientaid = ?");
        return $sql->execute(array($fincaHerramienta->getFinca(), $fincaHerramienta->getHerramienta()));
    }

    public function insertarFincaHerramienta($fincaHerramienta)
    {
        // Verificar si ya existe un registro activo
        if ($this->verificarFincaHerramienta($fincaHerramienta)) {
            return false; // Ya existe esa herramienta en la finca
        }

        // Verificar si ya existe un registro inactivo
        if ($this->verificarFincaHerramienta($fincaHerramienta)) {
            return $this->activarFincaHerramienta($fincaHerramienta); // Activar el registro inactivo
        }

        $con = $this->conectar();

        $fincaId = $fincaHerramienta->getFinca();
        $herramientaId = $fincaHerramienta->getHerramienta();

        $tempsql = $con->prepare("SELECT MAX(tbfincaherramientaid) AS tbfincaherramientaid FROM tbfincaherramienta");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbfincaherramienta (tbfincaherramientaid, tbfincaherramientafincaid, tbfincaherramientaherramientaid, tbfincaherramientaestado) VALUES (?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $fincaId,
            $herramientaId,
            1
        ));
    }

    public function consultarHerramientasPorFinca($fincaId, $estado)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
    SELECT 
        tbherramienta.tbherramientacodigo,
        tbherramienta.tbherramientanombre,
        tbherramienta.tbherramientadescripcion,
        tbherramienta.tbherramientaid
    FROM tbherramienta
    INNER JOIN 
        tbfincaherramienta ON tbherramienta.tbherramientaid = tbfincaherramienta.tbfincaherramientaherramientaid
    WHERE
        tbfincaherramienta.tbfincaherramientafincaid = ?
    AND
        tbfincaherramienta.tbfincaherramientaestado = ?");
        $sql->execute(array($fincaId, $estado));

        $fincaHerramientaList = array();
        foreach ($sql->fetchAll() as $data) {
            $fincaHerramientaList[] = array(
                "codHerramienta" => $data['tbherramientaid'],
                "descripcionHerramienta" => $data["tbherramientadescripcion"],
                "nombreHerramienta" => $data['tbherramientanombre']
            );
        }

        return json_encode($fincaHerramientaList);
    }

    public function eliminarFincaHerramienta($fincaId, $herramientaId)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbfincaherramienta SET tbfincaherramientaestado=? WHERE tbfincaherramientafincaid=? AND tbfincaherramientaherramientaid=?");
        return $sql->execute(array(0, $fincaId, $herramientaId));
    }

    public function reactivarHerammientaFinca($fincaHerramienta)
    {
        if (!$this->verificarFincaHerramienta($fincaHerramienta)) {   
            return $this->activarFincaHerramienta($fincaHerramienta);
        }
    }
}
