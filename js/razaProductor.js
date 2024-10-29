$(document).ready(function () {
    inicializarEventos();

    function inicializarEventos() {

        const $listaInactivos = $('#listaInactivos');
        $listaInactivos.hide();

        cargarRazasFavoritas();

        $('#toggleInactivos').click(function () {
            const $listaInactivos = $('#listaInactivos');
            if ($listaInactivos.is(':visible')) {
                $listaInactivos.hide();
                $('#toggleInactivos').text('Ver Inactivos');
            } else {
                $listaInactivos.show();
                $('#toggleInactivos').text('Ocultar Inactivos');
                mostrarRazasInactivas(); // Mostrar razas inactivas al abrir
            }
        });

        $('#mostrarRazasInactivas').on('click', function () {
            cargarRazasInactivas();
            $listaInactivos.toggle();
        });

        $('#mostrarRazasDisponibles').on('click', function () {
            cargarRazasDisponibles();
            $('#availableRazas').show();
        });

        $(document).on('click', '.agregarFavorita', function () {
            agregarRazaFavorita($(this).data('codigo'));
        });

        $(document).on('click', '.eliminarRazaFavorita', function () {
            eliminarRazaFavorita($(this).data('codigo'));
        });

        $('#mostrarFormEspecifica').on('click', function () {
            cargarFormularioEspecifica();
        });
    }

    function cargarFormularioEspecifica() {
        if ($('#containerRazaEspecifica').is(':empty')) {
            $.ajax({
                url: 'razaProductorEspecifica.php',
                type: 'GET',
                success: function (response) {
                    $('#containerRazaEspecifica').html(response);
                    $('body > :not(#containerRazaEspecifica, #mostrarFormEspecifica, #volver)').hide();
                    $('#mostrarFormEspecifica').text('Continuar administrando mi lista de razas');
                },
                error: function (error) {
                    console.log('Error al cargar el formulario específico:', error);
                }
            });
        } else {
            $('body > :not(#containerRazaEspecifica, #mostrarFormEspecifica, #volver)').show();
            $('#containerRazaEspecifica').empty();
            $('#mostrarFormEspecifica').text('Crear nueva raza específica');
        }
    }

    function cargarRazasDisponibles() {
        $.ajax({
            type: 'POST',
            url: '../action/razaProductorAction.php',
            data: { option: 4 },
            success: function (response) {
                var razas = JSON.parse(response);
                mostrarRazasEnTabla('#listaRazasDisponibles', razas, 'agregarFavorita');
            }
        });
    }

    function cargarRazasFavoritas() {
        $.ajax({
            url: '../action/razaProductorAction.php',
            type: 'POST',
            data: { option: 2 },
            success: function (response) {
                var razas = JSON.parse(response);
                var html = '';
                for (var i = 0; i < razas.length; i++) {
                    html += '<tr>';
                    html += '<td><button class="eliminarRazaFavorita" data-codigo="' + razas[i].codRaza + '">Eliminar</button></td>';
                    html += '<td>' + razas[i].nombreRaza + '</td>';
                    html += '<td>' + razas[i].descripcionRaza + '</td>';
                    html += '</tr>';
                }
                $('#listaRazasFavoritas').html(html);
            },
            error: function (error) {
                console.log('Error al consultar razas favoritas:', error);
            }
        });
    }

    function mostrarRazasEnTabla(selector, razas, botonClase) {
        var html = '';
        for (var i = 0; i < razas.length; i++) {
            html += '<tr>';
            html += '<td><button class="' + botonClase + '" data-codigo="' + (razas[i].tbrazacodigo) + '">' + 'Agregar' + '</button></td>';

            html += '<td>' + (razas[i].tbrazanombre) + '</td>';
            html += '<td>' + (razas[i].tbrazadescripcion || '') + '</td>';
            html += '</tr>';
        }
        $(selector).html(html);
    }

    function agregarRazaFavorita(codRaza) {
        $.ajax({
            type: 'POST',
            url: '../action/razaProductorAction.php',
            data: {
                option: 1,
                codRaza: codRaza
            },
            success: function (response) {
                alert(response);
                cargarRazasFavoritas();
            }
        });
    }

    function eliminarRazaFavorita(codRaza) {
        $.ajax({
            type: 'POST',
            url: '../action/razaProductorAction.php',
            data: {
                option: 3,
                codRaza: codRaza
            },
            success: function (response) {
                alert('Raza eliminada de tus favoritas');
                cargarRazasFavoritas();
            }
        });
    }

    function mostrarRazasInactivas() {
        let option = 5; // Opción para obtener razas inactivas

        $.ajax({
            url: '../action/razaProductorAction.php',
            data: { option: option },
            type: 'POST',
            success: function (response) {
                console.log(response);
                let list = JSON.parse(response);
                let template = '';
                list.forEach(raza => {
                    template += `
                        <tr codigo="${raza.codRaza}">
                        <td>${raza.codRaza}</td>
                        <td>${raza.nombreRaza}</td>
                        <td>${raza.descripcionRaza}</td>
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
        let codigo = $(element).attr('codigo'); // Obtiene el código de la raza
        const data = {
            option: 6, // Opción para reactivar la raza
            codigo: codigo
        };

        let url = '../action/razaProductorAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            console.log(result);
            if (result == "1") {
                mostrarRazasInactivas(); // Actualiza la lista de razas inactivas
                cargarRazasFavoritas();
                alert("Raza reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});
