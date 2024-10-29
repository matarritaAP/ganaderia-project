function validarFormulario(edit) {
    return new Promise((resolve) => {
        let tipoUnidad = document.getElementById('tipoUnidad').value;

        if (!validarCamposUnidadMedida(tipoUnidad)) {
            resolve(false);
        } else if (!validarSoloTexto(tipoUnidad)) {
            alert("El campo del tipo de unidad solo debe contener texto, sin números.");
            resolve(false);
        } else {
            verificarUnidadRepetida(tipoUnidad).then((unidadRepetidaValida) => {
                if (!unidadRepetidaValida) {
                    resolve(false);
                } else {
                    resolve(true);
                }
            });
        }
    });
}


function validarCamposUnidadMedida(tipoUnidad) {
    if (tipoUnidad === "") {
        alert("Debe completar todos los campos.");
        return false;
    }
    return true;
}

function validarSoloTexto(texto) {
    const regex = /^[A-Za-z\s]+$/;
    return regex.test(texto);
}


function verificarUnidadRepetida(tipoUnidad) {
    return new Promise((resolve) => {
        const data = { option: 6, tipoUnidad: tipoUnidad };
        let url = '../action/unidadMedidaAction.php';
        $.post(url, data, function (response) {
            if (response.trim() === "0") {
                resolve(true);
            } else {
                alert("Unidad de medida ya existe, intente con otra.");
                resolve(false);
            }
        });
    });
}

function obtenerUnidadesMedida() {
    $.ajax({
        url: '../action/unidadMedidaAction.php',
        data: { option: 2 },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(unidad => {
                template += `
                    <tr tipoUnidad="${unidad.tipoUnidad}">
                        <td>${unidad.tipoUnidad}</td>
                        <td>
                            <button class="btn btn-warning btnEdit">Editar</button>
                            <button class="btn btn-danger btnDelete">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $('#listaUnidadesMedida').html(template);
        }
    });
}

$(document).ready(function () {
    obtenerUnidadesMedida();

    $('#btnCancelar').click(function () {
        $('#formUnidadMedida').trigger('reset');
        $('#btnGuardar').text('Registrar');
        $('#tipoUnidadAntiguo').val('');
    });

    let indicatorEdit = false;
    $('#formUnidadMedida').submit(function (e) {
        e.preventDefault(); // Evitar el envío normal del formulario

        validarFormulario(indicatorEdit).then((valido) => {
            if (valido) {
                let tipoUnidad = $('#tipoUnidad').val();
                let tipoUnidadAntiguo = $('#tipoUnidadAntiguo').val();
                let option = tipoUnidadAntiguo ? 5 : 1; // 5 para actualización, 1 para inserción

                $.post('../action/unidadMedidaAction.php', {
                    option: option,
                    tipoUnidad: tipoUnidad,
                    tipoUnidadAntiguo: tipoUnidadAntiguo
                }, function (response) {
                    if (response.trim() === "1") {
                        obtenerUnidadesMedida();
                        alert("Guardado");
                        $('#formUnidadMedida').trigger('reset');
                        $('#btnGuardar').text('Registrar');
                    } else {
                        alert("Error: " + response);
                    }
                });
                indicatorEdit = false;
            }
        });
    });

    $(document).on('click', '.btnEdit', function () {
        let tipoUnidad = $(this).closest('tr').attr('tipoUnidad');
        $.post('../action/unidadMedidaAction.php', {
            option: 4,
            tipoUnidad: tipoUnidad
        }, function (response) {
            let unidad = JSON.parse(response);
            $('#tipoUnidad').val(unidad.tipoUnidad);
            $('#tipoUnidadAntiguo').val(unidad.tipoUnidad);
            $('#btnGuardar').text('Actualizar');
            indicatorEdit = true;
        });
    });

    $(document).on('click', '.btnDelete', function () {
        let tipoUnidad = $(this).closest('tr').attr('tipoUnidad');
        if (confirm(`¿Está seguro de eliminar la unidad de medida ${tipoUnidad}?`)) {
            $.post('../action/unidadMedidaAction.php', {
                option: 3,
                tipoUnidad: tipoUnidad
            }, function (response) {
                if (response.trim() === "1") {
                    obtenerUnidadesMedida();
                    alert("Eliminado");
                } else {
                    alert("Error: " + response);
                }
            });
        }
    });
});
