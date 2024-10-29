<?php

class fincaNaturaleza
{
    private $finca;
    private $naturaleza;

    public function __construct($finca, $naturaleza)
    {
        $this->finca = $finca;
        $this->naturaleza = $naturaleza;
    }

    public function getFinca()
    {
        return $this->finca;
    }

    public function getNaturaleza()
    {
        return $this->naturaleza;
    }

    public function setFinca($finca)
    {
        $this->finca = $finca;
    }

    public function setNaturaleza($naturaleza)
    {
        $this->naturaleza = $naturaleza;
    }
}
