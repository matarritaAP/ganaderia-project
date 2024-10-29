<?php

include_once "../domain/bovino.php";
include_once "../data/database.php";
include_once "../data/razaProductorData.php";
include_once "../data/estadoProductorData.php";

class bovinoCompraData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarBovino($bovino)
    {
        $con = $this->conectar();
        // Obtener el siguiente ID disponible para el bovino
        $tempsql = $con->prepare("SELECT MAX(tbbovinocompraid) AS tbbovinocompraid FROM tbbovinocompra");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        // Obtener los IDs de padre y madre
        // $padreID = self::obtenerIdPorNumero($bovino->getBovinoPadre(), $bovino->getBovinoProductor());
        // $madreID = self::obtenerIdPorNumero($bovino->getBovinoMadre(), $bovino->getBovinoProductor());
        // Preparar la consulta de inserción
        $sql = $con->prepare("INSERT INTO tbbovinocompra (
            tbbovinocompraid,
            tbbovinocompranumero, 
            tbbovinocompranombre, 
            tbbovinocomprapadreid, 
            tbbovinocompramadreid, 
            tbbovinocomprafechanacimiento, 
            tbbovinocomprafechacompra, 
            tbbovinocompraprecio,
            tbbovinocomprapeso,
            tbbovinocompravendedor,
            tbbovinocompraraza,
            tbbovinocompraestado, 
            tbbovinocompragenero, 
            tbbovinocomprafincaid,
            tbbovinocompraproductorid, 
            tbbovinocompradetalle,
            tbbovinocompraactivo
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        // Insertar los datos del bovino
        return $sql->execute(array(
            $tempid['tbbovinocompraid'] + 1,
            $bovino->getBovinoNumero(),
            $bovino->getBovinoNombre(),
            $bovino->getBovinoPadre(),
            $bovino->getBovinoMadre(),
            $bovino->getBovinoFechaNacimiento(),
            $bovino->getBovinoFechaCompra(),
            $bovino->getBovinoPrecio(),
            $bovino->getBovinoPeso(),
            $bovino->getBovinoVendedor(),
            $bovino->getBovinoRaza(),
            $bovino->getBovinoEstado(),
            $bovino->getBovinoGenero(),
            $bovino->getBovinoFinca(),
            $bovino->getBovinoProductor(),
            $bovino->getBovinoDetalle(),
            1 // Activo
        ));
    }

    public function consultarBovino($usuarioID, $manejoActual)
    {
        // manejoActual == 1 -> Activos, manejoActual == 0 -> Inactivos
        $bovinoList = array();
        $con = $this->conectar();

        if ($con) {
            // Determinar el estado de manejo (activo o inactivo)
            $estadoActivo = ($manejoActual == 1) ? 1 : 0;

            // Preparar la consulta con el valor de tbbovinocompraactivo como parámetro
            $sql = $con->prepare("
            SELECT DISTINCT
                b.tbbovinocompranumero, 
                b.tbbovinocompranombre, 
                padre.tbbovinocompranombre AS nombre_padre,  -- Uniendo con el nombre del padre
                madre.tbbovinocompranombre AS nombre_madre,  -- Uniendo con el nombre de la madre
                b.tbbovinocomprafechanacimiento, 
                b.tbbovinocomprafechacompra, 
                b.tbbovinocompraprecio,
                b.tbbovinocomprapeso,
                b.tbbovinocompravendedor,
                b.tbbovinocompraraza, 
                b.tbbovinocompraestado, 
                b.tbbovinocompragenero, 
                f.tbfincanumplano AS nombre_finca, -- Número de plano de la finca
                b.tbbovinocomprafincaid, 
                b.tbbovinocompraproductorid, 
                b.tbbovinocompradetalle,
                b.tbbovinocompraactivo
            FROM tbbovinocompra b
                LEFT JOIN tbbovinocompra padre ON b.tbbovinocomprapadreid = padre.tbbovinocompraid  -- Relaciona el padre
                LEFT JOIN tbbovinocompra madre ON b.tbbovinocompramadreid = madre.tbbovinocompraid  -- Relaciona la madre
                LEFT JOIN tbfincaproductor fp ON b.tbbovinocomprafincaid = fp.tbfincaproductorfincaid -- Relaciona con el productor
                LEFT JOIN tbfinca f ON fp.tbfincaproductorfincaid = f.tbfincaid -- Relaciona con la finca
                WHERE b.tbbovinocompraproductorid = ? 
                AND b.tbbovinocompraactivo = ?
            ORDER BY b.tbbovinocompranumero ASC
            ");
            $sql->execute([$usuarioID, $estadoActivo]);
            // Obtener los resultados
            foreach ($sql->fetchAll() as $data) {
                $bovinoList[] = array(
                    "bovinonumero" => $data['tbbovinocompranumero'],
                    "bovinonombre" => $data['tbbovinocompranombre'],
                    "bovinopadre" => $data['nombre_padre'],
                    "bovinomadre" => $data['nombre_madre'],
                    "bovinofechanacimiento" => $data['tbbovinocomprafechanacimiento'],
                    "bovinofechacompra" => $data['tbbovinocomprafechacompra'],
                    "bovinoprecio" => $data['tbbovinocompraprecio'],
                    "bovinopeso" => $data['tbbovinocomprapeso'],
                    "bovinovendedor" => $data['tbbovinocompravendedor'],
                    "bovinoraza" => $data['tbbovinocompraraza'],
                    "bovinoestado" => $data['tbbovinocompraestado'],
                    "bovinogenero" => $data['tbbovinocompragenero'],
                    "bovinofinca" => $data['nombre_finca'],
                    "bovinoproductor" => $data['tbbovinocompraproductorid'],
                    "bovinodetalle" => $data['tbbovinocompradetalle'],
                    "bovinoactivo" => $data['tbbovinocompraactivo']
                );
            }
        }

        // Convertir los resultados a JSON
        $jsonString = json_encode($bovinoList);
        return $jsonString;
    }

    public function eliminarBovino($numero, $usuarioID)
    {
        $con = $this->conectar();
        $sql = $con->prepare("UPDATE tbbovinocompra SET tbbovinocompraactivo=? WHERE tbbovinocompranumero=? AND tbbovinocompraproductorid=?");
        return $sql->execute(array(0, $numero, $usuarioID));
    }

    public function verificarNumeroBovino($numero, $usuarioID)
    {
        $con = $this->conectar();
        $sql = $con->prepare("SELECT COUNT(*) AS total FROM tbbovinocompra WHERE tbbovinocompranumero=? AND tbbovinocompraproductorid=?");
        $sql->execute([$numero, $usuarioID]);
        $data = $sql->fetch();
        return $data['total'] > 0;
    }

    public static function consultarBovinoPorNumero($numero, $usuarioID)
    {
        $conexion = new bovinoCompraData();
        $con = $conexion->conectar();
        $bovinoList = array();

        if ($con) {

            $sql = $con->prepare("
                SELECT 
                    b.tbbovinocompranumero, 
                    b.tbbovinocompranombre, 
                    b.tbbovinocomprapadreid, 
                    b.tbbovinocompramadreid, 
                    b.tbbovinocomprafechanacimiento, 
                    b.tbbovinocomprafechacompra, 
                    b.tbbovinocompraprecio,
                    b.tbbovinocomprapeso,
                    b.tbbovinocompravendedor,
                    b.tbbovinocompraraza,
                    b.tbbovinocompraestado,
                    b.tbbovinocompragenero, 
                    b.tbbovinocomprafincaid, 
                    b.tbbovinocompraproductorid, 
                    b.tbbovinocompradetalle, 
                    b.tbbovinocompraactivo
                FROM tbbovinocompra b
                WHERE b.tbbovinocompranumero = ? AND b.tbbovinocompraproductorid = ?
            ");
            $sql->execute([$numero, $usuarioID]);

            $data = $sql->fetch();

            if ($data) {
                $bovinoList = array(
                    "bovinonumero" => $data['tbbovinocompranumero'],
                    "bovinonombre" => $data['tbbovinocompranombre'],
                    "bovinopadre" => $data['tbbovinocomprapadreid'],
                    "bovinomadre" => $data['tbbovinocompramadreid'],
                    "bovinofechanacimiento" => $data['tbbovinocomprafechanacimiento'],
                    "bovinofechacompra" => $data['tbbovinocomprafechacompra'],
                    "bovinoprecio" => $data['tbbovinocompraprecio'],
                    "bovinopeso" => $data['tbbovinocomprapeso'],
                    "bovinovendedor" => $data['tbbovinocompravendedor'],
                    "bovinoraza" => $data['tbbovinocompraraza'],
                    "bovinoestado" => $data['tbbovinocompraestado'],
                    "bovinogenero" => $data['tbbovinocompragenero'],
                    "bovinofinca" => $data['tbbovinocomprafincaid'],
                    "bovinoproductor" => $data['tbbovinocompraproductorid'],
                    "bovinodetalle" => $data['tbbovinocompradetalle'],
                    "bovinoactivo" => $data['tbbovinocompraactivo']
                );
            }
        }

        // Convertir el resultado a JSON
        $jsonString = json_encode($bovinoList);
        return $jsonString;
    }

    public static function actualizarBovino($bovino, $usuarioID)
    {
        $conexion = new bovinoCompraData();
        $con = $conexion->conectar();

        $sql = $con->prepare("
            UPDATE tbbovinocompra 
            SET 
                tbbovinocompranombre = ?, 
                tbbovinocomprapadreid = ?, 
                tbbovinocompramadreid = ?, 
                tbbovinocomprafechanacimiento = ?, 
                tbbovinocomprafechacompra = ?, 
                tbbovinocompraprecio = ?, 
                tbbovinocomprapeso = ?, 
                tbbovinocompravendedor = ?, 
                tbbovinocompraraza = ?, 
                tbbovinocompraestado = ?, 
                tbbovinocompragenero = ?,
                tbbovinocomprafincaid = ?,
                tbbovinocompradetalle = ?
            WHERE 
                tbbovinocompranumero = ? 
                AND tbbovinocompraproductorid = ?
        ");

        return $sql->execute(array(
            $bovino->getBovinoNombre(),
            $bovino->getBovinoPadre(),
            $bovino->getBovinoMadre(),
            $bovino->getBovinoFechaNacimiento(),
            $bovino->getBovinoFechaCompra(),
            $bovino->getBovinoPrecio(),
            $bovino->getBovinoPeso(),
            $bovino->getBovinoVendedor(),
            $bovino->getBovinoRaza(),
            $bovino->getBovinoEstado(),
            $bovino->getBovinoGenero(),
            $bovino->getBovinoFinca(),
            $bovino->getBovinoDetalle(),
            $bovino->getBovinoNumero(),
            $usuarioID
        ));
    }


    public function reactivarBovino($numero)
    {
        $con = $this->conectar();
        $sql = $con->prepare("
        UPDATE tbbovinocompra
        SET tbbovinocompraactivo = 1 
        WHERE  tbbovinocompranumero = ? ");
        return $sql->execute(array($numero));
    }

    public static function obtenerIdPorNumero($numero, $usuarioID)
    {
        $conexion = new bovinoCompraData();
        $con = $conexion->conectar();

        if ($con) {
            $sql = $con->prepare("SELECT tbbovinocompraid FROM tbbovinocompra WHERE tbbovinocompranumero = ? AND tbbovinocompraproductorid = ?");
            $sql->execute([$numero, $usuarioID]);
            $data = $sql->fetch();

            if ($data) {
                return $data['tbbovinocompraid']; // Retorna el ID del bovino encontrado
            }
        }

        return null; // Retorna null si no se encuentra el bovino
    }

    public function consultarBovinoPorGenero($genero, $usuarioID)
    {
        // manejoActual == 1 -> Activos, manejoActual == 0 -> Inactivos
        $bovinoList = array();
        $con = $this->conectar();

        if ($con) {
            $tipoGenero = ($genero == 1) ? 'Toro' : 'Vaca';
            $sql = $con->prepare("
            SELECT 
                b.tbbovinocompraid,
                b.tbbovinocompranumero, 
                b.tbbovinocompranombre
            FROM tbbovinocompra b
            WHERE b.tbbovinocompragenero = ? AND b.tbbovinocompraproductorid = ?
            ");
            $sql->execute([$tipoGenero, $usuarioID]);
            // Obtener los resultados
            foreach ($sql->fetchAll() as $data) {
                $bovinoList[] = array(
                    "bovinoid" => $data['tbbovinocompraid'],
                    "bovinonumero" => $data['tbbovinocompranumero'],
                    "bovinonombre" => $data['tbbovinocompranombre'],
                );
            }
        }
        // Convertir los resultados a JSON
        $jsonString = json_encode($bovinoList);
        return $jsonString;
    }
}
