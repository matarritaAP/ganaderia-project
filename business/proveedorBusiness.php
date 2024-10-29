<?php

include_once "../data/proveedorData.php";

class proveedorBusiness
{

    private $proveedorData;

    public function __construct()
    {
        $this->proveedorData = new proveedorData();
    }

    public function insertarProveedor($proveedor, $tbproductorid)
    {
        return $this->proveedorData->insertarProveedor($proveedor,  $tbproductorid);
    }

    public function consultarProveedor($tbproductorid, $estado)
    {
        return $this->proveedorData->consultarProveedor($tbproductorid, $estado);
    }

    public function eliminarProveedor($correo,  $tbproductorid)
    {
        return $this->proveedorData->eliminarProveedor($correo,  $tbproductorid);
    }

    public function consultarProveedorPorCorreo($correo, $tbproductorid)
    {
        return $this->proveedorData->consultarProveedorPorCorreo($correo, $tbproductorid);
    }

    public function actualizarProveedor($proveedor, $correoAnterior, $tbproductorid)
    {
        return $this->proveedorData->actualizarProveedor($proveedor, $correoAnterior, $tbproductorid);
    }

    public function ValidarCorreo($codigo, $tbproductorid)
    {
        return $this->proveedorData->ValidarCorreo($codigo, $tbproductorid);
    }

    public function ValidarNombresComercialesSimilares($nombre, $tbproductorid)
    {
        return $this->proveedorData->ValidarNombresComercialesSimilares($nombre, $tbproductorid);
    }

    public function reactivarProveedor($correo, $tbproductorid)
    {
        return $this->proveedorData->reactivarProveedor($correo, $tbproductorid);
    }
}
