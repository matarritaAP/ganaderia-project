<?php
class fierro{
    private $numeroFierro;
    private $fechaEmision;
    private $fechaVencimiento;
    private $imagen;

    public function __construct($numeroFierro, $fechaEmision, $fechaVencimiento, $imagen){

        $this->numeroFierro = $numeroFierro;
        $this->fechaEmision = $fechaEmision;
        $this->fechaVencimiento = $fechaVencimiento;
        $this->imagen = $imagen; 
    }

    

    /**
     * Get the value of numeroFierro
     */ 
    public function getNumeroFierro()
    {
        return $this->numeroFierro;
    }

    /**
     * Set the value of numeroFierro
     *
     * @return  self
     */ 
    public function setNumeroFierro($numeroFierro)
    {
        $this->numeroFierro = $numeroFierro;

        return $this;
    }

    /**
     * Get the value of fechaEmision
     */ 
    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    /**
     * Set the value of fechaEmision
     *
     * @return  self
     */ 
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * Get the value of fechaVencimiento
     */ 
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set the value of fechaVencimiento
     *
     * @return  self
     */ 
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get the value of imagen
     */ 
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */ 
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }
}