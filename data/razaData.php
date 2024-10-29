<?php

include_once "../domain/raza.php";
include_once "../data/database.php";

class razaData extends DataBase
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
        $sql = $con->prepare("SELECT tbrazacodigo FROM tbraza WHERE tbrazacodigo LIKE ?");
        $sql->execute(['PRD-' . $usuarioID . '-%']);
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }


    public function insertarRaza($raza, $actualUserType)
    {

        $con = $this->conectar();
        $codigo = $raza->getRazacodigo();
        $nombre = $raza->getRazanombre();
        $descripcion = $raza->getRazadescripcion();

        // Agregar 'ADM-' al inicio del código si el usuario es de tipo 0
        if ($actualUserType == 0) {
            $codigo = 'ADM-' . $codigo;
        }

        $tempsql = $con->prepare("SELECT MAX(tbrazaid) AS tbrazaid FROM tbraza");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbraza(tbrazaid, tbrazacodigo, tbrazanombre, tbrazadescripcion, tbrazaestado) VALUES (?,?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $codigo,
            $nombre,
            $descripcion,
            1
        ));
    }

    public function consultarRaza($actualUserType, $usuarioID, $manejoActual)
    {
        $RazaList = array();
        $con = $this->conectar();

        if ($con) {
            // Si el usuario es un administrador, obtener todas las razas
            if ($actualUserType == 0) {
                $sql = $con->prepare("SELECT * FROM tbraza WHERE tbrazaestado = 1");
                $sql->execute();
            } else if ($actualUserType == 1 && $manejoActual == 0) {
                // Si es productor y el manejo actual es 0, obtener las razas propias y las del administrador
                $sql = $con->prepare("
                SELECT * FROM tbraza 
                WHERE tbrazaestado = 1 
                AND (tbrazacodigo LIKE ? OR tbrazacodigo LIKE 'ADM-%')
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            } else if ($actualUserType == 1 && $manejoActual == 1) {
                // Si es productor y el manejo actual es 1, obtener solo las razas propias 
                $sql = $con->prepare("
                SELECT * FROM tbraza 
                WHERE tbrazaestado = 1 
                AND tbrazacodigo LIKE ?
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            }

            foreach ($sql->fetchAll() as $data) {
                $RazaList[] = array(
                    "tbrazacodigo" => $data['tbrazacodigo'],
                    "tbrazanombre" => $data['tbrazanombre'],
                    "tbrazadescripcion" => $data['tbrazadescripcion']
                );
            }
        }

        $jsonString = json_encode($RazaList);
        return $jsonString;
    }

    public function consultarRazasInactivas($actualUserType, $usuarioID, $manejoActual)
    {
        $RazaList = array();
        $con = $this->conectar();

        if ($con) {
            // Si el usuario es un administrador, obtener todas las razas
            if ($actualUserType == 0) {
                $sql = $con->prepare("SELECT * FROM tbraza WHERE tbrazaestado = 0");
                $sql->execute();
            } else if ($actualUserType == 1 && $manejoActual == 0) {
                // Si es productor y el manejo actual es 0, obtener las razas propias y las del administrador
                $sql = $con->prepare("
                SELECT * FROM tbraza 
                WHERE tbrazaestado = 0
                AND (tbrazacodigo LIKE ? OR tbrazacodigo LIKE 'ADM-%')
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            } else if ($actualUserType == 1 && $manejoActual == 1) {
                // Si es productor y el manejo actual es 1, obtener solo las razas propias 
                $sql = $con->prepare("
                SELECT * FROM tbraza 
                WHERE tbrazaestado = 0
                AND tbrazacodigo LIKE ?
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            }

            foreach ($sql->fetchAll() as $data) {
                $RazaList[] = array(
                    "tbrazacodigo" => $data['tbrazacodigo'],
                    "tbrazanombre" => $data['tbrazanombre'],
                    "tbrazadescripcion" => $data['tbrazadescripcion']
                );
            }
        }

        $jsonString = json_encode($RazaList);
        return $jsonString;
    }

    public function eliminarRaza($codigo, $actualUserType, $usuarioID)
    {
        $con = $this->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("UPDATE tbraza SET tbrazaestado=? WHERE tbrazacodigo=?");
            return $sql->execute(array(0, $codigo));
        } else {
            return false; // Código no válido para el tipo de usuario
        }
    }

    public static function consultarcodigoraza($codigo, $actualUserType, $usuarioID)
    {
        $conexion = new razaData;
        $con = $conexion->conectar();
        $razalista = array();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("SELECT * FROM tbraza WHERE tbrazacodigo=?");
            $sql->execute(array($codigo));
            foreach ($sql->fetchAll() as $data) {
                $razalista[] = array(
                    'codigo' => $data['tbrazacodigo'],
                    'nombre' => $data['tbrazanombre'],
                    'descripcion' => $data['tbrazadescripcion'],
                );
            }
            $jsonString = json_encode($razalista);
        } else {
            $jsonString = json_encode([]); // Código no válido para el tipo de usuario
        }
        return $jsonString;
    }

    public static function actualizarRaza($raza, $actualUserType, $usuarioID)
    {
        $conexion = new razaData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($raza->getRazacodigo(), $prefix) === 0) {
            $sql = $con->prepare("UPDATE tbraza SET tbrazanombre=?, tbrazadescripcion=? WHERE tbrazacodigo=?");
            return $sql->execute(array(
                $raza->getRazanombre(),
                $raza->getRazadescripcion(),
                $raza->getRazacodigo()
            ));
        } else {
            return false; // Código no válido para el tipo de usuario
        }
    }

    public function reactivarRaza($codigo)
    {
        $con = $this->conectar();
        $sql = $con->prepare("
        UPDATE tbraza
        SET tbrazaestado = 1 
        WHERE  tbrazacodigo = ? ");
        return $sql->execute(array($codigo));
    }

    public static function ValidarCodigo($codigo, $actualUserType, $usuarioID)
    {
        $conexion = new razaData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbraza WHERE tbrazacodigo = ?), 1, 0) AS resultado");
            $sql->execute(array($codigo));
            return $sql->fetchColumn();
        } else {
            return 0; // Código no válido para el tipo de usuario
        }
    }

    public static function ValidarRazasParecidas($nombre, $actualUserType, $usuarioID)
    {
        $conexion = new razaData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        $sql = $con->prepare("SELECT tbrazanombre FROM tbraza WHERE tbrazaestado = 1 AND tbrazacodigo LIKE ?");
        $sql->execute([$prefix . '%']);
        $razas = $sql->fetchAll(PDO::FETCH_COLUMN);

        $razasSimilares = [];
        foreach ($razas as $razaNombre) {
            $distancia = levenshtein(strtolower($nombre), strtolower($razaNombre));
            if ($distancia <= 2) { // Umbral de similitud
                $razasSimilares[] = $razaNombre;
            }
        }

        return json_encode($razasSimilares);
    }
}
