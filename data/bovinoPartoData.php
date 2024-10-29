<?php

include_once "../domain/bovino.php";
include_once "../data/database.php";
include_once "../data/razaProductorData.php";
include_once "../data/estadoProductorData.php";

class bovinoPartoData extends DataBase
{
    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarBovino($bovino)
    {
        $con = $this->conectar();
        // Obtener el siguiente ID disponible para el bovino
        $tempsql = $con->prepare("SELECT MAX(tbbovinopartoid) AS tbbovinopartoid FROM tbbovinoparto");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbbovinoparto (
            tbbovinopartoid,
            tbbovinopartonumero, 
            tbbovinopartonombre, 
            tbbovinopartopadreid, 
            tbbovinopartomadreid, 
            tbbovinopartofechanacimiento, 
            tbbovinopartopeso,
            tbbovinopartoraza,
            tbbovinopartoestado, 
            tbbovinopartogenero, 
            tbbovinopartofincaid,
            tbbovinopartoproductorid, 
            tbbovinopartodetalle,
            tbbovinopartoactivo
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        // Insertar los datos del bovino
        return $sql->execute(array(
            $tempid['tbbovinopartoid'] + 1,
            $bovino->getBovinoNumero(),
            $bovino->getBovinoNombre(),
            $bovino->getBovinoPadre(),
            $bovino->getBovinoMadre(),
            $bovino->getBovinoFechaNacimiento(),
            $bovino->getBovinoPeso(),
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

            // Preparar la consulta con el valor de tbbovinopartoactivo como parámetro
            $sql = $con->prepare("
            SELECT DISTINCT
                b.tbbovinopartonumero, 
                b.tbbovinopartonombre, 
                padre.tbbovinocompranombre AS nombre_padre,  -- Uniendo con el nombre del padre
                madre.tbbovinocompranombre AS nombre_madre,  -- Uniendo con el nombre de la madre
                b.tbbovinopartofechanacimiento, 
                b.tbbovinopartopeso,
                b.tbbovinopartoraza, 
                b.tbbovinopartoestado, 
                b.tbbovinopartogenero, 
                f.tbfincanumplano AS nombre_finca, -- Número de plano de la finca
                b.tbbovinopartofincaid, 
                b.tbbovinopartoproductorid, 
                b.tbbovinopartodetalle,
                b.tbbovinopartoactivo
            FROM tbbovinoparto b
                LEFT JOIN tbbovinocompra padre ON b.tbbovinopartopadreid = padre.tbbovinocompraid  -- Relaciona el padre
                LEFT JOIN tbbovinocompra madre ON b.tbbovinopartomadreid = madre.tbbovinocompraid  -- Relaciona la madre
                LEFT JOIN tbfincaproductor fp ON b.tbbovinopartofincaid = fp.tbfincaproductorfincaid -- Relaciona con el productor
                LEFT JOIN tbfinca f ON fp.tbfincaproductorfincaid = f.tbfincaid -- Relaciona con la finca
                WHERE b.tbbovinopartoproductorid = ? 
                AND b.tbbovinopartoactivo = ?
            ORDER BY b.tbbovinopartonumero ASC
            ");
            $sql->execute([$usuarioID, $estadoActivo]);
            // Obtener los resultados
            foreach ($sql->fetchAll() as $data) {
                $bovinoList[] = array(
                    "bovinonumero" => $data['tbbovinopartonumero'],
                    "bovinonombre" => $data['tbbovinopartonombre'],
                    "bovinopadre" => $data['nombre_padre'],
                    "bovinomadre" => $data['nombre_madre'],
                    "bovinofechanacimiento" => $data['tbbovinopartofechanacimiento'],
                    "bovinopeso" => $data['tbbovinopartopeso'],
                    "bovinoraza" => $data['tbbovinopartoraza'],
                    "bovinoestado" => $data['tbbovinopartoestado'],
                    "bovinogenero" => $data['tbbovinopartogenero'],
                    "bovinofinca" => $data['nombre_finca'],
                    "bovinoproductor" => $data['tbbovinopartoproductorid'],
                    "bovinodetalle" => $data['tbbovinopartodetalle'],
                    "bovinoactivo" => $data['tbbovinopartoactivo']
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
        $sql = $con->prepare("UPDATE tbbovinoparto SET tbbovinopartoactivo=? WHERE tbbovinopartonumero=? AND tbbovinopartoproductorid=?");
        return $sql->execute(array(0, $numero, $usuarioID));
    }

    public function verificarNumeroBovino($numero, $usuarioID)
    {
        $con = $this->conectar();
        $sql = $con->prepare("SELECT COUNT(*) AS total FROM tbbovinoparto WHERE tbbovinopartonumero=? AND tbbovinopartoproductorid=?");
        $sql->execute([$numero, $usuarioID]);
        $data = $sql->fetch();
        return $data['total'] > 0;
    }

    public static function consultarBovinoPorNumero($numero, $usuarioID)
    {
        $conexion = new bovinoPartoData();
        $con = $conexion->conectar();
        $bovinoList = array();

        if ($con) {

            $sql = $con->prepare("
                SELECT 
                    b.tbbovinopartonumero, 
                    b.tbbovinopartonombre, 
                    b.tbbovinopartopadreid, 
                    b.tbbovinopartomadreid, 
                    b.tbbovinopartofechanacimiento, 
                    b.tbbovinopartopeso,
                    b.tbbovinopartoraza,
                    b.tbbovinopartoestado,
                    b.tbbovinopartogenero, 
                    b.tbbovinopartofincaid, 
                    b.tbbovinopartoproductorid, 
                    b.tbbovinopartodetalle, 
                    b.tbbovinopartoactivo
                FROM tbbovinoparto b
                WHERE b.tbbovinopartonumero = ? AND b.tbbovinopartoproductorid = ?
            ");
            $sql->execute([$numero, $usuarioID]);

            $data = $sql->fetch();

            if ($data) {
                $bovinoList = array(
                    "bovinonumero" => $data['tbbovinopartonumero'],
                    "bovinonombre" => $data['tbbovinopartonombre'],
                    "bovinopadre" => $data['tbbovinopartopadreid'],
                    "bovinomadre" => $data['tbbovinopartomadreid'],
                    "bovinofechanacimiento" => $data['tbbovinopartofechanacimiento'],
                    "bovinopeso" => $data['tbbovinopartopeso'],
                    "bovinoraza" => $data['tbbovinopartoraza'],
                    "bovinoestado" => $data['tbbovinopartoestado'],
                    "bovinogenero" => $data['tbbovinopartogenero'],
                    "bovinofinca" => $data['tbbovinopartofincaid'],
                    "bovinoproductor" => $data['tbbovinopartoproductorid'],
                    "bovinodetalle" => $data['tbbovinopartodetalle'],
                    "bovinoactivo" => $data['tbbovinopartoactivo']
                );
            }
        }

        // Convertir el resultado a JSON
        $jsonString = json_encode($bovinoList);
        return $jsonString;
    }

    public static function actualizarBovino($bovino, $usuarioID)
    {
        $conexion = new bovinoPartoData();
        $con = $conexion->conectar();

        $sql = $con->prepare("
            UPDATE tbbovinoparto 
            SET 
                tbbovinopartonombre = ?, 
                tbbovinopartopadreid = ?, 
                tbbovinopartomadreid = ?, 
                tbbovinopartofechanacimiento = ?, 
                tbbovinopartopeso = ?, 
                tbbovinopartoraza = ?, 
                tbbovinopartoestado = ?, 
                tbbovinopartogenero = ?,
                tbbovinopartofincaid = ?,
                tbbovinopartodetalle = ?
            WHERE 
                tbbovinopartonumero = ? 
                AND tbbovinopartoproductorid = ?
        ");

        return $sql->execute(array(
            $bovino->getBovinoNombre(),
            $bovino->getBovinoPadre(),
            $bovino->getBovinoMadre(),
            $bovino->getBovinoFechaNacimiento(),
            $bovino->getBovinoPeso(),
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
        UPDATE tbbovinoparto
        SET tbbovinopartoactivo = 1 
        WHERE  tbbovinopartonumero = ? ");
        return $sql->execute(array($numero));
    }

    public static function obtenerIdPorNumero($numero, $usuarioID)
    {
        $conexion = new bovinoPartoData();
        $con = $conexion->conectar();

        if ($con) {
            $sql = $con->prepare("SELECT tbbovinopartoid FROM tbbovinoparto WHERE tbbovinopartonumero = ? AND tbbovinopartoproductorid = ?");
            $sql->execute([$numero, $usuarioID]);
            $data = $sql->fetch();

            if ($data) {
                return $data['tbbovinopartoid']; // Retorna el ID del bovino encontrado
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
