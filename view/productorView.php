<?php
session_start();
include_once '../business/sessionManager.php';
$script = str_replace('/view/', '/', $_SERVER['PHP_SELF']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($script) . '/index.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección Productor</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
    <script type="text/javascript">
        const isLoggedIn = <?php echo json_encode(isLoggedIn()); ?>;
    </script>
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>
            <?php
            if (isLoggedIn()) {
                echo 'Información de mi perfil';
            } else {
                echo 'Crear nueva cuenta';
            }
            ?>
        </h1>
        <hr>
    </header>
    <div class="insertProductor" id="insertProductor"><!--Registro de Productor-->
        <div class="container">
            <form class="insertProductor" novalidate id="forminsertProductor">
                <div>
                    <label for="docIdentidad">Documento de identidad</label>
                    <input type="text" id="docIdentidadProductor" placeholder="opcional">
                </div>
                <div>
                    <label for="nombre">Nombre de la ganadería</label>
                    <input type="text" id="nombreGanaderia" required>
                </div>
                <div>
                    <label for="nombre">Nombre del Usuario</label>
                    <input type="text" id="nombreProductor" required>
                </div>
                <div>
                    <label for="primerApellido">Primer Apellido</label>
                    <input type="text" id="primerApellidoProductor" placeholder="opcional">
                </div>
                <div>
                    <label for="segundoApellido">Segundo Apellido</label>
                    <input type="text" id="segundoApellidoProductor" placeholder="opcional">
                </div>
                <div>
                    <label for="fechaNacimiento">Fecha Nacimiento (opcional)</label>
                    <input type="date" id="fechaNacimientoProductor" placeholder="opcional">
                </div>
                <div>
                    <label for="email">Correo</label>
                    <input type="text" id="emailProductor" required>
                </div>
                <div>
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefonoProductor" placeholder="opcional">
                </div>
                <div>
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccionProductor" placeholder="opcional">
                </div>
                <div id="contrasenaContainer">
                    <label for="contrasenia">Contraseña</label>
                    <input type="password" id="contraseniaProductor" required>
                </div>
                <br>
                <div id="btnRegistrar">
                    <button type="submit" class="nuevoRegistro">Registrar</button>
                    <button id="cancelar" type="button">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/productor.js"></script>
</body>

</html>