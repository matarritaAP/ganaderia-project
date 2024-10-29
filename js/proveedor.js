// Función para validar datos del formulario de registro
function validarFormulario(edit, correoAnterior) {
    return new Promise((resolve) => {
        let nombreComercial = document.getElementById('nombrecomercial').value;
        let correo = document.getElementById('correo').value;

        if (!validarCampos(nombreComercial, correo)) {
            resolve(false);
        } else {
            verificarNombresComercialesSimilares(nombreComercial).then((nombreSimilarValido) => {
                if (!nombreSimilarValido) {
                    resolve(false);
                } else {
                    if (!edit || (edit && correoAnterior !== correo)) {
                        verificarCorreoExistente(correo).then((correoValido) => {
                            resolve(correoValido);
                        });
                    } else {
                        resolve(true);
                    }
                }
            });
        }
    });
}

function validarCampos(nombreComercial, correo) {
    if (nombreComercial === "" || correo === "") {
        alert("Debe completar todos los datos requeridos");
        return false;
    }
    return true;
}

function verificarNombresComercialesSimilares(nombreComercial) {
    return new Promise((resolve) => {
        const dataSimilar = { option: 7, nombrecomercial: nombreComercial };
        let url = '../action/proveedorAction.php';
        $.post(url, dataSimilar, function (similarResponse) {
            try {
                let similares = JSON.parse(similarResponse);
                if (similares.length === 0) {
                    resolve(true);
                } else {
                    let nombresSimilares = similares.join(', ');
                    let confirmar = confirm("Existen proveedores con nombres comerciales similares: " + nombresSimilares + ". ¿Desea continuar?");
                    resolve(confirmar);
                }
            } catch (e) {
                console.error("Error al procesar la respuesta de nombres similares:", e);
                resolve(false);
            }
        });
    });
}

function verificarCorreoExistente(correo) {
    return new Promise((resolve) => {
        const data = { option: 6, correo: correo };
        let url = '../action/proveedorAction.php';
        $.post(url, data, function (response) {
            if (response.trim() === "0") {
                resolve(true);
            } else {
                alert("El correo ya existe");
                resolve(false);
            }
        });
    });
}

function obtenerProveedores() {
    let option = 2;

    $.ajax({
        url: '../action/proveedorAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(proveedor => {
                template += `
                    <tr correo="${proveedor.tbproveedorcorreo}">
                    <td>${proveedor.tbproveedornombrecomercial}</td>
                    <td>${proveedor.tbproveedorpropietario || ''}</td>
                    <td>${proveedor.tbproveedortelefonowhatsapp || ''}</td>
                    <td>${proveedor.tbproveedorcorreo}</td>
                    <td>${proveedor.tbproveedorsinpe || ''}</td>
                    <td>${proveedor.tbproveedortelefonofijo || ''}</td>
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td>
                    </tr>
                `;
            });
            $('#listaProveedor').html(template);
        },
        error: function (error) {
            alert("Error al cargar proveedores: " + error.statusText);
        }
    });
}

function mostrarProveedoresInactivos() {
    let option = 8;

    $.ajax({
        url: '../action/proveedorAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(proveedor => {
                template += `
                    <tr correo="${proveedor.tbproveedorcorreo}">
                    <td>${proveedor.tbproveedornombrecomercial}</td>
                    <td>${proveedor.tbproveedorpropietario || ''}</td>
                    <td>${proveedor.tbproveedortelefonowhatsapp || ''}</td>
                    <td>${proveedor.tbproveedorcorreo}</td>
                    <td>${proveedor.tbproveedorsinpe || ''}</td>
                    <td>${proveedor.tbproveedortelefonofijo || ''}</td>
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
            mostrarProveedoresInactivos(); // Mostrar razas inactivas al abrir
        }
    });
};

$(document).ready(function () {
    obtenerProveedores();
    comportamientoListaInactivos();

    let indicatorEdit = false;
    let correoAnterior = '';

    $("#cancelar").click(function () {
        $('#forminsertProveedor').trigger('reset'); // Limpiar formulario
        indicatorEdit = false;
        correoAnterior = '';
        document.getElementById("correo").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    $('#forminsertProveedor').submit(function (e) {
        e.preventDefault(); // Evita el envío del formulario

        validarFormulario(indicatorEdit, correoAnterior).then((valido) => {
            if (valido) {
                let nombreComercial = document.getElementById('nombrecomercial').value;
                let propietario = document.getElementById('propietario').value || null;
                let telefonoWhatsApp = document.getElementById('telefonowhatsapp').value || null;
                let correo = document.getElementById('correo').value;
                let sinpe = document.getElementById('sinpe').value || null;
                let telefonoFijo = document.getElementById('telefonofijo').value || null;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/proveedorAction.php";
                const data = {
                    option: opc,
                    nombrecomercial: nombreComercial,
                    propietario: propietario,
                    telefonowhatsapp: telefonoWhatsApp,
                    correo: correo,
                    sinpe: sinpe,
                    telefonofijo: telefonoFijo,
                    correoAnterior: correoAnterior
                };

                $.post(url, data, function (response) {
                    let result = response.trim();

                    // Validamos la respuesta de la petición
                    if (result == "1") {
                        obtenerProveedores();
                        alert("Guardado");
                        $('#forminsertProveedor').trigger('reset'); // Limpiar formulario
                        document.getElementById("correo").disabled = false;
                        $('.nuevoRegistro').text('Registrar');
                    } else {
                        alert("Error al realizar solicitud");
                    }
                });
                indicatorEdit = false;
                correoAnterior = ''; // Limpiar el correo anterior después de la actualización
            }
        });
    });

    // Acción del botón editar de la tabla
    $(document).on('click', '.btnEdit', function () {
        let element = $(this)[0].parentElement.parentElement; // Accedemos al elemento tr de la tabla
        let correo = $(element).attr('correo'); // Accedemos al atributo del tr para obtener el correo
        const data = { option: 4, correo: correo };
        let url = '../action/proveedorAction.php';

        $.post(url, data, function (response) {
            // Recibimos la respuesta y la convertimos a formato JSON
            const proveedor = JSON.parse(response);
            // Asignación de valores a los inputs del formulario
            $('#nombrecomercial').val(proveedor[0].nombrecomercial);
            $('#propietario').val(proveedor[0].propietario);
            $('#telefonowhatsapp').val(proveedor[0].telefonowhatsapp);
            $('#correo').val(proveedor[0].correo);
            $('#sinpe').val(proveedor[0].sinpe);
            $('#telefonofijo').val(proveedor[0].telefonofijo);
            // Cambiamos indicador de editar
            indicatorEdit = true;
            correoAnterior = proveedor[0].correo; // Guardamos el correo original
            // Cambiamos texto del botón submit
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("correo").disabled = false; // Permitimos la edición del correo
        });
    });

    // Acción para eliminar proveedor de la tabla
    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement; // Accedemos al elemento tr de la tabla
        let correo = $(element).attr('correo'); // Accedemos al atributo del tr para obtener el correo
        const data = { option: 3, correo: correo };
        let url = '../action/proveedorAction.php';

        // Alerta para verificar si se detecta el clic
        alert("Eliminar proveedor con correo: " + correo);

        $.post(url, data, function (response) {
            let result = response.trim();

            if (result == "1") {
                alert("Eliminado correctamente");

                // Refrescar la tabla de proveedores
                obtenerProveedores();
            } else {
                alert("Error al eliminar");
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
                // Alerta para detectar si hay un problema en la comunicación con el servidor
                alert("Error en la solicitud: " + textStatus + ", " + errorThrown);
            });
    });

    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let correo = $(element).attr('correo'); // Obtiene el código de la raza

        const data = {
            option: 9, // Opción para reactivar la raza
            correo: correo
        };

        let url = '../action/proveedorAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                mostrarProveedoresInactivos(); // Actualiza la lista de razas inactivas
                obtenerProveedores(); // Actualiza la lista principal de razas
                alert("Raza reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});
