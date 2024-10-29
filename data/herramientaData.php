<?php

include_once "../domain/herramienta.php";
include_once "../data/database.php";

class herramientaData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function generarCodigoUnico($nombre, $descripcion)
    {
        // Generar varios códigos posibles
        $posiblesCodigos = [];
        $intentos = 10;  // Número de códigos a generar

        for ($i = 0; $i < $intentos; $i++) {
            $codigo = strtoupper(substr($nombre, 0, 3) . substr($descripcion, 0, 3) . str_pad($i, 2, '0', STR_PAD_LEFT));
            $codigo = substr($codigo, 0, 10);
            $posiblesCodigos[] = $codigo;
        }

        $codigosExistentes = $this->ValidarCodigos($posiblesCodigos);
        $codigosUnicos = array_diff($posiblesCodigos, $codigosExistentes);
        return reset($codigosUnicos);
    }

    public function ValidarCodigos(array $codigos)
    {
        $con = $this->conectar();
        $placeholders = implode(',', array_fill(0, count($codigos), '?'));
        $sql = $con->prepare("SELECT tbherramientacodigo FROM tbherramienta WHERE tbherramientacodigo IN ($placeholders)");

        $sql->execute($codigos);
        $codigosExistentes = $sql->fetchAll(PDO::FETCH_COLUMN);

        return $codigosExistentes;
    }

    public function insertarHerramienta($herramienta)
    {
        $con = $this->conectar();

        $codigo = $herramienta->getHerramientaCodigo();
        $nombre = $herramienta->getHerramientaNombre();
        $descripcion = $herramienta->getHerramientaDescripcion();

        $tempsql = $con->prepare("SELECT MAX(tbherramientaid) AS tbherramientaid FROM tbherramienta");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbherramienta(tbherramientaid, tbherramientacodigo, tbherramientanombre, tbherramientadescripcion, tbherramientaestado) VALUES (?,?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $codigo,
            $nombre,
            $descripcion,
            1
        ));
    }

    public function consultarHerramienta($estado, $usuarioID, $actualUserType, $herramientaPropia)
    {
        $HerramientaLista = array();
        $con = $this->conectar();

        $x;

        if ($con) {

            // Si el usuario es un administrador, obtener todas las Herramientas
            if ($actualUserType == 0) {
                $sql = $con->prepare("SELECT * FROM tbherramienta WHERE tbherramientaestado = ?");
                $sql->execute(array($estado));
            }else if ($actualUserType == 1 and $herramientaPropia == 0){
                // Si es productor obtener las herramientas propias y las del administrador
                $sql = $con->prepare("
                SELECT * FROM tbherramienta 
                WHERE tbherramientaestado = 1 
                AND (tbherramientacodigo LIKE ? OR tbherramientacodigo LIKE 'ADM-%')");
                $sql->execute(['PRD-' . $usuarioID . '%']);
            }else if ($actualUserType == 1 and $herramientaPropia == 1){
                // Si es productor obtener las herramientas propias y las del administrador
                $sql = $con->prepare("
                SELECT * FROM tbherramienta 
                WHERE tbherramientaestado = 1 
                AND (tbherramientacodigo LIKE ?)");
                $sql->execute(['PRD-' . $usuarioID . '%']);
            }

            foreach ($sql->fetchAll() as $data) {
                $HerramientaLista[] = array(
                    "tbherramientacodigo" => $data['tbherramientaid'],
                    "tbherramientanombre" => $data['tbherramientanombre'],
                    "tbherramientadescripcion" => $data['tbherramientadescripcion']
                );
            }
        }

        $jsonString = json_encode($HerramientaLista);
        return $jsonString;
    }


    public function eliminarHerramienta($codigo)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbherramienta SET tbherramientaestado=? WHERE tbherramientaid=?");
        return $sql->execute(array(0, $codigo));
    }

    public static function consultarcodigoherramienta($codigo)
    {
        $conexion = new herramientaData;
        $con = $conexion->conectar();
        $HerramientaLista = array();
        $sql = $con->prepare("SELECT * FROM tbherramienta WHERE tbherramientaid=?");
        $sql->execute(array($codigo));
        foreach ($sql->fetchAll() as $data) {
            $HerramientaLista[] = array(
                'codigo' => $data['tbherramientaid'],
                'nombre' => $data['tbherramientanombre'],
                'descripcion' => $data['tbherramientadescripcion'],
            );
        }
        $jsonString = json_encode($HerramientaLista);
        return $jsonString;
    }

    public static function actualizarHerramienta($herramienta)
    {
        $conexion = new herramientaData;
        $con = $conexion->conectar();
        $sql = $con->prepare("UPDATE tbherramienta SET tbherramientanombre=?, tbherramientadescripcion=? WHERE tbherramientaid=?");
        return $sql->execute(array(
            $herramienta->getHerramientaNombre(),
            $herramienta->getHerramientaDescripcion(),
            $herramienta->getHerramientaCodigo()
        ));
    }

    public static function ValidarCodigo($codigo)
    {
        $conexion = new herramientaData;
        $con = $conexion->conectar();
        $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbherramienta WHERE tbherramientacodigo = ?), 1, 0) AS resultado");
        $sql->execute(array($codigo));
        return $sql->fetchColumn();
    }

    public static function ValidarHerramientasParecidas($nombre)
    {
        $conexion = new herramientaData;
        $con = $conexion->conectar();
        $sql = $con->prepare("SELECT tbherramientanombre FROM tbherramienta WHERE tbherramientaestado = 1");
        $sql->execute();
        $herramientas = $sql->fetchAll(PDO::FETCH_COLUMN); // Obtener toda la columna de tbherramientanombre

        $herramientasSimilares = [];
        foreach ($herramientas as $herramientaNombre) {
            $distancia = levenshtein(strtolower($nombre), strtolower($herramientaNombre));
            if ($distancia <= 2) { // Umbral (Distancia o movimientos necesarios para transformar la cadena A en la cadena B)
                $herramientasSimilares[] = $herramientaNombre;
            }
        }

        return json_encode($herramientasSimilares);
    }

    public static function consultarHerramientaPorCodigo($codigo)
    {
        $conexion = new herramientaData;
        $con = $conexion->conectar();

        $sql = $con->prepare("SELECT tbherramientaid FROM tbherramienta WHERE tbherramientaid = ?");
        $sql->execute(array($codigo));
        $data = $sql->fetch();

        if ($data) {
            return $data['tbherramientaid'];
        } else {
            return null;
        }
    }

    public function reactivarHerramienta($codigo)
    {
        $con = $this->conectar();
        $sql = $con->prepare("
        UPDATE tbherramienta
        SET tbherramientaestado = 1 
        WHERE  tbherramientaid = ? ");
        return $sql->execute(array($codigo));
    }
}
