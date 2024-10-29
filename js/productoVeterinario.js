async function validarFormulario() {
    let nombre = document.getElementById('nombre').value;
    let fechavencimiento = document.getElementById('fechavencimiento').value;

    if (nombre === "") {
        alert("Debe agregar un nombre");
        return false;
    }
    if (fechavencimiento === "") {
        alert("Seleccione un fecha de Vencimiento");
        return false;
    }
    return true;
}


//obtiene los registros de la base datos y los muestra
function obtenerProductoVeterinario() {
    let option = 2;
   
    $.ajax({
        url: '../action/productoVeterinarioAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(productoVeterinario => {
                template += `
                    <tr codigoid="${productoVeterinario.tbproductoveterinarioid}">
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td><td>${productoVeterinario.tbproductoveterinarionombre}</td>
                    <td>${productoVeterinario.tbproductoveterinarioprincipioactivo}</td>
                    <td>${productoVeterinario.tbproductoveterinariodosificacion}</td>
                    <td>${productoVeterinario.tbproductoveterinariofechavencimiento}</td>
                    <td>${productoVeterinario.tbproductoveterinariofuncion}</td>
                    <td>${productoVeterinario.tbproductoveterinariodescripcion}</td>
                    <td>${productoVeterinario.tbproductoveterinariotipomedicamento}</td>
                    <td>${productoVeterinario.tbproductoveterinarioproveedor}</td>
                    
                    </tr>
                `;
            });
            $('#listaProductoVeterinario').html(template);
        }
    });
}

$(document).ready(function () {
    obtenerProductoVeterinario();

    $("#cancelar").click(function () {
        $('#divCkeckCompra').show();
        $('#forminsertProductoVeterinario').trigger('reset');
        indicatorEdit = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    let compra = "0"
    $('#forminsertProductoVeterinario').submit(function (e) {
        e.preventDefault();

        validarFormulario().then((valido) => {
            if (valido) {
                let id = document.getElementById('id').value;
                let nombre = document.getElementById('nombre').value;
                let principioactivo = document.getElementById('principioactivo').value;
                let dosificacion = document.getElementById('dosificacion').value;
                let fechavencimiento = document.getElementById('fechavencimiento').value;
                let funcion = document.getElementById('funcion').value;
                let descripcion = document.getElementById('descripcion').value;
                let tipomedicamento = document.getElementById('tipomedicamento').value;
                let proveedor = document.getElementById('proveedor').value;
                let user_id = document.getElementById('user_id').value;
                let fechacompra = document.getElementById('fechacompra').value;
                let cantidad = document.getElementById('cantidad').value;
                let precio = document.getElementById('precio').value;

                
                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/productoVeterinarioAction.php";
                const data = {
                    option: opc,
                    id: id,
                    nombre: nombre,
                    principioactivo: principioactivo,
                    dosificacion: dosificacion,
                    fechavencimiento: fechavencimiento,
                    funcion: funcion,
                    descripcion: descripcion,
                    tipomedicamento: tipomedicamento,
                    proveedor: proveedor,
                    user_id: user_id,
                    compra: compra,
                    fechacompra: fechacompra,
                    cantidad: cantidad,
                    precio: precio
                };
                $.post(url, data, function (response) {
                    let result = response.trim();
                    if (result == "1") {
                        alert("Guardado");
                        obtenerProductoVeterinario();
                        $('#forminsertProductoVeterinario').trigger('reset');
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

        let url = '../action/productoVeterinarioAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerProductoVeterinario();
                alert("Eliminado");
            } else {
                alert("Error al eliminar");
            }
        });
    });

    $(document).on('click', '.btnEdit', function () {

        $('#divCkeckCompra').hide();
        let element = $(this)[0].parentElement.parentElement;
        let codigoid = $(element).attr('codigoid');
        const data = {
            option: 4,
            codigoid: codigoid
        };
        let url = '../action/productoVeterinarioAction.php';
        $.post(url, data, function (response) {
            const productoVeterinario = JSON.parse(response);
            $('#id').val(productoVeterinario[0].tbproductoveterinarioid);
            $('#nombre').val(productoVeterinario[0].tbproductoveterinarionombre);
            $('#principioactivo').val(productoVeterinario[0].tbproductoveterinarioprincipioactivo);
            $('#dosificacion').val(productoVeterinario[0].tbproductoveterinariodosificacion);
            $('#fechavencimiento').val(productoVeterinario[0].tbproductoveterinariofechavencimiento);
            $('#funcion').val(productoVeterinario[0].tbproductoveterinariofuncion);
            $('#descripcion').val(productoVeterinario[0].tbproductoveterinariodescripcion);
            $('#tipomedicamento').val(productoVeterinario[0].tbproductoveterinariotipomedicamento);
            $('#proveedor').val(productoVeterinario[0].tbproductoveterinarioproveedor);
            indicatorEdit = true;
            $('.nuevoRegistro').text('Actualizar');
        });
    });

   
    $("#compra").change(function() {
        // Verifica si el checkbox está seleccionado
        let isChecked = $(this).is(":checked");
        
        if (isChecked) {
            // Muestra el campo de precio si el checkbox está seleccionado
            $("#divCompra").show();
            compra = "1";
        } else {
            // Oculta el campo de precio si el checkbox no está seleccionado
            $("#divCompra").hide();
            compra = "0";
        }
    });
    
    

});
