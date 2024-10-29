<?php

class CompraProductoVeterinario
{

    private $tbCompraProductoVeterinarioId;
    private $tbCompraProductoVeterinarioNombre;
    private $tbCompraProductoVeterinarioFechacompra;
    private $tbCompraProductoVeterinarioCantidad;
    private $tbCompraProductoVeterinarioPrecio;
    private $tbCompraProductoVeterinarioProductorid;

    // Constructor
    public function __construct($id, $nombre, $fechaCompra, $cantidad, $precio, $productorid)
    {
        $this->tbCompraProductoVeterinarioId = $id;
        $this->tbCompraProductoVeterinarioNombre = $nombre;
        $this->tbCompraProductoVeterinarioFechacompra = $fechaCompra;
        $this->tbCompraProductoVeterinarioCantidad = $cantidad;
        $this->tbCompraProductoVeterinarioPrecio = $precio;
        $this->tbCompraProductoVeterinarioProductorid = $productorid;
    }


    /**
     * Get the value of tbCompraProductoVeterinarioId
     */
    public function getTbCompraProductoVeterinarioId()
    {
        return $this->tbCompraProductoVeterinarioId;
    }

    /**
     * Set the value of tbCompraProductoVeterinarioId
     *
     * @return  self
     */
    public function setTbCompraProductoVeterinarioId($tbCompraProductoVeterinarioId)
    {
        $this->tbCompraProductoVeterinarioId = $tbCompraProductoVeterinarioId;

        return $this;
    }

    /**
     * Get the value of tbCompraProductoVeterinarioNombre
     */
    public function getTbCompraProductoVeterinarioNombre()
    {
        return $this->tbCompraProductoVeterinarioNombre;
    }

    /**
     * Set the value of tbCompraProductoVeterinarioNombre
     *
     * @return  self
     */
    public function setTbCompraProductoVeterinarioNombre($tbCompraProductoVeterinarioNombre)
    {
        $this->tbCompraProductoVeterinarioNombre = $tbCompraProductoVeterinarioNombre;

        return $this;
    }

    /**
     * Get the value of tbCompraProductoVeterinarioFechacompra
     */
    public function getTbCompraProductoVeterinarioFechacompra()
    {
        return $this->tbCompraProductoVeterinarioFechacompra;
    }

    /**
     * Set the value of tbCompraProductoVeterinarioFechacompra
     *
     * @return  self
     */
    public function setTbCompraProductoVeterinarioFechacompra($tbCompraProductoVeterinarioFechacompra)
    {
        $this->tbCompraProductoVeterinarioFechacompra = $tbCompraProductoVeterinarioFechacompra;

        return $this;
    }

    /**
     * Get the value of tbCompraProductoVeterinarioCantidad
     */
    public function getTbCompraProductoVeterinarioCantidad()
    {
        return $this->tbCompraProductoVeterinarioCantidad;
    }

    /**
     * Set the value of tbCompraProductoVeterinarioCantidad
     *
     * @return  self
     */
    public function setTbCompraProductoVeterinarioCantidad($tbCompraProductoVeterinarioCantidad)
    {
        $this->tbCompraProductoVeterinarioCantidad = $tbCompraProductoVeterinarioCantidad;

        return $this;
    }

    /**
     * Get the value of tbCompraProductoVeterinarioPrecio
     */
    public function getTbCompraProductoVeterinarioPrecio()
    {
        return $this->tbCompraProductoVeterinarioPrecio;
    }

    /**
     * Set the value of tbCompraProductoVeterinarioPrecio
     *
     * @return  self
     */
    public function setTbCompraProductoVeterinarioPrecio($tbCompraProductoVeterinarioPrecio)
    {
        $this->tbCompraProductoVeterinarioPrecio = $tbCompraProductoVeterinarioPrecio;

        return $this;
    }

    /**
     * Get the value of tbCompraProductoVeterinarioProductorid
     */
    public function getTbCompraProductoVeterinarioProductorid()
    {
        return $this->tbCompraProductoVeterinarioProductorid;
    }

    /**
     * Set the value of tbCompraProductoVeterinarioProductorid
     *
     * @return  self
     */
    public function setTbCompraProductoVeterinarioProductorid($tbCompraProductoVeterinarioProductorid)
    {
        $this->tbCompraProductoVeterinarioProductorid = $tbCompraProductoVeterinarioProductorid;

        return $this;
    }
}
