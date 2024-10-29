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
    <title>Sección Finca Herramienta</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de Herramientas de la Finca</h1>
        <hr>
    </header>

    <div class="herramientaPropia" id="herramientaPropia" style="display: none;">
        <hr>
        <h3>Agregar herramienta</h3>
        <div class="insertHerramienta" id="insertHerramienta"><!--Registro de Herramientas-->
            <div class="container">
                <form class="insertHerramienta" novalidate id="forminsertHerramienta">
                    <div>
                        <input type="hidden" id="codigoherramienta" requiered>
                    </div>
                    <div>
                        <label for="nombre">
                            Nombre
                        </label>
                        <input type="text" id="nombreherramienta" requiered>
                    </div>
                    <div>
                        <label for="descripcion">
                            Descripción
                        </label>
                        <input type="text" id="descripcionherramienta" requiered>
                    </div>
                    <br>
                    <div id="btnRegistrar">
                        <button type="submit" class="nuevoRegistro">
                            Registrar
                        </button>
                        <button id="cancelarHerramientaPropia" type="button">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="container" id="container"><!--Tabla para mostrar los datos-->
            <table>
                <thead>
                    <tr>
                        <th>
                            Nombre
                        </th>
                        <th>
                            Descripción
                        </th>
                    </tr>
                </thead>
                <tbody id="listaHerramienta"></tbody>
            </table>
        </div>
        <hr>
    </div>
    <div class="divHerramientas" id="divHerramientas">
        <div class="container" id="container">
            <h3>Seleccionar Finca</h3>
            <select id="fincaSelect">
                <option value="">Selecciona la finca a administrar</option>
            </select>
            <!-- Administración de las herramientas inactivas -->
            <div>
                <hr>
                <button id="toggleInactivos">Ver Inactivos</button>
                <button id="btnDivNuevaHerramienta">Nueva herramienta</button>
                <div id="listaInactivosPro">
                    <!-- Tabla para las razas inactivas -->
                    <table id="tablaInactivos">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="listaInactivosProCuerpo"></tbody>
                    </table>
                </div>
            </div>
            <hr>
            <h3>Herramientas Asignadas a la Finca</h3>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="listaHerramientasAsignadas"></tbody>
            </table>
            <hr>
            <button id="mostrarHerramientasDisponibles">Agregar nuevas herramientas a la finca</button>
            <hr>
        </div>

        <div class="availableHerramientas" id="availableHerramientas">
            <h3>Herramientas Disponibles</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="listaHerramientasDisponibles"></tbody>
            </table>
        </div>
    </div>
    <br><br>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/fincaHerramienta.js"></script>
    <script src="../js/herramienta.js"></script>
</body>

</html>