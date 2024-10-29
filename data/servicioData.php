<?php
include_once "../domain/Servicio.php";
include_once "../data/database.php";

class servicioData extends DataBase
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
        $sql = $con->prepare("SELECT tbserviciocodigo FROM tbservicio WHERE tbserviciocodigo LIKE ?");
        $sql->execute(['PRD-' . $usuarioID . '-%']);
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }

    public function insertarServicio($servicio, $actualUserType)
    {
        $con = $this->conectar();

        $codigo = $servicio->getServicioCodigo();
        $nombre = $servicio->getServicioNombre();
        $descripcion = $servicio->getServicioDescripcion();

        // Agregar 'ADM-' al inicio del código si el usuario es de tipo 0
        if ($actualUserType == 0) {
            $codigo = 'ADM-' . $codigo;
        }

        $tempsql = $con->prepare("SELECT MAX(tbservicioid) AS tbservicioid FROM tbservicio");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbservicio(tbservicioid, tbserviciocodigo, tbservicionombre, tbserviciodescripcion, tbservicioestado) VALUES (?,?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $codigo,
            $nombre,
            $descripcion,
            1
        ));
    }

    public function consultarServicio($actualUserType, $usuarioID, $manejoActual)
    {
        $servicioLista = array();
        $con = $this->conectar();

        // Si el usuario es un administrador, obtener todas los servicios
        if ($actualUserType == 0) {
            $sql = $con->prepare("SELECT * FROM tbservicio WHERE tbservicioestado = 1");
            $sql->execute();
        } else if ($actualUserType == 1 && $manejoActual == 0) {
            // Si es productor y el manejo actual es 0, obtener los servicios propios y las del administrador
            $sql = $con->prepare("
            SELECT * FROM tbservicio 
            WHERE tbservicioestado = 1 
            AND (tbserviciocodigo LIKE ? OR tbserviciocodigo LIKE 'ADM-%')
        ");
            $sql->execute(['PRD-' . $usuarioID . '-%']);
        } else if ($actualUserType == 1 && $manejoActual == 1) {
            // Si es productor y el manejo actual es 1, obtener solo los servicios propios 
            $sql = $con->prepare("
            SELECT * FROM tbservicio 
            WHERE tbservicioestado = 1 
            AND tbserviciocodigo LIKE ?
        ");
            $sql->execute(['PRD-' . $usuarioID . '-%']);
        }

        foreach ($sql->fetchAll() as $data) {
            $servicioLista[] = array(
                "tbserviciocodigo" => $data['tbserviciocodigo'],
                "tbservicionombre" => $data['tbservicionombre'],
                "tbserviciodescripcion" => $data['tbserviciodescripcion']
            );
        }

        $jsonString = json_encode($servicioLista);
        return $jsonString;
    }

    public function eliminarServicio($codigo, $actualUserType, $usuarioID)
    {
        $con = $this->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("UPDATE tbservicio SET tbservicioestado=? WHERE tbserviciocodigo=?");
            return $sql->execute(array(0, $codigo));
        } else {
            return false; // Código no válido para el tipo de usuario
        }
    }

    public static function consultarCodigoServicio($codigo, $actualUserType, $usuarioID)
    {
        $conexion = new servicioData;
        $con = $conexion->conectar();
        $serviciolista = array();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';

        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("SELECT * FROM tbservicio WHERE tbserviciocodigo=?");
            $sql->execute(array($codigo));
            foreach ($sql->fetchAll() as $data) {
                $serviciolista[] = array(
                    'codigo' => $data['tbserviciocodigo'],
                    'nombre' => $data['tbservicionombre'],
                    'descripcion' => $data['tbserviciodescripcion'],
                );
            }
            $jsonString = json_encode($serviciolista);
        } else {
            $jsonString = json_encode([]); // Código no válido para el tipo de usuario
        }
        return $jsonString;
    }

    public static function actualizarServicio($servicio, $actualUserType, $usuarioID)
    {
        $conexion = new servicioData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($servicio->getServiciocodigo(), $prefix) === 0) {
            $sql = $con->prepare("UPDATE tbservicio SET tbservicionombre=?, tbserviciodescripcion=? WHERE tbserviciocodigo=?");
            return $sql->execute(array(
                $servicio->getServicioNombre(),
                $servicio->getServicioDescripcion(),
                $servicio->getServiciocodigo()
            ));
        } else {
            return false; // Código no válido para el tipo de usuario
        }
    }

    public static function validarCodigo($codigo, $actualUserType, $usuarioID)
    {
        $conexion = new servicioData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        if (strpos($codigo, $prefix) === 0) {
            $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbservicio WHERE tbserviciocodigo = ?), 1, 0) AS resultado");
            $sql->execute(array($codigo));
            return $sql->fetchColumn();
        } else {
            return 0; // Código no válido para el tipo de usuario
        }
    }

    public static function validarServicioParecidos($nombre, $actualUserType, $usuarioID)
    {
        $conexion = new servicioData;
        $con = $conexion->conectar();
        $prefix = $actualUserType == 0 ? 'ADM-' : 'PRD-' . $usuarioID . '-';
        $sql = $con->prepare("SELECT tbservicionombre FROM tbservicio WHERE tbservicioestado = 1 AND tbserviciocodigo LIKE ?");
        $sql->execute([$prefix . '%']);
        $servicios = $sql->fetchAll(PDO::FETCH_COLUMN);

        $serviciosSimilares = [];
        foreach ($servicios as $servicioNombre) {
            $distancia = levenshtein(strtolower($nombre), strtolower($servicioNombre));
            if ($distancia <= 2) { // Umbral de similitud
                $serviciosSimilares[] = $servicioNombre;
            }
        }

        return json_encode($serviciosSimilares);
    }

    public static function consultarServicioPorCodigo($codigo)
    {
        $conexion = new servicioData;
        $con = $conexion->conectar();

        $sql = $con->prepare("SELECT tbservicioid FROM tbservicio WHERE tbserviciocodigo = ?");
        $sql->execute(array($codigo));
        $data = $sql->fetch();

        if ($data) {
            return $data['tbservicioid'];
        } else {
            return null;
        }
    }

    public function reactivarServicio($codigo)
    {
        $con = $this->conectar();
        $sql = $con->prepare("
        UPDATE tbservicio 
        SET tbservicioestado = 1 
        WHERE  tbserviciocodigo = ? ");
        return $sql->execute(array($codigo));
    }

    public function consultarServicioInactivo($actualUserType, $usuarioID, $manejoActual)
    {
        $servicioLista = array();
        $con = $this->conectar();

        // Si el usuario es un administrador, obtener todas los servicios
        if ($actualUserType == 0) {
            $sql = $con->prepare("SELECT * FROM tbservicio WHERE tbservicioestado = 0");
            $sql->execute();
        } else if ($actualUserType == 1 && $manejoActual == 0) {
            // Si es productor y el manejo actual es 0, obtener los servicios propios y las del administrador
            $sql = $con->prepare("
            SELECT * FROM tbservicio 
            WHERE tbservicioestado = 0
            AND (tbserviciocodigo LIKE ? OR tbserviciocodigo LIKE 'ADM-%')
        ");
            $sql->execute(['PRD-' . $usuarioID . '-%']);
        } else if ($actualUserType == 1 && $manejoActual == 1) {
            // Si es productor y el manejo actual es 1, obtener solo los servicios propios 
            $sql = $con->prepare("
            SELECT * FROM tbservicio 
            WHERE tbservicioestado = 0 
            AND tbserviciocodigo LIKE ?
        ");
            $sql->execute(['PRD-' . $usuarioID . '-%']);
        }

        foreach ($sql->fetchAll() as $data) {
            $servicioLista[] = array(
                "tbserviciocodigo" => $data['tbserviciocodigo'],
                "tbservicionombre" => $data['tbservicionombre'],
                "tbserviciodescripcion" => $data['tbserviciodescripcion']
            );
        }

        $jsonString = json_encode($servicioLista);
        return $jsonString;
    }
    
}
