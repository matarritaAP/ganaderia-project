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
    let precio = document.getElementById('precio').value;
    let fechaCompra = document.getElementById('fechaCompra').value;

    if (!validarCampos(codigoid, nombre, nombrecomun, presentacion, casacomercial, cantidad, funcion, aplicacion, descripcion, formula, provedor, precio, fechaCompra)) {
        return false;
    }

    return true;
}

function validarCampos(codigoid, nombre, nombrecomun, presentacion, casacomercial, cantidad, funcion, aplicacion, descripcion, formula, provedor, precio, fechaCompra) {
    if (codigoid === "" || nombre === "" || nombrecomun === "" || presentacion === "" || casacomercial === "" || cantidad === "" || funcion === "" || aplicacion === "" || descripcion === "" || formula === "" || provedor === "" || precio === "" || fechaCompra === "") {
        alert("Debe completar todos los datos");
        return false;
    }
    return true;
}

async function verificarCodigoExistente(codigoid) {
    try {
        const data = { option: 6, codigoid: codigoid };
        let url = '../action/compraHerbicidasAction.php';
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
        url: '../action/compraHerbicidasAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            
            let template = '';
            list.forEach(herbicida => {
                console.log(response.toString());
                template += `
                    <tr codigoid="${herbicida.tbcompracodigo}">
                    <td>${herbicida.tbcompracodigo}</td>
                    <td>${herbicida.tbcompranombre}</td>
                    <td>${herbicida.tbcompranombrecomun}</td>
                    <td>${herbicida.tbcomprapresentacion}</td>
                    <td>${herbicida.tbcompracasacomercial}</td>
                    <td>${herbicida.tbcompracantidad}</td>
                    <td>${herbicida.tbcomprafuncion}</td>
                    <td>${herbicida.tbcompraaplicacion}</td>
                    <td>${herbicida.tbcompradescripcion}</td>
                    <td>${herbicida.tbcompraformula}</td>
                    <td>${herbicida.tbcompraprovedor}</td>
                    <td>${herbicida.tbcompraprecio}</td>
                    <td>${herbicida.tbcomprafechacompra}</td>
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

$(document).ready(function () {
    obtenerHerbicidas();

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
                let precio = document.getElementById('precio').value;
                let fechaCompra = document.getElementById('fechaCompra').value;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/compraHerbicidasAction.php";
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
                    provedor: provedor,
                    precio: precio,
                    fechaCompra: fechaCompra
                };
                $.post(url, data, function (response) {
                    let result = response.trim();
                    if (result == "1") {
                        obtenerHerbicidas();
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

        let url = '../action/compraHerbicidasAction.php';

        $.post(url, data, function (response) {
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
        let url = '../action/compraHerbicidasAction.php';
        $.post(url, data, function (response) {
            const herbicida = JSON.parse(response);
            $('#codigoid').val(herbicida[0].tbcompracodigo);
            $('#nombre').val(herbicida[0].tbcompranombre);
            $('#nombrecomun').val(herbicida[0].tbcompranombrecomun);
            $('#presentacion').val(herbicida[0].tbcomprapresentacion);
            $('#casacomercial').val(herbicida[0].tbcompracasacomercial);
            $('#cantidad').val(herbicida[0].tbcompracantidad);
            $('#funcion').val(herbicida[0].tbcomprafuncion);
            $('#aplicacion').val(herbicida[0].tbcompraaplicacion);
            $('#descripcion').val(herbicida[0].tbcompradescripcion);
            $('#formula').val(herbicida[0].tbcompraformula);
            $('#provedor').val(herbicida[0].tbcompraprovedor);
            $('#precio').val(herbicida[0].tbcompraprecio);
            $('#fechaCompra').val(herbicida[0].tbcomprafechacompra);
            indicatorEdit = true;
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("codigoid").disabled = true;
        });
    });
});
