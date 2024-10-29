<?php
    include_once "../domain/fierro.php";
    include_once "../business/fierroBusiness.php";
    include_once "../business/sessionManager.php";

    $fierroBusiness = new fierroBusiness();
    $user_id = getUserId();
    $option = $_POST['option'];

    if($option == 1){

        $directory = "../docs/imagenFierro/";
        $numero = $_POST['numeroFierro'];
        $ruta = $directory.basename($user_id."".$numero).'.jpg';
        $fEmision = $_POST['fechaEmisionFierro'];
        $fVencimiento = $_POST['fechaVencimientoFierro'];


        $fierro = new fierro($numero, $fEmision, $fVencimiento, $ruta);
        $resultado = $fierroBusiness->insertarFierro($fierro, $user_id);

        if($resultado == 1){
            move_uploaded_file($_FILES['imagenFierro']['tmp_name'], $ruta);
        }
        
        echo $resultado;
    }
    else if($option == 2){
        $resultado = $fierroBusiness->consultarFierro($user_id);
        echo $resultado;
    }
    else if ($option == 3) {
        $codigo = $_POST['codigo'];
        $resultado = $fierroBusiness->eliminarFierro($codigo);
        echo $resultado;
    }
    else if($option == 4){
        $codigo = $_POST['codigo'];
        $resultado = $fierroBusiness->consultarcodigoFierro($codigo);
        echo $resultado;
    }
    else if($option == 5){
        $directory = "../docs/imagenFierro/";
        $numero = $_POST['numeroFierroHidden'];
        $ruta = $directory.basename($user_id."".$numero).'.jpg';
        $fEmision = $_POST['fechaEmisionFierro'];
        $fVencimiento = $_POST['fechaVencimientoFierro'];
        $file = $_FILES['imagenFierro']['name'];

        $renovar = $_POST['renovar'];

        $fierro = new fierro($numero, $fEmision, $fVencimiento, $ruta);
        $resultado = $fierroBusiness->actualizarFierro($fierro, $renovar);
        if($resultado == 1){
            move_uploaded_file($_FILES['imagenFierro']['tmp_name'], $ruta);
       }       
        echo $resultado;
    }
    else if($option == 6){
        $docIdentidad = $_POST['docIdentidad'];
        $resultado = $fierroBusiness->ValidarDocumento($docIdentidad);
        echo $resultado;
    }
?>