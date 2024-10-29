<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: login.php');
    exit();
}
$script = str_replace('/view/', '/', $_SERVER['PHP_SELF']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($script) . '/index.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección CVO Productor</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Información de mi CVO</h1>
    </header>
    <div class="container" id="container">
        <hr>
        <h3>CVOs Favoritos</h3>
        <br>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha de Emisión</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="listaCVOsFavoritos"></tbody>
        </table>
        <hr>
        <button id="mostrarCVOsDisponibles">Agregar nuevos CVOs a favoritos</button>
        <hr>
    </div>

    <div class="availableCVOs" id="availableCVOs">
        <br>
        <h3>CVOs Disponibles</h3>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha de Emisión</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="listaCVOsDisponibles"></tbody>
        </table>
    </div>
    <br><br>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/cvoproductor.js"></script>
</body>
</html>