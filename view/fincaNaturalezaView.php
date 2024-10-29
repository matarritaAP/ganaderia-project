<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: login.php'); // !Productor -> Ir a login
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
    <title>Sección Finca Naturaleza</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de Naturalezas de la Finca</h1>
        <hr>
    </header>
    <!-- Administración de las naturalezas -->
    <br>
    <button id="mostrarFormEspecifica">Insertar una naturaleza propia</button>
    <div class="containerNaturalezaEspecifica" id="containerNaturalezaEspecifica"></div>
    <hr>
    <div class="container" id="container">
        <h3>Seleccionar Finca</h3>
        <select id="fincaSelect">
            <option value="">Selecciona la finca a administrar</option>
        </select>
        <!-- Administración de los servicios inactivas -->
        <div>
            <hr>
            <button id="toggleInactivos">Ver Inactivos</button>
            <div id="listaInactivos">
                <!-- Tabla para las razas inactivas -->
                <table id="tablaInactivos">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="listaInactivosCuerpo"></tbody>
                </table>
            </div>
        </div>
        <hr>
        <h3>Naturalezas Asignadas a la Finca</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="listaNaturalezasAsignadas"></tbody>
        </table>
        <hr>
        <button id="mostrarNaturalezasDisponibles">Agregar nuevas naturalezas a la finca</button>
        <hr>
    </div>

    <div class="availableNaturalezas" id="availableNaturalezas">
        <h3>Naturalezas Disponibles</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="listaNaturalezasDisponibles"></tbody>
        </table>
    </div>
    <br><br>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/fincaNaturaleza.js"></script>
</body>

</html>