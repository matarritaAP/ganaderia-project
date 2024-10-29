<?php

class fincaServicio
{
    private $finca;
    private $servicio;

    public function __construct($finca, $servicio)
    {
        $this->finca = $finca;
        $this->servicio = $servicio;
    }

    public function getFinca()
    {
        return $this->finca;
    }

    public function getservicio()
    {
        return $this->servicio;
    }

    public function setFinca($finca)
    {
        $this->finca = $finca;
    }

    public function setServicio($servicio)
    {
        $this->servicio = $servicio;
    }
}
