<?php
session_start();

// Verificar si el usuario está autenticado
$user = $_SESSION['user_role'];
if ($user == null || $user != 'PRODUCTOR') {
    echo "usted no tiene autorización";
    die();
}
$script = str_replace('/view/', '/', $_SERVER['PHP_SELF']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($script) . '/index.php';
?>


<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección Fierro</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de mi fierro</h1>
    </header>
    <div class="insertFierro" id="insertFierro"><!--Registro de Fierro-->
        <hr>
        <div class="container">
            <form class="insertFierro" novalidate id="forminsertFierro">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                <div>
                    <label for="numero">
                        Numero Fierro
                    </label>
                    <input type="text" id="numeroFierro" name="numeroFierro" requiered>
                    <input type="hidden" id="numeroFierroHidden" name="numeroFierroHidden">
                </div>
                <div>
                    <label for="fechaEmision">
                        Fecha Emision
                    </label>
                    <input type="date" id="fechaEmisionFierro" name="fechaEmisionFierro" requiered>
                </div>
                <div>
                    <label for="fechaVencimiento">
                        Fecha Vencimiento
                    </label>
                    <input type="date" id="fechaVencimientoFierro" name="fechaVencimientoFierro" requiered>
                </div>
                <div>
                    <label for="imagen">
                        Imagen
                    </label>
                    <input type="file" id="imagenFierro" name="imagenFierro" requiered>
                </div>
                <br>
                <div id="btnRegistrar">
                    <button type="submit" class="nuevoRegistro">
                        Registrar
                    </button>
                    <button id="cancelar" type="button">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <br>
    <div class="container" id="container"><!--Tabla para mostrar los datos-->
        <table>
            <thead>
                <tr>
                    <th>
                        Acciones
                    </th>

                    <th>
                    </th>
                    <th>
                        Numero
                    </th>
                    <th>
                        Fecha de Emision
                    </th>
                    <th>
                        Fecha de Vencimiento
                    </th>
                    <th>
                        Fierro
                    </th>
                </tr>
            </thead>
            <tbody id="listaFierro"></tbody>
        </table>
    </div>
    <hr>
    <!-- Ventana emergente para la imagen grande -->
    <div id="imagenGrande" style="display: none; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); background: white; padding: 10px; border: 1px solid #ccc; z-index: 1000;">
        <img id="imgGrande" src="" alt="Imagen Grande" style="max-width: 100%; max-height: 80vh;">
        <br>
        <button onclick="descargarImagen()" style="color: white; background: green; border: none; padding: 10px;">Descargar</button>
        <button onclick="cerrarImagen()" style="color: white; background: red; border: none; padding: 10px;">Cerrar</button>
    </div>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/fierro.js"></script>
</body>

</html>