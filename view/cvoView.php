<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: ./login.php'); // !Productor -> Ir a login
    exit();
}
$script = str_replace('/view/', '/', $_SERVER['PHP_SELF']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($script) . '/index.php';
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección CVO</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de mi CVO</h1>
    </header>
    <div class="insertCVO" id="insertCVO"><!--Registro de CVO-->
        <hr>
        <div class="container">
            <form class="insertCVO" novalidate id="forminsertCVO">
                <div>
                    <label for="numero">
                        Número CVO
                    </label>
                    <input type="text" id="numeroCVO" name="numeroCVO" required>
                    <input type="hidden" id="numeroCVOHidden" name="numeroCVOHidden">
                </div>
                <div>
                    <label for="fechaEmision">
                        Fecha Emisión
                    </label>
                    <input type="date" id="fechaEmisionCVO" name="fechaEmisionCVO" required>
                </div>
                <div>
                    <label for="fechaVencimiento">
                        Fecha Vencimiento
                    </label>
                    <input type="date" id="fechaVencimientoCVO" name="fechaVencimientoCVO" required>
                </div>
                <div>
                    <label for="imagen">
                        Imagen
                    </label>
                    <input type="file" id="imagenCVO" name="imagenCVO" required>
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
                        Número
                    </th>
                    <th>
                        Fecha Emisión
                    </th>
                    <th>
                        Fecha Vencimiento
                    </th>
                    <th>
                        Imagen
                    </th>
                </tr>
            </thead>
            <tbody id="listaCVO"></tbody>
        </table>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/cvo.js"></script>
</body>

</html>