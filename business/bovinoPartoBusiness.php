<?php

include_once "../data/bovinoPartoData.php";

class bovinoPartoBusiness
{
    private $bovinoPartoData;

    public function __construct()
    {
        $this->bovinoPartoData = new bovinoPartoData();
    }

    public function insertarBovino($bovino)
    {
        return $this->bovinoPartoData->insertarBovino($bovino);
    }
    public function verificarNumeroBovino($numero, $productorID)
    {
        return $this->bovinoPartoData->verificarNumeroBovino($numero, $productorID);
    }

    public function consultarBovino($usuarioID, $manejoActual)
    {
        return $this->bovinoPartoData->consultarBovino($usuarioID, $manejoActual);
    }

    public function eliminarBovino($numero, $usuarioID)
    {
        return $this->bovinoPartoData->eliminarBovino($numero, $usuarioID);
    }

    public function consultarBovinoPorNumero($numero, $usuarioID)
    {
        return $this->bovinoPartoData->consultarBovinoPorNumero($numero, $usuarioID);
    }

    public function actualizarBovino($bovino, $usuarioID)
    {
        return $this->bovinoPartoData->actualizarBovino($bovino, $usuarioID);
    }

    public function reactivarBovino($numero)
    {
        return $this->bovinoPartoData->reactivarBovino($numero);
    }

    public function obtenerIdPorNumero($numero, $usuarioID)
    {
        return $this->bovinoPartoData->obtenerIdPorNumero($numero, $usuarioID);
    }

    public function consultarBovinoPorGenero($genero, $usuarioID){
        return $this->bovinoPartoData->consultarBovinoPorGenero($genero, $usuarioID);
    }
}
