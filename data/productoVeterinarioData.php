<?php

include_once "../data/database.php";

class ProductoVeterinarioData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }



    public function insertarProductoVeterinario($productoVeterinario)
    {

        
        $con = $this->conectar();

        $id = $productoVeterinario->getTbproductoVeterinarioid();
        $nombre = $productoVeterinario->getTbproductoVeterinarionombre();
        $principioactivo = $productoVeterinario->getTbproductoVeterinarioprincipioactivo();
        $dosificacion = $productoVeterinario->getTbproductoVeterinariodosificacion();
        $fechavencimiento = $productoVeterinario->getTbproductoVeterinariofechavencimiento();
        $funcion = $productoVeterinario->getTbproductoVeterinariofuncion();
        $descripcion = $productoVeterinario->getTbproductoVeterinariodescripcion();
        $tipomedicamento = $productoVeterinario->getTbproductoVeterinariotipomedicamento();
        $proveedor = $productoVeterinario->getTbproductoVeterinarioproveedor();
        $productorid = $productoVeterinario->getTbproductoVeterinarioproductorid();

        // VA A LA TABLA Y SELECCIONA EL ÚLTIMO ID INSERTADO
        $tempsql = $con->prepare("SELECT MAX(tbproductoveterinarioid) AS tbproductoveterinarioid FROM tbproductoveterinario");
        $tempsql->execute();
        $tempid = $tempsql->fetch(); // GUARDA EN UN TEMPORAL

        $sql = $con->prepare("INSERT INTO tbproductoveterinario (tbproductoveterinarioid, tbproductoveterinarionombre, 
        tbproductoveterinarioprincipioactivo, tbproductoveterinariodosificacion, tbproductoveterinariofechavencimiento, 
        tbproductoveterinariofuncion, tbproductoveterinariodescripcion, tbproductoveterinariotipomedicamento, 
        tbproductoveterinarioproveedor, tbproductoveterinarioproductorid, tbproductoveterinarioestado) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $result = $sql->execute(array(
            $tempid[0] + 1,  // ACA AL TEMPORAL LE SUMA 1
            $nombre,
            $principioactivo,
            $dosificacion,
            $fechavencimiento,
            $funcion,
            $descripcion,
            $tipomedicamento,
            $proveedor,
            $productorid,
            1 // Estado fijo
        ));

        return $result;
    }

    // Método para consultar todos los productoVeterinario
    public function consultarProductoVeterinario()
    {
        $productoVeterinarioList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {                   
                $sql = "SELECT * FROM tbproductoveterinario WHERE tbproductoVeterinarioestado=1";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar productoVeterinario: " . $e->getMessage(), 3, '/var/log/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }
    //para llenar el formulario cuando se le da editar

    public function consultarProductoVeterinarioPorCodigo($codigoid)
    {
        $con = $this->conectar();
        if ($con !== null) {
          
            try {
                $sql = "SELECT * FROM tbproductoveterinario WHERE tbproductoveterinarioid = :codigoid";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':codigoid', $codigoid, PDO::PARAM_INT);
                $stmt->execute();
                
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                error_log("Error al consultar productoVeterinario: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return null;
            } finally {
                $con = null; // Cierra la conexión explícitamente
            }
        }
        return null; // Devolver null si la conexión es nula
    }

    public function eliminarProductoVeterinario($codigoid)
    {
        $con = $this->conectar();
        if ($con != null) {
            try {
               $sql = "UPDATE tbproductoveterinario SET 
                            tbproductoveterinarioestado = ? 
                        WHERE tbproductoVeterinarioid = ?";
            
                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(0, $codigoid));

                return true;
            } catch (PDOException $e) {
                echo "Error al eliminar productoVeterinario: " . $e->getMessage();
                return false;
            }
        }
    }

    public function actualizarProductoVeterinario($productoVeterinario)
    {
        $con = $this->conectar();

        $id = $productoVeterinario->getTbproductoVeterinarioid();
        $nombre = $productoVeterinario->getTbproductoVeterinarionombre();
        $principioactivo = $productoVeterinario->getTbproductoVeterinarioprincipioactivo();
        $dosificacion = $productoVeterinario->getTbproductoVeterinariodosificacion();
        $fechavencimiento = $productoVeterinario->getTbproductoVeterinariofechavencimiento();
        $funcion = $productoVeterinario->getTbproductoVeterinariofuncion();
        $descripcion = $productoVeterinario->getTbproductoVeterinariodescripcion();
        $tipomedicamento = $productoVeterinario->getTbproductoVeterinariotipomedicamento();
        $proveedor = $productoVeterinario->getTbproductoVeterinarioproveedor();

        if ($con !== null) {
            try {
                $sql = "UPDATE tbproductoveterinario SET 
                            tbproductoveterinarionombre = ?, 
                            tbproductoveterinarioprincipioactivo = ?, 
                            tbproductoveterinariodosificacion = ?, 
                            tbproductoveterinariofechavencimiento = ?, 
                            tbproductoVeterinariofuncion = ?, 
                            tbproductoVeterinariodescripcion = ?, 
                            tbproductoveterinariotipomedicamento = ?, 
                            tbproductoveterinarioproveedor = ?
                        WHERE tbproductoVeterinarioid = ?";
                
                    $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(
                    $nombre,
                    $principioactivo,
                    $dosificacion,
                    $fechavencimiento,
                    $funcion,
                    $descripcion,
                    $tipomedicamento,
                    $proveedor,
                    $id,
                ));
                
                return $x; // Devuelve true si la ejecución fue exitosa
            } catch (PDOException $e) {
                error_log("Error al actualizar productoVeterinario: " . $e->getMessage(), 3, 'C:/xampp/htdocs/ganaderia/logs/php_errors.log');
                return false;
            } finally {
                $con = null; // Cierra la conexión
            }
        }
        return false; // Devuelve false si la conexión es nula
  
    }
}

?>
