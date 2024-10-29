<?php

class BovinoEvento
{

    private $bovino; // ID del bovino
    private $tipoEvento;
    private $fecha;
    private $descripcion;
    private $productor;
    private $activo; // Estado del evento (1: Activo, 0: Inactivo)

    // Constructor
    public function __construct($bovino, $tipoEvento, $fecha, $descripcion, $productor, $activo = 1)
    {
        $this->bovino = $bovino;
        $this->tipoEvento = $tipoEvento;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->productor = $productor;
        $this->activo = $activo;
    }

    // Getters
   

    public function getBovino()
    {
        return $this->bovino;
    }

    public function getTipoEvento()
    {
        return $this->tipoEvento;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getProductor()
    {
        return $this->productor;
    }

    public function getActivo()
    {
        return $this->activo;
    }

    // Setters
    

    public function setBovino($bovino)
    {
        $this->bovino = $bovino;
    }

    public function setTipoEvento($tipoEvento)
    {
        $this->tipoEvento = $tipoEvento;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setProductor($productor)
    {
        $this->productor = $productor;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;
    }
}
?>
