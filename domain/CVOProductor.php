<?php

class CVOProductor
{
    private $numCVO;
    private $cedProductor;

    public function __construct($numCVO, $cedProductor) {
        $this->numCVO = $numCVO;
        $this->cedProductor = $cedProductor;
    }

    public function setnumCVO($numCVO)
    {
        $this->numCVO = $numCVO;

        return $this;
    }

    public function getnumCVO()
    {
        return $this->numCVO;
    }

    public function setcedProductor($cedProductor)
    {
        $this->cedProductor = $cedProductor;

        return $this;
    }

    public function getcedProductor()
    {
        return $this->cedProductor;
    }

}