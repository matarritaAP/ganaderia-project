async function validarFormulario() {
    let nombre = document.getElementById('nombre').value;
    
    if (nombre === "") {
        alert("Debe agregar un nombre");
        return false;
    }
    return true;
}


//obtiene los registros de la base datos y los muestra
function obtenerEnfermedad() {
    let option = 2;
   
    $.ajax({
        url: '../action/enfermedadAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(enfermedad => {
                template += `
                    <tr codigoid="${enfermedad.tbenfermedadid}">
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td><td>${enfermedad.tbenfermedadnombre}</td>
                    <td>${enfermedad.tbenfermedaddescripcion}</td>
                    <td>${enfermedad.tbenfermedadsintomas}</td>                 
                    </tr>
                `;
            });
            $('#listaEnfermedad').html(template);
        }
    });
}

$(document).ready(function () {
    obtenerEnfermedad();

    $("#cancelar").click(function () {
        $('#divCkeckCompra').show();
        $('#forminsertEnfermedad').trigger('reset');
        indicatorEdit = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    let compra = "0"
    $('#forminsertEnfermedad').submit(function (e) {
        e.preventDefault();

        validarFormulario().then((valido) => {
            if (valido) {
                let id = document.getElementById('id').value;
                let nombre = document.getElementById('nombre').value;
                let descripcion = document.getElementById('descripcion').value;
                let sintomas = document.getElementById('sintomas').value;
                let user_id = document.getElementById('user_id').value;

                
                let opc = indicatorEdit === false ? 1 : 5;
                let url = "../action/enfermedadAction.php";
                const data = {
                    option: opc,
                    id: id,
                    nombre: nombre,
                    descripcion: descripcion,
                    sintomas: sintomas,
                    user_id: user_id
                };
                $.post(url, data, function (response) {
                    let result = response.trim();
                    if (result == "1") {
                        alert("Guardado");
                        obtenerEnfermedad();
                        $('#forminsertEnfermedad').trigger('reset');
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

        let url = '../action/enfermedadAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerEnfermedad();
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
        let url = '../action/enfermedadAction.php';
        $.post(url, data, function (response) {
            const enfermedad = JSON.parse(response);
            $('#id').val(enfermedad[0].tbenfermedadid);
            $('#nombre').val(enfermedad[0].tbenfermedadnombre);
            $('#descripcion').val(enfermedad[0].tbenfermedaddescripcion);
            $('#sintomas').val(enfermedad[0].tbenfermedadsintomas);
            indicatorEdit = true;
            $('.nuevoRegistro').text('Actualizar');
        });
    });

   
 /*   $("#compra").change(function() {
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
    
    */

});
