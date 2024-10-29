<?php

include_once "../data/database.php";

class CompraProductoVeterinarioData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarCompraProductoVeterinario($compraProductoVeterinario)
    {
    
        $con = $this->conectar();

        $id = $compraProductoVeterinario->gettbCompraProductoVeterinarioId();
        $nombre = $compraProductoVeterinario->gettbCompraProductoVeterinarioNombre();
        $fechaCompra = $compraProductoVeterinario->gettbCompraProductoVeterinarioFechacompra();
        $cantidad = $compraProductoVeterinario->gettbCompraProductoVeterinarioCantidad();
        $precio = $compraProductoVeterinario->gettbCompraProductoVeterinarioPrecio();
        $productorid = $compraProductoVeterinario->gettbCompraProductoVeterinarioProductorid();

        // VA A LA TABLA Y SELECCIONA EL ÚLTIMO ID INSERTADO
        $tempsql = $con->prepare("SELECT MAX(tbcompraid) AS tbcompraid  FROM tbcompraproductoveterinario");
        $tempsql->execute();
        $tempid = $tempsql->fetch(); // GUARDA EN UN TEMPORAL

        $sql = $con->prepare("INSERT INTO tbcompraproductoveterinario (tbcompraid, tbcompranombre, tbcomprafechacompra, 
        tbcompracantidad, tbcompraprecio, tbcompraidproductor, tbcompraestado) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");

        $result = $sql->execute(array(
            $tempid[0] + 1,  // ACA AL TEMPORAL LE SUMA 1
            $nombre,
            $fechaCompra,
            $cantidad,
            $precio,
            $productorid,
            1 // Estado fijo
        ));

        return $result;
    }

    // Método para consultar todos los productoVeterinario
    public function consultarCompraProductoVeterinario()
    {
        $productoVeterinarioList = array();
        $con = $this->conectar();
        if ($con !== null) {
            try {                   
                $sql = "SELECT * FROM tbcompraproductoveterinario WHERE tbcompraestado=1";
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

    public function consultarCompraProductoVeterinarioPorCodigo($codigoid)
    {
        $con = $this->conectar();
        if ($con !== null) {
          
            try {                     
                $sql = "SELECT * FROM tbcompraproductoveterinario WHERE tbcompraid  = :codigoid";
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
        return null; // Devolver null si la conexión es nula*/
    }

    public function eliminarCompraProductoVeterinario($codigoid)
    {
        $con = $this->conectar();
        if ($con != null) {
            try {
               $sql = "UPDATE tbcompraproductoveterinario SET 
                            tbcompraestado = ? 
                        WHERE tbcompraid = ?";
            
                $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(0, $codigoid));

                return true;
            } catch (PDOException $e) {
                echo "Error al eliminar productoVeterinario: " . $e->getMessage();
                return false;
            }
        }
    }

    public function actualizarCompraProductoVeterinario($compraProductoVeterinario)
    {
        $con = $this->conectar();

        $id = $compraProductoVeterinario->gettbCompraProductoVeterinarioId();
       $nombre = $compraProductoVeterinario->gettbCompraProductoVeterinarioNombre();
        $fechaCompra = $compraProductoVeterinario->gettbCompraProductoVeterinarioFechacompra();
        $cantidad = $compraProductoVeterinario->gettbCompraProductoVeterinarioCantidad();
        $precio = $compraProductoVeterinario->gettbCompraProductoVeterinarioPrecio();
        if ($con !== null) {
            try {
                $sql = "UPDATE tbcompraproductoveterinario SET 
                            tbcompranombre = ?, 
                            tbcomprafechacompra = ?, 
                            tbcompracantidad = ?, 
                            tbcompraprecio = ?
                        WHERE tbcompraid  = ?";
                
                    $stmt = $con->prepare($sql);
                $x = $stmt->execute(array(
                    $nombre,
                    $fechaCompra,
                    $cantidad,
                    $precio,
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
