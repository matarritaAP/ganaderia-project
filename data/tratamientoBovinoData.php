<?php
include_once "../domain/tratamientoBovino.php"; // Ajustar a tu dominio de tratamientoBovino
include_once "../data/database.php";
class tratamientoBovinoData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }
    public function insertarTratamientoBovino($tratamientoBovino)
    {
        
        $con = $this->conectar();
        $bovinoId = $tratamientoBovino->getBovinoId();
        $fecha = $tratamientoBovino->getFecha();
        $enfermedadId = $tratamientoBovino->getEnfermedadId();
        $tipoMedicamentoId = $tratamientoBovino->getTipoMedicamentoId();
        $dosis = $tratamientoBovino->getDosis();
       
        // Selecciona el último ID insertado en la tabla
        $tempsql = $con->prepare("SELECT MAX(tbtratamientobovinoid) AS tbtratamientobovinoid FROM tbtratamientobovino");
        $tempsql->execute();
        $tempid = $tempsql->fetch(); // Guarda en un temporal
        $sql = $con->prepare("INSERT INTO tbtratamientobovino (tbtratamientobovinoid, tbbovinoid, tbtratamientobovinofecha, tbtratamientobovinoenfermedadid, tbtratamientobovinotipomedicamentoid, tbtratamientobovinodosis, tbtratamientobovinoestado) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
        $x = $sql->execute(array(
            $tempid[0] + 1,  // Al temporal le suma 1
            $bovinoId,
            $fecha,
            $enfermedadId,
            $tipoMedicamentoId,
            $dosis,
             1   // Estado fijo o dinámico dependiendo del valor ingresado
        ));
        return $x;
    }
    public function consultarTratamientosBovinos()
    {
        $tratamientoBovinoList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbtratamientobovino WHERE tbtratamientobovinoestado = 1";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar tratamientos de bovinos: " . $e->getMessage(), 3, '/var/log/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null;
    }
    //consulta en base datos los inactivos pasando 0 como dato quemado
    public function consultarTratamientosBovinosInactivos()
    {
        $tratamientoBovinoList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbtratamientobovino WHERE tbtratamientobovinoestado = 0";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar tratamientos de bovinos: " . $e->getMessage(), 3, '/var/log/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null;
    }
            //consultarTratamientoBovinoPorId
    public function consultarTratamientoBovinoPorId($tbbovinoId)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                //echo "hola: " . $tbbovinoId;
               // echo "tbbovinoId: " . $tbbovinoId;
                $sql = "SELECT * FROM tbtratamientobovino WHERE tbtratamientobovinoid  = :tbbovinoId";
                $stmt = $con->prepare($sql);
                // Vincula el parámetro :bovinoId al valor de $bovinoId
                $stmt->bindParam(':tbbovinoId', $tbbovinoId, PDO::PARAM_INT);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //var_dump($resultados);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar tratamiento bovino: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return null;
            } finally {
                $con = null;
            }
        }
        return null;
    }
    // "elimina" en la base datos el resgistro, como tal pone en cero el estado
    public function eliminarTratamientoBovino($bovinoId)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "UPDATE tbtratamientobovino SET 
                        tbtratamientobovinoestado = ? 
                    WHERE tbtratamientobovinoid = ?";
                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(0, $bovinoId));
                return true;
            } catch (PDOException $e) {
                echo "Error al eliminar tratamiento de bovino: " . $e->getMessage();
                return false;
            }
        }
    }
// funcion para reactivar, cambia el estado en la base datos
    public function reactivarTratamientoBovino($bovinoId)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "UPDATE tbtratamientobovino SET 
                        tbtratamientobovinoestado = ? 
                    WHERE tbtratamientobovinoid= ?";
                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(1, $bovinoId));
                return true;
            } catch (PDOException $e) {
                echo "No se pudo realizar la accio de: " . $e->getMessage();
                return false;
            }
        }
       // return $bovinoId;
    }
// funcion de base datos para actualizar, se le pasan los parametros y se actualiza registro
public function actualizarTratamientoBovino($tratamientoBovino, $tbbovinoId)
{
    $con = $this->conectar();
    if ($con !== null) {
        try {
            $sql = "UPDATE tbtratamientobovino SET 
                    tbbovinoid = ?, 
                    tbtratamientobovinofecha = ?, 
                    tbtratamientobovinoenfermedadid = ?, 
                    tbtratamientobovinotipomedicamentoid = ?, 
                    tbtratamientobovinodosis = ? 
                    WHERE tbtratamientobovinoid = ?"; // Coma eliminada y se agregó marcador para el ID
            $stmt = $con->prepare($sql);
            $x = $stmt->execute(array(
                $tratamientoBovino->getBovinoId(),
                $tratamientoBovino->getFecha(),
                $tratamientoBovino->getEnfermedadId(),
                $tratamientoBovino->getTipoMedicamentoId(),
                $tratamientoBovino->getDosis(),
                $tbbovinoId // Se agrega el ID al final
            ));
            return $x; // Devuelve true si la ejecución fue exitosa
        } catch (PDOException $e) {
            error_log("Error al actualizar tratamiento de bovino: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
            return false;
        } finally {
            $con = null; // Cierra la conexión
        }
    }
    return false;
}
}