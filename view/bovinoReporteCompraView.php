<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: ./login.php');
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
    <title>Reportes de Compra de Bovinos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button>
        <hr>
        <h1>Administración de Reportes Compra de Bovinos</h1>
        <hr>
    </header>

    <div class="container">
        <hr>
        <div class="graficos-row">
            <div id="container-preciopeso" class="grafico-container" onclick="agrandarGrafico('graficoPrecioVsPeso')">
                <h2>Gráfico de Precio vs Peso</h2>
                <canvas id="graficoPrecioVsPeso"></canvas>
            </div>

            <div id="container-evolucionpesos" class="grafico-container" onclick="agrandarGrafico('graficoEvolucionPrecios')">
                <h2>Evolución de Precios</h2>
                <canvas id="graficoEvolucionPrecios"></canvas>
            </div>

            <div id="container-distrestados" class="grafico-container" onclick="agrandarGrafico('graficoEstadoDistribucion')">
                <h2>Distribución del Estado</h2>
                <canvas id="graficoEstadoDistribucion"></canvas>
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
    <hr>
    <div class="filtros">
        <input type="text" id="searchInput" placeholder="Buscar bovinos..." />
        <button onclick="exportTableToExcel('reporte_bovinos_compras.xls')">Exportar a Excel</button>
        <button onclick="exportTableToPDF('reporte_bovinos_compras.pdf', 'container')">Exportar a PDF</button>
    </div>
    <hr>
    <div id="container">
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Nombre</th>
                    <th>Padre</th>
                    <th>Madre</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Fecha de Compra</th>
                    <th>Precio</th>
                    <th>Peso</th>
                    <th>Vendedor</th>
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
    <div id="paginacion">
        <button onclick="cambiarPagina(-1)">Anterior</button>
        <span id="paginaActual">1</span>
        <button onclick="cambiarPagina(1)">Siguiente</button>
    </div>
    </div>

    <hr>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bovinoReporteCompra.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
</body>

</html>