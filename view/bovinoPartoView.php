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
    <title>Sección Gestor de Bovinos</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de Reprodución de Bovinos (Partos)</h1>
    </header>
    <!-- Administracion de bovinos inactivos -->
    <div>
        <hr>
        <button id="toggleInactivos"> Ver Inactivos</button>
        <br />
        <div id="listaInactivos" style="display: none;">
            <!-- Tabla para los bovinos inactivos -->
            <table id="tablaInactivos">
                <thead>
                    <tr>
                        <th>Nuevo número</th>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Estado</th>
                        <th>Sexo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="listaInactivosCuerpo"></tbody>
            </table>
        </div>
    </div>
    <hr>
    <!-- Administracion de inserción de bovinos -->
    <div class="insertBovino" id="insertBovino">
        <div class="container">
            <form id="formInsertBovino" novalidate>
                <div>
                    <label for="numero">Nuevo número</label>
                    <input type="text" id="numero" required>
                </div>
                <div>
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre">
                </div>
                <div>
                    <label for="padreID">Padre</label>
                    <select id="padreID" required></select>
                </div>
                <div>
                    <label for="madreID">Madre</label>
                    <select id="madreID" required></select>
                </div>
                <div>
                    <label for="fechaNacimiento">Fecha de Parto</label>
                    <input type="date" id="fechaNacimiento">
                </div>
                <div>
                    <label for="peso">Peso</label>
                    <input type="decimal" id="peso">
                </div>
                <div>
                    <label for="razaID">Raza</label>
                    <select id="razaID" required></select>
                </div>
                <div>
                    <label for="estadoID">Estado</label>
                    <select id="estadoID" required></select>
                </div>
                <div>
                    <label for="genero">Género</label>
                    <select id="genero" required>
                        <option value="Vaca">Vaca</option>
                        <option value="Toro">Toro</option>
                    </select>
                </div>
                <div>
                    <label for="fincaID">Finca asignada</label>
                    <select id="fincaID" required></select>
                </div>
                <div>
                    <label for="detalle">Detalles Adicionales</label>
                    <textarea id="detalle"></textarea>
                </div>
                <br />
                <div>
                    <button type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <hr><br>
    <div class="container" id="container">
        <!--Tabla para mostrar los datos-->
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Nombre</th>
                    <th>Padre</th>
                    <th>Madre</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Peso</th>
                    <th>Raza</th>
                    <th>Estado</th>
                    <th>Género</th>
                    <th>Finca Asignada</th>
                    <th>Detalles Adicionales</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="listaBovinos"></tbody>
        </table>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>

    <script src="../js/bovinoParto.js"></script>
</body>

</html>