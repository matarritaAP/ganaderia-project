<?php

class ProductoVeterinario {

    private $tbproductoVeterinarioid;
    private $tbproductoVeterinarionombre;
    private $tbproductoVeterinarioprincipioactivo;
    private $tbproductoVeterinariodosificacion;
    private $tbproductoVeterinariofechavencimiento;
    private $tbproductoVeterinariofuncion;
    private $tbproductoVeterinariodescripcion;
    private $tbproductoVeterinariotipomedicamento;
    private $tbproductoVeterinarioproveedor;
    private $tbproductoVeterinarioproductorid;

    // Constructor
    public function __construct($id, $nombre, $principioactivo, $dosificacion, $fechavencimiento, $funcion, $descripcion, $tipomedicamento, $proveedor, $productorid) {
        $this->tbproductoVeterinarioid = $id;
        $this->tbproductoVeterinarionombre = $nombre;
        $this->tbproductoVeterinarioprincipioactivo = $principioactivo;
        $this->tbproductoVeterinariodosificacion = $dosificacion;
        $this->tbproductoVeterinariofechavencimiento = $fechavencimiento;
        $this->tbproductoVeterinariofuncion = $funcion;
        $this->tbproductoVeterinariodescripcion = $descripcion;
        $this->tbproductoVeterinariotipomedicamento = $tipomedicamento;
        $this->tbproductoVeterinarioproveedor = $proveedor;
        $this->tbproductoVeterinarioproductorid = $productorid;
    }

    // Getters and Setters
    public function getTbproductoVeterinarioid() {
        return $this->tbproductoVeterinarioid;
    }

    public function setTbproductoVeterinarioid($id) {
        $this->tbproductoVeterinarioid = $id;
    }

    public function getTbproductoVeterinarionombre() {
        return $this->tbproductoVeterinarionombre;
    }

    public function setTbproductoVeterinarionombre($nombre) {
        $this->tbproductoVeterinarionombre = $nombre;
    }

    public function getTbproductoVeterinarioprincipioactivo() {
        return $this->tbproductoVeterinarioprincipioactivo;
    }

    public function setTbproductoVeterinarioprincipioactivo($principioactivo) {
        $this->tbproductoVeterinarioprincipioactivo = $principioactivo;
    }

    public function getTbproductoVeterinariodosificacion() {
        return $this->tbproductoVeterinariodosificacion;
    }

    public function setTbproductoVeterinariodosificacion($dosificacion) {
        $this->tbproductoVeterinariodosificacion = $dosificacion;
    }

    public function getTbproductoVeterinariofechavencimiento() {
        return $this->tbproductoVeterinariofechavencimiento;
    }

    public function setTbproductoVeterinariofechavencimiento($fechavencimiento) {
        $this->tbproductoVeterinariofechavencimiento = $fechavencimiento;
    }

    public function getTbproductoVeterinariofuncion() {
        return $this->tbproductoVeterinariofuncion;
    }

    public function setTbproductoVeterinariofuncion($funcion) {
        $this->tbproductoVeterinariofuncion = $funcion;
    }

    public function getTbproductoVeterinariodescripcion() {
        return $this->tbproductoVeterinariodescripcion;
    }

    public function setTbproductoVeterinariodescripcion($descripcion) {
        $this->tbproductoVeterinariodescripcion = $descripcion;
    }

    public function getTbproductoVeterinariotipomedicamento() {
        return $this->tbproductoVeterinariotipomedicamento;
    }

    public function setTbproductoVeterinariotipomedicamento($tipomedicamento) {
        $this->tbproductoVeterinariotipomedicamento = $tipomedicamento;
    }

    public function getTbproductoVeterinarioproveedor() {
        return $this->tbproductoVeterinarioproveedor;
    }

    public function setTbproductoVeterinarioproveedor($proveedor) {
        $this->tbproductoVeterinarioproveedor = $proveedor;
    }

    public function getTbproductoVeterinarioproductorid() {
        return $this->tbproductoVeterinarioproductorid;
    }

    public function setTbproductoVeterinarioproductorid($productorid) {
        $this->tbproductoVeterinarioproductorid = $productorid;
    }
}

?>
