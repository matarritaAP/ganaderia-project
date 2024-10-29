<?php
    class naturaleza{
        private $codigo;
        private $nombre;
        private $descripcion;
    
        public function __construct($codigo, $nombre, $descripcion)
        {
            $this->codigo = $codigo;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
        }
        
        public function getNaturalezaCodigo(){
            return $this->codigo;
        }
        public function setNaturalezaCodigo($codigo){
    
        }
    
        public function getNaturalezaNombre()
        {
            return $this->nombre;
        }
    
        public function setNaturalezaNombre($nombre)
        {
            $this->nombre = $nombre;
            return $this;
        }
    
        public function getNaturalezaDescripcion()
        {
            return $this->descripcion;
        }
    
        public function setNaturalezaDescripcion($descripcion)
        {
            $this->descripcion = $descripcion;
            return $this;
        }
    }
?>