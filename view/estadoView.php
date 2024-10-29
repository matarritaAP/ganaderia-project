<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: ./view/login.php'); // !Admin -> Ir a login
    exit();
}
$script = str_replace('/view/', '/', $_SERVER['PHP_SELF']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($script) . '/index.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--meta name="viewport" content="width=device-width, initial-scale=1.0"-->
    <title>Sección Estado</title>
    <style>
        body {
            margin: 20px;
        }

        header {
            text-align: center;
        }

        header li {
            text-align: left;
            list-style-type: none;
        }

        input {
            margin-bottom: 10px;
            margin-left: 10px;
        }

        tr {
            text-align: center;
        }

        hr {
            border: 1px solid #ccc;
            margin: 15px 0;
        }

        table,
        th,
        td {
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-right: 1px solid #ccc;
        }

        th:last-child,
        td:last-child {
            border-right: none;
        }
    </style>
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de los Estados de Ganado del Sistema</h1>
    </header>

    <div>
        <hr>
        <button id="toggleInactivos">Ver Inactivos</button>
        <br /><br />
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
        <hr>
    </div><br>
    
    <div class="insertEstado" id="insert">
        <div class="container">
            <form class="insertEstado" novalidate id="forminsertEstado">
                <div>
                    <label for="codigo">
                        Codigo
                    </label>
                    <input type="text" id="codigoestado" requiered>
                </div>
                <div>
                    <label for="nombre">
                        Nombre
                    </label>
                    <input type="text" id="nombreestado" requiered>
                </div>
                <div>
                    <label for="descripcion">
                        Descripción
                    </label>
                    <input type="text" id="descripcionestado" requiered>
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
    <hr><br>
    <div class="container" id="container"><!--Tabla para mostrar los datos-->
        <table>
            <thead>
                <tr>
                    <th>
                        Codigo
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Descripción
                    </th>
                </tr>insertRaza
            </thead>
            <tbody id="listaEstado"></tbody>
        </table>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/estado.js"></script>
</body>

</html>