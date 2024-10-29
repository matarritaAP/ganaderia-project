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
                mostrarServiciosInactivos(); // Mostrar razas inactivas al abrir
            }
        });

        $('#fincaSelect').change(function () {
            const numPlano = $(this).val();
            if (numPlano === '0') {
                fincaId = null; // Resetear fincaId si se selecciona "Selecciona la finca a administrar"
                $('#listaServiciosAsignados').html(''); // Limpiar la lista de servicios asignados
                $('#availableServicios').hide(); // Ocultar servicios disponibles
            } else {
                obtenerFincaIdPorPlano(numPlano);
            }
        });

        $('#mostrarServiciosDisponibles').on('click', function () {
            if (fincaId) {
                cargarServiciosDisponibles();
                $('#availableServicios').show();
            } else {
                alert("Por favor, seleccione una finca.");
            }
        });

        $(document).on('click', '.agregarServicio', function () {
            agregarServicioFinca($(this).data('codigo'));
        });

        $(document).on('click', '.eliminarServicio', function () {
            eliminarServicioFinca($(this).data('codigo'));
        });

        $('#mostrarFormEspecifico').on('click', function () {
            cargarFormularioEspecifico();
        });
    }

    function cargarFormularioEspecifico() {
        if ($('#containerServicioEspecifico').is(':empty')) {
            $.ajax({
                url: 'servicioFincaEspecifico.php',
                type: 'GET',
                success: function (response) {
                    $('#containerServicioEspecifico').html(response);
                    $('body > :not(#containerServicioEspecifico, #mostrarFormEspecifico, #volver)').hide();
                    $('#mostrarFormEspecifico').text('Continuar administrando mi lista de razas');
                },
                error: function (error) {
                    console.log('Error al cargar el formulario específico:', error);
                }
            });
        } else {
            $('body > :not(#containerServicioEspecifico, #mostrarFormEspecifico, #volver)').show();
            $('#containerServicioEspecifico').empty();
            $('#mostrarFormEspecifico').text('Crear nuevo servicio propio');
        }
    }

    function cargarFincas() {
        $.ajax({
            url: '../action/fincaServicioAction.php',
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
            url: '../action/fincaServicioAction.php',
            type: 'POST',
            data: { option: 6, numPlano: numPlano },
            success: function (response) {
                fincaId = JSON.parse(response);
                if (fincaId) {
                    cargarServiciosAsignados();
                }
            },
            error: function (error) {
                console.log('Error al obtener el ID de la finca:', error);
            }
        });
    }

    function cargarServiciosDisponibles() {
        $.ajax({
            type: 'POST',
            url: '../action/fincaServicioAction.php',
            data: { option: 4 },
            success: function (response) {
                var servicios = JSON.parse(response);
                mostrarServiciosEnTabla('#listaServiciosDisponibles', servicios, 'agregarServicio');
            }
        });
    }

    function cargarServiciosAsignados() {
        if (!fincaId) return;
        $.ajax({
            url: '../action/fincaServicioAction.php',
            type: 'POST',
            data: { option: 2, fincaId: fincaId },
            success: function (response) {
                var servicios = JSON.parse(response);
                var html = '';
                for (var i = 0; i < servicios.length; i++) {
                    html += '<tr>';
                    html += '<td>' + servicios[i].nombreServicio + '</td>';
                    html += '<td>' + servicios[i].descripcionServicio + '</td>';
                    html += '<td><button class="eliminarServicio" data-codigo="' + servicios[i].codServicio + '">Eliminar</button></td>';
                    html += '</tr>';
                }
                $('#listaServiciosAsignados').html(html);
            },
            error: function (error) {
                console.log('Error al consultar servicios asignados:', error);
            }
        });
    }

    function mostrarServiciosEnTabla(selector, servicios, botonClase) {
        var html = '';
        for (var i = 0; i < servicios.length; i++) {
            html += '<tr>';
            html += '<td>' + (servicios[i].tbservicionombre) + '</td>';
            html += '<td>' + (servicios[i].tbserviciodescripcion || '') + '</td>';
            html += '<td><button class="' + botonClase + '" data-codigo="' + (servicios[i].tbserviciocodigo) + '">' + 'Agregar' + '</button></td>';
            html += '</tr>';
        }
        $(selector).html(html);
    }

    function agregarServicioFinca(codServicio) {
        if (!fincaId) {
            alert("Por favor, seleccione una finca.");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '../action/fincaServicioAction.php',
            data: {
                option: 1,
                servicioCodigo: codServicio,
                fincaId: fincaId
            },
            success: function (response) {
                alert(response);
                cargarServiciosAsignados();
            }
        });
    }

    function eliminarServicioFinca(codServicio) {
        if (!fincaId) {
            alert("Por favor, seleccione una finca.");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '../action/fincaServicioAction.php',
            data: {
                option: 3,
                servicioCodigo: codServicio,
                fincaId: fincaId
            },
            success: function (response) {
                alert('Servicio eliminado de la finca');
                cargarServiciosAsignados();
            }
        });
    }

    function mostrarServiciosInactivos() {
        if (!fincaId) return;
        let option = 7;
        console.log(fincaId);
        $.ajax({
            url: '../action/fincaServicioAction.php',
            data: { option: option, fincaId: fincaId },
            type: 'POST',
            success: function (response) {
                console.log(response);
                let list = JSON.parse(response);
                let template = '';
                list.forEach(servicio => {
                    template += `
                        <tr codigo="${servicio.codServicio}">
                        <td>${servicio.codServicio}</td>
                        <td>${servicio.nombreServicio}</td>
                        <td>${servicio.descripcionServicio}</td>
                        <td>
                            <button class="btnReactivar">Reactivar</button>
                        </td>
                        </tr>
                    `;
                });
                $('#listaInactivosCuerpo').html(template);
            }
        });
    }

    // Acción para reactivar una raza
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código de la servicio
        console.log(codigo);
        const data = {
            option: 8, // Opción para reactivar el servicio
            servicioCodigo: codigo,
            fincaId: fincaId
        };

        let url = '../action/fincaServicioAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            console.log(response);
            if (result == "1") {
                mostrarServiciosInactivos(); // Actualiza la lista de servicios inactivos
                cargarServiciosAsignados();
                alert("Servicio reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});

