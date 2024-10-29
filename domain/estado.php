<?php
class estado
{
  private $estadocodigo;
  private $estadonombre;
  private $estadodescripcion;

  public function __construct($estadocodigo, $estadonombre, $estadodescripcion)
  {
    $this->estadocodigo = $estadocodigo;
    $this->estadonombre = $estadonombre;
    $this->estadodescripcion = $estadodescripcion;
  }

  /**
   * Get the value of razacodigo
   */
  public function getEstadocodigo()
  {
    return $this->estadocodigo;
  }

  /**
   * Set the value of razacodigo
   *
   * @return  self
   */
  public function setEstadocodigo($estadocodigo)
  {
    $this->estadocodigo = $estadocodigo;

    return $this;
  }
  /**
   *Get value of estadoNombre 
   */
  public function getEstadoNombre()
  {
    return $this->estadonombre;
  }

  /**
   * Set value of estadoNombre
   * @return self
   */
  public function setEstadoNombre($estadonombre)
  {
    $this->estadonombre = $estadonombre;
    return $this;
  }

  /**
   * Get value of estadoDescripcion
   */
  public function getEstadoDescripcion()
  {
    return $this->estadodescripcion;
  }

  /**
   * Set value of estadoDescripcion
   * @return self
   */
  public function setEstadoDescripcion($estadodescripcion)
  {
    $this->estadodescripcion = $estadodescripcion;
    return $this;
  }
}
