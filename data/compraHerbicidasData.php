<?php

include_once "../domain/compraHerbicidas.php";
include_once "../data/database.php";

class compraHerbicidasData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarCompraHerbicida($compraHerbicida)
    {
        $con = $this->conectar();

        $codigo = $compraHerbicida->getCodigoid();
        $nombre = $compraHerbicida->getNombre();
        $nombrecomun = $compraHerbicida->getNombrecomun();
        $presentacion = $compraHerbicida->getPresentacion();
        $casacomercial = $compraHerbicida->getCasacomercial();
        $cantidad = $compraHerbicida->getCantidad();
        $funcion = $compraHerbicida->getFuncion();
        $aplicacion = $compraHerbicida->getAplicacion();
        $descripcion = $compraHerbicida->getDescripcion();
        $formula = $compraHerbicida->getFormula();
        $provedor = $compraHerbicida->getProvedor();
        $precio = $compraHerbicida->getPrecio();
        $fechaCompra = $compraHerbicida->getFechaCompra();

        //VA A LA TABLA Y SELECCIONA EL ULTIMO ID INSERTADO
        $tempsql = $con->prepare("SELECT MAX(tbcompraherbicidasid) AS tbcompraherbicidasid FROM tbcompraherbicidas");
        $tempsql->execute();
        $tempid = $tempsql->fetch(); //GUARDA EN UN TEMPORAL

        $sql = $con->prepare("INSERT INTO tbcompraherbicidas (tbcompraherbicidasid, tbcompracodigo, tbcompranombre, tbcompranombrecomun, tbcomprapresentacion, tbcompracasacomercial, tbcompracantidad, tbcomprafuncion, tbcompraaplicacion, tbcompradescripcion, tbcompraformula, tbcompraprovedor, tbcompraprecio, tbcomprafechacompra, tbcompraestado) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $x = $sql->execute(array(
            $tempid[0] + 1,  //ACA AL TEMPORAL LE SUMA 1
            $codigo,
            $nombre,
            $nombrecomun,
            $presentacion,
            $casacomercial,
            $cantidad,
            $funcion,
            $aplicacion,
            $descripcion,
            $formula,
            $provedor,
            $precio,
            $fechaCompra,
            1 // Estado fijo
        ));

        return $x;
    }

    public function consultarCompraHerbicidas()
    {
        $compraHerbicidaList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbcompraherbicidas WHERE tbcompraestado=1";
                $stmt = $con->prepare($sql);
                $stmt->execute();

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                // Registra el error en un archivo de log
                error_log("Error al consultar compra de herbicidas: " . $e->getMessage(), 3, '/var/log/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }

    public function consultarCompraHerbicidaPorCodigo($codigoid)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbcompraherbicidas WHERE tbcompracodigo = :codigoid";
                $stmt = $con->prepare($sql);
                // Vincula el parámetro :codigoid al valor de $codigoid
                $stmt->bindParam(':codigoid', $codigoid, PDO::PARAM_STR);
                $stmt->execute();

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                // Cambia la ruta del archivo de log a una ubicación válida
                error_log("Error al consultar compra de herbicidas: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return null;
            } finally {
                // Cierra la conexión explícitamente
                $con = null;
            }
        }
        return null; // Devolver null si la conexión es nula
    }

    public function eliminarCompraHerbicida($codigoid)
    {
        $con = $this->conectar();

        if ($con != null) {
            try {
                $sql = "UPDATE tbcompraherbicidas SET 
                        tbcompraestado = ? 
                    WHERE tbcompracodigo = ?";

                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(0, $codigoid));

                return true;
            } catch (PDOException $e) {
                echo "Error al eliminar compra de herbicida: " . $e->getMessage();
                return false;
            }
        }
    }

    public function actualizarCompraHerbicida($compraHerbicida)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "UPDATE tbcompraherbicidas SET 
                        tbcompranombre = ?, 
                        tbcompranombrecomun = ?, 
                        tbcomprapresentacion = ?, 
                        tbcompracasacomercial = ?, 
                        tbcompracantidad = ?, 
                        tbcomprafuncion = ?, 
                        tbcompraaplicacion = ?, 
                        tbcompradescripcion = ?, 
                        tbcompraformula = ?, 
                        tbcompraprovedor = ?, 
                        tbcompraprecio = ?, 
                        tbcomprafechacompra = ?
                    WHERE tbcompracodigo = ?";

                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(
                    $compraHerbicida->getNombre(),
                    $compraHerbicida->getNombrecomun(),
                    $compraHerbicida->getPresentacion(),
                    $compraHerbicida->getCasacomercial(),
                    $compraHerbicida->getCantidad(),
                    $compraHerbicida->getFuncion(),
                    $compraHerbicida->getAplicacion(),
                    $compraHerbicida->getDescripcion(),
                    $compraHerbicida->getFormula(),
                    $compraHerbicida->getProvedor(),
                    $compraHerbicida->getPrecio(),
                    $compraHerbicida->getFechaCompra(),
                    $compraHerbicida->getCodigoid()
                ));

                return $x; // Devuelve true si la ejecución fue exitosa
            } catch (PDOException $e) {
                error_log("Error al actualizar compra de herbicida: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return false;
            } finally {
                $con = null; // Cierra la conexión
            }
        }
        return false; // Devuelve false si la conexión es nula
    }
}
