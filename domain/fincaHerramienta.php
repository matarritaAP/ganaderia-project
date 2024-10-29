<?php

class fincaHerramienta
{
    private $finca;
    private $herramienta;

    public function __construct($finca, $herramienta)
    {
        $this->finca = $finca;
        $this->herramienta = $herramienta;
    }

    public function getFinca()
    {
        return $this->finca;
    }

    public function getHerramienta()
    {
        return $this->herramienta;
    }

    public function setFinca($finca)
    {
        $this->finca = $finca;
    }

    public function setHerramienta($herramienta)
    {
        $this->herramienta = $herramienta;
    }
}
