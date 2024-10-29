<?php

include_once "../data/bovinoCompraData.php";

class bovinoCompraBusiness
{
    private $bovinoCompraData;

    public function __construct()
    {
        $this->bovinoCompraData = new bovinoCompraData();
    }

    public function insertarBovino($bovino)
    {
        return $this->bovinoCompraData->insertarBovino($bovino);
    }
    public function verificarNumeroBovino($numero, $productorID)
    {
        return $this->bovinoCompraData->verificarNumeroBovino($numero, $productorID);
    }

    public function consultarBovino($usuarioID, $manejoActual)
    {
        return $this->bovinoCompraData->consultarBovino($usuarioID, $manejoActual);
    }

    public function eliminarBovino($numero, $usuarioID)
    {
        return $this->bovinoCompraData->eliminarBovino($numero, $usuarioID);
    }

    public function consultarBovinoPorNumero($numero, $usuarioID)
    {
        return $this->bovinoCompraData->consultarBovinoPorNumero($numero, $usuarioID);
    }

    public function actualizarBovino($bovino, $usuarioID)
    {
        return $this->bovinoCompraData->actualizarBovino($bovino, $usuarioID);
    }

    public function reactivarBovino($numero)
    {
        return $this->bovinoCompraData->reactivarBovino($numero);
    }

    public function obtenerIdPorNumero($numero, $usuarioID)
    {
        return $this->bovinoCompraData->obtenerIdPorNumero($numero, $usuarioID);
    }

    public function consultarBovinoPorGenero($genero, $usuarioID){
        return $this->bovinoCompraData->consultarBovinoPorGenero($genero, $usuarioID);
    }
}
