<?php

class proveedor
{
    private $nombrecomercial;
    private $propietario;
    private $telefonowhatsapp;
    private $correo;
    private $sinpe;
    private $telefonofijo;

    public function __construct($nombrecomercial, $propietario, $telefonowhatsapp, $correo, $sinpe, $telefonofijo)
    {
        $this->nombrecomercial = $nombrecomercial;
        $this->propietario = $propietario;
        $this->telefonowhatsapp = $telefonowhatsapp;
        $this->correo = $correo;
        $this->sinpe = $sinpe;
        $this->telefonofijo = $telefonofijo;
    }

    public function getNombrecomercial()
    {
        return $this->nombrecomercial;
    }

    public function setNombrecomercial($nombrecomercial)
    {
        $this->nombrecomercial = $nombrecomercial;
    }

    public function getPropietario()
    {
        return $this->propietario;
    }

    public function setPropietario($propietario)
    {
        $this->propietario = $propietario;
    }

    public function getTelefonowhatsapp()
    {
        return $this->telefonowhatsapp;
    }

    public function setTelefonowhatsapp($telefonowhatsapp)
    {
        $this->telefonowhatsapp = $telefonowhatsapp;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function getSinpe()
    {
        return $this->sinpe;
    }

    public function setSinpe($sinpe)
    {
        $this->sinpe = $sinpe;
    }

    public function getTelefonofijo()
    {
        return $this->telefonofijo;
    }

    public function setTelefonofijo($telefonofijo)
    {
        $this->telefonofijo = $telefonofijo;
    }
}
