<?php
class Servicio
{
    private $codigo;
    private $nombre;
    private $descripcion;

    public function __construct($codigo, $nombre, $descripcion)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function getServicioCodigo(){
        return $this->codigo;
    }
    public function setServicioCodigo($codigo){

    }

    public function getServicioNombre()
    {
        return $this->nombre;
    }

    public function setServicioNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getServicioDescripcion()
    {
        return $this->descripcion;
    }

    public function setServicioDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }
}
?>