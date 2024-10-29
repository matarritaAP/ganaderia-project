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
    });
});

function cargarDatosIniciales() {
    cargarBovinos();
}

function cargarBovinos() {
    $.post('../action/bovinoPartoAction.php', { option: 2 }, function (response) {
        const list = JSON.parse(response);
        let template = '';
        bovinos = list;
        list.forEach(bovino => {
            template += crearFilaBovino(bovino);
        });

        console.log("BOVINOS", list);
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
            <td class="bovinoPeso">${bovino.bovinopeso || 'Desconocido'}</td>
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
    downloadLink.download = filename || "reporte_bovinos_partos.xls";

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

function exportTableToPDF(filename) {
    const { jsPDF } = window.jspdf;
    var pdf = new jsPDF('p', 'pt', 'a4');
    var tableElement = document.getElementById('container');

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

        pdf.save(filename || 'reporte_bovinos_partos.pdf');
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

function generarGraficoDistribucionGenero() {
    let generoCounts = {};

    bovinos.forEach(bovino => {
        generoCounts[bovino.bovinogenero] = (generoCounts[bovino.bovinogenero] || 0) + 1;
    });

    const etiquetas = Object.keys(generoCounts);
    const cantidades = Object.values(generoCounts);

    const ctx = document.getElementById('graficoDistribucionGenero').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Distribución por Género',
                data: cantidades,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)', // Macho
                    'rgba(255, 159, 64, 0.2)'  // Hembra
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)'
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

function generarGraficoEvolucionNacimientos() {
    let etiquetas = bovinos.map(bovino => bovino.bovinofechanacimiento);
    let nacimientos = etiquetas.reduce((count, fecha) => {
        count[fecha] = (count[fecha] || 0) + 1;
        return count;
    }, {});

    etiquetas = Object.keys(nacimientos);
    let valores = Object.values(nacimientos);

    const ctx = document.getElementById('graficoEvolucionNacimientos').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Evolución de Nacimientos',
                data: valores,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Número de Nacimientos'
                    }
                }
            }
        }
    });
}

function generarGraficoRazaNacidos() {
    let razaCounts = {};

    bovinos.forEach(bovino => {
        razaCounts[bovino.bovinoraza] = (razaCounts[bovino.bovinoraza] || 0) + 1;
    });

    const etiquetas = Object.keys(razaCounts);
    const cantidades = Object.values(razaCounts);

    const ctx = document.getElementById('graficoRazaNacidos').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Raza de los Bovinos Nacidos',
                data: cantidades,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Raza'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Número de Bovinos'
                    }
                }
            }
        }
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
    generarGraficoDistribucionGenero();
    generarGraficoEvolucionNacimientos();
    generarGraficoRazaNacidos();
}