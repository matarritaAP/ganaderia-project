<?php

include_once "../domain/fincaServicio.php";
include_once "../data/database.php";

class fincaServicioData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function verificarFincaServicio($fincaServicio)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT COUNT(*) as count
        FROM tbfincaservicio
        WHERE tbfincaserviciofincaid = ? AND tbfincaservicioservicioid = ? AND tbfincaservicioestado = ?");
        $sql->execute(array($fincaServicio->getFinca(), $fincaServicio->getServicio(), 1));

        $result = $sql->fetch();
        return $result['count'] > 0;
    }

    public function activarFincaServicio($fincaServicio)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        UPDATE tbfincaservicio
        SET tbfincaservicioestado = 1 
        WHERE tbfincaserviciofincaid = ? AND tbfincaservicioservicioid = ?");
        return $sql->execute(array($fincaServicio->getFinca(), $fincaServicio->getServicio()));
    }

    public function insertarFincaServicio($fincaServicio)
    {
        // Verificar si ya existe un registro activo
        if ($this->verificarFincaServicio($fincaServicio)) {
            return false; // Ya existe ese servicio en la finca
        }

        // Verificar si ya existe un registro inactivo
        if ($this->verificarFincaServicio($fincaServicio)) {
            return $this->activarFincaServicio($fincaServicio); // Activar el registro inactivo
        }

        $con = $this->conectar();

        $fincaId = $fincaServicio->getFinca();
        $servicioId = $fincaServicio->getServicio();

        $tempsql = $con->prepare("SELECT MAX(tbfincaservicioid) AS tbfincaservicioid FROM tbfincaservicio");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbfincaservicio (tbfincaservicioid, tbfincaserviciofincaid, tbfincaservicioservicioid, tbfincaservicioestado) VALUES (?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $fincaId,
            $servicioId,
            1
        ));
    }

    public function consultarServiciosPorFinca($fincaId, $estado)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
    SELECT 
        tbservicio.tbserviciocodigo,
        tbservicio.tbservicionombre,
        tbservicio.tbserviciodescripcion
    FROM tbservicio
    INNER JOIN 
        tbfincaservicio ON tbservicio.tbservicioid = tbfincaservicio.tbfincaservicioservicioid
    WHERE
        tbfincaservicio.tbfincaserviciofincaid = ?
    AND
        tbfincaservicio.tbfincaservicioestado = ?");
        $sql->execute(array($fincaId, $estado));

        $fincaServicioList = array();
        foreach ($sql->fetchAll() as $data) {
            $fincaServicioList[] = array(
                "codServicio" => $data['tbserviciocodigo'],
                "descripcionServicio" => $data["tbserviciodescripcion"],
                "nombreServicio" => $data['tbservicionombre']
            );
        }

        return json_encode($fincaServicioList);
    }

    public function eliminarFincaServicio($fincaId, $servicioId)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbfincaservicio SET tbfincaservicioestado=? WHERE tbfincaserviciofincaid=? AND tbfincaservicioservicioid=?");
        return $sql->execute(array(0, $fincaId, $servicioId));
    }

    public function reactivarServicioFinca($fincaServicio)
    {
        if (!$this->verificarFincaServicio($fincaServicio)) {
            return $this->activarFincaServicio($fincaServicio);
        }
    }
}
