<?php

include_once "../data/productoVeterinarioData.php";

class ProductoVeterinarioBusiness {

    private $productoVeterinarioData;

    public function __construct() {
        $this->productoVeterinarioData = new ProductoVeterinarioData();
    }

    public function insertarProductoVeterinario($productoVeterinario) {
        return $this->productoVeterinarioData->insertarProductoVeterinario($productoVeterinario);
    }

    public function consultarProductoVeterinario() {
        return $this->productoVeterinarioData->consultarProductoVeterinario();
    }

    public function eliminarProductoVeterinario($codigoid) {
        return $this->productoVeterinarioData->eliminarProductoVeterinario($codigoid);
    }

    public function consultarProductoVeterinarioPorCodigo($codigoid) {
        return $this->productoVeterinarioData->consultarProductoVeterinarioPorCodigo($codigoid);
    }

    public function actualizarProductoVeterinario($productoVeterinario) {
        return $this->productoVeterinarioData->actualizarProductoVeterinario($productoVeterinario);
    }

    // Puedes implementar m�todos de validaci�n espec�ficos si es necesario,
    // adaptando los m�todos de HerbicidasData como validarCodigo y validarHerbicidasParecidos.
}

?>
