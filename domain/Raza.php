<?php
    class Raza{

        private $razacodigo;
        private $razanombre;
        private $razadescripcion;

        public function __construct($razacodigo, $razanombre, $razadescripcion){
            $this-> razacodigo = $razacodigo;
            $this-> razanombre = $razanombre;
            $this-> razadescripcion = $razadescripcion;
        }

        
        /**
         * Get the value of razacodigo
         */ 
        public function getRazacodigo()
        {
                return $this->razacodigo;
        }

        /**
         * Set the value of razacodigo
         *
         * @return  self
         */ 
        public function setRazacodigo($razacodigo)
        {
                $this->razacodigo = $razacodigo;

                return $this;
        }

        /**
         * Get the value of razanombre
         */ 
        public function getRazanombre()
        {
                return $this->razanombre;
        }

        /**
         * Set the value of razanombre
         *
         * @return  self
         */ 
        public function setRazanombre($razanombre)
        {
                $this->razanombre = $razanombre;

                return $this;
        }

        /**
         * Get the value of razadescripcion
         */ 
        public function getRazadescripcion()
        {
                return $this->razadescripcion;
        }

        /**
         * Set the value of razadescripcion
         *
         * @return  self
         */ 
        public function setRazadescripcion($razadescripcion)
        {
                $this->razadescripcion = $razadescripcion;

                return $this;
        }
    }
?>