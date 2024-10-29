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
    <title>Sección Proveedor</title>
    <style>
        body {
            margin: 20px;
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
    <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
    <br>

    <div>
        <hr>
        <button id="toggleInactivos">Ver Inactivos</button>
        <br /><br />
        <div id="listaInactivos">
            <!-- Tabla para las razas inactivas -->
            <table id="tablaInactivos">
                <thead>
                    <tr>
                        <th>Nombre Comercial</th>
                        <th>Propietario</th>
                        <th>Teléfono WhatsApp</th>
                        <th>Correo</th>
                        <th>SINPE</th>
                        <th>Teléfono Fijo</th>
                    </tr>
                </thead>
                <tbody id="listaInactivosCuerpo"></tbody>
            </table>
        </div>
        <hr>
    </div><br>

    <div class="insertProveedor" id="insertProveedor"><!--Registro de proveedor-->
        <div class="container">
            <form class="insertProveedor" novalidate id="forminsertProveedor">
                <div>
                    <label for="nombrecomercial">
                        Nombre Comercial
                    </label>
                    <input type="text" id="nombrecomercial" required>
                </div>
                <div>
                    <label for="propietario">
                        Propietario
                    </label>
                    <input type="text" id="propietario">
                </div>
                <div>
                    <label for="telefonowhatsapp">
                        Teléfono WhatsApp
                    </label>
                    <input type="text" id="telefonowhatsapp">
                </div>
                <div>
                    <label for="correo">
                        Correo
                    </label>
                    <input type="email" id="correo" required>
                </div>
                <div>
                    <label for="sinpe">
                        SINPE
                    </label>
                    <input type="text" id="sinpe">
                </div>
                <div>
                    <label for="telefonofijo">
                        Teléfono Fijo
                    </label>
                    <input type="text" id="telefonofijo">
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
                        Nombre Comercial
                    </th>
                    <th>
                        Propietario
                    </th>
                    <th>
                        Teléfono WhatsApp
                    </th>
                    <th>
                        Correo
                    </th>
                    <th>
                        SINPE
                    </th>
                    <th>
                        Teléfono Fijo
                    </th>
                </tr>
            </thead>
            <tbody id="listaProveedor"></tbody>
        </table>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/proveedor.js"></script>
</body>

</html>