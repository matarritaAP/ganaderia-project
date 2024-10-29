<?php

include_once "../domain/proveedor.php";
include_once "../data/database.php";

class proveedorData extends DataBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertarProveedor($proveedor, $tbproductorid)
    {
        $con = $this->conectar();

        $nombrecomercial = $proveedor->getNombrecomercial();
        $propietario = $proveedor->getPropietario();
        $telefonowhatsapp = $proveedor->getTelefonowhatsapp();
        $correo = $proveedor->getCorreo();
        $sinpe = $proveedor->getSinpe();
        $telefonofijo = $proveedor->getTelefonofijo();

        $tempsql = $con->prepare("SELECT MAX(tbproveedorid) AS tbproveedorid FROM tbproveedor");
        $tempsql->execute();
        $tempid = $tempsql->fetch();

        $sql = $con->prepare("INSERT INTO tbproveedor(tbproveedorid, tbproveedornombrecomercial, tbproveedorpropietario, tbproveedortelefonowhatsapp, tbproveedorcorreo, tbproveedorsinpe, tbproveedortelefonofijo, tbproveedorestado, tbproveedorproductorid) VALUES (?,?,?,?,?,?,?,?,?)");
        return $sql->execute(array(
            $tempid[0] + 1,
            $nombrecomercial,
            $propietario ?: null,
            $telefonowhatsapp ?: null,
            $correo,
            $sinpe,
            $telefonofijo ?: null,
            1,
            $tbproductorid
        ));
    }


    public function consultarProveedor($tbproductorid, $estado)
    {
        $ProveedorList = array();
        $con = $this->conectar();

        if ($con) {
            $sql = $con->prepare("SELECT * FROM tbproveedor WHERE tbproveedorestado = ? AND tbproveedorproductorid = ?");
            $sql->execute(array($estado, $tbproductorid));

            foreach ($sql->fetchAll() as $data) {
                $ProveedorList[] = array(
                    "tbproveedornombrecomercial" => $data['tbproveedornombrecomercial'],
                    "tbproveedorpropietario" => $data['tbproveedorpropietario'],
                    "tbproveedortelefonowhatsapp" => $data['tbproveedortelefonowhatsapp'],
                    "tbproveedorcorreo" => $data['tbproveedorcorreo'],
                    "tbproveedorsinpe" => $data['tbproveedorsinpe'],
                    "tbproveedortelefonofijo" => $data['tbproveedortelefonofijo']
                );
            }
        }

        $jsonString = json_encode($ProveedorList);
        return $jsonString;
    }

    public function eliminarProveedor($correo, $tbproductorid)
    {
        $con = $this->conectar();

        // Depuración de los parámetros recibidos
        //var_dump($correo, $tbproductorid); // Verifica que los valores sean los correctos

        // Comprobar si el proveedor existe con el correo y productor ID
        $sql = $con->prepare("SELECT tbproveedorid FROM tbproveedor WHERE tbproveedorcorreo = ? AND tbproveedorproductorid = ?");
        $sql->execute(array($correo, $tbproductorid));
        $result = $sql->fetch();

        // Verificar si se encontró el proveedor
        if ($result) {
            error_log("Proveedor encontrado, ID: " . $result['tbproveedorid']);
            $id = $result['tbproveedorid'];

            // Realizar la eliminación lógica (cambiar estado a 0)
            $update = $con->prepare("UPDATE tbproveedor SET tbproveedorestado=? WHERE tbproveedorid=?");
            if ($update->execute(array(0, $id))) {
                error_log("Proveedor eliminado correctamente, ID: $id");
                return true;
            } else {
                error_log("Error al eliminar proveedor, ID: $id");
                return false;
            }
        } else {
            error_log("Proveedor no encontrado para el correo: $correo y productor ID: $tbproductorid");
            // No se encontró el proveedor, devuelve false
            return false;
        }
    }

    // public function eliminarProveedor($correo, $tbproductorid)
    // {
    //     $con = $this->conectar();

    //     $sql = $con->prepare("SELECT tbproveedorid FROM tbproveedor WHERE tbproveedorcorreo = ? AND tbproveedorproductorid = ?");
    //     $sql->execute(array($correo, $tbproductorid));
    //     $result = $sql->fetch();

    //     if ($result) {
    //         $id = $result['tbproveedorid'];

    //         $update = $con->prepare("UPDATE tbproveedor SET tbproveedorestado=? WHERE tbproveedorid=?");
    //         return $update->execute(array(0, $id));
    //     } else {
    //         return false;
    //     }
    // }

    public static function consultarProveedorPorCorreo($correo, $tbproductorid)
    {
        $conexion = new proveedorData();
        $con = $conexion->conectar();
        $proveedorLista = array();

        $sql = $con->prepare("SELECT * FROM tbproveedor WHERE tbproveedorcorreo=? AND tbproveedorproductorid=? AND tbproveedorestado=1");
        $sql->execute(array($correo, $tbproductorid));

        foreach ($sql->fetchAll() as $data) {
            $proveedorLista[] = array(
                'id' => $data['tbproveedorid'],
                'nombrecomercial' => $data['tbproveedornombrecomercial'],
                'propietario' => $data['tbproveedorpropietario'],
                'telefonowhatsapp' => $data['tbproveedortelefonowhatsapp'],
                'correo' => $data['tbproveedorcorreo'],
                'sinpe' => $data['tbproveedorsinpe'],
                'telefonofijo' => $data['tbproveedortelefonofijo'],
            );
        }

        $jsonString = json_encode($proveedorLista);
        return $jsonString;
    }

    public static function actualizarProveedor($proveedor, $correoAnterior, $tbproductorid)
    {
        $conexion = new proveedorData();
        $con = $conexion->conectar();

        $sql = $con->prepare("UPDATE tbproveedor SET tbproveedornombrecomercial=?, tbproveedorpropietario=?, tbproveedortelefonowhatsapp=?, tbproveedorcorreo=? ,tbproveedorsinpe=?, tbproveedortelefonofijo=? WHERE tbproveedorcorreo=? AND tbproveedorproductorid=?");
        return $sql->execute(array(
            $proveedor->getNombrecomercial(),
            $proveedor->getPropietario() ?: null,
            $proveedor->getTelefonowhatsapp() ?: null,
            $proveedor->getCorreo(),
            $proveedor->getSinpe(),
            $proveedor->getTelefonofijo() ?: null,
            $correoAnterior,
            $tbproductorid
        ));
    }

    public static function ValidarCorreo($correo, $tbproductorid)
    {
        $conexion = new proveedorData();
        $con = $conexion->conectar();

        $sql = $con->prepare("SELECT IF(EXISTS (SELECT 1 FROM tbproveedor WHERE tbproveedorcorreo = ? AND tbproveedorproductorid = ?), 1, 0) AS resultado");
        $sql->execute(array($correo, $tbproductorid));
        return $sql->fetchColumn();
    }

    public function reactivarProveedor($email, $tbproductorid)
    {
        $con = $this->conectar();
        $sql = $con->prepare("
            UPDATE tbproveedor
            SET tbproveedorestado = 1 
            WHERE tbproveedorcorreo = ? 
            AND tbproveedorproductorid = ?");
        return $sql->execute(array($email, $tbproductorid));
    }

    public static function ValidarNombresComercialesSimilares($nombre, $tbproductorid)
    {
        $conexion = new proveedorData();
        $con = $conexion->conectar();

        $sql = $con->prepare("SELECT tbproveedornombrecomercial FROM tbproveedor WHERE tbproveedorestado = 1 AND tbproveedorproductorid = ?");
        $sql->execute(array($tbproductorid));
        $nombresComerciales = $sql->fetchAll(PDO::FETCH_COLUMN);

        $nombresSimilares = [];
        foreach ($nombresComerciales as $nombreComercial) {
            $distancia = levenshtein(strtolower($nombre), strtolower($nombreComercial));
            if ($distancia <= 2) {
                $nombresSimilares[] = $nombreComercial;
            }
        }

        return json_encode($nombresSimilares);
    }
}
