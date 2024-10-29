async function validarFormulario() {
    let bovinoId = document.getElementById('bovinoId').value;
    let enfermedadId = document.getElementById('enfermedadId').value;
    let fechaAplicacion = document.getElementById('fechaAplicacion').value;
    let tipoMedicamentoId = document.getElementById('tipoMedicamentoId').value;
    let dosis = document.getElementById('dosis').value;
    if (!validarCampos(bovinoId, enfermedadId, fechaAplicacion, tipoMedicamentoId, dosis)) {
        return false;
    }
    return true;
}
function validarCampos(bovinoId, enfermedadId, fechaAplicacion, tipoMedicamentoId, dosis) {
    if (bovinoId === "" || enfermedadId === "" || fechaAplicacion === "" || tipoMedicamentoId === "" || dosis === "") {
        alert("Debe completar todos los campos.");
        return false;
    }
    return true;
}
async function verificarCodigoExistente(bovinoId) {
    try {
        const data = { option: 6, bovinoId: bovinoId };
        let url = '../actions/tratamientoBovinoAction.php';
        let response = await $.post(url, data);
        if (response.trim() === "0") {
            return true;
        } else {
            alert("El código ya existe.");
            return false;
        }
    } catch (e) {
        console.error("Error al verificar el código existente:", e);
        return false;
    }
}
function obtenerTratamientos() {
    let option = 2;
    $.ajax({
        url: '../action/tratamientoBovinoAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(tratamiento => {
                template += `
                    <tr tbtratamientobovinoId="${tratamiento.tbtratamientobovinoid}">
                    <td>${tratamiento.tbbovinoid}</td>
                    <td>${tratamiento.tbtratamientobovinofecha}</td>
                    <td>${tratamiento.tbtratamientobovinoenfermedadid}</td>
                    <td>${tratamiento.tbtratamientobovinotipomedicamentoid}</td>
                    <td>${tratamiento.tbtratamientobovinodosis}</td>
                    <td><button class="btnEdit">Editar</button></td>
                    <td><button class="btndelete">Eliminar</button></td>
                    </tr>
                `;
            });
            $('#listaTratamientos').html(template);
        }
    });
}
function cargarTipoMedicamento() {
    $.post('../action/tipoMedicamentoAction.php', { option: 2 }, function (response) {
        const list = JSON.parse(response);
        let template = '<option value="">Seleccione un tipo de medicamento</option>';
        list.forEach(tipoMedicamento => {
            tipoMedicamentos[tipoMedicamento.tipoMedicamento] = tipoMedicamento.tipoMedicamentoId;
            template += `<option value="${tipoMedicamento.tipoMedicamentoId}">${tipoMedicamento.tipoMedicamento}</option>`;
        });
        $('#tipoMedicamentoId').html(template);
    }).fail(function (xhr, status, error) {
        console.error('Error al cargar los tipos de medicamentos:', error);
    });
}
function cargarBovinos() {
    $.post('../action/bovinoPartoAction.php', { option: 10 }, function(response) {
        // Intentamos convertir la respuesta a un objeto JSON
        const bovinosCombinados = JSON.parse(response);
        let template = '<option value="">Seleccione un bovino</option>';
        // Iteramos sobre los bovinos combinados
        bovinosCombinados.forEach(bovino => {
            // Añadimos cada bovino al template del select
            template += `<option value="${bovino.bovinonumero}">${bovino.bovinonombre}</option>`;
        });
        // Actualizamos el contenido del select con los bovinos
        $('#bovinoId').html(template);
    }).fail(function(xhr, status, error) {
        // Manejo de errores en caso de que falle la solicitud
        console.error('Error al cargar los bovinos:', error);
    });
}
function cargarEnfermedades() {
    $.post('../action/enfermedadAction.php', { option: 2 }, function (response) {
        const list = JSON.parse(response);
        let template = '<option value="">Seleccione una enfermedad</option>';
        list.forEach(enfermedad => {
            template += `<option value="${enfermedad.tbenfermedadid}">${enfermedad.tbenfermedadnombre}</option>`;
        });
        $('#enfermedadId').html(template);
    }).fail(function (xhr, status, error) {
        console.error('Error al cargar las enfermedades:', error);
    });
}
function mostrarInactivos() {
    let option = 8;
    $.ajax({
        url: '../action/tratamientoBovinoAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(tratamiento => {
                template += `
                    <tr tbtratamientobovinoId="${tratamiento.tbtratamientobovinoid}">
                    <td>${tratamiento.tbbovinoid}</td>
                    <td>${tratamiento.tbtratamientobovinofecha}</td>
                    <td>${tratamiento.tbtratamientobovinoenfermedadid}</td>
                    <td>${tratamiento.tbtratamientobovinotipomedicamentoid}</td>
                    <td>${tratamiento.tbtratamientobovinodosis}</td>
                    <td><button class="btnReactivar">Reactivar</button></td>
                    </tr>
                `;
            });
            $('#listaInactivosCuerpo').html(template);
        }
    });
}
const $listaInactivos = $('#listaInactivos');
$listaInactivos.hide();
function comportamientoListaInactivos() {
    $('#toggleInactivos').click(function () {
        if ($listaInactivos.is(':visible')) {
            $listaInactivos.hide();
            $('#toggleInactivos').text('Ver Inactivos');
        } else {
            $listaInactivos.show();
            $('#toggleInactivos').text('Ocultar Inactivos');
            mostrarInactivos();
        }
    });
}
let tbtratamientobovinoId
let tipoMedicamentos = {};
let bovinos = {};
let enfermedades = {};
$(document).ready(function () {
    obtenerTratamientos();
    cargarBovinos();
    cargarTipoMedicamento();
    comportamientoListaInactivos();
    $("#cancelar").click(function () {
        $('#formInsertTratamientoBovino').trigger('reset');
        indicatorEdit = false;
        $('.nuevoRegistro').text('Registrar');
    });
    let indicatorEdit = false;
    $('#insertTratamientoBovino').submit(function (e) {
        e.preventDefault();
        validarFormulario().then((valido) => {
            if (valido) {
                let bovinoId = $('#bovinoId option:selected').text();
                let fechaAplicacion = document.getElementById('fechaAplicacion').value;
                let enfermedadId = document.getElementById('enfermedadId').value;
                let tipoMedicamento = $('#tipoMedicamentoId option:selected').text();
                let dosis = document.getElementById('dosis').value;
                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/tratamientoBovinoAction.php";
                const data = {
                    option: opc,
                    bovinoId: bovinoId,
                    tbtratamientobovinoId: tbtratamientobovinoId,
                    fechaAplicacion: fechaAplicacion,
                    enfermedadId: enfermedadId,
                    tipoMedicamento: tipoMedicamento,
                    dosis: dosis
                };
                $.post(url, data, function (response) {
                    let result = response.trim();
                    if (result == "1") {
                        alert("Tratamiento guardado correctamente.");
                        obtenerTratamientos();
                        $('#formInsertTratamientoBovino').trigger('reset');
                        $('.nuevoRegistro').text('Registrar');
                    } else {
                        alert("Error al guardar el tratamiento.");
                    }
                });
                indicatorEdit = false;
            }
        });
    });
    $(document).on('click', '.btndelete', function () {
        if (confirm("¿Está seguro de que desea eliminar este tratamiento?")) {
            let element = $(this)[0].parentElement.parentElement;
            tbtratamientobovinoId = $(element).attr('tbtratamientobovinoId');
            const data = {
                option: 3,
                tbtratamientobovinoId: tbtratamientobovinoId
            };
            let url = '../action/tratamientoBovinoAction.php';
            $.post(url, data, function (response) {
                let result = response.trim();
                if (result == "1") {
                    alert("Tratamiento eliminado correctamente.");
                    obtenerTratamientos();
                } else {
                    alert("Error al eliminar el tratamiento.");
                }
            });
        }
    });
    
    
    $(document).on('click', '.btnEdit', function () {
        let element = $(this)[0].parentElement.parentElement;
        tbtratamientobovinoId = $(element).attr('tbtratamientobovinoId');
        const data = {
            option: 4,
            tbtratamientobovinoId: tbtratamientobovinoId
        };
        let url = '../action/tratamientoBovinoAction.php';
        $.post(url, data, function (response) {
            let tratamiento = JSON.parse(response);
            $('#bovinoId').val(tratamiento[0].tbbovinoid);
            $('#fechaAplicacion').val(tratamiento[0].tbtratamientobovinofecha);
            $('#enfermedadId').val(tratamiento[0].tbtratamientobovinoenfermedadid);
            $('#tipoMedicamentoId').val(tratamiento[0].tbtratamientobovinotipomedicamentoid);
            $('#dosis').val(tratamiento[0].tbtratamientobovinodosis);
            indicatorEdit = true;
            $('.nuevoRegistro').text('Actualizar');
        });
    });
    
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement;
        let tbtratamientobovinoId = $(element).attr('tbtratamientobovinoId');
        const data = {
            option: 9,
            tbtratamientobovinoId: tbtratamientobovinoId
        };
        let url = '../action/tratamientoBovinoAction.php';
        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                alert("Tratamiento reactivado correctamente.");
                mostrarInactivos();
                obtenerTratamientos();
            } else {
                alert("Error al reactivar el tratamiento.");
            }
        });
    });
});