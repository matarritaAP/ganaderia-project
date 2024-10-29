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
    <title>Sección Finca Servicio</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de Servicios de la Finca</h1>
        <hr>
    </header>
    <!-- Administración de los servicios propios -->
    <button id="mostrarFormEspecifico">Insertar un servicio propio</button>
    <div class="containerServicioEspecifico" id="containerServicioEspecifico"></div>
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
            <br />
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
        <h3>Servicios Asignados a la Finca</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="listaServiciosAsignados"></tbody>
        </table>
        <hr>
        <button id="mostrarServiciosDisponibles">Agregar nuevos servicios a la finca</button>
        <hr>
    </div>

    <div class="availableServicios" id="availableServicios">
        <h3>Servicios Disponibles</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="listaServiciosDisponibles"></tbody>
        </table>
    </div>
    <br><br>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/fincaServicio.js"></script>
</body>

</html>