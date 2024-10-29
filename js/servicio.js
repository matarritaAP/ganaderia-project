var actualUserType; // variable global

if (typeof actualUserType === 'undefined') {
    var actualUserType = 1;
}


function obtenerTipoUsuario() {
    return new Promise((resolve) => {
        $.post('../action/servicioAction.php', { option: 0 }, function (response) {
            let data = JSON.parse(response);
            actualUserType = data.userType; // Asignar el tipo de usuario a la variable global
            resolve(actualUserType);
            console.log(response);
        });
    });
}

//funcion para validar datos del formulario registro

function validarFormulario(edit) {
    return new Promise((resolve) => {
        let codigo = document.getElementById('codigoservicio').value;
        let nombre = document.getElementById('nombreservicio').value;
        let descripcion = document.getElementById('descripcionservicio').value;

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
        let url = '../action/servicioAction.php';
        $.post(url, dataSimilar, function (similarResponse) {
            try {
                let similarServicios = JSON.parse(similarResponse);
                if (similarServicios.length === 0) {
                    resolve(true);
                } else {
                    let nombresSimilares = similarServicios.join(', ');
                    let confirmar = confirm("Existen Servicios con nombres similares: " + nombresSimilares + ". ¿Desea continuar?");
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
        let url = '../action/servicioAction.php';
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

function obtenerServicio() {
    let option = 2;
    $.ajax({
        url: '../action/servicioAction.php',
        data: {
            option: option
        },
        type: 'POST',
        success: function (response) {
            try {
                let list = JSON.parse(response);
                let template = '';
                list.forEach(Servicio => {
                    template += `
                        <tr codigo="${Servicio.tbserviciocodigo}">
                        <td>${Servicio.tbserviciocodigo}</td>
                        <td>${Servicio.tbservicionombre}</td>
                        <td>${Servicio.tbserviciodescripcion}</td>
                        <td>
                            <button class="btnEdit">Editar</button>
                        </td>
                        <td>
                            <button class="btndelete">Eliminar</button>
                        </td>
                        </tr>
                    `
                });
                $('#listaServicio').html(template);
            } catch (e) {
                console.error("Error al parsear el JSON:", e);
            }

        }
    });
}

function mostrarServiciosInactivos() {
    let option = 8;

    $.ajax({
        url: '../action/servicioAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            console.log(response);
            let list = JSON.parse(response);
            let template = '';
            list.forEach(servicio => {
                template += `
                    <tr codigo="${servicio.tbserviciocodigo}">
                    <td>${servicio.tbserviciocodigo}</td>
                    <td>${servicio.tbservicionombre}</td>
                    <td>${servicio.tbserviciodescripcion}</td>
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
            mostrarServiciosInactivos();
        }
    });
};

$(document).ready(function () {
    obtenerTipoUsuario();
    obtenerServicio();
    comportamientoListaInactivos();

    $("#cancelar").click(function () {
        $('#forminsertServicio').trigger('reset');//limpiar formulario
        indicatorEdit = false;
        document.getElementById("codigoservicio").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#forminsertServicio').submit(function (e) {
        e.preventDefault()//evita el envio del formulario

        validarFormulario(indicatorEdit).then((valido) => {

            if (valido) {
                let codigo = document.getElementById('codigoservicio').value;
                let nombre = document.getElementById('nombreservicio').value;
                let descripcion = document.getElementById('descripcionservicio').value;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/servicioAction.php";
                const data = {
                    option: opc,
                    codigo: codigo,
                    nombre: nombre,
                    descripcion: descripcion
                }
                //ajax para registrar o editar
                $.post(url, data, function (response) {
                    let result = response.trim();

                    //validar la respuesta de peticion
                    if (result == "1") {
                        obtenerServicio();
                        alert("Guardado");
                        $('#forminsertServicio').trigger('reset');//limpiar formulario
                        document.getElementById("codigoservicio").disabled = false;
                        $('.nuevoRegistro').text('Registrar');
                    } else {
                        alert("Error al realizar solicitud");
                    }
                });
                indicatorEdit = false;
            }
        });
    });

    //accion para eliminar servicio de la tabla
    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement;
        let codigo = $(element).attr('codigo');//accedemos al atributo del tr para obtener el codigo
        const data = {
            option: 3,
            codigo: codigo
        }

        let url = "../action/servicioAction.php";

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerServicio();
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
        let url = "../action/servicioAction.php";
        $.post(url, data, function (response) {
            // recivimos la respuesta y la convertimos a formato json
            const servicio = JSON.parse(response);
            //asignacion de valores a los inputs del form
            $('#codigoservicio').val(servicio[0].codigo);
            $('#nombreservicio').val(servicio[0].nombre);
            $('#descripcionservicio').val(servicio[0].descripcion);
            //cambiamos indicador de editar 
            indicatorEdit = true;
            //cambiamos texto del boton submit
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("codigoservicio").disabled = true;
        });

    });

    // Acción para reactivar un servicio
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Obtiene el código de la raza

        const data = {
            option: 9, // Opción para reactivar el servicio
            codigo: codigo
        };

        let url = '../action/servicioAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                mostrarServiciosInactivos(); // Actualiza la lista de servicios inactivos
                obtenerServicio(); // Actualiza la lista principal de servicios
                alert("Servicio reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});