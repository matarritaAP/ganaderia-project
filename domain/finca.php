<?php
class finca
{
    //private $codigo;
    private $numPlano;
    private $coordenada;
    private $latitud;
    private $longitud;
    private $areaTotal;
    private $areaPastoreo;
    private $areaConstruccion;
    private $areaForestal;
    private $areaCamino;
    private $areaOtraCriterio;

    public function __construct(
        // $codigo,
        $numPlano,
        $coordenada,
        $latitud,
        $longitud,
        $areaTotal,
        $areaPastoreo,
        $areaConstruccion,
        $areaForestal,
        $areaCamino,
        $areaOtraCriterio
    ) {
        //$this->codigo = $codigo;
        $this->numPlano = $numPlano;
        $this->coordenada = $coordenada;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->areaTotal = $areaTotal;
        $this->areaPastoreo = $areaPastoreo;
        $this->areaConstruccion = $areaConstruccion;
        $this->areaForestal = $areaForestal;
        $this->areaCamino = $areaCamino;
        $this->areaOtraCriterio = $areaOtraCriterio;
    }

    public function getFincaNumPlano()
    {
        return $this->numPlano;
    }

    public function setFincaNumPlano($numPlano)
    {
        $this->numPlano = $numPlano;
    }

    public function getFincaCoordenada()
    {
        return $this->coordenada;
    }

    public function setFincaCoordenada($coordenada)
    {
        $this->coordenada = $coordenada;
    }

    public function getFincaLatitud()
    {
        return $this->latitud;
    }

    public function setFincaLatitud($latitud)
    {
        $this->latitud = $latitud;
    }

    public function getFincaLongitud()
    {
        return $this->longitud;
    }

    public function setFincaLongitud($longitud)
    {
        $this->longitud = $longitud;
    }

    public function getFincaAreaTotal()
    {
        return $this->areaTotal;
    }

    public function setFincaAreaTotal($areaTotal)
    {
        $this->areaTotal = $areaTotal;
    }

    public function getFincaAreaPastoreo()
    {
        return $this->areaPastoreo;
    }

    public function setFincaAreaPastoreo($areaPastoreo)
    {
        $this->areaPastoreo = $areaPastoreo;
    }

    public function getFincaAreaConstruccion()
    {
        return $this->areaConstruccion;
    }

    public function setFincaAreaConstruccion($areaConstruccion)
    {
        $this->areaConstruccion = $areaConstruccion;
    }

    public function getFincaAreaForestal()
    {
        return $this->areaForestal;
    }

    public function setFincaAreaForestal($areaForestal)
    {
        $this->areaForestal = $areaForestal;
    }

    public function getFincaAreaCamino()
    {
        return $this->areaCamino;
    }

    public function setFincaAreaCamino($areaCamino)
    {
        $this->areaCamino = $areaCamino;
    }

    public function getFincaAreaOtraCriterio()
    {
        return $this->areaOtraCriterio;
    }

    public function setFincaAreaOtraCriterio($areaOtraCriterio)
    {
        $this->areaOtraCriterio = $areaOtraCriterio;
    }
}
