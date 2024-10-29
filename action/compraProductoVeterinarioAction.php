

<?php
     include_once "../domain/compraProductoVeterinario.php";
    include_once "../business/compraProductoVeterinarioBusiness.php";
    
    $compraProductoVeterinarioBusiness = new CompraProductoVeterinarioBusiness();
    
    $option = $_POST['option'];

    if ($option == 1) {
        $nombre = $_POST['nombre']; $user_id = $_POST['user_id'];
        $compra = $_POST['compra'];
        $fechacompra = $_POST['fechacompra'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];

        $compraProductoVeterinario = new CompraProductoVeterinario(null, $nombre, $fechacompra, $cantidad, $precio, $user_id);
        $resultado = $compraProductoVeterinarioBusiness->insertarCompraProductoVeterinario($compraProductoVeterinario);          
        
        echo $resultado;
   
    } else if ($option == 2) {
       // echo"consultar";
      $resultado = $compraProductoVeterinarioBusiness->consultarCompraProductoVeterinario();
       echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario
        
    } else if ($option == 3) {
        $codigoid = $_POST['codigoid'];
        $resultado = $compraProductoVeterinarioBusiness->eliminarCompraProductoVeterinario($codigoid);
        echo $resultado;
    
    }else if ($option == 4) {
        $codigoid = $_POST['codigoid'];
        $resultado = $compraProductoVeterinarioBusiness->consultarCompraProductoVeterinarioPorCodigo($codigoid);
        echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

    //opcion de editar
    } else if ($option == 5) {
        $id = $_POST["id"];
        $nombre = $_POST['nombre']; 
        $user_id = $_POST['user_id'];
        $fechacompra = $_POST['fechacompra'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];

        $compraProductoVeterinario = new CompraProductoVeterinario($id, $nombre, $fechacompra, $cantidad, $precio, $user_id);
        $resultado = $compraProductoVeterinarioBusiness->actualizarCompraProductoVeterinario($compraProductoVeterinario);
        echo $resultado;
    
    } 
?>
