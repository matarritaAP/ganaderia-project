
async function validarFormulario() {

    let codigoid = document.getElementById('codigoid').value;
    let nombre = document.getElementById('nombre').value;
    let nombrecomun = document.getElementById('nombrecomun').value;
    let presentacion = document.getElementById('presentacion').value;
    let casacomercial = document.getElementById('casacomercial').value;
    let cantidad = document.getElementById('cantidad').value;
    let funcion = document.getElementById('funcion').value;
    let aplicacion = document.getElementById('aplicacion').value;
    let descripcion = document.getElementById('descripcion').value;
    let formula = document.getElementById('formula').value;
    let provedor = document.getElementById('provedor').value;

    if (!validarCampos(nombre, nombrecomun, presentacion, casacomercial, cantidad, funcion, aplicacion, descripcion, formula, provedor)) {
        return false;

    }


    return true;
}


function validarCampos(codigoid, nombre, nombrecomun, presentacion, casacomercial, cantidad, funcion, aplicacion, descripcion, formula, provedor,) {
    if (codigoid === "" || nombre === "" || nombrecomun === "" || presentacion === "" || casacomercial === "" || cantidad === "" || funcion === "" || aplicacion === "" || descripcion === "" || formula === "" || provedor === "") {
        alert("Debe completar todos los datos");
        return false;
    }
    return true;
}




/*function verificarCodigoExistente(codigoid) {
    return new Promise((resolve) => {
        const data = { option: 6, codigoid: codigoid };
        let url = '../actions/herbicidasAction.php';
        $.post(url, data, function (response) {
            if (response.trim() === "0") {
                resolve(true);
            } else {
                alert("El código ya existe");
                resolve(false);
            }
        });
    });
}*/

async function verificarCodigoExistente(codigoid) {
    try {
        const data = { option: 6, codigoid: codigoid };
        let url = '../actions/herbicidasAction.php';
        let response = await $.post(url, data);
        if (response.trim() === "0") {
            return true;
        } else {
            alert("El código ya existe");
            return false;
        }
    } catch (e) {
        console.error("Error al verificar el código existente:", e);
        return false;
    }
}

function obtenerHerbicidas() {
    let option = 2;

    $.ajax({
        url: '../action/herbicidasAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {

            let list = JSON.parse(response);

            let template = '';
            list.forEach(herbicida => {
                template += `
                    <tr codigoid="${herbicida.tbcodigo}">
                    <td>${herbicida.tbcodigo}</td>
                    <td>${herbicida.tbnombre}</td>
                    <td>${herbicida.tbnombrecomun}</td>
                    <td>${herbicida.tbpresentacion}</td>
                    <td>${herbicida.tbcasacomercial}</td>
                    <td>${herbicida.tbcantidad}</td>
                    <td>${herbicida.tbfuncion}</td>
                    <td>${herbicida.tbaplicacion}</td>
                    <td>${herbicida.tbdescripcion}</td>
                    <td>${herbicida.tbformula}</td>
                    <td>${herbicida.tbprovedor}</td>
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td>
                    </tr>
                `;
            });
            $('#listaHerbicidas').html(template);
        }
    });
}

function mostrarInactivos() {
    let option = 6; // Opción para obtener razas inactivas

    $.ajax({
        url: '../action/herbicidasAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(herbicida => {
                template += `
                    <tr codigoid="${herbicida.tbcodigo}">
                    <td>${herbicida.tbcodigo}</td>
                    <td>${herbicida.tbnombre}</td>
                    <td>${herbicida.tbnombrecomun}</td>
                    <td>${herbicida.tbpresentacion}</td>
                    <td>${herbicida.tbcasacomercial}</td>
                    <td>${herbicida.tbcantidad}</td>
                    <td>${herbicida.tbfuncion}</td>
                    <td>${herbicida.tbaplicacion}</td>
                    <td>${herbicida.tbdescripcion}</td>
                    <td>${herbicida.tbformula}</td>
                    <td>${herbicida.tbprovedor}</td>
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
            mostrarInactivos(); // Mostrar razas inactivas al abrir
        }
    });
};

$(document).ready(function () {
    obtenerHerbicidas();
    comportamientoListaInactivos();
    $("#cancelar").click(function () {
        $('#forminsertHerbicida').trigger('reset');
        indicatorEdit = false;
        document.getElementById("codigoid").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#forminsertHerbicida').submit(function (e) {

        e.preventDefault();

        validarFormulario().then((valido) => {
            //alert(valido);
            if (valido) {
                let codigoid = document.getElementById('codigoid').value;
                let nombre = document.getElementById('nombre').value;
                let nombrecomun = document.getElementById('nombrecomun').value;
                let presentacion = document.getElementById('presentacion').value;
                let casacomercial = document.getElementById('casacomercial').value;

                let cantidad = document.getElementById('cantidad').value;
                let funcion = document.getElementById('funcion').value;
                let aplicacion = document.getElementById('aplicacion').value;
                let descripcion = document.getElementById('descripcion').value;
                let formula = document.getElementById('formula').value;
                let provedor = document.getElementById('provedor').value;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/herbicidasAction.php";
                const data = {
                    option: opc,
                    codigoid: codigoid,
                    nombre: nombre,
                    nombrecomun: nombrecomun,
                    presentacion: presentacion,
                    casacomercial: casacomercial,
                    cantidad: cantidad,
                    funcion: funcion,
                    aplicacion: aplicacion,
                    descripcion: descripcion,
                    formula: formula,
                    provedor: provedor
                };
                $.post(url, data, function (response) {
                    let result = response.trim();
                    if (result == "1") {
                        obtenerHerbicidas();
                        //alert("Guardado");
                        $('#forminsertHerbicida').trigger('reset');
                        document.getElementById("codigoid").disabled = false;
                        $('.nuevoRegistro').text('Registrar');
                    } else {
                        alert("Error al realizar solicitud");
                    }
                });
                indicatorEdit = false;
            }
        });
    });

    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement;
        let codigoid = $(element).attr('codigoid');
        const data = {
            option: 3,
            codigoid: codigoid
        };

        let url = '../action/herbicidasAction.php';

        $.post(url, data, function (response) {
            // alert(response);
            let result = response.trim();
            if (result == "1") {
                obtenerHerbicidas();
                alert("Eliminado");
            } else {
                alert("Error al eliminar");
            }
        });
    });

    $(document).on('click', '.btnEdit', function () {
        let element = $(this)[0].parentElement.parentElement;
        let codigoid = $(element).attr('codigoid');
        const data = {
            option: 4,
            codigoid: codigoid
        };
        let url = '../action/herbicidasAction.php';
        $.post(url, data, function (response) {
            // alert(response);
            const herbicida = JSON.parse(response);
            $('#codigoid').val(herbicida[0].tbcodigo);
            $('#nombre').val(herbicida[0].tbnombre);
            $('#nombrecomun').val(herbicida[0].tbnombrecomun);
            $('#presentacion').val(herbicida[0].tbpresentacion);
            $('#casacomercial').val(herbicida[0].tbcasacomercial);
            $('#cantidad').val(herbicida[0].tbcantidad);
            $('#funcion').val(herbicida[0].tbfuncion);
            $('#aplicacion').val(herbicida[0].tbaplicacion);
            $('#descripcion').val(herbicida[0].tbdescripcion);
            $('#formula').val(herbicida[0].tbformula);
            $('#provedor').val(herbicida[0].tbprovedor);
            indicatorEdit = true;
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("codigoid").disabled = true;
        });
    });

    // Acción para reactivar
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigoid = $(element).attr('codigoid');

        const data = {
            option: 7,
            codigoid: codigoid
        };

        let url = '../action/herbicidasAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                mostrarInactivos();
                obtenerHerbicidas();
                alert("Herbicidas reactivada");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});
