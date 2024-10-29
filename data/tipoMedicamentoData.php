<?php
include_once "../domain/tipoMedicamento.php";
include_once "../data/database.php";

class tipoMedicamentoData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarTipoMedicamento($tipoMedicamento)
    {
        $con = $this->conectar();

        $tipoMedicamento = $tipoMedicamento->getTipoMedicamento();

        $tempsql = $con->prepare("SELECT MAX(tbtipoMedicamentoid) AS tbtipoMedicamentoid FROM tbtipomedicamento");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbtipomedicamento (tbtipoMedicamentoid, tbtipoMedicamentoNombre, tbtipoMedicamentoEstado) VALUES (?, ?, ?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $tipoMedicamento,
            1
        ));
    }

    public function actualizarTipoMedicamento($tipoMedicamentoAntiguo, $tipoMedicamentoNuevo)
    {
        $con = $this->conectar();

        if ($con) {
            try {
                $sql = $con->prepare("UPDATE tbtipomedicamento SET tbtipoMedicamentoNombre = ? WHERE tbtipoMedicamentoNombre = ?");
                $resultado = $sql->execute(array($tipoMedicamentoNuevo, $tipoMedicamentoAntiguo));

                return $resultado ? 1 : 0;
            } catch (PDOException $e) {
                echo "Error al actualizar el tipo de medicamento: " . $e->getMessage();
                return 0;
            }
        }
        return 0;
    }

    public function obtenerTipoMedicamentoPorNombre($tipoMedicamento)
    {
        $con = $this->conectar();

        if ($con) {
            try {
                $sql = $con->prepare("SELECT * FROM tbtipomedicamento WHERE tbtipoMedicamentoNombre = ? AND tbtipoMedicamentoEstado = 1");
                $sql->execute(array($tipoMedicamento));

                $data = $sql->fetch(PDO::FETCH_ASSOC);

                if ($data) {
                    // Crear un objeto de tipoMedicamento y retornar
                    $tipoMedicamento = new tipoMedicamento($data['tbtipoMedicamentoNombre']);
                    return $tipoMedicamento;
                } else {
                    // No se encontró el tipo de medicamento
                    return null;
                }
            } catch (PDOException $e) {
                echo "Error al obtener el tipo de medicamento: " . $e->getMessage();
                return null;
            }
        }
        return null;
    }

    public function consultarTipoMedicamentos()
    {
        $tipoMedicamentoLista = array();
        $con = $this->conectar();
        if ($con) {
            $sql = $con->query("SELECT * FROM tbtipomedicamento WHERE tbtipoMedicamentoEstado = 1");
            foreach ($sql->fetchAll() as $data) {
                $tipoMedicamentoLista[] = array(
                    "tipoMedicamento" => $data['tbtipoMedicamentoNombre']
                );
            }
        }
        $jsonString = json_encode($tipoMedicamentoLista);
        return $jsonString;
    }

    public function eliminarTipoMedicamento($tipoMedicamento)
    {
        $con = $this->conectar();

        if ($con) {
            try {
                $sql = $con->prepare("UPDATE tbtipomedicamento SET tbtipoMedicamentoEstado = 0 WHERE tbtipoMedicamentoNombre = ?");
                $resultado = $sql->execute(array($tipoMedicamento));

                return $resultado ? 1 : 0;
            } catch (PDOException $e) {
                echo "Error al eliminar (desactivar) el tipo de medicamento: " . $e->getMessage();
                return 0;
            }
        }
        return 0;
    }

    public static function validarTipoMedicamentoRepetido($tipoMedicamento)
    {
        $conexion = new tipoMedicamentoData();
        $con = $conexion->conectar();
        $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbtipomedicamento WHERE tbtipoMedicamentoNombre = ?), 1, 0) AS resultado ");
        $sql->execute(array($tipoMedicamento));
        return $sql->fetchColumn();
    }
}
