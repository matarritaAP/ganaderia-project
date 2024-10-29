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
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Sección Tratamientos Bovinos</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>
<body>
    <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
    <br>
    <div>
        <hr>
        <button id="toggleInactivos">Ver Inactivos</button>
        <br /><br />
        <div id="listaInactivos">
            <!-- Tabla para los tratamientos inactivos -->
            <table id="tablaInactivos">
                <thead>
                    <tr>
                        <th>
                            Bovino 
                        </th>
                        <th>
                            Fecha aplicacion
                        </th>
                        <th>
                            Enfermedad 
                        </th>
                        <th>
                            Tipo Medicamento 
                        </th>
                        <th>
                            Dosis
                        </th>
                        
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaInactivosCuerpo"></tbody>
            </table>
        </div>
        <hr>
    </div><br>
    <div class="insertTratamientoBovino" id="insertTratamientoBovino"><!--Registro de tratamiento bovino-->
        <div class="container">
            <form class="insertTratamientoBovino" novalidate id="formInsertTratamientoBovino">
            <div>
                    <label for="bovinoId">Bovino</label>
                    <select id="bovinoId" required></select>
                </div>
                <div>
                    <label for="fechaAplicacion">
                        Fecha
                    </label>
                    <input type="date" id="fechaAplicacion" required>
                </div>
                <div>
                    <label for="enfermedadId">Enfermedad</label>
                    <input type="text" id="enfermedadId" required>
                </div>
                <div>
                    <label for="tipoMedicamentoId">Tipo de Medicamento</label>
                    <select id="tipoMedicamentoId" required></select>
                </div>
                <div style="display: flex; align-items: flex-start; margin-bottom: 1em;">
                <label for="dosis" style="margin-right: 10px;">Dosis</label>
            <textarea id="dosis" required rows="4" cols="45" style="flex: 1;"></textarea>
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
                        Bovino ID
                    </th>
                    <th>
                        Fecha Aplicacion
                    </th>
                    <th>
                        Enfermedad 
                    </th>
                    <th>
                        Tipo Medicamento
                    </th>
                    <th>
                        Dosis
                    </th>
                    <th>
                    Acciones
                    </th>
                </tr>
            </thead>
            <tbody id="listaTratamientos"></tbody>
        </table>
    </div>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/tratamientoBovino.js"></script>
</body>
</html>