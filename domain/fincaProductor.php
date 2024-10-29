<?php

class fincaProductor
{

    private $productor;
    private $finca;

    public function __construct($productor, $finca)
    {
        $this->productor = $productor;
        $this->finca = $finca;
    }

    public function getProductor()
    {
        return $this->productor;
    }

    public function getFinca()
    {
        return $this->finca;
    }

    public function setProductor($productor)
    {
        $this->productor = $productor;
    }

    public function setFinca($finca)
    {
        $this->finca = $finca;
    }
}
