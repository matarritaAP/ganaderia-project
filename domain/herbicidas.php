<?php

class herbicidas {
    private $codigoid;
    private $nombre;
    private $nombrecomun;
    private $presentacion;
    private $casacomercial;
    private $cantidad;
    private $funcion;
    private $aplicacion;
    private $descripcion;
    private $formula;
    private $provedor;

    // Constructor
    public function __construct($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $aplicacion, $descripcion, $formula, $provedor) {
        $this->codigoid = $codigoid;
        $this->nombre = $nombre;
        $this->nombrecomun = $nombrecomun;
        $this->presentacion = $presentacion;
        $this->casacomercial = $casacomercial;
        $this->cantidad = $cantidad;
        $this->funcion = $funcion;
        $this->aplicacion = $aplicacion;
        $this->descripcion = $descripcion;
        $this->formula = $formula;
        $this->provedor = $provedor;
    }

    // M�todos Get y Set
    public function getCodigoid() {
        return $this->codigoid;
    }

    public function setCodigoid($codigoid) {
        $this->codigoid = $codigoid;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombrecomun() {
        return $this->nombrecomun;
    }

    public function setNombrecomun($nombrecomun) {
        $this->nombrecomun = $nombrecomun;
    }

    public function getPresentacion() {
        return $this->presentacion;
    }

    public function setPresentacion($presentacion) {
        $this->presentacion = $presentacion;
    }

    public function getCasacomercial() {
        return $this->casacomercial;
    }

    public function setCasacomercial($casacomercial) {
        $this->casacomercial = $casacomercial;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getFuncion() {
        return $this->funcion;
    }

    public function setFuncion($funcion) {
        $this->funcion = $funcion;
    }

    public function getAplicacion() {
        return $this->aplicacion;
    }

    public function setAplicacion($aplicacion) {
        $this->aplicacion = $aplicacion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getFormula() {
        return $this->formula;
    }

    public function setFormula($formula) {
        $this->formula = $formula;
    }

    public function getProvedor() {
        return $this->provedor;
    }

    public function setProvedor($provedor) {
        $this->provedor = $provedor;
    }

}

?>
