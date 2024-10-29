<?php
class bovino
{
    private $numero;
    private $nombre;
    private $padre;
    private $madre;
    private $fechaNacimiento;
    private $fechaCompra;
    private $precio;
    private $peso;
    private $vendedor;
    private $raza;
    private $estado;
    private $genero;
    private $finca;
    private $detalle;
    private $productor;

    public function __construct(
        $numero,
        $nombre,
        $padre,
        $madre,
        $fechaNacimiento,
        $fechaCompra,
        $precio,
        $peso,
        $vendedor,
        $raza,
        $estado,
        $genero,
        $finca,
        $detalle,
        $productor
    ) {
        $this->numero = $numero;
        $this->nombre = $nombre;
        $this->padre = $padre;
        $this->madre = $madre;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->fechaCompra = $fechaCompra;
        $this->precio = $precio;
        $this->peso = $peso;
        $this->vendedor = $vendedor;
        $this->raza = $raza;
        $this->estado = $estado;
        $this->genero = $genero;
        $this->finca = $finca;
        $this->detalle = $detalle;
        $this->productor = $productor;
    }

    public function getBovinoNumero()
    {
        return $this->numero;
    }

    public function setBovinoNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getBovinoNombre()
    {
        return $this->nombre;
    }

    public function setBovinoNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getBovinoPadre()
    {
        return $this->padre;
    }

    public function setBovinoPadre($padre)
    {
        $this->padre = $padre;
    }

    public function getBovinoMadre()
    {
        return $this->madre;
    }

    public function setBovinoMadre($madre)
    {
        $this->madre = $madre;
    }

    public function getBovinoFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function setBovinoFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getBovinoFechaCompra()
    {
        return $this->fechaCompra;
    }

    public function setBovinoFechaCompra($fechaCompra)
    {
        $this->fechaCompra = $fechaCompra;
    }

    public function getBovinoPrecio()
    {
        return $this->precio;
    }

    public function setBovinoPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function getBovinoPeso()
    {
        return $this->peso;
    }

    public function setBovinoPeso($peso)
    {
        $this->peso = $peso;
    }

    public function getBovinoVendedor()
    {
        return $this->vendedor;
    }

    public function setBovinoVendedor($vendedor)
    {
        $this->vendedor = $vendedor;
    }

    public function getBovinoRaza()
    {
        return $this->raza;
    }

    public function setBovinoRaza($raza)
    {
        $this->raza = $raza;
    }

    public function getBovinoEstado()
    {
        return $this->estado;
    }

    public function setBovinoEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getBovinoGenero()
    {
        return $this->genero;
    }

    public function setBovinoGenero($genero)
    {
        $this->genero = $genero;
    }

    public function getBovinoFinca()
    {
        return $this->finca;
    }

    public function setBovinoFinca($finca)
    {
        $this->finca = $finca;
    }

    public function getBovinoDetalle()
    {
        return $this->detalle;
    }

    public function setBovinoDetalle($detalle)
    {
        $this->detalle = $detalle;
    }

    public function getBovinoProductor()
    {
        return $this->productor;
    }

    public function setBovinoProductor($productor)
    {
        $this->productor = $productor;
    }
}
