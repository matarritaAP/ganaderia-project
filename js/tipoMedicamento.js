function validarFormulario() {
    return new Promise((resolve) => {
        let tipoMedicamento = document.getElementById('tipoMedicamento').value;

        if (!validarCamposTipoMedicamento(tipoMedicamento)) {
            resolve(false);
        } else if (!validarSoloTexto(tipoMedicamento)) {
            alert("El campo del tipo de medicamento solo debe contener texto, sin números.");
            resolve(false);
        } else {
            verificartipoMedicamentoRepetida(tipoMedicamento).then((tipoMedicamentoRepetidoValido) => {
                if (!tipoMedicamentoRepetidoValido) {
                    resolve(false);
                } else {
                    resolve(true);
                }
            });
        }
    });
}

function validarCamposTipoMedicamento() {
    const tipoMedicamento = $('#tipoMedicamento').val().trim();
    if (tipoMedicamento === "") {
        alert("Debe completar todos los campos.");
        return false;
    }
    return true;
}

function validarSoloTexto(texto) {
    const regex = /^[A-Za-z\s]+$/;
    return regex.test(texto);
}

function verificartipoMedicamentoRepetida(tipoMedicamento) {
    return new Promise((resolve) => {
        const data = { option: 6, tipoMedicamento: tipoMedicamento };
        let url = '../action/tipoMedicamentoAction.php';
        $.post(url, data, function (response) {
            if (response.trim() === "0") {
                resolve(true);
            } else {
                alert("El tipo de medicamento ya existe, intente con otro.");
                resolve(false);
            }
        });
    });
}

function obtenerTipoMedicamentos() {
    $.ajax({
        url: '../action/tipoMedicamentoAction.php',
        data: { option: 2 },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(tipo => {
                template += `
                    <tr tipoMedicamento="${tipo.tipoMedicamento}">
                        <td>${tipo.tipoMedicamento}</td>
                        <td>
                            <button class="btn btn-warning btnEdit">Editar</button>
                            <button class="btn btn-danger btnDelete">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $('#listaTipoMedicamentos').html(template);
        }
    });
}

$(document).ready(function () {
    obtenerTipoMedicamentos();

    $('#btnCancelar').click(function () {
        $('#formTipoMedicamento').trigger('reset');
        $('#btnGuardar').text('Registrar');
        $('#tipoMedicamentoAntiguo').val('');
    });

    $('#formTipoMedicamento').submit(function (e) {
        e.preventDefault();

        validarFormulario().then((valido) => {
            if (valido) {
                let tipoMedicamento = $('#tipoMedicamento').val();
                let tipoMedicamentoAntiguo = $('#tipoMedicamentoAntiguo').val();
                let option = tipoMedicamentoAntiguo ? 5 : 1; // 5 para actualización, 1 para inserción

                $.post('../action/tipoMedicamentoAction.php', {
                    option: option,
                    tipoMedicamento: tipoMedicamento,
                    tipoMedicamentoAntiguo: tipoMedicamentoAntiguo
                }, function (response) {
                    if (response.trim() === "1") {
                        obtenerTipoMedicamentos();
                        alert("Guardado");
                        $('#formTipoMedicamento').trigger('reset');
                        $('#btnGuardar').text('Registrar');
                    } else {
                        alert("Error: " + response);
                    }
                });
            }
        });
    });

    $(document).on('click', '.btnEdit', function () {
        let tipoMedicamento = $(this).closest('tr').attr('tipoMedicamento');
        $.post('../action/tipoMedicamentoAction.php', {
            option: 4,
            tipoMedicamento: tipoMedicamento
        }, function (response) {
            let tipo = JSON.parse(response);
            $('#tipoMedicamento').val(tipo.tipoMedicamento);
            $('#tipoMedicamentoAntiguo').val(tipo.tipoMedicamento);
            $('#btnGuardar').text('Actualizar');
        });
    });

    $(document).on('click', '.btnDelete', function () {
        let tipoMedicamento = $(this).closest('tr').attr('tipoMedicamento');
        if (confirm(`¿Está seguro de eliminar el tipo de medicamento ${tipoMedicamento}?`)) {
            $.post('../action/tipoMedicamentoAction.php', {
                option: 3,
                tipoMedicamento: tipoMedicamento
            }, function (response) {
                if (response.trim() === "1") {
                    obtenerTipoMedicamentos();
                    alert("Eliminado");
                } else {
                    alert("Error: " + response);
                }
            });
        }
    });
});

