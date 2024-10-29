// Variables globales para almacenar datos de razas y estados
let razas = {};
let estados = {};
let toros = {};
let vacas = {};
let fincas = {};
let bovinoID = '';
let edicion = false;

$(document).ready(function () {
    inicializarFormulario();
    cargarDatosIniciales();
    manejarEventos();
});

function inicializarFormulario() {
    // Manejar la inserción o actualización de un bovino
    $('#formInsertBovino').on('submit', manejarFormularioBovino);
}

function alternarFechas(input1, input2) {
    input2.disabled = !!input1.value;
}

function manejarFormularioBovino(e) {
    e.preventDefault();

    const nuevoBovino = obtenerDatosFormulario();

    const errorMensaje = validarBovino(nuevoBovino);
    if (errorMensaje) {
        alert(errorMensaje);
        return;
    }

    console.log("Datos del formulario:", nuevoBovino);

    $.ajax({
        url: '../action/bovinoPartoAction.php',
        data: {
            option: bovinoID ? 5 : 1, // 1 para insertar, 5 para actualizar
            ...nuevoBovino,
        },
        type: 'POST',
        success: function (response) {
            if (response === "1") {
                procesarExitoFormulario();
                setTimeout(cargarBovinos, 500);
            } else {
                alert('Error: ' + response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error al insertar/actualizar bovino:', error);
        }
    });
}

function validarBovino(bovino) {
    const validaciones = {
        numero: 'El número de bovino es obligatorio.',
        nombre: 'El nombre del bovino es obligatorio.',
        fechaNacimiento: 'La fecha de parto es obligatoria.'
    };

    for (const [campo, mensaje] of Object.entries(validaciones)) {
        if (!bovino[campo]) {
            return mensaje;
        }
    }

    return null;
}


function obtenerDatosFormulario() {
    return {
        numero: $('#numero').val(),
        nombre: $('#nombre').val(),
        padreID: $('#padreID').val() || 'Desconocido',
        madreID: $('#madreID').val() || 'Desconocido',
        fechaNacimiento: $('#fechaNacimiento').val(),
        peso: $('#peso').val(),
        razaID: $('#razaID').val(),
        estadoID: bovinoID ? $('#estadoID').val() : 'Cría al Nacer',
        genero: $('#genero').val(),
        fincaID: $('#fincaID').val(),
        detalle: $('#detalle').val()
    };

}

function procesarExitoFormulario() {
    $('#formInsertBovino')[0].reset(); // Restablecer formulario
    habilitarCamposFormulario(true);
    $('#formInsertBovino button[type="submit"]').text('Guardar');
    bovinoID = '';
    alert(bovinoID ? 'Bovino actualizado correctamente.' : 'Bovino insertado correctamente.');
}

function habilitarCamposFormulario(habilitar) {
    document.getElementById("numero").disabled = !habilitar;
    document.getElementById("fechaNacimiento").disabled = !habilitar;
}

function manejarEventos() {

    // Manejar la edición de un bovino
    $(document).on('click', '.btnEditar', function () { edicion = true; console.log('NUEVO VALOR:', edicion); cargarEstados()});
    $(document).on('click', '.btnEditar', editarBovino);

    // Manejar la eliminación de un bovino
    $(document).on('click', '.btnEliminar', eliminarBovino);

    // Manejar la reactivación de un bovino
    $(document).on('click', '.btnReactivar', reactivarBovino);

    // Mostrar y ocultar lista de bovinos inactivos
    $('#toggleInactivos').click(toggleInactivos);
}

function editarBovino() {
    const numero = obtenerNumeroBovino(this);

    $.post('../action/bovinoPartoAction.php', { option: 4, numero: numero }, function (response) {
        const bovino = JSON.parse(response);
        asignarDatosFormulario(bovino);
    });
}

function eliminarBovino() {
    const numero = obtenerNumeroBovino(this);

    if (confirm('¿Está seguro de que desea eliminar este bovino?')) {
        $.post('../action/bovinoPartoAction.php', { option: 3, bovinoID: numero }, function (response) {
            if (response === "1") {
                alert('Bovino eliminado correctamente.');
                setTimeout(cargarBovinos, 500);
            } else {
                alert('Error al eliminar bovino: ' + response);
            }
        });
    }
}

function obtenerNumeroBovino(element) {
    return $(element).closest('tr').find('.bovinoNumero').text();
}

function asignarDatosFormulario(bovino) {
    $('#numero').val(bovino.bovinonumero).prop('disabled', true);
    $('#nombre').val(bovino.bovinonombre);
    $('#padreID').val(bovino.bovinopadre);
    $('#madreID').val(bovino.bovinomadre);
    if (toros[bovino.bovinopadre]) {
        $('#padreID option[value="' + bovino.bovinopadre + '"]').text(toros[bovino.bovinopadre]);
    } else {
        $('#padreID option[value=""]').text('Desconocido');
    }
    if (vacas[bovino.bovinomadre]) {
        $('#madreID option[value="' + bovino.bovinomadre + '"]').text(vacas[bovino.bovinomadre]);
    } else {
        $('#madreID option[value=""]').text('Desconocido');
    }
    $('#fechaNacimiento').val(bovino.bovinofechanacimiento);
    $('#peso').val(bovino.bovinopeso);
    $('#razaID').val(bovino.bovinoraza);
    $('#estadoID').val(bovino.bovinoestado);
    $('#genero').val(bovino.bovinogenero);
    $('#fincaID').val(bovino.bovinofinca);
    $('#detalle').val(bovino.bovinodetalle);
    bovinoID = bovino.bovinonumero;
    $('#formInsertBovino button[type="submit"]').text('Actualizar');
}

function reactivarBovino() {
    const numero = obtenerNumeroBovino(this);

    if (confirm('¿Está seguro de que desea reactivar este bovino?')) {
        $.post('../action/bovinoPartoAction.php', { option: 7, numero: numero }, function (response) {
            if (response === "1") {
                alert('Bovino reactivado correctamente.');
                mostrarBovinosInactivos();
                setTimeout(cargarBovinos, 500);
            } else {
                alert('Error al reactivar bovino: ' + response);
            }
        });
    }
}

function toggleInactivos() {
    const $listaInactivos = $('#listaInactivos');

    if ($listaInactivos.is(':visible')) {
        $listaInactivos.hide();
        $('#toggleInactivos').text('Ver Inactivos');
    } else {
        mostrarBovinosInactivos();
        $listaInactivos.show();
        $('#toggleInactivos').text('Ocultar Inactivos');
    }
}

function cargarDatosIniciales() {
    cargarRazas();
    cargarEstados();
    cargarToros();
    cargarVacas();
    cargarBovinos();
    cargarFincas();
}

function cargarRazas() {
    $.post('../action/razaProductorAction.php', { option: 2 }, function (response) {
        const list = JSON.parse(response);
        let template = '<option value="">Seleccione una raza</option>';

        list.forEach(raza => {
            razas[raza.nombreRaza] = raza.descripcionRaza;
            template += `<option value="${raza.nombreRaza}">${raza.nombreRaza}</option>`;
        });

        $('#razaID').html(template);
    }).fail(function (xhr, status, error) {
        console.error('Error al cargar razas:', error);
    });
}

function cargarEstados() {
    $.post('../action/estadoProductorAction.php', { option: 2 }, function (response) {
        const list = JSON.parse(response);
        let template = '';
    
        if (edicion) {
            template = '<option value="">Seleccione un estado</option>';
            list.forEach(estado => {
                template += `<option value="${estado.nombreEstado}">${estado.nombreEstado}</option>`;
            });
        } else {
            template = '<option value="Cría al Nacer">Cría al Nacer</option>';
        }

        $('#estadoID').html(template);
    }).fail(function (xhr, status, error) {
        console.error('Error al cargar estados:', error);
    });
}


function cargarToros() {
    $.post('../action/bovinoPartoAction.php', { option: 8 }, function (response) {
        const list = JSON.parse(response);
        let template = '<option value="">Seleccione un toro de padre</option>';
        console.log(list);
        list.forEach(toro => {
            toros[toro.bovinonombre] = toro.bovinonumero;
            template += `<option value="${toro.bovinoid}">${toro.bovinonombre}</option>`;
        });

        $('#padreID').html(template);
    }).fail(function (xhr, status, error) {
        console.error('Error al cargar estados:', error);
    });
}

function cargarVacas() {
    $.post('../action/bovinoPartoAction.php', { option: 9 }, function (response) {
        const list = JSON.parse(response);
        let template = '<option value="">Seleccione una vaca de madre</option>';

        list.forEach(toro => {
            toros[toro.bovinonombre] = toro.bovinonumero;
            template += `<option value="${toro.bovinoid}">${toro.bovinonombre}</option>`;
        });

        $('#madreID').html(template);
    }).fail(function (xhr, status, error) {
        console.error('Error al cargar estados:', error);
    });
}

function cargarBovinos() {
    $.post('../action/bovinoPartoAction.php', { option: 2 }, function (response) {
        const list = JSON.parse(response);
        let template = '';

        list.forEach(bovino => {
            template += crearFilaBovino(bovino);
        });

        console.log("BOVINOS", list);
        $('#listaBovinos').html(template);
    }).fail(function (error) {
        console.error('Error al cargar bovinos:', error);
    });
}

function cargarFincas() {
    $.post('../action/fincaAction.php', { option: 2 }, function (response) {
        const list = JSON.parse(response);
        let template = '<option value="">Seleccione la finca en donde asignará al bovino</option>';
        console.log(list);
        list.forEach(finca => {
            fincas[finca.tbfincaid] = finca.tbfincanumplano;
            template += `<option value="${finca.tbfincaid}">${finca.tbfincanumplano}</option>`;
        });

        $('#fincaID').html(template);
    }).fail(function (xhr, status, error) {
        console.error('Error al cargar estados:', error);
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
            <td><button class="btnEditar">Editar</button></td>
            <td><button class="btnEliminar">Eliminar</button></td>
        </tr>
    `;
}

function mostrarBovinosInactivos() {
    $.post('../action/bovinoPartoAction.php', { option: 6 }, function (response) {
        const list = JSON.parse(response);
        let template = '';

        list.forEach(bovino => {
            template += `
                <tr>
                    <td class="bovinoNumero">${bovino.bovinonumero}</td>
                    <td class="bovinoNombre">${bovino.bovinonombre}</td>
                    <td><button class="btnReactivar">Reactivar</button></td>
                </tr>
            `;
        });

        $('#listaInactivos').html(template);
    }).fail(function (error) {
        console.error('Error al cargar bovinos inactivos:', error);
    });
}
