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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección Fertilizantes</title>
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
                        <th>
                            Código ID
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
                            Dosificación
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaInactivosCuerpo"></tbody>
            </table>
        </div>
        <hr>
    </div><br>

    <div class="insertFertilizante" id="insertFertilizante"><!--Registro de fertilizante-->
        <div class="container">
            <form class="insertFertilizante" novalidate id="forminsertFertilizante">
                <div>
                    <label for="codigoid">
                        Código ID
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
                    <label for="dosificacion">
                        Dosificación
                    </label>
                    <input type="text" id="dosificacion" required>
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
                    <label for="proveedor">
                        Proveedor
                    </label>
                    <input type="text" id="proveedor" required>
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
                        Código ID
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
                        Dosificación
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
                </tr>
            </thead>
            <tbody id="listaFertilizantes"></tbody>
        </table>
    </div>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/fertilizantes.js"></script>
</body>

</html>