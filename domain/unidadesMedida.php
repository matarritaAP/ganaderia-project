<?php
class unidadesMedida
{
    private $tipoUnidad;

    public function __construct($tipoUnidad)
    {
        $this->tipoUnidad = $tipoUnidad;
    }

    public function setTipoUnidad($tipoUnidad)
    {
        $this->tipoUnidad = $tipoUnidad;

        return $this;
    }

    public function getTipoUnidad()
    {
        return $this->tipoUnidad;
    }

}