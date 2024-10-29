<?php
class tipoMedicamento
{
    private $tipoMedicamento;

    public function __construct($tipoMedicamento)
    {
        $this->tipoMedicamento = $tipoMedicamento;
    }

    public function setTipoMedicamento($tipoMedicamento)
    {
        $this->tipoMedicamento = $tipoMedicamento;

        return $this;
    }

    public function getTipoMedicamento()
    {
        return $this->tipoMedicamento;
    }
}