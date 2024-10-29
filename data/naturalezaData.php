<?php
include_once "../domain/naturaleza.php";
include_once "../data/database.php";

class naturalezaData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function generarCodigoUnico($nombre, $descripcion, $usuarioID)
    {
        // Cachear los códigos existentes al iniciar el proceso
        $codigosExistentes = $this->obtenerCodigosExistentes($usuarioID);

        $intentos = 0;
        $codigoUnico = false;
        $codigo = '';

        while (!$codigoUnico && $intentos < 100) {
            $codigo = strtoupper(substr($nombre, 0, 3) . substr($descripcion, 0, 3) . str_pad($intentos, 2, '0', STR_PAD_LEFT));
            $codigo = substr($codigo, 0, 10); // Asegurar que el código no exceda los 10 caracteres
            $codigoCompleto = 'PRD-' . $usuarioID . '-' . $codigo;

            if (!in_array($codigoCompleto, $codigosExistentes)) {
                $codigoUnico = true;
            }

            $intentos++;
        }

        if ($codigoUnico) {
            return $codigo;
        } else {
            throw new Exception("No se pudo generar un código único después de múltiples intentos.");
        }
    }

    private function obtenerCodigosExistentes($usuarioID)
    {
        $con = $this->conectar();
        $sql = $con->prepare("SELECT tbnaturalezacodigo FROM tbnaturaleza WHERE tbnaturalezacodigo LIKE ?");
        $sql->execute(['PRD-' . $usuarioID . '-%']);
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }

    public function insertarNaturaleza($naturaleza, $actualUserType)
    {
        $con = $this->conectar();

        $codigo = $naturaleza->getnaturalezaCodigo();
        $nombre = $naturaleza->getnaturalezaNombre();
        $descripcion = $naturaleza->getnaturalezaDescripcion();

        // Agregar 'ADM-' al inicio del código si el usuario es de tipo 0
        if ($actualUserType == 0) {
            $codigo = 'ADM-' . $codigo;
        }

        $tempsql = $con->prepare("SELECT MAX(tbnaturalezaid) AS tbnaturalezaid FROM tbnaturaleza");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbnaturaleza(tbnaturalezaid, tbnaturalezacodigo, tbnaturalezanombre, tbnaturalezadescripcion, tbnaturalezaestado) VALUES (?,?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $codigo,
            $nombre,
            $descripcion,
            1
        ));
    }

    public function consultarNaturaleza($actualUserType, $usuarioID, $manejoActual)
    {
        $naturalezaLista = array();
        $con = $this->conectar();

        if ($con) {
            // Si el usuario es un administrador, obtener todas las naturaleza
            if ($actualUserType == 0) {
                $sql = $con->prepare("SELECT * FROM tbnaturaleza WHERE tbnaturalezaestado = 1");
                $sql->execute();
            } else if ($actualUserType == 1 && $manejoActual == 0) {
                // Si es productor y el manejo actual es 0, obtener las naturaleza propias y las del administrador
                $sql = $con->prepare("
                SELECT * FROM tbnaturaleza 
                WHERE tbnaturalezaestado = 1 
                AND (tbnaturalezacodigo LIKE ? OR tbnaturalezacodigo LIKE 'ADM-%')
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            } else if ($actualUserType == 1 && $manejoActual == 1) {
                // Si es productor y el manejo actual es 1, obtener solo las naturaleza propias 
                $sql = $con->prepare("
                SELECT * FROM tbnaturaleza 
                WHERE tbnaturalezaestado = 1 
                AND tbnaturalezacodigo LIKE ?
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            }

            foreach ($sql->fetchAll() as $data) {
                $naturalezaLista[] = array(
                    "tbnaturalezacodigo" => $data['tbnaturalezacodigo'],
                    "tbnaturalezanombre" => $data['tbnaturalezanombre'],
                    "tbnaturalezadescripcion" => $data['tbnaturalezadescripcion']
                );
            }
        }

        $jsonString = json_encode($naturalezaLista);
        return $jsonString;
    }


    public function consultarNaturalezasInactivas($actualUserType, $usuarioID, $manejoActual)
    {
        $naturalezaLista = array();
        $con = $this->conectar();

        if ($con) {
            // Si el usuario es un administrador, obtener todas las naturaleza
            if ($actualUserType == 0) {
                $sql = $con->prepare("SELECT * FROM tbnaturaleza WHERE tbnaturalezaestado = 0");
                $sql->execute();
            } else if ($actualUserType == 1 && $manejoActual == 0) {
                // Si es productor y el manejo actual es 0, obtener las naturaleza propias y las del administrador
                $sql = $con->prepare("
                SELECT * FROM tbnaturaleza 
                WHERE tbnaturalezaestado = 0
                AND (tbnaturalezacodigo LIKE ? OR tbnaturalezacodigo LIKE 'ADM-%')
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            } else if ($actualUserType == 1 && $manejoActual == 1) {
                // Si es productor y el manejo actual es 1, obtener solo las naturaleza propias 
                $sql = $con->prepare("
                SELECT * FROM tbnaturaleza 
                WHERE tbnaturalezaestado = 0
                AND tbnaturalezacodigo LIKE ?
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            }

            foreach ($sql->fetchAll() as $data) {
                $naturalezaLista[] = array(
                    "tbnaturalezacodigo" => $data['tbnaturalezacodigo'],
                    "tbnaturalezanombre" => $data['tbnaturalezanombre'],
                    "tbnaturalezadescripcion" => $data['tbnaturalezadescripcion']
                );
            }
        }

        $jsonString = json_encode($naturalezaLista);
        return $jsonString;
    }

    public function eliminarNaturaleza($codigo, $actualUserType, $usuarioID)
    {

        $con = $this->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("UPDATE tbnaturaleza SET tbnaturalezaestado=? WHERE tbnaturalezacodigo=?");
            return $sql->execute(array(0, $codigo));
        } else {
            return false;
        }
    }

    public static function consultarCodigoNaturaleza($codigo, $actualUserType, $usuarioID)
    {

        $conexion = new naturalezaData;
        $con = $conexion->conectar();
        $naturalezaLista = array();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("SELECT * FROM tbnaturaleza WHERE tbnaturalezacodigo=?");
            $sql->execute(array($codigo));
            foreach ($sql->fetchAll() as $data) {
                $naturalezaLista[] = array(
                    'codigo' => $data['tbnaturalezacodigo'],
                    'nombre' => $data['tbnaturalezanombre'],
                    'descripcion' => $data['tbnaturalezadescripcion'],
                );
            }
            $jsonString = json_encode($naturalezaLista);
        } else {
            $jsonString = json_encode([]); // Código no válido para el tipo de usuario
        }
        return $jsonString;
    }


    public static function actualizarNaturaleza($naturaleza, $actualUserType, $usuarioID)
    {

        $conexion = new naturalezaData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($naturaleza->getnaturalezaCodigo(), $prefix) === 0) {
            $sql = $con->prepare("UPDATE tbnaturaleza SET tbnaturalezanombre=?, tbnaturalezadescripcion=? WHERE tbnaturalezacodigo=?");
            return $sql->execute(array(
                $naturaleza->getnaturalezaNombre(),
                $naturaleza->getnaturalezaDescripcion(),
                $naturaleza->getnaturalezaCodigo()
            ));
        } else {
            return false; // Código no válido para el tipo de usuario
        }
    }

    public static function validarCodigo($codigo, $actualUserType, $usuarioID)
    {
        $conexion = new naturalezaData;

        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbnaturaleza WHERE tbnaturalezacodigo = ?), 1, 0) AS resultado");
            $sql->execute(array($codigo));
            return $sql->fetchColumn();
        } else {
            return 0; // Código no válido para el tipo de usuario
        }
    }

    public static function validarNaturalezaParecidos($nombre, $actualUserType, $usuarioID)
    {
        $conexion = new naturalezaData;

        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        $sql = $con->prepare("SELECT tbnaturalezanombre FROM tbnaturaleza WHERE tbnaturalezaestado = 1 AND tbnaturalezacodigo LIKE ?");
        $sql->execute([$prefix . '%']);
        $naturalezas = $sql->fetchAll(PDO::FETCH_COLUMN);

        $naturalezasSimilares = [];
        foreach ($naturalezas as $naturalezaNombre) {
            $distancia = levenshtein(strtolower($nombre), strtolower($naturalezaNombre));
            if ($distancia <= 2) {
                $naturalezasSimilares[] = $naturalezaNombre;
            }
        }
        return json_encode($naturalezasSimilares);
    }

    public static function consultarNaturalezaPorCodigo($codigo)
    {
        $conexion = new naturalezaData;
        $con = $conexion->conectar();

        $sql = $con->prepare("SELECT tbnaturalezaid FROM tbnaturaleza WHERE tbnaturalezacodigo = ?");
        $sql->execute(array($codigo));
        $data = $sql->fetch();

        if ($data) {
            return $data['tbnaturalezaid'];
        } else {
            return null;
        }
    }

    public function reactivarNaturaleza($codigo)
    {
        $con = $this->conectar();
        $sql = $con->prepare("
        UPDATE tbnaturaleza 
        SET tbnaturalezaestado = 1 
        WHERE  tbnaturalezacodigo = ? ");
        return $sql->execute(array($codigo));
    }
}