<?php
class Productor{
    private $docIdentidad;
    private $nombreGanaderia;
    private $nombre;
    private $primerApellido;
    private $segundoApellido;
    private $fechaNacimiento;
    private $email;
    private $telefono;
    private $direccion;

    public function __construct($docIdentidad, $nombreGanaderia,$nombre, $primerApellido, $segundoApellido, $fechaNacimiento, $email, $telefono, $direccion){

        $this->docIdentidad = $docIdentidad;
        $this->nombreGanaderia = $nombreGanaderia; 
        $this->nombre = $nombre;
        $this->primerApellido = $primerApellido;
        $this->segundoApellido = $segundoApellido;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->direccion = $direccion;    
    }

    /**
     * Get the value of docIdentidad
     */ 
    public function getDocIdentidad()
    {
        return $this->docIdentidad;
    }

    /**
     * Set the value of docIdentidad
     *
     * @return  self
     */ 
    public function setDocIdentidad($docIdentidad)
    {
        $this->docIdentidad = $docIdentidad;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombreGanaderia()
    {
        return $this->nombreGanaderia;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombreGanaderia($nombreGanaderia)
    {
        $this->nombreGanaderia = $nombreGanaderia;

        return $this;
    }
    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of primerApellido
     */ 
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * Set the value of primerApellido
     *
     * @return  self
     */ 
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get the value of segundoApellido
     */ 
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * Set the value of segundoApellido
     *
     * @return  self
     */ 
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get the value of fechaNacimiento
     */ 
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set the value of fechaNacimiento
     *
     * @return  self
     */ 
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telefono
     */ 
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */ 
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of direccion
     */ 
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     *
     * @return  self
     */ 
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }
}