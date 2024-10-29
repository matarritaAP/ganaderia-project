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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tipos de Medicamento</title>
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
        <h1>Administración de los Tipos de Medicamentos del Sistema</h1>
        <hr>
    </header>
    <div class="container">
        <!-- Formulario para agregar o actualizar un tipo de medicamento -->
        <form id="formTipoMedicamento" novalidate>
            <div class="form-group">
                <label for="tipoMedicamento">Tipo de Medicamento</label>
                <input type="text" class="form-control" id="tipoMedicamento" required>
                <input type="hidden" id="tipoMedicamentoAntiguo">
            </div>
            <button type="submit" class="btn btn-primary" id="btnGuardar">Registrar</button>
            <button type="button" class="btn btn-secondary" id="btnCancelar">Cancelar</button>
        </form>

        <hr>

        <!-- Tabla para mostrar los tipos de medicamento -->
        <h4>Lista de Tipos de Medicamento</h4>
        <table>
            <thead>
                <tr>
                    <th>Tipo de Medicamento</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="listaTipoMedicamentos">
                <!-- Aquí se cargarán dinámicamente los tipos de medicamento -->
            </tbody>
        </table>
    </div>
    <hr>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/tipoMedicamento.js"></script>
</body>

</html>