<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: login.php'); // !Producto -> Ir a login
    exit();
}
$script = str_replace('/view/', '/', $_SERVER['PHP_SELF']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($script) . '/index.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección Estados Productor</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>

    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de Estados de Crecimiento Bovinos</h1>
        <hr>
    </header>
    <!-- Administración de los estados -->
    <button id="mostrarFormEspecifica">Insertar un estado propio</button>
    <div class="containerEstadoEspecifico" id="containerEstadoEspecifico"></div>
    <!-- Administración de los estados inactivas -->

    <div>
        <hr>
        <button id="toggleInactivos">Ver Inactivos</button>
        <br />
        <div id="listaInactivos">
            <!-- Tabla para los estados inactivas -->
            <table id="tablaInactivos">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="listaInactivosCuerpo"></tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <hr>
        <h3>Estados Favoritos</h3>
        <br>
        <table>
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody id="listaEstadosFavoritos"></tbody>
        </table>
        <hr>
        <button id="mostrarEstadosDisponibles">Agregar nuevos estados a favoritos</button>
        <hr>
    </div>

    <div class="availableEstado" id="availableEstado" style="display: none;">
        <h3>Estados Disponibles</h3>
        <table>
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody id="listaEstadosDisponibles"></tbody>
        </table>
        <hr>
    </div>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/estadoProductor.js"></script>
</body>
</html>