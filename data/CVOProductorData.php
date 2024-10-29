<?php
include_once "../domain/CVOProductor.php";
include_once "../data/database.php";

class CVOProductorData extends DataBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function verificarCVOProductorEstado($CVOProductor, $CVOProductorEstado)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT COUNT(*) as count
        FROM tbcvoproductor
        WHERE tbcvoproductornumCVO = ? AND tbcvoproductorcedproductor = ? AND tbcvoproductorestado = ?");
        $sql->execute(array($CVOProductor->getnumCVO(), $CVOProductor->getcedProductor(), $CVOProductorEstado));

        $result = $sql->fetch();
        return $result['count'] > 0;
    }

    public function activarCVOProductor($CVOProductor)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        UPDATE tbcvoproductor
        SET tbcvoproductorestado = 1 
        WHERE tbcvoproductornumCVO = ? AND tbcvoproductorcedproductor = ?");
        return $sql->execute(array($CVOProductor->getnumCVO(), $CVOProductor->getcedProductor()));
    }

    public function insertarCVOProductor($CVOProductor)
    {
        if ($this->verificarCVOProductorEstado($CVOProductor, 1)) {
            return false;
        }

        if ($this->verificarCVOProductorEstado($CVOProductor, 0)) {
            return $this->activarCVOProductor($CVOProductor);
        }

        $con = $this->conectar();

        $numCVO = $CVOProductor->getnumCVO();
        $cedProductor = $CVOProductor->getcedProductor();

        $tempsql = $con->prepare("SELECT MAX(tbcvoproductorid) AS tbcvoproductorid FROM tbcvoproductor");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbcvoproductor (tbcvoproductorid, tbcvoproductornumCVO, tbcvoproductorcedproductor, tbcvoproductorestado) VALUES (?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $numCVO,
            $cedProductor,
            1
        ));
    }

    public function consultarCVOPorProductor($cedProductor)
    {
        $con = $this->conectar();

        $sql = $con->prepare("
        SELECT tbcvoproductor.tbcvoproductornumCVO, tbcvo.tbcvofechaEmision, tbcvo.tbcvofechaVencimiento, tbcvo.tbcvoimagen
        FROM tbcvoproductor
        JOIN tbcvo ON tbcvoproductor.tbcvoproductornumCVO = tbcvo.tbcvonumero 
        WHERE tbcvoproductor.tbcvoproductorcedproductor = ? AND tbcvoproductor.tbcvoproductorestado = 1
    ");
        $sql->execute(array($cedProductor));

        $CVOProductorList = array();
        foreach ($sql->fetchAll() as $data) {
            $CVOProductorList[] = array(
                "numCVO" => $data['tbcvoproductornumCVO'],
                "fechaEmision" => $data['tbcvofechaEmision'],
                "fechaVencimiento" => $data['tbcvofechaVencimiento'],
                "imagen" => $data['tbcvoimagen']
            );
        }

        $jsonString = json_encode($CVOProductorList);
        return $jsonString;
    }

    public function eliminarCVOProductor($numCVO, $cedProductor)
{
    $con = $this->conectar();

    $sql = $con->prepare("UPDATE tbcvoproductor SET tbcvoproductorestado=? WHERE tbcvoproductornumCVO=? AND tbcvoproductorcedproductor=?");
    return $sql->execute(array(0, $numCVO, $cedProductor));
}

}
