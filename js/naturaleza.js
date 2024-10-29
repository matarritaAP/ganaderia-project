var actualUserType; // variable global

if (typeof actualUserType === 'undefined') {
    var actualUserType = 1;
}

function obtenerTipoUsuario() {
    return new Promise((resolve) => {
        $.post('../action/naturalezaAction.php', { option: 0 }, function (response) {
            let data = JSON.parse(response);
            actualUserType = data.userType; // Asignar el tipo de usuario a la variable global
            resolve(actualUserType);
            console.log(response);
        });
    });
}

function validarFormulario(edit) {
    return new Promise((resolve) => {
        let codigo = document.getElementById('codigonaturaleza').value;
        let nombre = document.getElementById('nombrenaturaleza').value;
        let descripcion = document.getElementById('descripcionnaturaleza').value;

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
    if (isCodigoRequired != 1 && codigo === "" || nombre === "" || descripcion === "") {
        alert("Debe completar todos los datos");
        return false;
    }
    return true;
}


function verificarNombreSimilar(nombre) {
    return new Promise((resolve) => {
        const dataSimilar = { option: 7, nombre: nombre };
        let url = '../action/naturalezaAction.php';
        $.post(url, dataSimilar, function (similarResponse) {
            try {
                let similarNaturalezas = JSON.parse(similarResponse);
                if (similarNaturalezas.length === 0) {
                    resolve(true);
                } else {
                    let nombresSimilares = similarNaturalezas.join(', ');
                    let confirmar = confirm("Existen naturalezas con nombres similares: " + nombresSimilares + ". ¿Desea continuar?");
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
        let url = '../action/naturalezaAction.php';
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

function obtenerNaturaleza() {
    let option = 2;
    $.ajax({
        url: '../action/naturalezaAction.php',
        data: {
            option: option
        },
        type: 'POST',
        success: function (response) {
            try {
                let list = JSON.parse(response);
                let template = '';
                list.forEach(naturaleza => {
                    template += `
                        <tr codigo="${naturaleza.tbnaturalezacodigo}">
                        <td>${naturaleza.tbnaturalezacodigo}</td>
                        <td>${naturaleza.tbnaturalezanombre}</td>
                        <td>${naturaleza.tbnaturalezadescripcion}</td>
                        <td>
                            <button class="btnEdit">Editar</button>
                        </td>
                        <td>
                            <button class="btndelete">Eliminar</button>
                        </td>
                        </tr>
                    `;
                });
                $('#listaNaturaleza').html(template);
            } catch (e) {
                console.error("Error al parsear el JSON:", e);
            }
        },
    });
}


function mostrarNaturalezasInactivas() {
    let option = 8;

    $.ajax({
        url: '../action/naturalezaAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            console.log(response);
            let list = JSON.parse(response);
            let template = '';
            list.forEach(naturaleza => {
                template += `
                    <tr codigo="${naturaleza.tbnaturalezacodigo}">
                    <td>${naturaleza.tbnaturalezacodigo}</td>
                    <td>${naturaleza.tbnaturalezanombre}</td>
                    <td>${naturaleza.tbnaturalezadescripcion}</td>
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
            mostrarNaturalezasInactivas();
        }
    });
};

$(document).ready(function () {

    obtenerTipoUsuario();
    obtenerNaturaleza();
    comportamientoListaInactivos();

    $("#cancelar").click(function () {
        $('#forminsertNaturaleza').trigger('reset');
        indicatorEdit = false;
        document.getElementById("codigonaturaleza").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#forminsertNaturaleza').submit(function (e) {
        e.preventDefault()//evita el envio del formulario

        validarFormulario(indicatorEdit).then((valido) => {

            if (valido) {
                let codigo = document.getElementById('codigonaturaleza').value;
                let nombre = document.getElementById('nombrenaturaleza').value;
                let descripcion = document.getElementById('descripcionnaturaleza').value;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/naturalezaAction.php";
                const data = {
                    option: opc,
                    codigo: codigo,
                    nombre: nombre,
                    descripcion: descripcion
                }
                $.post(url, data, function (response) {
                    let result = response.trim();

                    if (result === "1") {
                        obtenerNaturaleza();
                        alert("Guardado");
                        $('#forminsertNaturaleza').trigger('reset');
                        document.getElementById("codigonaturaleza").disabled = false;
                        $('.nuevoRegistro').text('Registrar');
                    } else {
                        alert("Error al realizar solicitud");
                    }
                });
                indicatorEdit = false;
            }
        });
    });

    //accion para eliminar naturaleza de la tabla
    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement;
        let codigo = $(element).attr('codigo');//accedemos al atributo del tr para obtener el codigo
        const data = {
            option: 3,
            codigo: codigo
        }

        let url = "../action/naturalezaAction.php";

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerNaturaleza();
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
        let url = "../action/naturalezaAction.php";
        $.post(url, data, function (response) {
            console.log(response);
            // recivimos la respuesta y la convertimos a formato json
            const naturaleza = JSON.parse(response);
            //asignacion de valores a los inputs del form
            $('#codigonaturaleza').val(naturaleza[0].codigo);
            $('#nombrenaturaleza').val(naturaleza[0].nombre);
            $('#descripcionnaturaleza').val(naturaleza[0].descripcion);
            //cambiamos indicador de editar 
            indicatorEdit = true;
            //cambiamos texto del boton submit
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("codigonaturaleza").disabled = true;
        });

    });

    // Acción para reactivar una naturaleza
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código de la naturaleza

        const data = {
            option: 9, // Opción para reactivar el naturaleza
            codigo: codigo
        };

        let url = '../action/naturalezaAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                mostrarNaturalezasInactivas(); // Actualiza la lista de naturalezas inactivas
                obtenerNaturaleza(); // Actualiza la lista principal de naturaleza
                alert("Naturaleza reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});