$(document).ready(function () {
    let fincaId = null; // Variable para almacenar el ID de la finca seleccionada

    inicializarEventos();

    function inicializarEventos() {
        const $listaInactivosPro = $('#listaInactivosPro');
        $listaInactivosPro.hide();

        cargarFincas(); // Cargar las fincas al iniciar

        $('#toggleInactivos').click(function () {
            const $listaInactivosPro = $('#listaInactivosPro');
            if ($listaInactivosPro.is(':visible')) {
                $listaInactivosPro.hide();
                $('#toggleInactivos').text('Ver Inactivos');
            } else {
                $listaInactivosPro.show();
                $('#toggleInactivos').text('Ocultar Inactivos');
                mostrarHerramientasInactivas(); // Mostrar razas inactivas al abrir
            }
        });

        $('#fincaSelect').change(function () {
            const numPlano = $(this).val();
            if (numPlano === '0') {
                fincaId = null; // Resetear fincaId si se selecciona "Selecciona la finca a administrar"
                $('#listaHerramientasAsignadas').html(''); // Limpiar la lista de herramientas asignadas
                $('#availableHerramientas').hide(); // Ocultar herramientas disponibles
            } else {
                obtenerFincaIdPorPlano(numPlano);
            }
        });

        $('#mostrarHerramientasDisponibles').on('click', function () {
            if (fincaId) {
                cargarHerramientasDisponibles();
                $('#availableHerramientas').show();
            } else {
                alert("Por favor, seleccione una finca.");
            }
        });

        $(document).on('click', '.agregarHerramienta', function () {
            agregarHerramientaFinca($(this).data('codigo'));
        });

        $(document).on('click', '.eliminarHerramienta', function () {
            eliminarHerramientaFinca($(this).data('codigo'));
        });
    }

    function cargarFincas() {
        $.ajax({
            url: '../action/fincaHerramientaAction.php',
            type: 'POST',
            data: { option: 5 },
            success: function (response) {
                const fincas = JSON.parse(response);
                if (Array.isArray(fincas)) {
                    let options = '<option value="0">Selecciona la finca a administrar</option>'; // Opción inicial
                    fincas.forEach(finca => {
                        options += `<option value="${finca.tbfincanumplano}">${finca.tbfincanumplano}</option>`;
                    });
                    $('#fincaSelect').html(options);
                } else {
                    console.error("La respuesta no es un array:", fincas);
                }
            },
            error: function (error) {
                console.log('Error al cargar fincas:', error);
            }
        });
    }

    function obtenerFincaIdPorPlano(numPlano) {
        $.ajax({
            url: '../action/fincaHerramientaAction.php',
            type: 'POST',
            data: { option: 6, numPlano: numPlano },
            success: function (response) {
                fincaId = JSON.parse(response);
                if (fincaId) {
                    mostrarHerramientasInactivas();
                    cargarHerramientasAsignadas();
                }
            },
            error: function (error) {
                console.log('Error al obtener el ID de la finca:', error);
            }
        });
    }

    function cargarHerramientasDisponibles() {
        $.ajax({
            type: 'POST',
            url: '../action/fincaHerramientaAction.php',
            data: { option: 4 },
            success: function (response) {
                var herramientas = JSON.parse(response);
                mostrarHerramientasEnTabla('#listaHerramientasDisponibles', herramientas, 'agregarHerramienta');
            }
        });
    }

    function cargarHerramientasAsignadas() {
        if (!fincaId) return;
        $.ajax({
            url: '../action/fincaHerramientaAction.php',
            type: 'POST',
            data: { option: 2, fincaId: fincaId },
            success: function (response) {
                var herramientas = JSON.parse(response);
                var html = '';
                for (var i = 0; i < herramientas.length; i++) {
                    html += '<tr>';
                    html += '<td>' + herramientas[i].nombreHerramienta + '</td>';
                    html += '<td>' + herramientas[i].descripcionHerramienta + '</td>';
                    html += '<td><button class="eliminarHerramienta" data-codigo="' + herramientas[i].codHerramienta + '">Eliminar</button></td>';
                    html += '</tr>';
                }
                $('#listaHerramientasAsignadas').html(html);
            },
            error: function (error) {
                console.log('Error al consultar herramientas asignadas:', error);
            }
        });
    }

    function mostrarHerramientasEnTabla(selector, herramientas, botonClase) {
        var html = '';
        for (var i = 0; i < herramientas.length; i++) {
            html += '<tr>';
            html += '<td>' + (herramientas[i].tbherramientanombre) + '</td>';
            html += '<td>' + (herramientas[i].tbherramientadescripcion || '') + '</td>';
            html += '<td><button class="' + botonClase + '" data-codigo="' + (herramientas[i].tbherramientacodigo) + '">' + 'Agregar' + '</button></td>';
            html += '</tr>';
        }
        $(selector).html(html);
    }

    function agregarHerramientaFinca(codHerramienta) {
        if (!fincaId) {
            alert("Por favor, seleccione una finca.");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '../action/fincaHerramientaAction.php',
            data: {
                option: 1,
                herramientaCodigo: codHerramienta,
                fincaId: fincaId
            },
            success: function (response) {
                alert(response);
                cargarHerramientasAsignadas();
            }
        });
    }

    function eliminarHerramientaFinca(codHerramienta) {
        if (!fincaId) {
            alert("Por favor, seleccione una finca.");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '../action/fincaHerramientaAction.php',
            data: {
                option: 3,
                herramientaCodigo: codHerramienta,
                fincaId: fincaId
            },
            success: function (response) {
                alert(response);
                //alert('Herramienta eliminada de la finca');
                cargarHerramientasAsignadas();
            }
        });
    }

    function mostrarHerramientasInactivas() {
        if (!fincaId) return;
        let option = 7; // Opción para obtener razas inactivas
        console.log(fincaId);
        $.ajax({
            url: '../action/fincaHerramientaAction.php',
            data: { option: option, fincaId: fincaId},
            type: 'POST',
            success: function (response) {
                console.log(response);
                let list = JSON.parse(response);
                let template = '';
                list.forEach(herramienta => {
                    template += `
                        <tr codigo="${herramienta.codHerramienta}">
                        <td>${herramienta.nombreHerramienta}</td>
                        <td>${herramienta.descripcionHerramienta}</td>
                        <td>
                            <button class="btnReactivar">Reactivar</button>
                        </td>
                        </tr>
                    `;
                });
                $('#listaInactivosProCuerpo').html(template);
            }
        });
    }

    // Acción para reactivar una raza
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código de la herramienta
        console.log(codigo);
        const data = {
            option: 8, // Opción para reactivar la herramienta
            herramientaCodigo: codigo, 
            fincaId: fincaId
        };

        let url = '../action/fincaHerramientaAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            console.log(response);
            if (result == "1") {
                mostrarHerramientasInactivas(); // Actualiza la lista de herramientas inactivas
                cargarHerramientasAsignadas();
                alert("Herramienta reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });

    $('#btnDivNuevaHerramienta').click(function () {
        $('#divHerramientas').hide();
        $('#herramientaPropia').show();
    });

    $('#cancelarHerramientaPropia').click(function () {
        $('#divHerramientas').show();
        $('#herramientaPropia').hide();
    });
    
});

