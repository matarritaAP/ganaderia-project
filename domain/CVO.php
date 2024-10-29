<?php
class CVO
{
    private $numero;
    private $fechaEmision;
    private $fechaVencimiento;
    private $imagen;

    public function __construct($numero, $fechaEmision, $fechaVencimiento, $imagen)
    {
        $this->numero = $numero;
        $this->fechaEmision = $fechaEmision;
        $this->fechaVencimiento = $fechaVencimiento;
        $this->imagen = $imagen;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

}