async function validarFormulario() {
    let codigoid = document.getElementById('codigoid').value;
    let nombre = document.getElementById('nombre').value;
    let nombrecomun = document.getElementById('nombrecomun').value;
    let presentacion = document.getElementById('presentacion').value;
    let casacomercial = document.getElementById('casacomercial').value;
    let cantidad = document.getElementById('cantidad').value;
    let funcion = document.getElementById('funcion').value;
    let dosificacion = document.getElementById('dosificacion').value;
    let descripcion = document.getElementById('descripcion').value;
    let formula = document.getElementById('formula').value;
    let proveedor = document.getElementById('proveedor').value;

    if (!validarCampos(codigoid, nombre, nombrecomun, presentacion, casacomercial, cantidad, funcion, dosificacion, descripcion, formula, proveedor)) {
        return false;
    }

    return true;
}

function validarCampos(codigoid, nombre, nombrecomun, presentacion, casacomercial, cantidad, funcion, dosificacion, descripcion, formula, proveedor) {
    if (codigoid === "" || nombre === "" || nombrecomun === "" || presentacion === "" || casacomercial === "" || cantidad === "" || funcion === "" || dosificacion === "" || descripcion === "" || formula === "" || proveedor === "") {
        alert("Debe completar todos los datos");
        return false;
    }
    return true;
}
//recordar cambiar actions - quitarle la s, probar despues
async function verificarCodigoExistente(codigoid) {
    try {
        const data = { option: 6, codigoid: codigoid };
        let url = '../actions/fertilizantesAction.php';
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
//obtiene los registros de la base datos y los muestra
function obtenerFertilizantes() {
    let option = 2;

    $.ajax({
        url: '../action/fertilizantesAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            //alert(response);
            let list = JSON.parse(response);
            let template = '';
            list.forEach(fertilizante => {
                template += `
                    <tr codigoid="${fertilizante.tbfertilizantecodigo}">
                    <td>${fertilizante.tbfertilizantecodigo}</td>
                    <td>${fertilizante.tbfertilizantenombre}</td>
                    <td>${fertilizante.tbfertilizantenombrecomun}</td>
                    <td>${fertilizante.tbfertilizantepresentacion}</td>
                    <td>${fertilizante.tbfertilizantecasacomercial}</td>
                    <td>${fertilizante.tbfertilizantecantidad}</td>
                    <td>${fertilizante.tbfertilizantefuncion}</td>
                    <td>${fertilizante.tbfertilizantedosificacion}</td>
                    <td>${fertilizante.tbfertilizantedescripcion}</td>
                    <td>${fertilizante.tbfertilizanteformula}</td>
                    <td>${fertilizante.tbfertilizanteproveedor}</td>
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td>
                    </tr>
                `;
            });
            $('#listaFertilizantes').html(template);
        }
    });
}

function mostrarInactivos() {
    let option = 8; // Opción para obtener razas inactivas

    $.ajax({
        url: '../action/fertilizantesAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            console.log(response);
            list.forEach(fertilizante => {
                template += `
                    <tr codigoid="${fertilizante.tbfertilizantecodigo}">
                    <td>${fertilizante.tbfertilizantecodigo}</td>
                    <td>${fertilizante.tbfertilizantenombre}</td>
                    <td>${fertilizante.tbfertilizantenombrecomun}</td>
                    <td>${fertilizante.tbfertilizantepresentacion}</td>
                    <td>${fertilizante.tbfertilizantecasacomercial}</td>
                    <td>${fertilizante.tbfertilizantecantidad}</td>
                    <td>${fertilizante.tbfertilizantefuncion}</td>
                    <td>${fertilizante.tbfertilizantedosificacion}</td>
                    <td>${fertilizante.tbfertilizantedescripcion}</td>
                    <td>${fertilizante.tbfertilizanteformula}</td>
                    <td>${fertilizante.tbfertilizanteproveedor}</td>
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
    obtenerFertilizantes();
    comportamientoListaInactivos();
    $("#cancelar").click(function () {
        $('#forminsertFertilizante').trigger('reset');
        indicatorEdit = false;
        document.getElementById("codigoid").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#forminsertFertilizante').submit(function (e) {
        e.preventDefault();

        validarFormulario().then((valido) => {
            if (valido) {
                let codigoid = document.getElementById('codigoid').value;
                let nombre = document.getElementById('nombre').value;
                let nombrecomun = document.getElementById('nombrecomun').value;
                let presentacion = document.getElementById('presentacion').value;
                let casacomercial = document.getElementById('casacomercial').value;
                let cantidad = document.getElementById('cantidad').value;
                let funcion = document.getElementById('funcion').value;
                let dosificacion = document.getElementById('dosificacion').value;
                let descripcion = document.getElementById('descripcion').value;
                let formula = document.getElementById('formula').value;
                let proveedor = document.getElementById('proveedor').value;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/fertilizantesAction.php";
                const data = {
                    option: opc,
                    codigoid: codigoid,
                    nombre: nombre,
                    nombrecomun: nombrecomun,
                    presentacion: presentacion,
                    casacomercial: casacomercial,
                    cantidad: cantidad,
                    funcion: funcion,
                    dosificacion: dosificacion,
                    descripcion: descripcion,
                    formula: formula,
                    proveedor: proveedor
                };
                $.post(url, data, function (response) {
                    // alert (response);
                    let result = response.trim();
                    if (result == "1") {
                        obtenerFertilizantes();
                        $('#forminsertFertilizante').trigger('reset');
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

        let url = '../action/fertilizantesAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerFertilizantes();
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
        let url = '../action/fertilizantesAction.php';
        $.post(url, data, function (response) {
            // alert(response);
            const fertilizante = JSON.parse(response);
            $('#codigoid').val(fertilizante[0].tbfertilizantecodigo);
            $('#nombre').val(fertilizante[0].tbfertilizantenombre);
            $('#nombrecomun').val(fertilizante[0].tbfertilizantenombrecomun);
            $('#presentacion').val(fertilizante[0].tbfertilizantepresentacion);
            $('#casacomercial').val(fertilizante[0].tbfertilizantecasacomercial);
            $('#cantidad').val(fertilizante[0].tbfertilizantecantidad);
            $('#funcion').val(fertilizante[0].tbfertilizantefuncion);
            $('#dosificacion').val(fertilizante[0].tbfertilizantedosificacion);
            $('#descripcion').val(fertilizante[0].tbfertilizantedescripcion);
            $('#formula').val(fertilizante[0].tbfertilizanteformula);
            $('#proveedor').val(fertilizante[0].tbfertilizanteproveedor);
            indicatorEdit = true;
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("codigoid").disabled = true; //desabilita el 
        });
    });

    // Acción para reactivar
    $(document).on('click', '.btnReactivar', function () {
        let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
        let codigoid = $(element).attr('codigoid');

        const data = {
            option: 9,
            codigoid: codigoid
        };

        let url = '../action/fertilizantesAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                mostrarInactivos();
                obtenerFertilizantes();
                setTimeout(cargarProductosAlimenticios, 500);
                alert("Fertilizante reactivado");
            } else {
                alert("Error al reactivar");
            }
        });
    });
});

