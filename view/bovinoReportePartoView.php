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
    <title>Sección Gestor de Bovinos</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de Reprodución de Bovinos (Partos)</h1>
        <hr>
    </header>
    <div class="container">
        <hr>
        <div class="graficos-row">
            <div id="container-disgenero" class="grafico-container" onclick="agrandarGrafico('graficoDistribucionGenero')">
                <h2>Gráfico Distribución de Género</h2>
                <canvas id="graficoDistribucionGenero"></canvas>
            </div>

            <div id="container-evolucionnacimientos" class="grafico-container" onclick="agrandarGrafico('graficoEvolucionNacimientos')">
                <h2>Evolución de Nacimiento en el Tiempo</h2>
                <canvas id="graficoEvolucionNacimientos"></canvas>
            </div>

            <div id="container-razanacidos" class="grafico-container" onclick="agrandarGrafico('graficoRazaNacidos')">
                <h2>Gráfico de Raza de los Bovinos Nacidos</h2>
                <canvas id="graficoRazaNacidos"></canvas>
            </div>
        </div>

        <!-- Ventana modal para agrandar gráficos -->
        <div id="graphModal" class="modal">
            <div class="modal-content" id="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <canvas id="enlargedGraph"></canvas>
            </div>
            <div class="modal-footer">
                <button id="downloadButton">Descargar</button>
                <button id="cancelButton">Cancelar</button>
            </div>
        </div>

    </div>
    <!-- Barra de búsqueda y filtros -->
    <div>
        <input type="text" id="searchInput" placeholder="Buscar bovinos..." />
        <button onclick="exportTableToExcel('reporte_bovinos_partos.xls')">Exportar a Excel</button>
        <button onclick="exportTableToPDF('reporte_bovinos_partos.pdf')">Exportar a PDF</button>
    </div>
    <hr>
    <div class="container" id="container">
        <!--Tabla para mostrar los datos-->
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Nombre</th>
                    <th>Padre</th>
                    <th>Madre</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Peso</th>
                    <th>Raza</th>
                    <th>Estado</th>
                    <th>Género</th>
                    <th>Finca Asignada</th>
                    <th>Detalles Adicionales</th>
                </tr>
            </thead>
            <tbody id="listaBovinos"></tbody>
        </table>
    </div>
    <hr>
    <!-- Controles de paginación -->
    <div id="paginacion">
        <button onclick="cambiarPagina(-1)">Anterior</button>
        <span id="paginaActual">1</span>
        <button onclick="cambiarPagina(1)">Siguiente</button>
    </div>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bovinoReporteParto.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
</body>

</html>