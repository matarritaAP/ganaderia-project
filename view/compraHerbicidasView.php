<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: ./login.php'); // !Admin -> Ir a login
    exit();
}
$script = str_replace('/view/', '/', $_SERVER['PHP_SELF']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($script) . '/index.php';
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sección de Compras de Herbicidas</title>
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
    <hr>
    <div class="insertHerbicida" id="insertHerbicida"><!--Registro de herbicida-->
        <div class="container">
            <form class="insertHerbicida" novalidate id="forminsertHerbicida">
                <div>
                    <label for="codigoid">
                        Codigo ID
                    </label>
                    <input type="text" id="codigoid" required>
                </div>
                <div>
                    <label for="nombre">
                        Nombre
                    </label>
                    <input type="text" id="nombre" required>
                </div>
                <div>
                    <label for="nombrecomun">
                        Nombre Común
                    </label>
                    <input type="text" id="nombrecomun" required>
                </div>
                <div>
                    <label for="presentacion">
                        Presentación
                    </label>
                    <input type="text" id="presentacion" required>
                </div>
                <div>
                    <label for="casacomercial">
                        Casa Comercial
                    </label>
                    <input type="text" id="casacomercial" required>
                </div>
                <div>
                    <label for="cantidad">
                        Cantidad
                    </label>
                    <input type="text" id="cantidad" required>
                </div>
                <div>
                    <label for="funcion">
                        Función
                    </label>
                    <input type="text" id="funcion" required>
                </div>
                <div>
                    <label for="aplicacion">
                        Aplicación
                    </label>
                    <input type="text" id="aplicacion" required>
                </div>
                <div>
                    <label for="descripcion">
                        Descripción
                    </label>
                    <input type="text" id="descripcion" required>
                </div>
                <div>
                    <label for="formula">
                        Fórmula
                    </label>
                    <input type="text" id="formula" required>
                </div>
                <div>
                    <label for="provedor">
                        Proveedor
                    </label>
                    <input type="text" id="provedor" required>
                </div>
                <div>
                    <label for="precio">
                        Precio
                    </label>
                    <input type="number" id="precio" required>
                </div>
                <div>
                    <label for="fechaCompra">
                        Fecha de Compra
                    </label>
                    <input type="date" id="fechaCompra" required>
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
    <br><br>
    <div class="container" id="container"><!--Tabla para mostrar los datos-->
        <table>
            <thead>
                <tr>
                    <th>
                        Codigo ID
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Nombre Común
                    </th>
                    <th>
                        Presentación
                    </th>
                    <th>
                        Casa Comercial
                    </th>
                    <th>
                        Cantidad
                    </th>
                    <th>
                        Función
                    </th>
                    <th>
                        Aplicación
                    </th>
                    <th>
                        Descripción
                    </th>
                    <th>
                        Fórmula
                    </th>
                    <th>
                        Proveedor
                    </th>
                    <th>
                        Precio
                    </th>
                    <th>
                        Fecha de Compra
                    </th>
                </tr>
            </thead>
            <tbody id="listaHerbicidas"></tbody>
        </table>
    </div>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/compraHerbicidas.js"></script>
</body>

</html>