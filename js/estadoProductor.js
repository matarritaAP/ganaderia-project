$(document).ready(function () {
    iniciarEventos();
        
    function iniciarEventos() {

        const $listaInactivos = $('#listaInactivos');
        $listaInactivos.hide();
        
        cargarEstadosFavoritos();
        
        $('#toggleInactivos').click(function () {
            const $listaInactivos = $('#listaInactivos');
            if ($listaInactivos.is(':visible')) {
                $listaInactivos.hide();
                $('#toggleInactivos').text('Ver Inactivos');
            } else {
                $listaInactivos.show();
                $('#toggleInactivos').text('Ocultar Inactivos');
                mostrarEstadosInactivos(); // Mostrar razas inactivas al abrir
            }
        });

        $('#mostrarEstadosInactivos').on('click', function () {
            cargarEstadosInactivos();
            $listaInactivos.toggle();
        });

        $('#mostrarEstadosDisponibles').on('click', function (){
            cargarEstadosDisponibles();
            $('#availableEstado').show();
        });

        $(document).on('click', '.agregarFavorita', function () {
            agregarEstadoAFavoritos($(this).data('codigo'));
        });

        $(document).on('click', '.eliminarEstadoFavorito', function (){
            eliminarEstadoFavorito($(this).data('codigo'));
        });

        $('#mostrarFormEspecifica').on('click', function (){
            cargarFormularioEspecifica();
        });

    }

    function cargarFormularioEspecifica() {
        if ($('#containerEstadoEspecifico').is(':empty')) {
            $.ajax({
                url: 'estadoProductorEspecifico.php',
                type: 'GET',
                success: function (response) {
                    $('#containerEstadoEspecifico').html(response);
                    $('body > :not(#containerEstadoEspecifico, #mostrarFormEspecifica, #volver)').hide();
                    $('#mostrarFormEspecifica').text('Continuar administrando mi lista de razas');
                },
                error: function (error) {
                    console.log('Error al cargar el formulario específico:', error);
                }
            });
        } else {
            $('body > :not(#containerEstadoEspecifico, #mostrarFormEspecifica, #volver)').show();
            $('#containerEstadoEspecifico').empty();
            $('#mostrarFormEspecifica').text('Crear nueva raza específica');
        }
    }


    function cargarEstadosDisponibles() {
        $.ajax({
            type: 'POST',
            url: '../action/estadoProductorAction.php',
            data: { option: 4 },
            success: function (response) {
                var estados = JSON.parse(response);
                mostrarEstadosEnTabla('#listaEstadosDisponibles', estados, 'agregarFavorita');
            }
        });
    }

    function cargarEstadosFavoritos() {
        $.ajax({
            url: '../action/estadoProductorAction.php',
            type: 'POST',
            data: { option: 2 },
            success: function (response) {
                console.log(response);
                var estados = JSON.parse(response);
                var html = '';
                for (var i = 0; i < estados.length; i++) {
                    html += '<tr>';
                    html += '<td><button class="eliminarEstadoFavorito" data-codigo="' + estados[i].codEstado + '">Eliminar</button></td>';
                    html += '<td>' + estados[i].nombreEstado + '</td>';
                    html += '<td>' + estados[i].descripcionEstado + '</td>';
                    html += '</tr>';
                }
                $('#listaEstadosFavoritos').html(html);
            },
            error: function (error) {
                console.log('Error al consultar estados favoritos:', error);
            }
        });
    }


    function mostrarEstadosEnTabla(selector, estados, botonClase) {
        var html = '';
        for (var i = 0; i < estados.length; i++) {
            html += '<tr>';
            html += '<td><button class="' + botonClase + '" data-codigo="' + estados[i].tbestadocodigo + '">Agregar</button></td>';

            html += '<td>' + (estados[i].tbestadonombre) + '</td>';
            html += '<td>' + (estados[i].tbestadodescripcion || '') + '</td>';
           
            html += '</tr>';
        }
        $(selector).html(html);
    }

    function agregarEstadoAFavoritos(codEstado) {
        //var codEstado = $(this).data('codigo');
        $.ajax({
            type: 'POST',
            url: '../action/estadoProductorAction.php',
            data: {
                option: 1,
                codEstado: codEstado
            },
            success: function (response) {
                alert(response);
                cargarEstadosFavoritos();
            }
        });
        $('#availableEstado').hide();

    }

    function eliminarEstadoFavorito(codEstado) {
        //var codEstado = $(this).data('codigo');
        $.ajax({
            type: 'POST',
            url: '../action/estadoProductorAction.php',
            data: {
                option: 3,
                codEstado: codEstado
                
            },
            success: function (response) {
                console.log("Código de estado: " + codEstado);
                //console.log("Datos enviados: ", data);
                alert('Estado eliminado de tus favoritas');
                cargarEstadosFavoritos();
            }
            

        });
    }


    function mostrarEstadosInactivos() {
        let option = 5; // Opción para obtener estados inactivas

        $.ajax({
            url: '../action/estadoProductorAction.php',
            data: { option: option },
            type: 'POST',
            success: function (response) {
                console.log(response);
                let list = JSON.parse(response);
                let template = '';
                list.forEach(raza => {
                    template += `
                        <tr codigo="${raza.codEstado}">
                        <td>${raza.codEstado}</td>
                        <td>${raza.nombreEstado}</td>
                        <td>${raza.descripcionEstado}</td>
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

    // Acción para reactivar un estado
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código del estado
        const data = {
            option: 6, // Opción para reactivar el estado
            codigo: codigo
        };

        let url = '../action/estadoProductorAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            console.log(result);
            if (result == "1") {
                mostrarEstadosInactivos(); // Actualiza la lista de estados inactivos
                cargarEstadosFavoritos();
                alert("Estado reactivado");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});
