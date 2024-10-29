

let bovinos = {};
let eventoID = '';

$(document).ready(function () {
    inicializarFormulario();
    cargarDatosIniciales();
    manejarEventos();
});

function inicializarFormulario() {
    // Manejar la inserción o actualización de un bovino
    $('#formInsertEvento').on('submit', manejarFormularioEvento);
}

function cargarDatosIniciales() {
    cargarBovinos();
    cargarEventos();
}

function cargarBovinos() {
    $.post('../action/bovinoEventoAction.php', { option: 3 }, function (response) {
        console.log("Respuesta del servidor:", response); // Imprimir la respuesta para depuración
        try {
            const list = response;
            let template = '<option value="">Seleccione un bovino</option>';

            list.forEach(bovino => {
                template += `<option value="${bovino.bovinoid}">${bovino.bovinonombre}</option>`;

            });

            $('#bovinoID').html(template);
        } catch (e) {
            console.error("Error al parsear JSON:", e);
        }
    }).fail(function (xhr, status, error) {
        console.error('Error al cargar estados:', error);
    });
}


function manejarFormularioEvento(e) {
    e.preventDefault();

    const nuevoEvento = obtenerDatosFormulario();

    const errorMensaje = validarEvento(nuevoEvento);
    if (errorMensaje) {
        alert(errorMensaje);
        return;
    }

    console.log("Datos del formulario:", nuevoEvento);

    $.ajax({
        url: '../action/bovinoEventoAction.php',
        data: {
            option: eventoID ? 5 : 1, //1 = insertar | 5 = actualizar
            eventoid: eventoID,
            ...nuevoEvento,
        },
        type: 'POST',
        success: function (response) {
            console.log("Respuesta del servidor:", response);
            try {
                const result = response;//nuevo
                if (result.success) {
                    procesarExitoFormulario();
                    setTimeout(cargarDatosIniciales, 500);
                } else {
                    alert('Error: ' + response);
                }
            } catch (error) {
                console.error('Error al parsear la respuesta:', e);
                alert('Error inesperado al procesar la solicitud.');
            }

        },
        error: function (xhr, status, error) {
            console.error('Error al insertar/actualizar eventos:', error);
        }
    });
}

function validarEvento(evento) {
    const validaciones = {
        bovinoID: 'El bovino es obligatorio',
        tipoEvento: 'El tipo de evento es obligatorio',
        //fecha: 'La fecha del evento es obligatoria'
    };

    for (const [campo, mensaje] of Object.entries(validaciones)) {
        if (!evento[campo]) {
            return mensaje;
        }
    }
    return null;
}

function obtenerDatosFormulario() {
    return {
        bovinoID: $('#bovinoID').val(),
        tipoEvento: $('#evento').val(),
        fechaEvento: $('#fechaEvento').val(),
        descripcion: $('#descripcion').val()
    };
}

function procesarExitoFormulario() {
    $('#formInsertEvento')[0].reset(); //Restablece el formulario
    habilitarCamposFormulario(true);
    $('#formInsertEvento button[type="submit"]').text('Guardar');
    eventoID = '';
    alert(eventoID ? 'Evento actualizado correctamente.' : 'Evento agregado Correctamente.');
}

function habilitarCamposFormulario(habilitar) {
    document.getElementById("bovinoID").disabled = !habilitar;
    document.getElementById("evento").disabled = !habilitar;
    document.getElementById("fechaEvento").disabled = !habilitar;
}

function manejarEventos() {
    // Manejar la edición de un bovino
    $(document).on('click', '.btnEditar', editarEvento);

    // Manejar la eliminación de un bovino
    $(document).on('click', '.btnEliminar', eliminarEvento);
}

function editarEvento() {
    const bovinoid = obtenerNumeroBovino(this);

    // Hacer la petición para obtener los datos del evento por el `bovinoid`
    $.post('../action/bovinoEventoAction.php', { option: 4, bovinoid: bovinoid }, function (response) {
        try {
            const evento = response;
            console.log("Datos del evento recibidos del servidor:", evento);
            asignarDatosEventoFormulario(evento);
        } catch (e) {
            console.error('Error al parsear la respuesta:', e);
            alert('Error al obtener los datos del evento.');
        }
    });
}

function eliminarEvento() {
    const eventoid = $(this).closest('tr').data('eventoid');

    if (!eventoid) {
        console.error("No se pudo obtener el ID del evento.");
        return;
    }

    if (confirm('¿Está seguro de que desea eliminar este evento?')) {
        $.post('../action/bovinoEventoAction.php', { option: 6, eventoid: eventoid }, function (response) {
            try {
                const result = response; // Analiza la respuesta para verificar si es exitosa
                if (result.success) {
                    alert('Evento eliminado correctamente!');
                    setTimeout(cargarDatosIniciales, 500);
                } else {
                    alert('Error al eliminar evento: ' + result.message);
                }
            } catch (error) {
                console.error('Error al parsear la respuesta:', error);
                alert('Error inesperado al procesar la solicitud de eliminación.');
            }
        });
    }
}


// Función para obtener el ID del bovino desde la fila
function obtenerNumeroBovino(element) {
    return $(element).closest('tr').find('.bovinoid').text().trim();
}

// Asignar los datos del evento al formulario para su edición
// function asignarDatosEventoFormulario(evento) {
    
//     console.log("Asignando datos al formulario:", evento);
//     $('#fechaEvento').val(evento.eventofecha);
//     $('#descripcion').val(evento.eventodescripcion);

//     // Cambiar el texto del botón de envío para indicar que estamos actualizando
//     $('#formInsertEvento button[type="submit"]').text('Actualizar');
//     eventoID = evento.bovinoid; // Guardar el bovinoID del evento para futuras actualizaciones
// }

function asignarDatosEventoFormulario(evento) {
    console.log("Asignando datos al formulario:", evento);
    
    // Asignar los datos al formulario
    $('#fechaEvento').val(evento.tbbovinoeventofecha);
    $('#descripcion').val(evento.tbbovinoeventodescripcion);

    // Cambiar el texto del botón de envío para indicar que estamos actualizando
    $('#formInsertEvento button[type="submit"]').text('Actualizar');

    // Guardar el ID del evento para futuras actualizaciones
    eventoID = evento.tbbovinoeventoid; // Asegúrate de que estás guardando el ID del evento, no del bovino
}









function cargarEventos() {
    $.post('../action/bovinoEventoAction.php', { option: 2 }, function (response) {
        try {
            const list = response; // Asegurarse de que la respuesta es un objeto JSON
            let template = '';

            list.forEach(evento => {
                template += crearFilaEvento(evento);
            });

            $('#listaEventos').html(template);
        } catch (e) {
            console.error('Error al parsear JSON:', e);
        }
    }).fail(function (error) {
        console.error('Error al cargar los eventos:', error);
    });
}

function crearFilaEvento(evento) {
    console.log(evento);
    return `
        <tr data-eventoid="${evento.eventoid}">
            <td style="display: none;" class="bovinoid">${evento.bovinoid}</td> <!-- ID oculto del bovino para la referencia -->
            <td class="bovinoNombre">${evento.bovinonombre || 'Desconocido'}</td>
            <td class="tipoEvento">${evento.eventotipo || 'Desconocido'}</td>
            <td class="fecha">${evento.eventofecha || 'Desconocido'}</td>
            <td class="descripcion">${evento.eventodescripcion || 'Desconocido'}</td>
            <td><button class="btnEditar">Editar</button></td>
            <td><button class="btnEliminar">Eliminar</button></td>
        </tr>
    `;
}


// function crearFilaEvento(evento) {
//     return `
//         <tr data-eventoid="${evento.tbbovinoeventoid}>
//             <td style="display: none;" class="bovinoid">${evento.bovinoid}</td> <!-- ID oculto del bovino para la referencia -->
//             <td class="bovinoNombre">${evento.bovinonombre || 'Desconocido'}</td>
//             <td class="tipoEvento">${evento.eventotipo || 'Desconocido'}</td>
//             <td class="fecha">${evento.eventofecha || 'Desconocido'}</td>
//             <td class="descripcion">${evento.eventodescripcion || 'Desconocido'}</td>
//             <td><button class="btnEditar">Editar</button></td>
//             <td><button class="btnEliminar">Eliminar</button></td>
//         </tr>
//     `;
// }

