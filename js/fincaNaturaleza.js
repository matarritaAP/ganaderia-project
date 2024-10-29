$(document).ready(function () {
    let fincaId = null; // Variable para almacenar el ID de la finca seleccionada

    inicializarEventos();

    function inicializarEventos() {
        const $listaInactivos = $('#listaInactivos');
        $listaInactivos.hide();

        cargarFincas(); // Cargar las fincas al iniciar
        
        $('#toggleInactivos').click(function () {
            const $listaInactivos = $('#listaInactivos');
            if ($listaInactivos.is(':visible')) {
                $listaInactivos.hide();
                $('#toggleInactivos').text('Ver Inactivos');
            } else {
                $listaInactivos.show();
                $('#toggleInactivos').text('Ocultar Inactivos');
                mostrarNaturalezasInactivas(); // Mostrar razas inactivas al abrir
            }
        });

        $('#fincaSelect').change(function () {
            const numPlano = $(this).val();
            if (numPlano === '0') {
                fincaId = null; // Resetear fincaId si se selecciona "Selecciona la finca a administrar"
                $('#listaNaturalezasAsignadas').html(''); // Limpiar la lista de naturalezas asignadas
                $('#availableNaturalezas').hide(); // Ocultar naturalezas disponibles
            } else {
                obtenerFincaIdPorPlano(numPlano);
            }
        });

        $('#mostrarNaturalezasDisponibles').on('click', function () {
            if (fincaId) {
                cargarNaturalezasDisponibles();
                $('#availableNaturalezas').show();
            } else {
                alert("Por favor, seleccione una finca.");
            }
        });

        $(document).on('click', '.agregarNaturaleza', function () {
            agregarNaturalezaFinca($(this).data('codigo'));
        });

        $(document).on('click', '.eliminarNaturaleza', function () {
            eliminarNaturalezaFinca($(this).data('codigo'));
        });

        $('#mostrarFormEspecifica').on('click', function () {
            cargarFormularioEspecifica();
        });
    }

    function cargarFormularioEspecifica() {

        if ($('#containerNaturalezaEspecifica').is(':empty')) {
            $.ajax({
                url: 'fincaNaturalezaEspecifica.php',
                type: 'GET',
                success: function (response) {
                    $('#containerNaturalezaEspecifica').html(response);
                    $('body > :not(#containerNaturalezaEspecifica, #mostrarFormEspecifica, #volver)').hide();
                    $('#mostrarFormEspecifica').text('Continuar administrando mi lista de naturalezas');
                },
                error: function (error) {
                    console.log('Error al cargar el formulario específico:', error);
                }
            });
        } else {
            $('body > :not(#containerNaturalezaEspecifica, #mostrarFormEspecifica, #volver)').show();
            $('#containerNaturalezaEspecifica').empty();
            $('#mostrarFormEspecifica').text('Crear nueva naturaleza específica');
        }
    }

    function cargarFincas() {
        $.ajax({
            url: '../action/fincaNaturalezaAction.php',
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
            url: '../action/fincaNaturalezaAction.php',
            type: 'POST',
            data: { option: 6, numPlano: numPlano },
            success: function (response) {
                fincaId = JSON.parse(response);
                if (fincaId) {
                    cargarNaturalezasAsignadas();
                }
            },
            error: function (error) {
                console.log('Error al obtener el ID de la finca:', error);
            }
        });
    }

    function cargarNaturalezasDisponibles() {
        $.ajax({
            type: 'POST',
            url: '../action/fincaNaturalezaAction.php',
            data: { option: 4 },
            success: function (response) {
                var naturalezas = JSON.parse(response);
                mostrarNaturalezasEnTabla('#listaNaturalezasDisponibles', naturalezas, 'agregarNaturaleza');
            }
        });
    }

    function cargarNaturalezasAsignadas() {
        if (!fincaId) return;
        $.ajax({
            url: '../action/fincaNaturalezaAction.php',
            type: 'POST',
            data: { option: 2, fincaId: fincaId },
            success: function (response) {
                var naturalezas = JSON.parse(response);
                var html = '';
                for (var i = 0; i < naturalezas.length; i++) {
                    html += '<tr>';
                    html += '<td>' + naturalezas[i].nombreNaturaleza + '</td>';
                    html += '<td>' + naturalezas[i].descripcionNaturaleza + '</td>';
                    html += '<td><button class="eliminarNaturaleza" data-codigo="' + naturalezas[i].codNaturaleza + '">Eliminar</button></td>';
                    html += '</tr>';
                }
                $('#listaNaturalezasAsignadas').html(html);
            },
            error: function (error) {
                console.log('Error al consultar naturalezas asignadas:', error);
            }
        });
    }

    function mostrarNaturalezasEnTabla(selector, naturalezas, botonClase) {
        var html = '';
        for (var i = 0; i < naturalezas.length; i++) {
            html += '<tr>';
            html += '<td>' + (naturalezas[i].tbnaturalezanombre) + '</td>';
            html += '<td>' + (naturalezas[i].tbnaturalezadescripcion || '') + '</td>';
            html += '<td><button class="' + botonClase + '" data-codigo="' + (naturalezas[i].tbnaturalezacodigo) + '">' + 'Agregar' + '</button></td>';
            html += '</tr>';
        }
        $(selector).html(html);
    }

    function agregarNaturalezaFinca(codNaturaleza) {
        if (!fincaId) {
            alert("Por favor, seleccione una finca.");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '../action/fincaNaturalezaAction.php',
            data: {
                option: 1,
                naturalezaCodigo: codNaturaleza,
                fincaId: fincaId
            },
            success: function (response) {
                alert(response);
                cargarNaturalezasAsignadas();
            }
        });
    }

    function eliminarNaturalezaFinca(codNaturaleza) {
        if (!fincaId) {
            alert("Por favor, seleccione una finca.");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '../action/fincaNaturalezaAction.php',
            data: {
                option: 3,
                naturalezaCodigo: codNaturaleza,
                fincaId: fincaId
            },
            success: function (response) {
                alert('Naturaleza eliminada de la finca');
                cargarNaturalezasAsignadas();
            }
        });
    }

    function mostrarNaturalezasInactivas() {
        if (!fincaId) return;
        let option = 7; 
        console.log(fincaId);
        $.ajax({
            url: '../action/fincaNaturalezaAction.php',
            data: { option: option, fincaId: fincaId },
            type: 'POST',
            success: function (response) {
                console.log(response);
                let list = JSON.parse(response);
                let template = '';
                list.forEach(servicio => {
                    template += `
                        <tr codigo="${servicio.codNaturaleza}">
                        <td>${servicio.codNaturaleza}</td>
                        <td>${servicio.nombreNaturaleza}</td>
                        <td>${servicio.descripcionNaturaleza}</td>
                        <td>
                            <button class="btnReactivar">Reactivar</button>
                        </td>
                        </tr>
                    `;
                });
                $('#listaNaturaleza').html(template);
            }
        });
    }

    // Acción para reactivar una raza
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código de la naturalezas
        console.log(codigo);
        const data = {
            option: 8, // Opción para reactivar la naturalezas
            naturalezaCodigo: codigo,
            fincaId: fincaId
        };

        let url = '../action/fincaNaturalezaAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            console.log(response);
            if (result == "1") {
                mostrarNaturalezasInactivas(); // Actualiza la lista de naturalezas inactivas
                cargarNaturalezasAsignadas();
                alert("Naturaleza reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});