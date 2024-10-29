<?php
class herramienta
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

    public function getHerramientaCodigo()
    {
        return $this->codigo;
    }

    public function setHerramientaCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getHerramientaNombre()
    {
        return $this->nombre;
    }

    public function setHerramientaNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getHerramientaDescripcion()
    {
        return $this->descripcion;
    }

    public function setHerramientaDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }
}
