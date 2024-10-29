<?php
include_once "../domain/finca.php";
include_once "../data/database.php";

class fincaData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarFinca($finca)
    {
        $con = $this->conectar();

        //$codigo= $finca->getFincaCodigo();
        $numPlano = $finca->getFincaNumPlano();
        $coordenada = $finca->getFincaCoordenada();
        $latitud = $finca->getFincaLatitud();
        $longitud = $finca->getFincaLongitud();
        $areaTotal = $finca->getFincaAreaTotal();
        $areaPastoreo = $finca->getFincaAreaPastoreo();
        $areaConstruccion = $finca->getFincaAreaConstruccion();
        $areaForestal = $finca->getFincaAreaForestal();
        $areaCamino = $finca->getFincaAreaCamino();
        $areaOtraCriterio = json_encode($finca->getFincaAreaOtraCriterio());

        $tempsql = $con->prepare("SELECT MAX(tbfincaid) AS tbfincaid FROM tbfinca");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $sql = $con->prepare("INSERT INTO tbfinca(
            tbfincaid,tbfincanumplano,
            tbfincacoordenada, tbfincalatitud, 
            tbfincalongitud, tbfincaareatotal,
            tbfincaareapastoreo, tbfincaareaconstruccion, 
            tbfincaareaforestal, tbfincaareacamino,
            tbfincaareaotracriterio, tbfincaestado) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            //$codigo,
            $numPlano,
            $coordenada,
            $latitud,
            $longitud,
            $areaTotal,
            $areaPastoreo,
            $areaConstruccion,
            $areaForestal,
            $areaCamino,
            $areaOtraCriterio,
            1
        ));
    }

    public function consultarFinca($productor)
    {
        $fincaLista = array();
        $con = $this->conectar();
        if ($con) {
            $sql = $con->prepare("
            SELECT DISTINCT tbfinca.*
            FROM tbfinca
            INNER JOIN tbfincaproductor ON tbfinca.tbfincaid = tbfincaproductor.tbfincaproductorfincaid
            WHERE tbfinca.tbfincaestado = 1
            AND tbfincaproductor.tbfincaproductorproductorid = :productor
        ");

            $sql->bindParam(':productor', $productor, PDO::PARAM_INT);
            $sql->execute();

            foreach ($sql->fetchAll() as $data) {
                $fincaLista[] = array(
                    //"tbfincacodigo"=> $data['tbfincacodigo'],
                    "tbfincaid" => $data['tbfincaid'],
                    "tbfincanumplano" => $data['tbfincanumplano'],
                    "tbfincacoordenada" => $data['tbfincacoordenada'],
                    "tbfincalatitud" => $data['tbfincalatitud'],
                    "tbfincalongitud" => $data['tbfincalongitud'],
                    "tbfincaareatotal" => $data['tbfincaareatotal'],
                    "tbfincaareapastoreo" => $data['tbfincaareapastoreo'],
                    "tbfincaareaconstruccion" => $data['tbfincaareaconstruccion'],
                    "tbfincaareaforestal" => $data['tbfincaareaforestal'],
                    "tbfincaareacamino" => $data['tbfincaareacamino'],
                    "tbfincaareaotracriterio" => json_decode($data['tbfincaareaotracriterio'], true)
                );
            }
        }
        $jsonString = json_encode($fincaLista);
        return $jsonString;
    }

    public function eliminarFinca($numPlano)
    {
        $con = $this->conectar();

        $sql = $con->prepare("UPDATE tbfinca SET tbfincaestado=? WHERE tbfincanumplano=?");
        return $sql->execute(array(0, $numPlano));
    }

    public static function consultarCodigoFinca($numPlano)
    {
        $conexion = new fincaData;
        $con = $conexion->conectar();

        $sql = $con->prepare("SELECT * FROM tbfinca WHERE tbfincanumplano=?");
        $sql->execute(array($numPlano));
        $data = $sql->fetch();

        if ($data) {
            $finca = array(
                //'codigo'=>$data['tbfincacodigo'],
                'numPlano' => $data['tbfincanumplano'],
                'coordenada' => $data['tbfincacoordenada'],
                'latitud' => $data['tbfincalatitud'],
                'longitud' => $data['tbfincalongitud'],
                'areaTotal' => $data['tbfincaareatotal'],
                'areaPastoreo' => $data['tbfincaareapastoreo'],
                'areaConstruccion' => $data['tbfincaareaconstruccion'],
                'areaForestal' => $data['tbfincaareaforestal'],
                'areaCamino' => $data['tbfincaareacamino'],
                'areaOtraCriterio' => json_decode($data['tbfincaareaotracriterio'], true),
            );
            return json_encode($finca);
        } else {
            error_log("No se encontró el registro con numPlano: " . $numPlano);
            return json_encode([]);
        }
    }

    public static function actualizarFinca($finca)
    {
        $tbfincaareaotracriterio = json_encode($finca->getFincaAreaOtraCriterio());
        $conexion = new fincaData;
        $con = $conexion->conectar();
        $sql = $con->prepare("UPDATE tbfinca SET
             
             tbfincacoordenada=?,
             tbfincalatitud=?, 
             tbfincalongitud=?, 
             tbfincaareatotal=?,
             tbfincaareapastoreo=?,
             tbfincaareaconstruccion=?,
             tbfincaareaforestal=?,
             tbfincaareacamino=?,
             tbfincaareaotracriterio=? 
             WHERE tbfincanumplano=?"); //tbfincanumplano=?,

        return $sql->execute(array(

            $finca->getFincaCoordenada(),
            $finca->getFincaLatitud(),
            $finca->getFincaLongitud(),
            $finca->getFincaAreaTotal(),
            $finca->getFincaAreaPastoreo(),
            $finca->getFincaAreaConstruccion(),
            $finca->getFincaAreaForestal(),
            $finca->getFincaAreaCamino(),
            $tbfincaareaotracriterio,
            $finca->getFincaNumPlano()
        ));
    }

    public static function validarCodigo($numPlano)
    {
        $conexion = new fincaData;
        $con = $conexion->conectar();
        $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbfinca WHERE tbfincanumplano= ?),1,0) AS resultado");
        $sql->execute(array($numPlano));
        return $sql->fetchColumn();
    }

    public static function validarFincaParecidos($numPlano)
    {
        $conexion = new fincaData;
        $con = $conexion->conectar();
        $sql = $con->prepare("SELECT tbfincanumPlano FROM tbfinca WHERE tbfincaestado = 1");
        $sql->execute();

        $fincas = $sql->fetchAll(PDO::FETCH_COLUMN); // Obtener toda la columna de tbservicionombre

        $fincasSimilares = [];
        foreach ($fincas as $fincaNumPlano) {
            $distancia = levenshtein(strtolower($numPlano), strtolower($fincaNumPlano));
            if ($distancia <= 2) {
                $fincasSimilares[] = $fincaNumPlano;
            }
        }
        return json_encode($fincasSimilares);
    }

    public function obtenerFincaPorPlano($numPlano)
    {
        $con = $this->conectar();
        $sql = $con->prepare("SELECT tbfincaid FROM tbfinca WHERE tbfincanumPlano = ?");
        $sql->execute(array($numPlano));
        return $sql->fetchColumn();
    }
}
