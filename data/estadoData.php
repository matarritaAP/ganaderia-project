<?php
include_once "../domain/estado.php";
include_once "../data/database.php";

class estadoData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    //listo
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

    //listo
    private function obtenerCodigosExistentes($usuarioID)
    {
        $con = $this->conectar();
        $sql = $con->prepare("SELECT tbestadocodigo FROM tbestado WHERE tbestadocodigo LIKE ?");
        $sql->execute(['PRD-' . $usuarioID . '-%']);
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }

    //listo
    public function insertarEstado($estado, $actualUserType)
    {
        $con = $this->conectar();
        $nombre = $estado->getEstadoNombre();
        $codigo = $estado->getEstadoCodigo();
        $descripcion = $estado->getEstadoDescripcion();

        if ($actualUserType == 0) {
            $codigo = 'ADM-' . $codigo;
        }

        //Devuelve el ultimo valor id.
        $tempsql = $con->prepare("SELECT MAX(tbestadoid) AS tbestadoid FROM tbestado");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbestado(tbestadoid, tbestadocodigo, tbestadonombre,tbestadodescripcion,tbestadoactivo) VALUES (?,?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $codigo,
            $nombre,
            $descripcion,
            1
        ));
    }

    //listo
    public function consultarEstado($actualUserType, $usuarioID, $manejoActual)
    {
        $estadoList = array();
        $con = $this->conectar();

        if ($actualUserType == 0) {
            // Preparar la consulta con parámetros
            $sql = $con->prepare("SELECT * FROM tbestado WHERE tbestadoactivo = 1");
            $sql->execute();  // Ejecutar la consulta con el valor de $activo
        } else if($actualUserType == 1 && $manejoActual == 0){
            $sql = $con->prepare("SELECT * FROM tbestado WHERE tbestadoactivo = 1 AND (tbestadocodigo LIKE ? OR tbestadocodigo LIKE 'ADM-%')");
            $sql->execute(['PRD-' . $usuarioID . '-%']);
        } else if($actualUserType == 1 && $manejoActual == 1){
            $sql = $con->prepare("SELECT * FROM tbestado WHERE tbestadoactivo = 1 AND tbestadocodigo LIKE ?");
            $sql->execute(['PRD-' . $usuarioID . '-%']);
        }
        // Iterar sobre los resultados
        foreach ($sql->fetchAll() as $data) {
            $estadoList[] = array(
                "tbestadocodigo" => $data['tbestadocodigo'],
                "tbestadonombre" => $data['tbestadonombre'],
                "tbestadodescripcion" => $data['tbestadodescripcion']
            );
        }

        // Convertir el array a JSON
        $jsonString = json_encode($estadoList);
        return $jsonString;
    }

    public function consultarEstadosInactivos($actualUserType, $usuarioID, $manejoActual)
    {
        $estadoList = array();
        $con = $this->conectar();

        if ($con) {
            // Si el usuario es un administrador, obtener todas las razas
            if ($actualUserType == 0) {
                $sql = $con->prepare("SELECT * FROM tbestado WHERE tbestadoactivo = 0");
                $sql->execute();
            } else if ($actualUserType == 1 && $manejoActual == 0) {
                // Si es productor y el manejo actual es 0, obtener las razas propias y las del administrador
                $sql = $con->prepare("
                SELECT * FROM tbestado 
                WHERE tbestadoactivo = 0
                AND (tbestadocodigo LIKE ? OR tbestadocodigo LIKE 'ADM-%')
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            } else if ($actualUserType == 1 && $manejoActual == 1) {
                // Si es productor y el manejo actual es 1, obtener solo las razas propias 
                $sql = $con->prepare("
                SELECT * FROM tbestado 
                WHERE tbestadoactivo = 0
                AND tbestadocodigo LIKE ?
            ");
                $sql->execute(['PRD-' . $usuarioID . '-%']);
            }

            foreach ($sql->fetchAll() as $data) {
                $estadoList[] = array(
                    "tbestadocodigo" => $data['tbestadocodigo'],
                    "tbestadonombre" => $data['tbestadonombre'],
                    "tbestadodescripcion" => $data['tbestadodescripcion']
                );
            }
        }

        $jsonString = json_encode($estadoList);
        return $jsonString;
    }

    //listo
    public function eliminarEstado($codigo, $actualUserType, $usuarioID)
    {
        $con = $this->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("UPDATE tbestado SET tbestadoactivo = ? WHERE tbestadocodigo = ?");
        return $sql->execute(array(0, $codigo));
        } else {
            return false; // Código no válido para el tipo de usuario
        }
        
    }

    //listo
    public static function consultarcodigoestado($codigo, $actualUserType, $usuarioID)
    {
        $conexion = new estadoData;
        $con = $conexion->conectar();
        $estadolista = array();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("SELECT * FROM tbestado WHERE tbestadocodigo=?");
            $sql->execute(array($codigo));
            foreach ($sql->fetchAll() as $data) {
            $estadolista[] = array(
                'codigo' => $data['tbestadocodigo'],
                'nombre' => $data['tbestadonombre'],
                'descripcion' => $data['tbestadodescripcion'],
                );
            }
            $jsonString = json_encode($estadolista);
        } else {
            $jsonString = json_encode([]); // Código no válido para el tipo de usuario
        }
        return $jsonString;
    }

    //listo
    public static function actualizarEstado($estado, $actualUserType, $usuarioID)
    {
        $conexion = new estadoData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($estado->getEstadoCodigo(), $prefix) === 0) {
            $sql = $con->prepare("UPDATE tbestado SET tbestadonombre=?, tbestadodescripcion=? WHERE tbestadocodigo=?");
            return $sql->execute(array(
                $estado->getEstadoNombre(),
                $estado->getEstadoDescripcion(),
                $estado->getEstadoCodigo(),
            ));
        } else {
            return false;
        }
        
    }

    //listo
    public function reactivarEstado($codigo){
        $con = $this->conectar();
        $sql = $con->prepare("UPDATE tbestado SET tbestadoactivo = 1 WHERE tbestadocodigo =?");
        return $sql->execute(array($codigo));
    }

    //listo
    public static function ValidarCodigo($codigo, $actualUserType, $usuarioID)
    {
        $conexion = new estadoData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbestado WHERE tbestadocodigo = ?), 1, 0) AS resultado");
            $sql->execute(array($codigo));
            return $sql->fetchColumn();
        } else {
            return 0;
        }
        
    }

    //lista
    public static function validarEstadoSimilar($nombre, $actualUserType, $usuarioID)
    {
        $conexion = new estadoData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        $sql = $con->prepare("SELECT tbestadonombre FROM tbestado WHERE tbestadoactivo = 1 AND tbestadocodigo LIKE ?");
        $sql->execute([$prefix . '%']);
        $estados = $sql->fetchAll(PDO::FETCH_COLUMN); // Obtener toda la columna de tbestadonombre

        $estadoSimilar = [];
        foreach ($estados as $estadoNombre) {
            $distancia = levenshtein(strtolower($nombre), strtolower($estadoNombre));
            if ($distancia <= 2) { // Umbral (Distancia o movimientos necesarios para transformar la cadena A en la cadeba B)
                $estadoSimilar[] = $estadoNombre;
            }
        }
        return json_encode($estadoSimilar);
    }
}
