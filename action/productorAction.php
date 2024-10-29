<?php
include_once "../domain/Productor.php";
include_once "../business/productorBusiness.php";
include_once "../business/sessionManager.php";

$productorBusiness = new ProductorBusiness();
$option = $_POST['option'];
$productorID = getUserProductorId();

function validarDatosProductor($nombre, $email, $contrasenia, $docIdentidad, $primerApellido, $segundoApellido, $fechaNacimiento, $telefono, $direccion)
{
    // Validaciones
    if (empty($nombre) || !is_string($nombre)) {
        die("Error: El valor del nombre debe ser un texto.");
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: El valor del email es inválido.");
    }
    if (!is_null($contrasenia) && strlen($contrasenia) < 6) {
        die("Error: La contraseña debe tener al menos 6 caracteres.");
    }
    if (!is_null($primerApellido) && !is_string($primerApellido)) {
        die("Error: El valor del primer apellido debe ser texto.");
    }
    if (!is_null($segundoApellido) && !is_string($segundoApellido)) {
        die("Error: El valor del segundo apellido debe ser texto.");
    }
    if (!is_null($fechaNacimiento) && !DateTime::createFromFormat('Y-m-d', $fechaNacimiento)) {
        die("Error: El valor de la fecha de nacimiento debe tener el formato YYYY-MM-DD.");
    }
    if (!is_null($telefono) && !preg_match('/^[0-9]{8,15}$/', $telefono)) {
        die("Error: El valor del teléfono debe contener entre 8 y 15 dígitos.");
    }
    if (!is_null($direccion) && !is_string($direccion)) {
        die("Error: El valor de la dirección debe ser texto.");
    }
}

if ($option == 1) {
    try {
        // datos del productor necesarios [required] 
        $nombreGanaderia = $_POST['nombreGanaderia'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasenia = $_POST['contrasenia'];
        // datos del productor no necesarios [not required]
        $docIdentidad = empty($_POST['docIdentidad']) ? NULL : $_POST['docIdentidad'];
        $primerApellido = empty($_POST['primerApellido']) ? NULL : $_POST['primerApellido'];
        $segundoApellido = empty($_POST['segundoApellido']) ? NULL : $_POST['segundoApellido'];
        $fechaNacimiento = empty($_POST['fechaNacimiento']) ? NULL : $_POST['fechaNacimiento'];
        $telefono = empty($_POST['telefono']) ? NULL : $_POST['telefono'];
        $direccion = empty($_POST['direccion']) ? NULL : $_POST['direccion'];

        // Llamada a la función de validación
        validarDatosProductor($nombre, $email, $contrasenia, $docIdentidad, $primerApellido, $segundoApellido, $fechaNacimiento, $telefono, $direccion);

        // Aplicar hash a la contraseña
        $contraseniaHash = password_hash($contrasenia, PASSWORD_BCRYPT);
        $productor = new Productor(
            $docIdentidad,
            $nombreGanaderia,
            $nombre,
            $primerApellido,
            $segundoApellido,
            $fechaNacimiento,
            $email,
            $telefono,
            $direccion
        );

        if($productorBusiness->ValidarEmail($email)){
            die("El correo electrónico esta asociada a otro usuario.");
        }

        $resultado = $productorBusiness->insertarProductor($productor, $contraseniaHash);
        echo $resultado;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($option == 5) {
    // datos del productor necesarios [required] 
    $nombreGanaderia = $_POST['nombreGanaderia'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasenia = empty($_POST['contrasenia']) ? NULL : $_POST['contrasenia']; // La contraseña no es obligatoria para editar
    // datos del productor no necesarios [not required]
    $docIdentidad = empty($_POST['docIdentidad']) ? NULL : $_POST['docIdentidad'];
    $primerApellido = empty($_POST['primerApellido']) ? NULL : $_POST['primerApellido'];
    $segundoApellido = empty($_POST['segundoApellido']) ? NULL : $_POST['segundoApellido'];
    $fechaNacimiento = empty($_POST['fechaNacimiento']) ? NULL : $_POST['fechaNacimiento'];
    $telefono = empty($_POST['telefono']) ? NULL : $_POST['telefono'];
    $direccion = empty($_POST['direccion']) ? NULL : $_POST['direccion'];

    // Llamada a la función de validación
    validarDatosProductor($nombre, $email, $contrasenia, $docIdentidad, $primerApellido, $segundoApellido, $fechaNacimiento, $telefono, $direccion);

    // Si se proporciona una nueva contraseña, aplicar el hash
    $contraseniaHash = $contrasenia ? password_hash($contrasenia, PASSWORD_BCRYPT) : NULL;

    $productor = new Productor(
        $docIdentidad,
        $nombreGanaderia,
        $nombre,
        $primerApellido,
        $segundoApellido,
        $fechaNacimiento,
        $email,
        $telefono,
        $direccion
    );

    $resultado = $productorBusiness->actualizarProductor($productor);
    echo $resultado;
} else if ($option == 2) {
    echo $productorID;
    $resultado = $productorBusiness->consultarProductor();
    echo $resultado;
} else if ($option == 3) {
    $codigo = $_POST['codigo'];
    $resultado = $productorBusiness->eliminarProductor($codigo);
    echo $resultado;
} else if ($option == 4) {
    $resultado = $productorBusiness->consultarProductorPorID($productorID);
    echo $resultado;
} else if ($option == 6) {
    $docIdentidad = $_POST['docIdentidad'];
    $resultado = $productorBusiness->ValidarDocumento($docIdentidad);
    echo $resultado;
} else if ($option == 7) {
    $email = $_POST['email'];
    $resultado = $productorBusiness->ValidarEmail($email);
    echo $resultado;
}
