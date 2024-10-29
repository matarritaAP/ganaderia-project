

  <?php
    include_once "../domain/herbicidas.php";
    include_once "../business/herbicidasBusiness.php";


    $herbicidasBusiness = new herbicidasBusiness();
    $option = $_POST['option'];

    if($option == 1){
        $codigoid = $_POST['codigoid'];
        $nombre = $_POST['nombre'];
        $nombrecomun = $_POST['nombrecomun'];
        $presentacion = $_POST['presentacion'];
        $casacomercial = $_POST['casacomercial'];
        $cantidad = $_POST['cantidad'];
        $funcion = $_POST['funcion'];
        $aplicacion = $_POST['aplicacion'];
        $descripcion = $_POST['descripcion'];
        $formula = $_POST['formula'];
        $provedor = $_POST['provedor'];

        $herbicida = new herbicidas($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $aplicacion, $descripcion, $formula, $provedor);
        $resultado = $herbicidasBusiness->insertarHerbicida($herbicida);
        echo $resultado;
   
    }
    else if($option == 2){
        $resultado = $herbicidasBusiness->consultarHerbicidas(1);
        echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario
        
    }
    else if ($option == 3) {
        $codigoid = $_POST['codigoid'];
        $resultado = $herbicidasBusiness->eliminarHerbicida($codigoid);
        echo $resultado;
    }
    else if($option == 4){
        $codigoid = $_POST['codigoid'];
        $resultado = $herbicidasBusiness->consultarHerbicidaPorCodigo($codigoid);
        echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario
    }
    else if($option == 5){
        $codigoid = $_POST['codigoid'];
        $nombre = $_POST['nombre'];
        $nombrecomun = $_POST['nombrecomun'];
        $presentacion = $_POST['presentacion'];
        $casacomercial = $_POST['casacomercial'];
        $cantidad = $_POST['cantidad'];
        $funcion = $_POST['funcion'];
        $aplicacion = $_POST['aplicacion'];
        $descripcion = $_POST['descripcion'];
        $formula = $_POST['formula'];
        $provedor = $_POST['provedor'];

        $herbicida = new herbicidas($codigoid, $nombre, $nombrecomun, $presentacion, $casacomercial, $cantidad, $funcion, $aplicacion, $descripcion, $formula, $provedor);
        $resultado = $herbicidasBusiness->actualizarHerbicida($herbicida);
        echo $resultado;
    }
    /*else if($option == 6){
        $codigoid = $_POST['codigoid'];
        $resultado = $herbicidasBusiness->validarCodigo($codigoid);
        echo $resultado;
    }else if($option == 7){
        $nombre = $_POST['nombre'];
        $resultado = $herbicidasBusiness->validarHerbicidasParecidos($nombre);
        echo $resultado;
    }*/
    else if($option == 6){
        $resultado = $herbicidasBusiness->consultarHerbicidas(0);
        echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario
    }else if($option == 7){
        $codigoid = $_POST['codigoid'];
        $resultado = $herbicidasBusiness->reactivar($codigoid);
        echo $resultado;
    }
?>
