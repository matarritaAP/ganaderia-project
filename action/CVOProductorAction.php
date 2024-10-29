<?php
include_once "../domain/CVOProductor.php";
include_once "../business/CVOProductorBusiness.php";
include_once "../business/cvoBusiness.php";
include_once "../business/sessionManager.php";

$cvoProductorBusiness = new CVOProductorBusiness();
$cvoBusiness = new cvoBusiness();
$option = $_POST['option'];
$cedProductor = getUserId();

if ($option == 1) {
    $numCVO = $_POST['numCVO'];
    $cvoProductor = new CVOProductor($numCVO, $cedProductor);
    $resultado = $cvoProductorBusiness->insertarCVOProductor($cvoProductor);

    if ($resultado) {
        echo "CVO añadido a tus favoritos";
    } else {
        echo "Este CVO ya está en tus favoritos";
    }
} else if ($option == 2) {
    $resultado = $cvoProductorBusiness->consultarCVOPorProductor($cedProductor);
    echo $resultado;
} else if ($option == 3) {
    $numCVO = $_POST['numCVO'];
    $resultado = $cvoProductorBusiness->eliminarCVOProductor($numCVO, $cedProductor);
    echo $resultado;
} else if ($option == 4) {
    $resultado = $cvoBusiness->consultarCVO();
    echo $resultado;
} 
