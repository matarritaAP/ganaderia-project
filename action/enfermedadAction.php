

<?php
    include_once "../domain/enfermedad.php";
    include_once "../business/enfermedadBusiness.php";
    
    $enfermedadBusiness = new EnfermedadBusiness();
    
    $option = $_POST['option'];

    if ($option == 1) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $sintomas = $_POST['sintomas'];
        $user_id = $_POST['user_id'];

        $enfermedad = new Enfermedad(null, $user_id, $nombre, $descripcion, $sintomas);
        $resultado = $enfermedadBusiness->insertarEnfermedad($enfermedad);
        echo $resultado;
   
    } else if ($option == 2) {
      $resultado = $enfermedadBusiness->consultarEnfermedad();
       echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario
        
    } else if ($option == 3) {
        $codigoid = $_POST['codigoid'];
        $resultado = $enfermedadBusiness->eliminarEnfermedad($codigoid);
        echo $resultado;
    
    }else if ($option == 4) {
        $codigoid = $_POST['codigoid'];
        $resultado = $enfermedadBusiness->consultarEnfermedadPorCodigo($codigoid);
        echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

    //opcion de editar
    } else if ($option == 5) {
        $id = $_POST["id"];
        $user_id = $_POST['user_id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $sintomas = $_POST['sintomas'];

        $enfermedad = new Enfermedad($id, null, $nombre, $descripcion, $sintomas);
        $resultado = $enfermedadBusiness->actualizarEnfermedad($enfermedad);
        echo $resultado;
    
    }
?>
