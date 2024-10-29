<?php

class Enfermedad {

    private $tbenfermedadid;
    private $tbenfermedadproductorid;
    private $tbenfermedadnombre;
    private $tbenfermedaddescripcion;
    private $tbenfermedadsintomas;

    // Constructor
    public function __construct($id, $productorid, $nombre, $descripcion, $sintomas) {
        $this->tbenfermedadid = $id;
        $this->tbenfermedadproductorid = $productorid;
        $this->tbenfermedadnombre = $nombre;
        $this->tbenfermedaddescripcion = $descripcion;
        $this->tbenfermedadsintomas = $sintomas;
    }

    /**
     * Get the value of tbenfermedadid
     */ 
    public function getTbenfermedadid()
    {
        return $this->tbenfermedadid;
    }

    /**
     * Set the value of tbenfermedadid
     *
     * @return  self
     */ 
    public function setTbenfermedadid($tbenfermedadid)
    {
        $this->tbenfermedadid = $tbenfermedadid;

        return $this;
    }

    /**
     * Get the value of tbenfermedadproductorid
     */ 
    public function getTbenfermedadproductorid()
    {
        return $this->tbenfermedadproductorid;
    }

    /**
     * Set the value of tbenfermedadproductorid
     *
     * @return  self
     */ 
    public function setTbenfermedadproductorid($tbenfermedadproductorid)
    {
        $this->tbenfermedadproductorid = $tbenfermedadproductorid;

        return $this;
    }

    /**
     * Get the value of tbenfermedadnombre
     */ 
    public function getTbenfermedadnombre()
    {
        return $this->tbenfermedadnombre;
    }

    /**
     * Set the value of tbenfermedadnombre
     *
     * @return  self
     */ 
    public function setTbenfermedadnombre($tbenfermedadnombre)
    {
        $this->tbenfermedadnombre = $tbenfermedadnombre;

        return $this;
    }

    /**
     * Get the value of tbenfermedaddescripcion
     */ 
    public function getTbenfermedaddescripcion()
    {
        return $this->tbenfermedaddescripcion;
    }

    /**
     * Set the value of tbenfermedaddescripcion
     *
     * @return  self
     */ 
    public function setTbenfermedaddescripcion($tbenfermedaddescripcion)
    {
        $this->tbenfermedaddescripcion = $tbenfermedaddescripcion;

        return $this;
    }

    /**
     * Get the value of tbenfermedadsintomas
     */ 
    public function getTbenfermedadsintomas()
    {
        return $this->tbenfermedadsintomas;
    }

    /**
     * Set the value of tbenfermedadsintomas
     *
     * @return  self
     */ 
    public function setTbenfermedadsintomas($tbenfermedadsintomas)
    {
        $this->tbenfermedadsintomas = $tbenfermedadsintomas;

        return $this;
    }
}
?>