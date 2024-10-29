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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Sección Gestor de eventos de Bovinos</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button>
        <hr>
        <h1>Administración de Eventos de Bovinos</h1>
    </header>

    <!-- Administracion de inserción de eventos de bovinos -->
    <div class="insertEvento" id="insertEvento">
        <div class="container">
            <form id="formInsertEvento" novalidate>
                <div>
                    <label for="bovinoID">Seleccione el bovino</label>
                    <select id="bovinoID" required></select>
                </div>
                <div>
                    <label for="evento">Seleccione el evento</label>
                    <select id="evento" required>
                        <option value="">Seleccione un evento</option>
                        <option value="Venta">Venta</option>
                        <option value="Robo">Robo</option>
                        <option value="Muerte">Muerte</option>
                    </select>
                </div>
                <div>
                    <label for="fechaEvento">Fecha del evento</label>
                    <input type="date" id="fechaEvento">
                </div>
                <div>
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion"></textarea>
                </div>
                <br />
                <div>
                <button type="submit" title="Guardar el evento">Guardar</button>

                </div>
            </form>
        </div>
    </div>
    <hr><br>
    <div class="container" id="container">
        <table>
            <thead>
                <tr>
                    <th>Bovino</th>
                    <th>Evento</th>
                    <th>Fecha del evento</th>
                    <th>Descripcion</th>
                </tr>
            </thead>
            <tbody id="listaEventos"></tbody>
        </table>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>

    <script src="../js/bovinoEvento.js"></script>
</body>

</html>