<?php

include_once "../domain/fertilizantes.php";
include_once "../data/database.php";

class fertilizantesData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }



    public function insertarFertilizante($fertilizante)
    {
        $con = $this->conectar();

        $codigo = $fertilizante->getTbfertilizantecodigo();
        $nombre = $fertilizante->getTbfertilizantenombre();
        $nombreComun = $fertilizante->getTbfertilizantenombrecomun();
        $presentacion = $fertilizante->getTbfertilizantepresentacion();
        $casaComercial = $fertilizante->getTbfertilizantecasacomercial();
        $cantidad = $fertilizante->getTbfertilizantecantidad();
        $funcion = $fertilizante->getTbfertilizantefuncion();
        $dosificacion = $fertilizante->getTbfertilizantedosificacion();
        $descripcion = $fertilizante->getTbfertilizantedescripcion();
        $formula = $fertilizante->getTbfertilizanteformula();
        $proveedor = $fertilizante->getTbfertilizanteproveedor();

        // VA A LA TABLA Y SELECCIONA EL ÚLTIMO ID INSERTADO
        $tempsql = $con->prepare("SELECT MAX(tbfertilizanteid) AS tbfertilizanteid FROM tbfertilizantes");
        $tempsql->execute();
        $tempid = $tempsql->fetch(); // GUARDA EN UN TEMPORAL

        $sql = $con->prepare("INSERT INTO tbfertilizantes (tbfertilizanteid, tbfertilizantecodigo, tbfertilizantenombre, tbfertilizantenombrecomun, tbfertilizantepresentacion, tbfertilizantecasacomercial, tbfertilizantecantidad, tbfertilizantefuncion, tbfertilizantedosificacion, tbfertilizantedescripcion, tbfertilizanteformula, tbfertilizanteproveedor, tbfertilizanteestado) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $x = $sql->execute(array(
            $tempid[0] + 1,  // ACA AL TEMPORAL LE SUMA 1
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
            1 // Estado fijo
        ));

        return $x;
    }

    // Método para consultar todos los fertilizantes
    public function consultarFertilizantes($estado)
    {
        $fertilizanteList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "SELECT * FROM tbfertilizantes WHERE tbfertilizanteestado=?";
                // $sql = "SELECT * FROM tbfertilizantes";
                $stmt = $con->prepare($sql);
                $stmt->execute([$estado]);

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                //error_log("Error al consultar fertilizantes: " . $e->getMessage(), 3, '/var/log/php_errors.log');
                return $e;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }
    //para llenar el formulario cuando se le da editar

    public function consultarFertilizantePorCodigo($codigoid)
    {
        $con = $this->conectar();
        if ($con !== null) {

            try {
                $sql = "SELECT * FROM tbfertilizantes WHERE tbfertilizantecodigo = :codigoid";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':codigoid', $codigoid, PDO::PARAM_INT);
                $stmt->execute();

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar fertilizantes: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }

    public function eliminarFertilizante($codigoid)
    {
        $con = $this->conectar();
        if ($con != null) {
            try {
                $sql = "UPDATE tbfertilizantes SET 
                            tbfertilizanteestado = ? 
                        WHERE tbfertilizantecodigo = ?";

                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(0, $codigoid));

                return true;
            } catch (PDOException $e) {
                echo "Error al eliminar fertilizante: " . $e->getMessage();
                return false;
            }
        }
    }

    public function actualizarFertilizante($fertilizante)
    {
        $con = $this->conectar();
        if ($con !== null) {
            try {
                $sql = "UPDATE tbfertilizantes SET 
                            tbfertilizantenombre = ?, 
                            tbfertilizantenombrecomun = ?, 
                            tbfertilizantepresentacion = ?, 
                            tbfertilizantecasacomercial = ?, 
                            tbfertilizantecantidad = ?, 
                            tbfertilizantefuncion = ?, 
                            tbfertilizantedosificacion = ?, 
                            tbfertilizantedescripcion = ?, 
                            tbfertilizanteformula = ?, 
                            tbfertilizanteproveedor = ?
                        WHERE tbfertilizantecodigo = ?";

                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(
                    $fertilizante->getTbfertilizantenombre(),
                    $fertilizante->getTbfertilizantenombrecomun(),
                    $fertilizante->getTbfertilizantepresentacion(),
                    $fertilizante->getTbfertilizantecasacomercial(),
                    $fertilizante->getTbfertilizantecantidad(),
                    $fertilizante->getTbfertilizantefuncion(),
                    $fertilizante->getTbfertilizantedosificacion(),
                    $fertilizante->getTbfertilizantedescripcion(),
                    $fertilizante->getTbfertilizanteformula(),
                    $fertilizante->getTbfertilizanteproveedor(),
                    $fertilizante->getTbfertilizantecodigo()
                ));

                return $x; // Devuelve true si la ejecución fue exitosa
            } catch (PDOException $e) {
                error_log("Error al actualizar fertilizante: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
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
        UPDATE tbfertilizantes
        SET tbfertilizanteestado = 1 
        WHERE  tbfertilizantecodigo = ? ");
        return $sql->execute(array($codigo));
    }
}

?>