<?php

class RazaProductor
{

    private $codRaza;
    private $cedProductor;

    public function __construct($codRaza, $cedProductor)
    {
        $this->codRaza = $codRaza;
        $this->cedProductor = $cedProductor;
    }

    public function getCodRaza()
    {
        return $this->codRaza;
    }

    public function getCedProductor()
    {
        return $this->cedProductor;
    }

    public function setCodRaza($codRaza)
    {
        $this-> codRaza = $codRaza;
        
        return $this;
    }

    public function setCedProductor($cedProductor)
    {
        $this-> cedProductor = $cedProductor;
        
        return $this;
    }
}
