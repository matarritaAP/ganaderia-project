<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: ./login.php'); // Si no es admin, redirigir al login
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
    <title>Gestión de Tipos de Producto Alimenticio</title>
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
        <h1>Administración de los Tipos de Productos Alimenticios del Sistema</h1>
        <hr>
    </header>
    <div class="insertTipoProductoAlimenticio" id="insertTipoProductoAlimenticio">
        <div class="container">
            <form class="insertTipoProductoAlimenticio" novalidate id="formInsertTipoProductoAlimenticio">
                <div>
                    <label for="nombre">
                        Nombre
                    </label>
                    <input type="text" id="nombreTipoProductoAlimenticio" required>
                </div>
                <div>
                    <label for="descripcion">
                        Descripción
                    </label>
                    <input type="text" id="descripcionTipoProductoAlimenticio" required>
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
    <div class="container" id="container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody id="listaTipoProductoAlimenticio"></tbody>
        </table>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/tipoProductoAlimenticio.js"></script>
</body>

</html>