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
    <title>Sección Compra Producto Veterinarios</title>
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
    <div class="insertCompraProductoVeterinario" id="insertCompraProductoVeterinario"><!--Registro de Producto Veterinario-->
        <div class="container">
            <form class="insertCompraProductoVeterinario" novalidate id="forminsertCompraProductoVeterinario">         
            <input type="hidden" id="id">
                <div>
                    <label for="nombre">
                        Nombre
                    </label>
                    <input type="text" id="nombre" required>
                </div>
                <div>
                    <label for="fechacompra">
                        Fecha compra
                    </label>
                    <input type="date" id="fechacompra">
                </div>
                <div>
                    <label for="cantidad">
                    Cantidad
                    </label>
                    <input type="number" id="cantidad">
                </div>               
                    <label for="precio">
                    Precio $
                    </label>
                    <input type="number" id="precio">
                </div>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
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
                        
                    </th>
                    <th>
                       
                    </th>
                    <th>
                        Nombre - 
                    </th>
                    <th>
                        Fecha Compra - 
                    </th>
                    <th>
                        Cantidad - 
                    </th>
                    <th>
                        Precio
                    </th>
                </tr>
            </thead>
            <tbody id="listaCompraProductoVeterinario"></tbody>
        </table>
    </div>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/compraProductoVeterinario.js"></script>
</body>

</html>