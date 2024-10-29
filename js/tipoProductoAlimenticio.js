// Función para validar datos del formulario de registro
function validarFormulario(edit) {
    return new Promise((resolve) => {
        let nombre = document.getElementById('nombreTipoProductoAlimenticio').value;
        let descripcion = document.getElementById('descripcionTipoProductoAlimenticio').value;

        if (!validarCampos(nombre, descripcion)) {
            resolve(false);
        } else {
            verificarNombreSimilar(nombre).then((nombreSimilarValido) => {
                if (!nombreSimilarValido) {
                    resolve(false);
                } else {
                    resolve(true);
                }
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
        const dataSimilar = { option: 5, nombre: nombre };
        let url = '../action/tipoProductoAlimenticioAction.php';
        $.post(url, dataSimilar, function (similarResponse) {
            try {
                let similarProductos = JSON.parse(similarResponse);
                if (similarProductos.length === 0) {
                    resolve(true);
                } else {
                    let nombresSimilares = similarProductos.join(', ');
                    let confirmar = confirm("Existen tipos de productos con nombres similares: " + nombresSimilares + ". ¿Desea continuar?");
                    resolve(confirmar);
                }
            } catch (e) {
                console.error("Error al procesar la respuesta de nombres similares:", e);
                resolve(false);
            }
        });
    });
}

function obtenerTipoProductoAlimenticio() {
    let option = 2;

    $.ajax({
        url: '../action/tipoProductoAlimenticioAction.php',
        data: {
            option: option
        },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(tipoProducto => {
                template += `
                    <tr data-nombre="${tipoProducto.nombre}" data-descripcion="${tipoProducto.descripcion}">
                        <td>${tipoProducto.nombre}</td>
                        <td>${tipoProducto.descripcion}</td>
                        <td>
                            <button class="btnEdit">Editar</button>
                        </td>
                        <td>
                            <button class="btndelete">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $('#listaTipoProductoAlimenticio').html(template);
        }
    });
}


$(document).ready(function () {

    obtenerTipoProductoAlimenticio();

    $("#cancelar").click(function () {
        $('#formInsertTipoProductoAlimenticio').trigger('reset');//limpiar formulario
        indicatorEdit = false;
        $('#nombreTipoProductoAlimenticio').prop('disabled', false);
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#formInsertTipoProductoAlimenticio').submit(function (e) {
        e.preventDefault();//Evita el envío del formulario

        validarFormulario(indicatorEdit).then((valido) => {
            if (valido) {
                let nombreNuevo = $('#nombreTipoProductoAlimenticio').val();
                let descripcionNueva = $('#descripcionTipoProductoAlimenticio').val();

                let opc = indicatorEdit === false ? 1 : 4;

                // Obtenemos los datos antiguos almacenados anteriormente
                let nombreAntiguo = $('#nombreTipoProductoAlimenticio').data('nombreAntiguo');
                let descripcionAntigua = $('#descripcionTipoProductoAlimenticio').data('descripcionAntigua');

                let url = "../action/tipoProductoAlimenticioAction.php";
                const data = {
                    option: opc,
                    nombreAntiguo: nombreAntiguo,
                    descripcionAntigua: descripcionAntigua,
                    nombre: nombreNuevo,
                    descripcion: descripcionNueva
                }
                // AJAX para registrar o editar
                $.post(url, data, function (response) {
                    let result = response.trim();

                    // Validar la respuesta de la petición
                    if (result == "1") {
                        obtenerTipoProductoAlimenticio();
                        alert("Guardado");
                        $('#formInsertTipoProductoAlimenticio').trigger('reset');//limpiar formulario
                        $('#nombreTipoProductoAlimenticio').prop('disabled', false);
                        $('.nuevoRegistro').text('Registrar');
                    } else {
                        alert("Error al realizar solicitud");
                    }
                });
                indicatorEdit = false;
            }
        });
    });

    // Acción para eliminar Tipo de Producto Alimenticio de la tabla

    $(document).on('click', '.btndelete', function () {
        let element = $(this).closest('tr');
        let nombre = $(element).data('nombre');
        let descripcion = $(element).data('descripcion');

        const data = {
            option: 3,
            nombre: nombre,
            descripcion: descripcion
        }

        let url = '../action/tipoProductoAlimenticioAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerTipoProductoAlimenticio();
                alert("Eliminado");
            } else {
                alert("Error al eliminar");
            }
        });
    });


    // Acción del botón editar de la tabla
    $(document).on('click', '.btnEdit', function () {
        let element = $(this).closest('tr'); // Accedemos al tr correspondiente
        let nombreAntiguo = element.data('nombre'); // Obtenemos el valor de data-nombre
        let descripcionAntigua = element.data('descripcion'); // Obtenemos el valor de data-descripcion

        // Asignación de valores a los inputs del form
        $('#nombreTipoProductoAlimenticio').val(nombreAntiguo);
        $('#descripcionTipoProductoAlimenticio').val(descripcionAntigua);

        // Guardamos los valores antiguos en variables globales o en atributos ocultos
        $('#nombreTipoProductoAlimenticio').data('nombreAntiguo', nombreAntiguo);
        $('#descripcionTipoProductoAlimenticio').data('descripcionAntigua', descripcionAntigua);

        // Cambiamos indicador de editar 
        indicatorEdit = true;
        // Cambiamos texto del botón submit
        $('.nuevoRegistro').text('Actualizar');
        $('#nombreTipoProductoAlimenticio').prop('disabled', false); // Ahora el nombre es editable
    });

});
