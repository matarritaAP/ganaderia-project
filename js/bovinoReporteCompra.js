let bovinos = {};
let bovinoID = '';
let paginaActual = 1;
const elementosPorPagina = 20;

// Constante global para los encabezados
const HEADERS = [
    { text: 'Número', key: 'bovinoNumero' },
    { text: 'Nombre', key: 'bovinoNombre' },
    { text: 'Padre', key: 'bovinoPadre' },
    { text: 'Madre', key: 'bovinoMadre' },
    { text: 'Fecha de Nacimiento', key: 'bovinoFechaNacimiento' },
    { text: 'Fecha de Compra', key: 'bovinoFechaCompra' },
    { text: 'Precio', key: 'bovinoPrecio' },
    { text: 'Peso', key: 'bovinoPeso' },
    { text: 'Vendedor', key: 'bovinoVendedor' },
    { text: 'Raza', key: 'bovinoRaza' },
    { text: 'Estado', key: 'bovinoEstado' },
    { text: 'Género', key: 'bovinoGenero' },
    { text: 'Finca Asignada', key: 'bovinoFinca' },
    { text: 'Detalles Adicionales', key: 'bovinoDetalle' }
];

$(document).ready(function () {
    cargarDatosIniciales();

    // Filtrado en tiempo real
    $('#searchInput').on('input', function () {
        const searchTerm = $(this).val().toLowerCase();
        $('#listaBovinos tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
        });
        cargarGraficos();
    });
});

function cargarDatosIniciales() {
    cargarBovinos();
}

function cargarBovinos() {
    $.post('../action/bovinoCompraAction.php', { option: 2 }, function (response) {
        const list = JSON.parse(response);
        let template = '';
        bovinos = list;
        list.forEach(bovino => {
            template += crearFilaBovino(bovino);
        });

        $('#listaBovinos').html(template);
        paginarTabla(paginaActual);
        cargarGraficos();
    }).fail(function (error) {
        console.error('Error al cargar bovinos:', error);
    });
}

function crearFilaBovino(bovino) {
    return `
        <tr>
            <td class="bovinoNumero">${bovino.bovinonumero || 'Desconocido'}</td>
            <td class="bovinoNombre">${bovino.bovinonombre || 'Desconocido'}</td>
            <td class="bovinoPadre">${bovino.bovinopadre || 'Desconocido'}</td>
            <td class="bovinoMadre">${bovino.bovinomadre || 'Desconocido'}</td>
            <td class="bovinoFechaNacimiento">${bovino.bovinofechanacimiento || 'Desconocido'}</td>
            <td class="bovinoFechaCompra">${bovino.bovinofechacompra || 'Desconocido'}</td>
            <td class="bovinoPrecio">${bovino.bovinoprecio || 'Desconocido'}</td>
            <td class="bovinoPeso">${bovino.bovinopeso || 'Desconocido'}</td>
            <td class="bovinoVendedor">${bovino.bovinovendedor || 'Desconocido'}</td>
            <td class="bovinoRaza">${bovino.bovinoraza || 'Desconocido'}</td>
            <td class="bovinoEstado">${bovino.bovinoestado || 'Desconocido'}</td>
            <td class="bovinoGenero">${bovino.bovinogenero || 'Desconocido'}</td>
            <td class="bovinoFinca">${bovino.bovinofinca || 'Desconocido'}</td>
            <td class="bovinoDetalle">${bovino.bovinodetalle || 'Desconocido'}</td>
        </tr>
    `;
}

function paginarTabla(paginaActual) {
    const filas = $('#listaBovinos tr');
    const totalFilas = filas.length;
    filas.hide();
    filas.slice((paginaActual - 1) * elementosPorPagina, paginaActual * elementosPorPagina).show();
    $('#paginaActual').text(paginaActual);
}

function cambiarPagina(incremento) {
    const totalFilas = $('#listaBovinos tr').length;
    const totalPaginas = Math.ceil(totalFilas / elementosPorPagina);

    if ((paginaActual + incremento > 0) && (paginaActual + incremento <= totalPaginas)) {
        paginaActual += incremento;
        paginarTabla(paginaActual);
    }
}

function getExcelHeaders() {
    let headersHTML = '<tr>';
    HEADERS.forEach(header => {
        headersHTML += `<th>${header.text}</th>`;
    });
    headersHTML += '</tr>';
    return headersHTML;
}

function exportTableToExcel(filename) {
    var tableElement = document.getElementById("listaBovinos");

    var excelTemplate = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
        <x:Name>Sheet1</x:Name>
        <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>
        </x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>
        <body>
            <table>
                ${getExcelHeaders()}
                ${tableElement.innerHTML}
            </table>
        </body>
        </html>`;

    var blob = new Blob([excelTemplate], { type: "application/vnd.ms-excel" });
    var downloadLink = document.createElement("a");

    downloadLink.href = URL.createObjectURL(blob);
    downloadLink.download = filename || "reporte_bovinos_compras.xls";

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

function exportTableToPDF(filename, toExport) {
    const { jsPDF } = window.jspdf;
    var pdf = new jsPDF('p', 'pt', 'a4');
    var tableElement = document.getElementById(toExport);

    html2canvas(tableElement, {
        useCORS: true,
        scale: 2
    }).then(canvas => {
        var imgData = canvas.toDataURL('image/png');
        var imgWidth = 550;
        var pageHeight = 842;
        var imgHeight = (canvas.height * imgWidth) / canvas.width;
        var heightLeft = imgHeight;
        var position = 60;

        pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        pdf.save(filename || 'reporte.pdf');
    }).catch(err => {
        console.error('Error al generar PDF:', err);
    });
}

// Gráficos para los bovinos

function generarGraficoPrecioVsPeso() {
    let etiquetas = bovinos.map(bovino => bovino.bovinonombre);
    let datos = bovinos.map(bovino => ({
        x: bovino.bovinopeso || 0,
        y: bovino.bovinoprecio || 0
    }));

    const ctx = document.getElementById('graficoPrecioVsPeso').getContext('2d');
    new Chart(ctx, {
        type: 'scatter',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Peso vs Precio',
                data: datos,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Peso (kg)'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Precio (₡)'
                    }
                }
            }
        }
    });
}

function generarGraficoEvolucionPrecios() {
    let etiquetas = bovinos.map(bovino => bovino.bovinofechacompra);
    let precios = bovinos.map(bovino => bovino.bovinoprecio || 0);

    const ctx = document.getElementById('graficoEvolucionPrecios').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Evolución de Precios',
                data: precios,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function generarGraficoEstadoDistribucion() {
    let estadoCounts = {};

    bovinos.forEach(bovino => {
        estadoCounts[bovino.bovinoestado] = (estadoCounts[bovino.bovinoestado] || 0) + 1;
    });

    const etiquetas = Object.keys(estadoCounts);
    const cantidades = Object.values(estadoCounts);

    const ctx = document.getElementById('graficoEstadoDistribucion').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Distribución por Estado',
                data: cantidades,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    color: '#000',
                    anchor: 'end',
                    align: 'start',
                    formatter: (value, ctx) => {
                        let label = ctx.chart.data.labels[ctx.dataIndex];
                        return `${label}: ${value}`;
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}
function agrandarGrafico(graphId) {
    const modal = document.getElementById('graphModal');
    const enlargedGraph = document.getElementById('enlargedGraph');
    const graph = document.getElementById(graphId);


    enlargedGraph.width = 1000;
    enlargedGraph.height = 1000;

    const graphContext = enlargedGraph.getContext('2d');
    graphContext.clearRect(0, 0, enlargedGraph.width, enlargedGraph.height);
    graphContext.drawImage(graph, 0, 0, enlargedGraph.width, enlargedGraph.height);

    modal.style.display = 'block';

    const closeModalBtn = modal.querySelector(".close");
    closeModalBtn.onclick = function () {
        modal.style.display = "none";
    };

    const cancelButton = document.getElementById("cancelButton");
    cancelButton.onclick = function () {
        modal.style.display = "none";
    };

    const downloadButton = document.getElementById("downloadButton");
    downloadButton.onclick = function () {
        exportTableToPDF('reporte_bovinos_compras_grafico.pdf', 'modal-content');
    };
}

// Función para cerrar el modal
function closeModal() {
    const modal = document.getElementById('graphModal');
    modal.style.display = 'none';
}
// Cerrar el modal cuando se hace clic fuera del contenido del modal
window.onclick = function (event) {
    const modal = document.getElementById('graphModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};


function cargarGraficos() {
    generarGraficoPrecioVsPeso();
    generarGraficoEvolucionPrecios();
    generarGraficoEstadoDistribucion();
}