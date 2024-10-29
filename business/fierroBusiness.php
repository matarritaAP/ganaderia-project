<?php

include_once "../data/fierroData.php";

    class fierroBusiness{

        private $fierroData;

        public function __construct(){
            $this->fierroData = new fierroData();
        }

        public function insertarFierro($fierro, $user_id){
           return $this->fierroData->insertarFierro($fierro, $user_id);
        }

        public function consultarFierro($user_id){
            return $this->fierroData->consultarFierro($user_id);
        }

        public function eliminarFierro($codigo){
            return $this->fierroData->eliminarFierro($codigo);
        }

        public function consultarcodigoFierro($codigo){
            return $this->fierroData->consultarcodigoFierro($codigo);
        }
        
        public function actualizarFierro($fierro, $renovar){
            return $this->fierroData->actualizarFierro($fierro, $renovar);
        }

        public function ValidarDocumento($docIdentidad){
            return $this->fierroData->ValidarDocumento($docIdentidad);
        }
    }

?>