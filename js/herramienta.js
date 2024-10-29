var actualUserType; // variable global

if (typeof actualUserType === 'undefined') {
    var actualUserType = 1;
}


function obtenerTipoUsuario() {
    return new Promise((resolve) => {
        $.post('../action/razaAction.php', { option: 0 }, function (response) {
            let data = JSON.parse(response);
            actualUserType = data.userType; // Asignar el tipo de usuario a la variable global
            resolve(actualUserType);
            console.log(response);
        });
    });
}

// Función para validar datos del formulario de registro
function validarFormulario(edit) {
    return new Promise((resolve) => {
        let nombre = document.getElementById('nombreherramienta').value;
        let descripcion = document.getElementById('descripcionherramienta').value;

        if (!validarCampos(nombre, descripcion)) {
            resolve(false);
        } else {
            verificarNombreSimilar(nombre).then((nombreSimilarValido) => {
                resolve(nombreSimilarValido);
            });
        }
    });
}

function validarCampos(nombre, descripcion) {
    if (nombre === "" || descripcion === "") {
        alert("Debe completar todos los datos");
        return false;
    }
    return true;
}

function verificarNombreSimilar(nombre) {
    return new Promise((resolve) => {
        const dataSimilar = { option: 7, nombre: nombre };
        let url = '../action/herramientaAction.php';
        $.post(url, dataSimilar, function (similarResponse) {
            try {
                let similarHerramientass = JSON.parse(similarResponse);
                if (similarHerramientass.length === 0) {
                    resolve(true);
                } else {
                    let nombresSimilares = similarHerramientass.join(', ');
                    let confirmar = confirm("Existen herramientas con nombres similares: " + nombresSimilares + ". ¿Desea continuar?");
                    resolve(confirmar);
                }
            } catch (e) {
                console.error("Error al procesar la respuesta de nombres similares:", e);
                resolve(false);
            }
        });
    });
}

function obtenerHerramienta() {
    let option = 2;

    $.ajax({
        url: '../action/herramientaAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(Heramienta => {
                template += `
                    <tr data-id="${Heramienta.tbherramientacodigo}">
                        <td>${Heramienta.tbherramientanombre}</td>
                        <td>${Heramienta.tbherramientadescripcion}</td>
                        <td>
                            <button class="btnEdit">Editar</button>
                        </td>
                        <td>
                            <button class="btndelete">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $('#listaHerramienta').html(template);
        }
    });
}

function mostrarHerramientasInactivas() {
    let option = 8; // Opción para obtener razas inactivas

    $.ajax({
        url: '../action/herramientaAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(heramienta => {
                template += `
                    <tr codigo="${heramienta.tbherramientacodigo}">
                    <td>${heramienta.tbherramientanombre}</td>
                    <td>${heramienta.tbherramientadescripcion}</td>
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

const $listaInactivos = $('#listaInactivos');
$listaInactivos.hide();

function comportamientoListaInactivos() {

    $('#toggleInactivos').click(function () {
        const $listaInactivos = $('#listaInactivos');
        if ($listaInactivos.is(':visible')) {
            $listaInactivos.hide();
            $('#toggleInactivos').text('Ver Inactivos');
        } else {
            $listaInactivos.show();
            $('#toggleInactivos').text('Ocultar Inactivos');
            mostrarHerramientasInactivas();
        }
    });
};

$(document).ready(function () {
    obtenerTipoUsuario();
    obtenerHerramienta();
    comportamientoListaInactivos();

    $("#cancelar").click(function () {
        $('#forminsertHerramienta').trigger('reset'); // Limpiar formulario
        indicatorEdit = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#forminsertHerramienta').submit(function (e) {
        e.preventDefault(); // Evita el envío del formulario

        validarFormulario(indicatorEdit).then((valido) => {
            if (valido) {
                let nombre = document.getElementById('nombreherramienta').value;
                let descripcion = document.getElementById('descripcionherramienta').value;
                let codigo = indicatorEdit ? $('#forminsertHerramienta').data('codigo') : null;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/herramientaAction.php";
                const data = {
                    option: opc,
                    codigo: codigo,
                    nombre: nombre,
                    descripcion: descripcion
                };

                // AJAX para registrar o editar herramienta
                $.post(url, data, function (response) {
                    let result = response.trim();
                    //alert(response);
                    // Validamos la respuesta de la petición
                    if (result == "1") {
                        obtenerHerramienta();
                        alert("Guardado");
                        $('#forminsertHerramienta').trigger('reset'); // Limpiar formulario
                        $('.nuevoRegistro').text('Registrar');
                    } else {
                        alert("Error al realizar solicitud");
                    }
                });
                indicatorEdit = false;
            }
        });
    });

    // Acción para eliminar herramienta de la tabla
    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement; // Accedemos al elemento tr de la tabla
        let codigo = $(element).data('id'); // Accedemos al data-id para obtener el código
        const data = {
            option: 3,
            codigo: codigo
        };

        let url = '../action/herramientaAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerHerramienta();
                alert("Eliminado");
            } else {
                alert("Error al eliminar");
            }
        });
    });

    // Acción del botón editar de la tabla
    $(document).on('click', '.btnEdit', function () {
        let element = $(this)[0].parentElement.parentElement; // Accedemos al elemento tr de la tabla
        let codigo = $(element).data('id'); // Accedemos al data-id para obtener el código
        const data = {
            option: 4,
            codigo: codigo
        };
        let url = '../action/herramientaAction.php';
        $.post(url, data, function (response) {
            //console.log("Respuesta del servidor:", response);
            // Recibimos la respuesta y la convertimos a formato JSON
            const Heramienta = JSON.parse(response);
            // Asignación de valores a los inputs del form
            $('#nombreherramienta').val(Heramienta[0].nombre);
            $('#descripcionherramienta').val(Heramienta[0].descripcion);
            // Guardar el código en un atributo data del formulario para usarlo en la edición
            $('#forminsertHerramienta').data('codigo', codigo);
            // Cambiamos indicador de editar 
            indicatorEdit = true;
            // Cambiamos texto del botón submit
            $('.nuevoRegistro').text('Actualizar');
        });
    });

    // Acción para reactivar una raza
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código de la herramienta

        const data = {
            option: 9, // Opción para reactivar la raza
            codigo: codigo
        };

        let url = '../action/herramientaAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                mostrarHerramientasInactivas(); // Actualiza la lista de herramientas inactivas
                obtenerHerramienta(); // Actualiza la lista principal de herramienta
                alert("Raza reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});
