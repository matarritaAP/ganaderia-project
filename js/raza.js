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

function validarFormulario(edit) {
    return new Promise((resolve) => {
        let codigo = document.getElementById('codigoraza').value;
        let nombre = document.getElementById('nombreraza').value;
        let descripcion = document.getElementById('descripcionraza').value;

        // Si el código es requerido o si el usuario no es productor
        let isCodigoRequired = actualUserType !== 1; // actualUserType = 1 para productor

        if (!validarCampos(codigo, nombre, descripcion, isCodigoRequired)) {
            resolve(false);
        } else {
            verificarNombreSimilar(nombre).then((nombreSimilarValido) => {
                if (!nombreSimilarValido) {
                    resolve(false);
                } else {
                    if (!edit && isCodigoRequired) {
                        verificarCodigoExistente(codigo).then((codigoValido) => {
                            resolve(codigoValido);
                        });
                    } else {
                        resolve(true);
                    }
                }
            });
        }
    });
}

function validarCampos(codigo, nombre, descripcion, isCodigoRequired) {
    if ((isCodigoRequired != 1 && codigo === "") || nombre === "" || descripcion === "") {
        alert("Debe completar todos los datos");
        return false;
    }
    return true;
}

function verificarNombreSimilar(nombre) {
    return new Promise((resolve) => {
        const dataSimilar = { option: 7, nombre: nombre };
        let url = '../action/razaAction.php';
        $.post(url, dataSimilar, function (similarResponse) {
            try {
                let similarRazas = JSON.parse(similarResponse);
                if (similarRazas.length === 0) {
                    resolve(true);
                } else {
                    let nombresSimilares = similarRazas.join(', ');
                    let confirmar = confirm("Existen razas con nombres similares: " + nombresSimilares + ". ¿Desea continuar?");
                    resolve(confirmar);
                }
            } catch (e) {
                console.error("Error al procesar la respuesta de nombres similares:", e);
                resolve(false);
            }
        });
    });
}

function verificarCodigoExistente(codigo) {
    return new Promise((resolve) => {
        const data = { option: 6, codigo: codigo };
        let url = '../action/razaAction.php';
        $.post(url, data, function (response) {
            if (response.trim() === "0") {
                resolve(true);
            } else {
                alert("El código ya existe");
                resolve(false);
            }
        });
    });
}

function obtenerRaza() {

    let option = 2;

    $.ajax({
        url: '../action/razaAction.php',
        data: {
            option: option
        },
        type: 'POST',
        success: function (response) {

            let list = JSON.parse(response);
            let template = '';
            list.forEach(raza => {
                template += `
                    <tr codigo="${raza.tbrazacodigo}">
                    <td>${raza.tbrazacodigo}</td>
                    <td>${raza.tbrazanombre}</td>
                    <td>${raza.tbrazadescripcion}</td>
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td>
                    </tr>
                `
            });
            $('#listaRaza').html(template);
        }
    });
}

function mostrarRazasInactivas() {
    let option = 8; // Opción para obtener razas inactivas

    $.ajax({
        url: '../action/razaAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(raza => {
                template += `
                    <tr codigo="${raza.tbrazacodigo}">
                    <td>${raza.tbrazacodigo}</td>
                    <td>${raza.tbrazanombre}</td>
                    <td>${raza.tbrazadescripcion}</td>
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

function comportamientoListaInactivos() {
    
    $('#toggleInactivos').click(function () {
        const $listaInactivos = $('#listaInactivos');
        if ($listaInactivos.is(':visible')) {
            $listaInactivos.hide();
            $('#toggleInactivos').text('Ver Inactivos');
        } else {
            $listaInactivos.show();
            $('#toggleInactivos').text('Ocultar Inactivos');
            mostrarRazasInactivas(); // Mostrar razas inactivas al abrir
        }
    });
};

$(document).ready(function () {

    obtenerTipoUsuario();
    obtenerRaza();
    comportamientoListaInactivos();

    // Botón para ver razas inactivas
    $('#verInactivos').click(function () {
        mostrarRazasInactivas();
    });

    $("#cancelar").click(function () {
        $('#forminsertRaza').trigger('reset');//limpiar formulario
        indicatorEdit = false;
        document.getElementById("codigoraza").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#forminsertRaza').submit(function (e) {
        e.preventDefault()//Evita el envio del formulario

        validarFormulario(indicatorEdit).then((valido) => {

            if (valido) {
                let codigo = document.getElementById('codigoraza').value;
                let nombre = document.getElementById('nombreraza').value;
                let descripcion = document.getElementById('descripcionraza').value;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/razaAction.php";
                const data = {
                    option: opc,
                    codigo: codigo,
                    nombre: nombre,
                    descripcion: descripcion
                }
                //ajax para registrar o editar XD
                $.post(url, data, function (response) {
                    let result = response.trim();

                    // validamos la respuesta de la peticion

                    if (result == "1") {
                        obtenerRaza();
                        alert("Guardado");
                        $('#forminsertRaza').trigger('reset');//limpiar formulario
                        document.getElementById("codigoraza").disabled = false;
                        $('.nuevoRegistro').text('Registrar');
                    }
                    else {
                        alert("Error al realizar solicitud");
                    }
                });
                indicatorEdit = false;
            }
        });
    });

    //accion para eliminar Raza de la tabla
    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement;//accedemos al elemento tr de la tabla
        let codigo = $(element).attr('codigo');//accedemos al atributo del tr para obtener el codigo
        const data = {
            option: 3,
            codigo: codigo
        }
        
        let url = '../action/razaAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerRaza();
                alert("Eliminado");
            } else {
                alert("Error al eliminar");
            }
        });
    });

    //accion del boton editar de la tabla
    $(document).on('click', '.btnEdit', function () {
        let element = $(this)[0].parentElement.parentElement;//accedemos al elemento tr de la tabla
        let codigo = $(element).attr('codigo');//accedemos al atributo del tr para obtener el codigo
        const data = {
            option: 4,
            codigo: codigo
        }
        let url = '../action/razaAction.php';
        $.post(url, data, function (response) {
            // recivimos la respuesta y la convertimos a formato json
            const raza = JSON.parse(response);
            //asignacion de valores a los inputs del form
            $('#codigoraza').val(raza[0].codigo);
            $('#nombreraza').val(raza[0].nombre);
            $('#descripcionraza').val(raza[0].descripcion);
            //cambiamos indicador de editar 
            indicatorEdit = true;
            //cambiamos texto del boton submit
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("codigoraza").disabled = true;
        });
    });

    // Acción para reactivar una raza
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código de la raza

        const data = {
            option: 9, // Opción para reactivar la raza
            codigo: codigo
        };

        let url = '../action/razaAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                mostrarRazasInactivas(); // Actualiza la lista de razas inactivas
                obtenerRaza(); // Actualiza la lista principal de razas
                alert("Raza reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});