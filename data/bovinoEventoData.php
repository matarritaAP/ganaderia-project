<?php

include_once "../domain/bovinoEvento.php";
include_once "../data/database.php";
//los que falten

class bovinoEventoData extends DataBase
{

    public function __construct()
    {
        parent::__construct(); // Llamada al constructor de la clase padre
    }

    public function insertarEvento($bovinoEvento)
    {
        $con = $this->conectar();

        // Obtener el siguiente ID para `tbbovinoeventoid`
        $tempsql = $con->prepare("SELECT MAX(tbbovinoeventoid) AS tbbovinoeventoid FROM tbbovinoevento");
        $tempsql->execute();
        $tempid = $tempsql->fetch();
        $nuevoId = $tempid['tbbovinoeventoid'] + 1;

        // Prepara la consulta `INSERT`
        $sql = $con->prepare("INSERT INTO tbbovinoevento (
                tbbovinoeventoid,
                tbbovinoid,
                tbbovinoeventotipo,
                tbbovinoeventofecha,
                tbbovinoeventodescripcion,
                tbbovinoeventoproductorid,
                tbbovinoeventoactivo
            ) VALUES (?,?,?,?,?,?,?)");

        // Ejecuta la consulta con los valores
        $resultado = $sql->execute(array(
            $nuevoId,
            $bovinoEvento->getBovino(),
            $bovinoEvento->getTipoEvento(),
            $bovinoEvento->getFecha(),
            $bovinoEvento->getDescripcion(),
            $bovinoEvento->getProductor(),
            1 // Valor por defecto para `activo` (puedes ajustarlo según tu lógica)
        ));

        if ($resultado) {

            // Cambiar el estado del bovino a 0 en la tabla de compra o parto
            $this->actualizarEstadoBovino($bovinoEvento->getBovino(), 0);
        }

        return $resultado;
    }

    public function consultarEvento($usuarioID, $manejoActual)
    {
        $eventoList = array();
        $con = $this->conectar();

        if ($con) {
            $estadoActivo = ($manejoActual == 1) ? 1 : 0;

            // Preparar la consulta para obtener los eventos y el nombre del bovino
            $sql = $con->prepare("
                SELECT 
                    e.tbbovinoeventoid, 
                    e.tbbovinoid, 
                    e.tbbovinoeventotipo, 
                    e.tbbovinoeventofecha, 
                    e.tbbovinoeventodescripcion, 
                    e.tbbovinoeventoproductorid, 
                    e.tbbovinoeventoactivo, 
                    COALESCE(bcompra.tbbovinocompranombre, bparto.tbbovinopartonombre) AS nombre_bovino 
                FROM 
                    tbbovinoevento e
                LEFT JOIN 
                    tbbovinocompra bcompra ON e.tbbovinoid = bcompra.tbbovinocompraid 
                LEFT JOIN 
                    tbbovinoparto bparto ON e.tbbovinoid = bparto.tbbovinopartoid 
                WHERE 
                    e.tbbovinoeventoproductorid = ? 
                    AND e.tbbovinoeventoactivo = ? 
                ORDER BY 
                    e.tbbovinoeventofecha ASC
            ");

            // Ejecutar la consulta con los parámetros
            $sql->execute([$usuarioID, $estadoActivo]);

            // Obtener los resultados
            foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $data) {
                $eventoList[] = array(
                    "eventoid" => $data['tbbovinoeventoid'],
                    "bovinoid" => $data['tbbovinoid'],
                    "bovinonombre" => $data['nombre_bovino'],  // Nombre del bovino
                    "eventotipo" => $data['tbbovinoeventotipo'],
                    "eventofecha" => $data['tbbovinoeventofecha'],
                    "eventodescripcion" => $data['tbbovinoeventodescripcion'],
                    "eventoproductor" => $data['tbbovinoeventoproductorid'],
                    "eventoactivo" => $data['tbbovinoeventoactivo']
                );
            }
        }

        // Convertir los resultados a JSON
        return json_encode($eventoList);
    }


    // public function consultarEvento($usuarioID, $manejoActual)
    // {
    //     $eventoList = array();
    //     $con = $this->conectar();

    //     if ($con) {
    //         $estadoActivo = ($manejoActual == 1) ? 1 : 0;

    //         // Preparar la consulta para obtener los eventos y el nombre del bovino
    //         $sql = $con->prepare("
    //         SELECT 
    //             e.tbbovinoeventoid, 
    //             e.tbbovinoid, 
    //             e.tbbovinoeventotipo, 
    //             e.tbbovinoeventofecha, 
    //             e.tbbovinoeventodescripcion, 
    //             e.tbbovinoeventoproductorid, 
    //             e.tbbovinoeventoactivo, 
    //             COALESCE(bcompra.tbbovinocompranombre, bparto.tbbovinopartonombre) AS nombre_bovino 
    //         FROM 
    //             tbbovinoevento e
    //         LEFT JOIN 
    //             tbbovinocompra bcompra ON e.tbbovinoid = bcompra.tbbovinocompraid 
    //         LEFT JOIN 
    //             tbbovinoparto bparto ON e.tbbovinoid = bparto.tbbovinopartoid 
    //         WHERE 
    //             e.tbbovinoeventoproductorid = ? 
    //             AND e.tbbovinoeventoactivo = ? 
    //         ORDER BY 
    //             e.tbbovinoeventofecha ASC
    //     ");

    //         // Ejecutar la consulta con los parámetros
    //         $sql->execute([$usuarioID, $estadoActivo]);

    //         // Obtener los resultados
    //         foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $data) {
    //             $eventoList[] = array(
    //                 "eventoid" => $data['tbbovinoeventoid'],
    //                 "bovinoid" => $data['tbbovinoid'],
    //                 "bovinonombre" => $data['nombre_bovino'],  // Nombre del bovino
    //                 "eventotipo" => $data['tbbovinoeventotipo'],
    //                 "eventofecha" => $data['tbbovinoeventofecha'],
    //                 "eventodescripcion" => $data['tbbovinoeventodescripcion'],
    //                 "eventoproductor" => $data['tbbovinoeventoproductorid'],
    //                 "eventoactivo" => $data['tbbovinoeventoactivo']
    //             );
    //         }
    //     }

    //     // Convertir los resultados a JSON
    //     return json_encode($eventoList);
    // }

    //id del bovino
    // public function eliminarEvento($bovino, $usuarioID)
    // {
    //     $con = $this->conectar(); // Conexión a la base de datos

    //     if ($con) {
    //         // Preparar la consulta para hacer un borrado lógico
    //         $sql = $con->prepare("UPDATE tbbovinoevento SET tbbovinoeventoactivo = ? WHERE tbbovinoid = ? AND tbbovinoeventoproductorid = ?");

    //         // Ejecutar la consulta con los parámetros
    //         if ($sql->execute([0, $bovino, $usuarioID])) {
    //             return json_encode(array("success" => true, "message" => "Evento eliminado correctamente."));
    //         } else {
    //             return json_encode(array("success" => false, "message" => "No se pudo actualizar el estado del evento."));
    //         }
    //     } else {
    //         return json_encode(array("success" => false, "message" => "No se pudo conectar a la base de datos."));
    //     }
    // }

    public function eliminarEvento($eventoid, $usuarioID)
    {
        $con = $this->conectar(); // Conexión a la base de datos

        if ($con) {
            // Preparar la consulta para hacer un borrado lógico del evento
            $sql = $con->prepare("UPDATE tbbovinoevento SET tbbovinoeventoactivo = ? WHERE tbbovinoeventoid = ? AND tbbovinoeventoproductorid = ?");

            if ($sql->execute([0, $eventoid, $usuarioID])) {
                // Ahora necesitamos obtener el `bovinoid` para poder cambiar su estado a 1 (activo)
                $sqlSelect = $con->prepare("SELECT tbbovinoid FROM tbbovinoevento WHERE tbbovinoeventoid = ?");
                $sqlSelect->execute([$eventoid]);
                $bovino = $sqlSelect->fetch();

                if ($bovino) {
                    // Cambiar el estado del bovino a activo (1)
                    $this->actualizarEstadoBovino($bovino['tbbovinoid'], 1);
                }

                return array("success" => true, "message" => "Evento eliminado correctamente.");
            } else {
                return array("success" => false, "message" => "No se pudo actualizar el estado del evento.");
            }
        } else {
            return array("success" => false, "message" => "No se pudo conectar a la base de datos.");
        }
    }


    public function obtenerBovinosPorProductor($usuarioID)
    {
        $bovinoList = array();
        $con = $this->conectar();

        if ($con) {
            // Consulta para obtener los bovinos asociados al productor de ambas tablas (compra y parto)
            $sql = $con->prepare(""
                . "SELECT tbbovinocompraid AS id_bovino, "
                . "tbbovinocompranumero AS numero_bovino, "
                . "tbbovinocompranombre AS nombre_bovino "
                . "FROM tbbovinocompra "
                . "WHERE tbbovinocompraproductorid = ? "
                . "AND tbbovinocompraactivo = 1 "
                . "UNION "
                . "SELECT tbbovinopartoid AS id_bovino, NULL AS numero_bovino, tbbovinopartonombre AS nombre_bovino "
                . "FROM tbbovinoparto "
                . "WHERE tbbovinopartoproductorid = ? "
                . "AND tbbovinopartoactivo = 1");


            // Ejecutar la consulta
            $sql->execute([$usuarioID, $usuarioID]);

            // Obtener los resultados
            foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $data) {
                $bovinoList[] = array(
                    "bovinoid" => $data['id_bovino'],
                    "bovinonumero" => $data['numero_bovino'],
                    "bovinonombre" => $data['nombre_bovino']
                );
            }
        }

        return json_encode($bovinoList);
    }

    public function actualizarEvento($bovinoEvento, $eventoid, $usuarioID)
    {
        $con = $this->conectar();

        if ($con) {
            // Obtener el valor del bovino anterior:
            $sqlSelect = $con->prepare("SELECT tbbovinoid FROM tbbovinoevento 
                                    WHERE tbbovinoeventoid = ? 
                                    AND tbbovinoeventoproductorid = ?");
            $sqlSelect->execute(array($eventoid, $usuarioID));
            $resultado = $sqlSelect->fetch();

            // Guardar el valor en la variable $bovinoAnterior
            $bovinoAnterior = $resultado['tbbovinoid'];

            //-----------------------------------------------------
            // Verificar si se cambió el bovino y actualizar el estado del bovino anterior a 1
            if ($bovinoEvento->getBovino() != $bovinoAnterior) {
                $this->actualizarEstadoBovino($bovinoAnterior, 1);
            }

            // Preparar la consulta para actualizar el evento
            $sql = $con->prepare("UPDATE tbbovinoevento SET 
            tbbovinoid = ?,
            tbbovinoeventotipo = ?,
            tbbovinoeventofecha = ?,
            tbbovinoeventodescripcion = ?,
            tbbovinoeventoactivo = ?
            WHERE tbbovinoeventoid = ?
            AND tbbovinoeventoproductorid = ?");

            // Ejecutar la consulta con los valores
            $resultado = $sql->execute(array(
                $bovinoEvento->getBovino(),
                $bovinoEvento->getTipoEvento(),
                $bovinoEvento->getFecha(),
                $bovinoEvento->getDescripcion(),
                $bovinoEvento->getActivo(),
                $eventoid,  // Aquí se usa el `eventoid` para identificar qué evento actualizar
                $usuarioID
            ));

            if ($resultado) {
                // Cambiar el estado del nuevo bovino a 0
                $this->actualizarEstadoBovino($bovinoEvento->getBovino(), 0);
            }

            return $resultado;
        } else {
            return json_encode(array("success" => false, "message" => "No se pudo conectar a la base de datos."));
        }
    }


    public function consultarEventoPorBovinoId($bovinoid)
    {
        $con = $this->conectar();
        if ($con) {
            // Consulta el evento basado en el bovinoid proporcionado
            $sql = $con->prepare("SELECT * FROM tbbovinoevento WHERE tbbovinoid = ? AND tbbovinoeventoactivo = 1");
            $sql->execute([$bovinoid]);

            $evento = $sql->fetch(PDO::FETCH_ASSOC);
            return json_encode($evento);
        } else {
            return json_encode(array("success" => false, "message" => "No se pudo conectar a la base de datos."));
        }
    }


    private function actualizarEstadoBovino($bovinoId, $estado)
    {
        $con = $this->conectar();

        // Actualiza el estado del bovino en ambas tablas (compra y parto)
        $updateCompra = $con->prepare("UPDATE tbbovinocompra SET tbbovinocompraactivo = ? WHERE tbbovinocompraid = ?");
        $updateCompra->execute([$estado, $bovinoId]);

        $updateParto = $con->prepare("UPDATE tbbovinoparto SET tbbovinopartoactivo = ? WHERE tbbovinopartoid = ?");
        $updateParto->execute([$estado, $bovinoId]);
    }
}
