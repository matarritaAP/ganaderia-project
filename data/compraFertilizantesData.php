<?php

include_once "../domain/compraFertilizantes.php";
include_once "../data/database.php";

class compraFertilizantesData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarCompraFertilizante($compraFertilizante)
    {
        $con = $this->conectar();

        $codigo = $compraFertilizante->getTbfertilizantecodigo();
        $nombre = $compraFertilizante->getTbfertilizantenombre();
        $nombreComun = $compraFertilizante->getTbfertilizantenombrecomun();
        $presentacion = $compraFertilizante->getTbfertilizantepresentacion();
        $casaComercial = $compraFertilizante->getTbfertilizantecasacomercial();
        $cantidad = $compraFertilizante->getTbfertilizantecantidad();
        $funcion = $compraFertilizante->getTbfertilizantefuncion();
        $dosificacion = $compraFertilizante->getTbfertilizantedosificacion();
        $descripcion = $compraFertilizante->getTbfertilizantedescripcion();
        $formula = $compraFertilizante->getTbfertilizanteformula();
        $proveedor = $compraFertilizante->getTbfertilizanteproveedor();
        $precio = $compraFertilizante->getPrecio();
        $fechaCompra = $compraFertilizante->getFechaCompra();

        // Selecciona el último ID insertado
        $tempsql = $con->prepare("SELECT MAX(tbcomprafertilizanteid) AS tbcomprafertilizanteid FROM tbcomprafertilizantes");
        $tempsql->execute();
        $tempid = $tempsql->fetch(); // Guarda en un temporal

        $sql = $con->prepare("INSERT INTO tbcomprafertilizantes (tbcomprafertilizanteid, tbcomprafertilizantecodigo, tbcomprafertilizantenombre, tbcomprafertilizantenombrecomun, tbcomprafertilizantepresentacion, tbcomprafertilizantecasacomercial, tbcomprafertilizantecantidad, tbcomprafertilizantefuncion, tbcomprafertilizantedosificacion, tbcomprafertilizantedescripcion, tbcomprafertilizanteformula, tbcomprafertilizanteproveedor, tbcomprafertilizanteprecio, tbcomprafertilizantefechacompra, tbcomprafertilizanteestado) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $x = $sql->execute(array(
            $tempid[0] + 1,  // Incrementa el ID
            $codigo,
            $nombre,
            $nombreComun,
            $presentacion,
            $casaComercial,
            $cantidad,
            $funcion,
            $dosificacion,
            $descripcion,
            $formula,
            $proveedor,
            $precio,
            $fechaCompra,
            1 // Estado fijo
        ));

        return $x;
    }

    public function consultarCompraFertilizantes()
    {
        $compraFertilizanteList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbcomprafertilizantes WHERE tbcomprafertilizanteestado = 1";
                $stmt = $con->prepare($sql);
                $stmt->execute();

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar compras de fertilizantes: " . $e->getMessage(), 3, '/var/log/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }

    public function consultarCompraFertilizantePorCodigo($codigoid)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbcomprafertilizantes WHERE tbcomprafertilizantecodigo = :codigoid";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':codigoid', $codigoid, PDO::PARAM_STR);
                $stmt->execute();

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar compra de fertilizante: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }

    public function eliminarCompraFertilizante($codigoid)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "UPDATE tbcomprafertilizantes SET 
                            tbcomprafertilizanteestado = ? 
                        WHERE tbcomprafertilizantecodigo = ?";

                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(0, $codigoid));

                return $x; // Devuelve true si la ejecución fue exitosa
            } catch (PDOException $e) {
                error_log("Error al eliminar compra de fertilizante: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return false;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return false; // Devuelve false si la conexión es nula
    }

    public function actualizarCompraFertilizante($compraFertilizante)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "UPDATE tbcomprafertilizantes SET 
                            tbcomprafertilizantenombre = ?, 
                            tbcomprafertilizantenombrecomun = ?, 
                            tbcomprafertilizantepresentacion = ?, 
                            tbcomprafertilizantecasacomercial = ?, 
                            tbcomprafertilizantecantidad = ?, 
                            tbcomprafertilizantefuncion = ?, 
                            tbcomprafertilizantedosificacion = ?, 
                            tbcomprafertilizantedescripcion = ?, 
                            tbcomprafertilizanteformula = ?, 
                            tbcomprafertilizanteproveedor = ?, 
                            tbcomprafertilizanteprecio = ?, 
                            tbcomprafertilizantefechacompra = ?
                        WHERE tbcomprafertilizantecodigo = ?";

                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(
                    $compraFertilizante->getTbfertilizantenombre(),
                    $compraFertilizante->getTbfertilizantenombrecomun(),
                    $compraFertilizante->getTbfertilizantepresentacion(),
                    $compraFertilizante->getTbfertilizantecasacomercial(),
                    $compraFertilizante->getTbfertilizantecantidad(),
                    $compraFertilizante->getTbfertilizantefuncion(),
                    $compraFertilizante->getTbfertilizantedosificacion(),
                    $compraFertilizante->getTbfertilizantedescripcion(),
                    $compraFertilizante->getTbfertilizanteformula(),
                    $compraFertilizante->getTbfertilizanteproveedor(),
                    $compraFertilizante->getPrecio(),
                    $compraFertilizante->getFechaCompra(),
                    $compraFertilizante->getTbfertilizantecodigo()
                ));

                return $x; // Devuelve true si la ejecución fue exitosa
            } catch (PDOException $e) {
                error_log("Error al actualizar compra de fertilizante: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return false;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return false; // Devuelve false si la conexión es nula
    }
}