<?php

include_once "../domain/herbicidas.php";
include_once "../data/database.php";

class herbicidasData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }




    public function insertarHerbicida($herbicida)
    {
        $con = $this->conectar();

        $codigo = $herbicida->getCodigoid();
        $nombre = $herbicida->getNombre();
        $nombrecomun = $herbicida->getNombrecomun();
        $presentacion = $herbicida->getPresentacion();
        $casacomercial = $herbicida->getCasacomercial();
        $cantidad = $herbicida->getCantidad();
        $funcion = $herbicida->getFuncion();
        $aplicacion = $herbicida->getAplicacion();
        $descripcion = $herbicida->getDescripcion();
        $formula = $herbicida->getFormula();
        $provedor = $herbicida->getProvedor();
        //VA A LA TABLA Y SELECCIONA EL ULTIMO ID INSERTADO
        $tempsql = $con->prepare("SELECT MAX(tbherbicidasid) AS tbherbicidasid FROM tbherbicidas");
        $tempsql->execute();
        $tempid = $tempsql->fetch(); //GUARDA EN UN TEMPORAL

        $sql = $con->prepare("INSERT INTO tbherbicidas (tbherbicidasid, tbcodigo, tbnombre, tbnombrecomun, tbpresentacion, tbcasacomercial, tbcantidad, tbfuncion, tbaplicacion, tbdescripcion, tbformula, tbprovedor, tbestado) 
                          VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

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
            1 // Estado fijo
        ));

        return $x;
    }

    // Método para consultar todos los herbicidas
    public function consultarHerbicidas($estado)
    {
        $herbicidaList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbherbicidas WHERE tbestado = ?";
                $stmt = $con->prepare($sql);
                $stmt->execute([$estado]);

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                // Registra el error en un archivo de log
                error_log("Error al consultar herbicidas: " . $e->getMessage(), 3, '/var/log/php_errors.log');
                return null;
            } finally {
                // Cierra la conexión explícitamente
                $con = null;
            }
        }
        return null; // Devolver null si la conexión es nula
    }


    public function consultarHerbicidaPorCodigo($codigoid)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbherbicidas WHERE tbcodigo = :codigoid";
                $stmt = $con->prepare($sql);
                // Vincula el parámetro :codigoid al valor de $codigoid
                $stmt->bindParam(':codigoid', $codigoid, PDO::PARAM_INT);
                $stmt->execute();

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                // Cambia la ruta del archivo de log a una ubicación válida
                error_log("Error al consultar herbicidas: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return null;
            } finally {
                // Cierra la conexión explícitamente
                $con = null;
            }
        }
        return null; // Devolver null si la conexión es nula
    }


    // Método para eliminar un herbicida por su ID
    public function eliminarHerbicida($codigoid)
    {

        $con = $this->conectar();


        if ($con != null) {
            try {
                $sql = "UPDATE tbherbicidas SET 
                        tbestado = ? 
                    WHERE tbcodigo = ?";

                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(0, $codigoid));

                return true;
            } catch (PDOException $e) {
                echo "Error al eliminar herbicida: " . $e->getMessage();
                return false;
            }
        }
    }



    public function actualizarHerbicida($herbicida)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "UPDATE tbherbicidas SET 
                        tbnombre = ?, 
                        tbnombrecomun = ?, 
                        tbpresentacion = ?, 
                        tbcasacomercial = ?, 
                        tbcantidad = ?, 
                        tbfuncion = ?, 
                        tbaplicacion = ?, 
                        tbdescripcion = ?, 
                        tbformula = ?, 
                        tbprovedor = ?
                    WHERE tbcodigo = ?";

                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(
                    $herbicida->getNombre(),
                    $herbicida->getNombrecomun(),
                    $herbicida->getPresentacion(),
                    $herbicida->getCasacomercial(),
                    $herbicida->getCantidad(),
                    $herbicida->getFuncion(),
                    $herbicida->getAplicacion(),
                    $herbicida->getDescripcion(),
                    $herbicida->getFormula(),
                    $herbicida->getProvedor(),
                    $herbicida->getCodigoid()
                ));

                return $x; // Devuelve true si la ejecución fue exitosa
            } catch (PDOException $e) {
                error_log("Error al actualizar herbicida: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return false;
            } finally {
                $con = null; // Cierra la conexión
            }
        }
        return false; // Devuelve false si la conexión es nula
    }

    public function reactivar($codigo)
    {
        $con = $this->conectar();
        $sql = $con->prepare("
        UPDATE tbherbicidas
        SET tbestado = 1 
        WHERE  tbcodigo = ? ");
        return $sql->execute(array($codigo));
    }

}

?>