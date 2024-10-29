

<?php
    include_once "../domain/productoVeterinario.php";
    include_once "../business/productoVeterinarioBusiness.php";
    include_once "../domain/compraProductoVeterinario.php";
    include_once "../business/compraProductoVeterinarioBusiness.php";
    
    $productoVeterinarioBusiness = new ProductoVeterinarioBusiness();
    $compraProductoVeterinarioBusiness = new CompraProductoVeterinarioBusiness();
    
    $option = $_POST['option'];

    if ($option == 1) {
        $nombre = $_POST['nombre'];
        $principioactivo = $_POST['principioactivo'];
        $dosificacion = $_POST['dosificacion'];
        $fechavencimiento = $_POST['fechavencimiento'];
        $funcion = $_POST['funcion'];
        $descripcion = $_POST['descripcion'];
        $tipomedicamento = $_POST['tipomedicamento'];
        $proveedor = $_POST['proveedor'];
        $user_id = $_POST['user_id'];
        $compra = $_POST['compra'];
        $fechacompra = $_POST['fechacompra'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];

        $productoVeterinario = new ProductoVeterinario(null, $nombre, $principioactivo, $dosificacion, $fechavencimiento, $funcion, $descripcion, $tipomedicamento, $proveedor, $user_id);
        $resultado = $productoVeterinarioBusiness->insertarProductoVeterinario($productoVeterinario);

        if($compra == "1" && $resultado == "1"){
            $compraProductoVeterinario = new CompraProductoVeterinario(null, $nombre, $fechacompra, $cantidad, $precio, $user_id);
            $resultado = $compraProductoVeterinarioBusiness->insertarCompraProductoVeterinario($compraProductoVeterinario);          
        }
        echo $resultado;
   
    } else if ($option == 2) {
       // echo"consultar";
      $resultado = $productoVeterinarioBusiness->consultarProductoVeterinario();
       echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario
        
    } else if ($option == 3) {
        $codigoid = $_POST['codigoid'];
        $resultado = $productoVeterinarioBusiness->eliminarProductoVeterinario($codigoid);
        echo $resultado;
    
    }else if ($option == 4) {
        $codigoid = $_POST['codigoid'];
        $resultado = $productoVeterinarioBusiness->consultarProductoVeterinarioPorCodigo($codigoid);
        echo json_encode($resultado);  // Convertir el resultado en JSON si es necesario

    //opcion de editar
    } else if ($option == 5) {
        $id = $_POST["id"];
        $nombre = $_POST['nombre'];
        $principioactivo = $_POST['principioactivo'];
        $dosificacion = $_POST['dosificacion'];
        $fechavencimiento = $_POST['fechavencimiento'];
        $funcion = $_POST['funcion'];
        $descripcion = $_POST['descripcion'];
        $tipomedicamento = $_POST['tipomedicamento'];
        $proveedor = $_POST['proveedor'];
        $user_id = $_POST['user_id'];

        $productoVeterinario = new ProductoVeterinario($id, $nombre, $principioactivo, $dosificacion, $fechavencimiento, $funcion, $descripcion, $tipomedicamento, $proveedor, $user_id);
        $resultado = $productoVeterinarioBusiness->actualizarProductoVeterinario($productoVeterinario);
        echo $resultado;
    
    } 
?>
