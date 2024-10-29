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
    <title>Sección Producto Alimenticio</title>
    <style>
        body {
            margin: 20px;
        }

        input,
        select {
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
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaInactivosCuerpo"></tbody>
            </table>
        </div>
        <hr>
    </div><br>

    <div class="insertProductoAlimenticio" id="insertProductoAlimenticio">
        <div class="container">
            <form id="forminsertProductoAlimenticio" novalidate>
                <div>
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" required>
                </div>
                <div>
                    <label for="tipo">Tipo</label>
                    <select id="tipo" required></select>
                </div>
                <div>
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad">
                </div>
                <div>
                    <label for="fechaVencimiento">Fecha de Vencimiento</label>
                    <input type="date" id="fechaVencimiento" required>
                </div>
                <div>
                    <label for="proveedor">Proveedor</label>
                    <select id="proveedor" required></select>
                </div>
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
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="listaProductoAlimenticio"></tbody>
        </table>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/productoAlimenticio.js"></script>
</body>

</html>