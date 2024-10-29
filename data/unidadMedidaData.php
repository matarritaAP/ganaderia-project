<?php
include_once "../domain/unidadesMedida.php";
include_once "../data/database.php";

class unidadMedidaData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarUnidadMedida($unidadMedida)
    {
        $con = $this->conectar();

        $tipoUnidad = $unidadMedida->getTipoUnidad();

        $tempsql = $con->prepare("SELECT MAX(tbunidadMedidaid) AS tbunidadMedidaid FROM tbunidadmedida");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbunidadmedida (tbunidadMedidaid, tbUnidadMedidaTipoUnidad, tbUnidadMedidaEstado) VALUES (?, ?, ?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $tipoUnidad,
            1
        ));
    }

    public function actualizarUnidadMedida($tipoUnidadAntiguo, $tipoUnidadNuevo)
{
    $con = $this->conectar();
    
    if ($con) {
        try {
            $sql = $con->prepare("UPDATE tbunidadmedida SET tbUnidadMedidaTipoUnidad = ? WHERE tbUnidadMedidaTipoUnidad = ?");
            $resultado = $sql->execute(array($tipoUnidadNuevo, $tipoUnidadAntiguo));
            
            return $resultado ? 1 : 0;
        } catch (PDOException $e) {
            echo "Error al actualizar la unidad de medida: " . $e->getMessage();
            return 0;
        }
    }
    return 0;
}

public function obtenerUnidadMedidaPorTipo($tipoUnidad)
{
    $con = $this->conectar();

    if ($con) {
        try {
            $sql = $con->prepare("SELECT * FROM tbunidadmedida WHERE tbUnidadMedidaTipoUnidad = ? AND tbUnidadMedidaEstado = 1");
            $sql->execute(array($tipoUnidad));

            $data = $sql->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                // Crear un objeto de unidadesMedida y retornar
                $unidadMedida = new unidadesMedida($data['tbUnidadMedidaTipoUnidad'], $data['tbUnidadMedidaEstado']);
                return $unidadMedida;
            } else {
                // No se encontró la unidad de medida
                return null;
            }
        } catch (PDOException $e) {
            echo "Error al obtener la unidad de medida: " . $e->getMessage();
            return null;
        }
    }
    return null;
}


    public function consultarUnidadesMedidas()
    {
        $unidadMedidaLista = array();
        $con = $this->conectar();
        if ($con) {
            $sql = $con->query("SELECT * FROM tbunidadmedida WHERE tbUnidadMedidaEstado = 1");
            foreach ($sql->fetchAll() as $data) {
                $unidadMedidaLista[] = array(
                    "tipoUnidad" => $data['tbUnidadMedidaTipoUnidad']
                );
            }
        }
        $jsonString = json_encode($unidadMedidaLista);
        return $jsonString;
    }

    public function eliminarUnidadMedida($tipoUnidad)
    {
        $con = $this->conectar();
        
        if ($con) {
            try {
                $sql = $con->prepare("UPDATE tbunidadmedida SET tbUnidadMedidaEstado = 0 WHERE tbUnidadMedidaTipoUnidad = ?");
                $resultado = $sql->execute(array($tipoUnidad));
                
                return $resultado ? 1 : 0;
            } catch (PDOException $e) {
                echo "Error al eliminar (desactivar) la unidad de medida: " . $e->getMessage();
                return 0;
            }
        }
        return 0;
    }

    public static function validarTipoUnidadRepetida($tipoUnidad)
    {
        $conexion = new unidadMedidaData;
        $con = $conexion->conectar();
        $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbunidadmedida WHERE tbUnidadMedidaTipoUnidad = ?), 1, 0) AS resultado ");
        $sql->execute(array($tipoUnidad));
        return $sql->fetchColumn();
    }
}
?>
