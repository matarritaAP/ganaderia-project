async function validarFormulario() {
    let nombre = document.getElementById('nombre').value;
    let fechacompra = document.getElementById('fechacompra').value;

    if (nombre === "") {
        alert("Debe agregar un nombre");
        return false;
    }
    if (fechacompra === "") {
        alert("Seleccione un fecha de Compra");
        return false;
    }
    return true;
}


//obtiene los registros de la base datos y los muestra
function obtenerCompraProductoVeterinario() {
    let option = 2;
   
    $.ajax({
        url: '../action/compraProductoVeterinarioAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            //alert(response);
            let list = JSON.parse(response);
            let template = '';
            list.forEach(compraProductoVeterinario => {
                template += `
                    <tr codigoid="${compraProductoVeterinario.tbcompraid}">
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td>
                    <td>${compraProductoVeterinario.tbcompranombre}</td>
                    <td>${compraProductoVeterinario.tbcomprafechacompra}</td>
                    <td>${compraProductoVeterinario.tbcompracantidad}</td>
                    <td>${compraProductoVeterinario.tbcompraprecio}</td>
                    </tr>
                `;
            });
            $('#listaCompraProductoVeterinario').html(template);
        }
    });
}

$(document).ready(function () {
    obtenerCompraProductoVeterinario();

    $("#cancelar").click(function () {
        $('#forminsertCompraProductoVeterinario').trigger('reset');
        indicatorEdit = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    $('#insertCompraProductoVeterinario').submit(function (e) {
        e.preventDefault();

        validarFormulario().then((valido) => {
            if (valido) {
                let id = document.getElementById('id').value;
                let nombre = document.getElementById('nombre').value;
                let user_id = document.getElementById('user_id').value;
                let fechacompra = document.getElementById('fechacompra').value;
                let cantidad = document.getElementById('cantidad').value;
                let precio = document.getElementById('precio').value;

                
                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/compraProductoVeterinarioAction.php";
                const data = {
                    option: opc,
                    id: id,
                    nombre: nombre,
                    user_id: user_id,
                    fechacompra: fechacompra,
                    cantidad: cantidad,
                    precio: precio
                };
                $.post(url, data, function (response) {
                    //alert(response);
                    let result = response.trim();
                    if (result == "1") {
                        alert("Guardado");
                        obtenerCompraProductoVeterinario();
                        $('#forminsertCompraProductoVeterinario').trigger('reset');
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

        let url = '../action/compraProductoVeterinarioAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerCompraProductoVeterinario();
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
        let url = '../action/compraProductoVeterinarioAction.php';
        $.post(url, data, function (response) {
            const compraProductoVeterinario = JSON.parse(response);
            $('#id').val(compraProductoVeterinario[0].tbcompraid);
            $('#nombre').val(compraProductoVeterinario[0].tbcompranombre );
            $('#fechacompra').val(compraProductoVeterinario[0].tbcomprafechacompra);
            $('#cantidad').val(compraProductoVeterinario[0].tbcompracantidad);
            $('#precio').val(compraProductoVeterinario[0].tbcompraprecio);
            indicatorEdit = true;
            $('.nuevoRegistro').text('Actualizar');
        });
    });

});
