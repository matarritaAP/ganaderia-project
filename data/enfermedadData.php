<?php

include_once "../data/database.php";

class EnfermedadData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }



    public function insertarEnfermedad($enfermedad)
    {
        $con = $this->conectar();

        $id = $enfermedad->getTbenfermedadid();
        $productorid = $enfermedad->getTbenfermedadproductorid();
        $nombre = $enfermedad->getTbenfermedadnombre();
        $descripcion = $enfermedad->getTbenfermedaddescripcion();
        $sintomas = $enfermedad->getTbenfermedadsintomas();

        // VA A LA TABLA Y SELECCIONA EL ÚLTIMO ID INSERTADO
        $tempsql = $con->prepare("SELECT MAX(tbenfermedadid) AS tbenfermedadid FROM tbenfermedad");
        $tempsql->execute();
        $tempid = $tempsql->fetch(); // GUARDA EN UN TEMPORAL

        $sql = $con->prepare("INSERT INTO tbenfermedad (tbenfermedadid, tbenfermedadidproductor, tbenfermedadnombre, 
        tbenfermedaddescripcion, tbenfermedadsintomas, tbenfermedadestado) 
                              VALUES (?, ?, ?, ?, ?, ?)");
 
        $result = $sql->execute(array(
            $tempid[0] + 1,  // ACA AL TEMPORAL LE SUMA 1
            $productorid,
            $nombre,
            $descripcion,
            $sintomas, 
            1 // Estado fijo
        ));

        return $result;
    }

    // Método para consultar todos los Enfermedad
    public function consultarEnfermedad()
    {
        $enfermedadList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {                   
                $sql = "SELECT * FROM tbenfermedad WHERE tbenfermedadestado=1";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar enfermedad: " . $e->getMessage(), 3, '/var/log/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }
    //para llenar el formulario cuando se le da editar

    public function consultarEnfermedadPorCodigo($codigoid)
    {
        $con = $this->conectar();
        if ($con !== null) {
          
            try {
                $sql = "SELECT * FROM tbenfermedad WHERE tbenfermedadid = :codigoid";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':codigoid', $codigoid, PDO::PARAM_INT);
                $stmt->execute();
                
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar enfermedad: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }

    public function eliminarEnfermedad($codigoid)
    {
        $con = $this->conectar();
        if ($con != null) {
            try {
               $sql = "UPDATE tbenfermedad SET 
                            tbenfermedadestado = ? 
                        WHERE tbenfermedadid = ?";
            
                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(0, $codigoid));

                return true;
            } catch (PDOException $e) {
                echo "Error al eliminar enfermedad: " . $e->getMessage();
                return false;
            }
        }
    }

    public function actualizarEnfermedad($enfermedad)
    {
        $con = $this->conectar();

        $id = $enfermedad->getTbenfermedadid();
        $nombre = $enfermedad->getTbenfermedadnombre();
        $descripcion = $enfermedad->getTbenfermedaddescripcion();
        $sintomas = $enfermedad->getTbenfermedadsintomas();

        if ($con !== null) {
            try {
                $sql = "UPDATE tbenfermedad SET 
                            tbenfermedadnombre = ?,  
                            tbenfermedaddescripcion = ?, 
                            tbenfermedadsintomas= ?
                        WHERE tbenfermedadid = ?";
                
                    $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(
                    $nombre,
                    $descripcion,
                    $sintomas,
                    $id
                ));
                
                return $x; // Devuelve true si la ejecución fue exitosa
            } catch (PDOException $e) {
                error_log("Error al actualizar enfermedad: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return false;
            } finally {
                $con = null; // Cierra la conexión
            }
        }
        return false; // Devuelve false si la conexión es nula
  
    }
}

?>
