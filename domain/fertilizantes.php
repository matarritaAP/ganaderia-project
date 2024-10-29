<?php

class fertilizantes {

    private $tbfertilizantecodigo;
    private $tbfertilizantenombre;
    private $tbfertilizantenombrecomun;
    private $tbfertilizantepresentacion;
    private $tbfertilizantecasacomercial;
    private $tbfertilizantecantidad;
    private $tbfertilizantefuncion;
    private $tbfertilizantedosificacion;
    private $tbfertilizantedescripcion;
    private $tbfertilizanteformula;
    private $tbfertilizanteproveedor;

    // Constructor
    public function __construct($codigo, $nombre, $nombreComun, $presentacion, $casaComercial, $cantidad, $funcion, $dosificacion, $descripcion, $formula, $proveedor) {
        $this->tbfertilizantecodigo = $codigo;
        $this->tbfertilizantenombre = $nombre;
        $this->tbfertilizantenombrecomun = $nombreComun;
        $this->tbfertilizantepresentacion = $presentacion;
        $this->tbfertilizantecasacomercial = $casaComercial;
        $this->tbfertilizantecantidad = $cantidad;
        $this->tbfertilizantefuncion = $funcion;
        $this->tbfertilizantedosificacion = $dosificacion;
        $this->tbfertilizantedescripcion = $descripcion;
        $this->tbfertilizanteformula = $formula;
        $this->tbfertilizanteproveedor = $proveedor;
    }

    // Getters and Setters
    public function getTbfertilizantecodigo() {
        return $this->tbfertilizantecodigo;
    }

    public function setTbfertilizantecodigo($codigo) {
        $this->tbfertilizantecodigo = $codigo;
    }

    public function getTbfertilizantenombre() {
        return $this->tbfertilizantenombre;
    }

    public function setTbfertilizantenombre($nombre) {
        $this->tbfertilizantenombre = $nombre;
    }

    public function getTbfertilizantenombrecomun() {
        return $this->tbfertilizantenombrecomun;
    }

    public function setTbfertilizantenombrecomun($nombreComun) {
        $this->tbfertilizantenombrecomun = $nombreComun;
    }

    public function getTbfertilizantepresentacion() {
        return $this->tbfertilizantepresentacion;
    }

    public function setTbfertilizantepresentacion($presentacion) {
        $this->tbfertilizantepresentacion = $presentacion;
    }

    public function getTbfertilizantecasacomercial() {
        return $this->tbfertilizantecasacomercial;
    }

    public function setTbfertilizantecasacomercial($casaComercial) {
        $this->tbfertilizantecasacomercial = $casaComercial;
    }

    public function getTbfertilizantecantidad() {
        return $this->tbfertilizantecantidad;
    }

    public function setTbfertilizantecantidad($cantidad) {
        $this->tbfertilizantecantidad = $cantidad;
    }

    public function getTbfertilizantefuncion() {
        return $this->tbfertilizantefuncion;
    }

    public function setTbfertilizantefuncion($funcion) {
        $this->tbfertilizantefuncion = $funcion;
    }

    public function getTbfertilizantedosificacion() {
        return $this->tbfertilizantedosificacion;
    }

    public function setTbfertilizantedosificacion($dosificacion) {
        $this->tbfertilizantedosificacion = $dosificacion;
    }

    public function getTbfertilizantedescripcion() {
        return $this->tbfertilizantedescripcion;
    }

    public function setTbfertilizantedescripcion($descripcion) {
        $this->tbfertilizantedescripcion = $descripcion;
    }

    public function getTbfertilizanteformula() {
        return $this->tbfertilizanteformula;
    }

    public function setTbfertilizanteformula($formula) {
        $this->tbfertilizanteformula = $formula;
    }

    public function getTbfertilizanteproveedor() {
        return $this->tbfertilizanteproveedor;
    }

    public function setTbfertilizanteproveedor($proveedor) {
        $this->tbfertilizanteproveedor = $proveedor;
    }
}