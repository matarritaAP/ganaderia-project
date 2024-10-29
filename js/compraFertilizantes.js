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
    let precio = document.getElementById('proveedor').value;
    let fechaCompra = document.getElementById('fechaCompra').value;

    if (!validarCampos(codigoid, nombre, nombrecomun, presentacion, casacomercial, cantidad, funcion, dosificacion, descripcion, formula, proveedor, precio, fechaCompra)) {
        return false;
    }

    return true;
}

function validarCampos(codigoid, nombre, nombrecomun, presentacion, casacomercial, cantidad, funcion, dosificacion, descripcion, formula, proveedor, precio, fechaCompra) {
    if (codigoid === "" || nombre === "" || nombrecomun === "" || presentacion === "" || casacomercial === "" || cantidad === "" ||
        funcion === "" || dosificacion === "" || descripcion === "" || formula === "" || proveedor === "" ||
        precio === "" || fechaCompra === "") {
        alert("Debe completar todos los datos");
        return false;
    }
    return true;
}

async function verificarCodigoExistente(codigoid) {
    try {
        const data = { option: 6, codigoid: codigoid };
        let url = '../actions/compraFertilizantesAction.php';
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

function obtenerFertilizantes() {
    let option = 2;

    $.ajax({
        url: '../action/compraFertilizantesAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(fertilizante => {
                template += `
                    <tr codigoid="${fertilizante.tbcomprafertilizantecodigo}">
                    <td>${fertilizante.tbcomprafertilizantecodigo}</td>
                    <td>${fertilizante.tbcomprafertilizantenombre}</td>
                    <td>${fertilizante.tbcomprafertilizantenombrecomun}</td>
                    <td>${fertilizante.tbcomprafertilizantepresentacion}</td>
                    <td>${fertilizante.tbcomprafertilizantecasacomercial}</td>
                    <td>${fertilizante.tbcomprafertilizantecantidad}</td>
                    <td>${fertilizante.tbcomprafertilizantefuncion}</td>
                    <td>${fertilizante.tbcomprafertilizantedosificacion}</td>
                    <td>${fertilizante.tbcomprafertilizantedescripcion}</td>
                    <td>${fertilizante.tbcomprafertilizanteformula}</td>
                    <td>${fertilizante.tbcomprafertilizanteproveedor}</td>
                    <td>${fertilizante.tbcomprafertilizanteprecio}</td>
                    <td>${fertilizante.tbcomprafertilizantefechacompra}</td>
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

$(document).ready(function () {
    obtenerFertilizantes();

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
                let precio = document.getElementById('precio').value;
                let fechaCompra = document.getElementById('fechaCompra').value;

                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/compraFertilizantesAction.php";
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
                    proveedor: proveedor,
                    precio: precio,
                    fechaCompra: fechaCompra
                };
                $.post(url, data, function (response) {
                    let result = response.trim();
                    console.log(response);
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

        let url = '../action/compraFertilizantesAction.php';

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
        let url = '../action/compraFertilizantesAction.php';
        $.post(url, data, function (response) {
            const fertilizante = JSON.parse(response);
            $('#codigoid').val(fertilizante[0].tbcomprafertilizantecodigo);
            $('#nombre').val(fertilizante[0].tbcomprafertilizantenombre);
            $('#nombrecomun').val(fertilizante[0].tbcomprafertilizantenombrecomun);
            $('#presentacion').val(fertilizante[0].tbcomprafertilizantepresentacion);
            $('#casacomercial').val(fertilizante[0].tbcomprafertilizantecasacomercial);
            $('#cantidad').val(fertilizante[0].tbcomprafertilizantecantidad);
            $('#funcion').val(fertilizante[0].tbcomprafertilizantefuncion);
            $('#dosificacion').val(fertilizante[0].tbcomprafertilizantedosificacion);
            $('#descripcion').val(fertilizante[0].tbcomprafertilizantedescripcion);
            $('#formula').val(fertilizante[0].tbcomprafertilizanteformula);
            $('#proveedor').val(fertilizante[0].tbcomprafertilizanteproveedor);
            $('#precio').val(fertilizante[0].tbcomprafertilizanteprecio);
            $('#fechaCompra').val(fertilizante[0].tbcomprafertilizantefechacompra);
            indicatorEdit = true;
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("codigoid").disabled = true; 
        });
    });
});