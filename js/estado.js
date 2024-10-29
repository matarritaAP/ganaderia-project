var actualUserType; // variable global

if (typeof actualUserType === 'undefined') {
    var actualUserType = 1;
}


function obtenerTipoUsuario() {
    return new Promise((resolve) => {
        $.post('../action/estadoAction.php', { option: 0 }, function (response) {
            let data = JSON.parse(response);
            actualUserType = data.userType; // Asignar el tipo de usuario a la variable global
            resolve(actualUserType);
            console.log(response);
        });
    });
}

//listo
function validarFormulario(edit) {
    return new Promise((resolve) => {
        let codigo = document.getElementById('codigoestado').value;
        let nombre = document.getElementById('nombreestado').value;
        let descripcion = document.getElementById('descripcionestado').value;

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

//listo
function validarCampos(codigo, nombre, descripcion, isCodigoRequired) {
    if ((isCodigoRequired != 1 && codigo === "") || nombre === "" || descripcion === "") {
        alert("Debe completar todos los datos");
        return false;
    }
    return true;
}
//listo
function verificarNombreSimilar(nombre) {
    return new Promise((resolve) => {
        const dataSimilar = { option: 7, nombre: nombre };
        let url = '../action/estadoAction.php';
        $.post(url, dataSimilar, function (similarResponse) {
            try {
                let similarEstados = JSON.parse(similarResponse);
                if (similarEstados.length === 0) {
                    resolve(true);
                } else {
                    let nombresSimilares = similarEstados.join(', ');
                    let confirmar = confirm("Existen estados con nombres similares: " + nombresSimilares + ". ¿Desea continuar?");
                    resolve(confirmar);
                }
            } catch (e) {
                console.error("Error al procesar la respuesta de nombres similares:", e);
                resolve(false);
            }
        });
    });
}
//listo
function verificarCodigoExistente(codigo) {
    return new Promise((resolve) => {
        const data = { option: 6, codigo: codigo };
        let url = '../action/estadoAction.php';
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
//listo
function obtenerEstado() {

    let option = 2;

    $.ajax({
        url: '../action/estadoAction.php',
        data: {
            option: option
        },
        type: 'POST',
        success: function (response) {

            let list = JSON.parse(response);
            let template = '';
            list.forEach(estado => {
                template += `
                    <tr codigo="${estado.tbestadocodigo}">
                    <td>${estado.tbestadocodigo}</td>
                    <td>${estado.tbestadonombre}</td>
                    <td>${estado.tbestadodescripcion}</td>
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td>
                    </tr>
                `
            });
            $('#listaEstado').html(template);
        }
    });
}
//listo
function mostrarEstadosInactivos() {
    let option = 8; // Opción para obtener estados inactivos

    $.ajax({
        url: '../action/estadoAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(estado => {
                template += `
                    <tr codigo="${estado.tbestadocodigo}">
                    <td>${estado.tbestadocodigo}</td>
                    <td>${estado.tbestadonombre}</td>
                    <td>${estado.tbestadodescripcion}</td>
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
//listo
function comportamientoListaInactivos() {

    $('#toggleInactivos').click(function () {
        const $listaInactivos = $('#listaInactivos');
        if ($listaInactivos.is(':visible')) {
            $listaInactivos.hide();
            $('#toggleInactivos').text('Ver Inactivos');
        } else {
            $listaInactivos.show();
            $('#toggleInactivos').text('Ocultar Inactivos');
            mostrarEstadosInactivos(); // Mostrar razas inactivas al abrir
        }
    });
};

$(document).ready(function () {

    obtenerTipoUsuario();
    obtenerEstado();
    comportamientoListaInactivos();

    //Boton para ver estados inactivos
    $('#verInactivos').click(function () {
        mostrarEstadosInactivos();
    });

    $("#cancelar").click(function () {
        $('#forminsertEstado').trigger('reset');//limpiar formulario
        indicatorEdit = false;
        document.getElementById("codigoestado").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#forminsertEstado').submit(function (e) {
        e.preventDefault()//Evita el envio del formulario

        validarFormulario(indicatorEdit).then((valido) => {

            if (valido) {
                let codigo = document.getElementById('codigoestado').value;
                let nombre = document.getElementById('nombreestado').value;
                let descripcion = document.getElementById('descripcionestado').value;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/estadoAction.php";
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
                        obtenerEstado();
                        alert("Guardado");
                        $('#forminsertEstado').trigger('reset');//limpiar formulario
                        document.getElementById("codigoestado").disabled = false;
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

    //accion para eliminar Estado de la tabla
    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement;//accedemos al elemento tr de la tabla
        let codigo = $(element).attr('codigo');//accedemos al atributo del tr para obtener el codigo
        
        console.log(codigo); // Asegúrate de que el código se esté enviando correctamente

        const data = {
            option: 3,
            codigo: codigo
        }
        
        let url = '../action/estadoAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerEstado();
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
        let url = '../action/estadoAction.php';
        $.post(url, data, function (response) {
            // recivimos la respuesta y la convertimos a formato json
            const estado = JSON.parse(response);
            //asignacion de valores a los inputs del form
            $('#codigoestado').val(estado[0].codigo);
            $('#nombreestado').val(estado[0].nombre);
            $('#descripcionestado').val(estado[0].descripcion);
            //cambiamos indicador de editar 
            indicatorEdit = true;
            //cambiamos texto del boton submit
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("codigoestado").disabled = true;
        });
    });

    // Acción para reactivar un estado
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código de la raza
        console.log(codigo);
        const data = {
            option: 9, // Opción para reactivar la raza
            codigo: codigo
        };

        let url = '../action/estadoAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                mostrarEstadosInactivos(); // Actualiza la lista de razas inactivas
                obtenerEstado(); // Actualiza la lista principal de estados
                alert("Estado reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});