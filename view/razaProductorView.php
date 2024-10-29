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
    <title>Sección Raza Productor</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de Razas</h1>
        <hr>
    </header>

    <!-- Administración de las razas -->
    <button id="mostrarFormEspecifica">Insertar una raza propia</button>
    <div class="containerRazaEspecifica" id="containerRazaEspecifica"></div>

    <!-- Administración de las razas inactivas -->
    <div>
        <hr>
        <button id="toggleInactivos">Ver Inactivos</button>
        <br />
        <div id="listaInactivos">
            <!-- Tabla para las razas inactivas -->
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

    <!-- Administración de lista de razas seleccionadas -->
    <div class="container" id="container">
        <hr>
        <h3>Mi lista de Razas</h3>
        <br>
        <table>
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody id="listaRazasFavoritas"></tbody>
        </table>
        <hr>
        <button id="mostrarRazasDisponibles">Agregar nuevas razas a mi lista</button>
        <hr>
    </div>

    <!-- Administración de lista de razas disponibles del sistema -->
    <div class="availableRazas" id="availableRazas" style="display: none;">
        <h3>Razas Disponibles</h3>
        <table>
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody id="listaRazasDisponibles"></tbody>
        </table>

    </div>
    <br><br>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/razaProductor.js"></script>
</body>

</html>