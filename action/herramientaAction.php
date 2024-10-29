<?php
    include_once "../domain/herramienta.php";
    include_once "../business/herramientaBusiness.php";
    include_once '../business/sessionManager.php';

    $actualUserType = (isLoggedIn() && !isAdmin()) ? 1 : 0; // 0 = Administrador, 1 = productor
    $usuarioID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


    $herramientaBusiness = new herramientaBusiness();
    $option = $_POST['option'];

    if($option == 1){
        
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        //$codigo = $herramientaBusiness->generarCodigoUnico($nombre,$descripcion);
        
        if($actualUserType == 0){
            $codigo = "ADM-".$usuarioID;
        }else{
            $codigo = "PRD-".$usuarioID;
        }
        $herramienta = new herramienta($codigo, $nombre, $descripcion);
        $resultado = $herramientaBusiness->insertarHerramienta($herramienta);
        echo $resultado;
        //echo $codigo;
    }
    else if($option == 2){
        $resultado = $herramientaBusiness->consultarHerramienta(1, $usuarioID, $actualUserType, 1);
        echo $resultado;
    }
    else if ($option == 3) {
        $codigo = $_POST['codigo'];
        $resultado = $herramientaBusiness->eliminarHerramienta($codigo);
        echo $resultado;
    }
    else if($option == 4){
        $codigo = $_POST['codigo'];
        $resultado = $herramientaBusiness->consultarcodigoherramienta($codigo);
        echo $resultado;
    }
    else if($option == 5){
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $herramienta = new herramienta($codigo, $nombre, $descripcion);
        $resultado = $herramientaBusiness->actualizarHerramienta($herramienta);
        echo $resultado;
    }
    else if($option == 6){
        $codigo = $_POST['codigo'];
        $resultado = $herramientaBusiness->ValidarCodigo($codigo);
        echo $resultado;
    }else if($option == 7){
        $nombre = $_POST['nombre'];
        $resultado = $herramientaBusiness->ValidarHerramientasParecidas($nombre);
        echo $resultado;
    }else if($option == 8){
        $resultado = $herramientaBusiness->consultarHerramienta(0, $usuarioID, $actualUserType, 1);
        echo $resultado;
    }else if($option == 9){
        $codigo = $_POST['codigo'];
        $resultado = $herramientaBusiness->reactivarHerramienta($codigo);
        echo $resultado;
    }
