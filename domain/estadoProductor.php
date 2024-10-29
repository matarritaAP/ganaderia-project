<?php

class estadoProductor
{

    private $codEstado;
    private $cedProductor;

    public function __construct($codEstado, $cedProductor)
    {
        $this->codEstado = $codEstado;
        $this->cedProductor = $cedProductor;
    }

    public function getCodEstado()
    {
        return $this->codEstado;
    }

    public function getCedProductor()
    {
        return $this->cedProductor;
    }

    public function setCodEstado($codEstado)
    {
        $this->codEstado = $codEstado;
        
        return $this;
    }

    public function setCedProductor($cedProductor)
    {
        $this->cedProductor = $cedProductor;
        
        return $this;
    }
}
