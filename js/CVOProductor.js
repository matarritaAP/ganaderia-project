$(document).ready(function () {
    inicializarEventos();

    function inicializarEventos() {
        cargarCVOsFavoritos();

        $('#mostrarCVOsDisponibles').on('click', function () {
            cargarCVOsDisponibles();
            $('#availableCVO').show();
        });

        $(document).on('click', '.agregarFavorito', function () {
            agregarCVOFavorito($(this).data('numcvo'));
        });

        $(document).on('click', '.eliminarCVOFavorito', function () {
            eliminarCVOFavorito($(this).data('numcvo'));
        });
    }

    function cargarCVOsDisponibles() {
        $.ajax({
            type: 'POST',
            url: '../action/CVOProductorAction.php',
            data: { option: 4 },
            success: function (response) {
                console.log(response);
                var cvoList = JSON.parse(response);
                mostrarCVOsEnTabla('#listaCVOsDisponibles', cvoList, 'agregarFavorito');
            }
        });
    }

    function cargarCVOsFavoritos() {
        $.ajax({
            url: '../action/CVOProductorAction.php',
            type: 'POST',
            data: { option: 2 },
            success: function (response) {
                var cvoList = JSON.parse(response);
                var html = '';
                for (var i = 0; i < cvoList.length; i++) {
                    html += '<tr>';
                    html += '<td>' + cvoList[i].numCVO + '</td>';
                    html += '<td>' + cvoList[i].fechaEmision + '</td>';
                    html += '<td>' + cvoList[i].fechaVencimiento + '</td>';
                    html += '<td><button class="eliminarCVOFavorito" data-numcvo="' + cvoList[i].numCVO + '">Eliminar</button></td>';
                    html += '</tr>';
                }
                $('#listaCVOsFavoritos').html(html);
            },
            error: function (error) {
                console.log('Error al consultar CVOs favoritos:', error);
            }
        });
    }

    function mostrarCVOsEnTabla(selector, cvoList, botonClase) {
    var template = '';
    cvoList.forEach(CVO => {

        let timestamp = new Date().getTime(); // Obtiene la cantidad de milisegundos desde el epoch
        let imagenUrl = `${CVO.tbcvoimagen}?v=${timestamp}`;

        template += `
            <tr codigo="${CVO.tbcvonumero}">
                <td>${CVO.tbcvonumero}</td>
                <td>${CVO.tbcvofechaEmision}</td>
                <td>${CVO.tbcvofechaVencimiento}</td>
                <td><img src="${imagenUrl}" alt="Imagen" style="max-width: 100px; max-height: 100px;"></td>
                <td><button class="${botonClase}" data-numcvo="${CVO.tbcvonumero}">Agregar</button></td>
            </tr>
        `;
    });
    $(selector).html(template);
}


function agregarCVOFavorito(numCVO) {
    $.ajax({
        type: 'POST',
        url: '../action/CVOProductorAction.php',
        data: {
            option: 1,
            numCVO: numCVO
        },
        success: function (response) {
            // Mostrar mensaje basado en la respuesta del servidor
            if (response.trim() === "CVO añadido a tus favoritos") {
                alert('CVO añadido a tus favoritos');
            } else if (response.trim() === "Este CVO ya está en tus favoritos") {
                alert('Este CVO ya está en tus favoritos');
            } else {
                alert('Respuesta inesperada del servidor');
            }
            cargarCVOsFavoritos();
        },
        error: function (xhr, status, error) {
            console.log('Error:', error);
            alert('Error al añadir CVO a favoritos');
        }
    });
}


    function eliminarCVOFavorito(numCVO) {
        $.ajax({
            type: 'POST',
            url: '../action/CVOProductorAction.php',
            data: {
                option: 3,
                numCVO: numCVO
            },
            success: function (response) {
                console.log('Respuesta del servidor:', response);
                alert('CVO eliminado de tus favoritos');
                cargarCVOsFavoritos();
            },
            error: function (xhr, status, error) {
                console.log('Error:', error);
            }
        });
    }
    
});
