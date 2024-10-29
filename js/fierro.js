

function obtenerFierro() {

    let option = 2;
    let user_id = document.getElementById('user_id').value;

    $.ajax({
        url: '../action/fierroAction.php',
        data: {
            option: option,
            user_id: user_id
        },
        type: 'POST',
        success: function (response) {
            //console.log(response);
            let list = JSON.parse(response);
            let template = '';
            list.forEach(fierro => {

                let timestamp = new Date().getTime(); // Obtiene la cantidad de milisegundos desde el epoch
                // Construir la URL de la imagen con el parámetro de consulta
                let imagenUrl = `${fierro.tbfierroimagen}?v=${timestamp}`;

                template += `
                    <tr codigo="${fierro.tbfierronumero}">
                     <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td>
                    <td>${fierro.tbfierronumero}</td>
                    <td>${fierro.tbfierrofechaemision}</td>
                    <td>${fierro.tbfierrofechavencimiento}</td>
                    <td>
                        <img src="${imagenUrl}" alt="Imagen" style="max-width: 100px; max-height: 100px;" class="imagen-fierro">
                    </td>
                    <td>
                        <button class="btnRenovar">Renovar</button>
                    </td>
                    </tr>
                `
            });
            $('#listaFierro').html(template);

            $('.imagen-fierro').on('click', function() {
                mostrarImagenGrande(this.src);
            });
        }
    });
}


function mostrarImagenGrande(src) {
    currentImageSrc = src; // Guardar la URL de la imagen actual
    document.getElementById("imgGrande").src = src;
    document.getElementById("imagenGrande").style.display = "block";
}

function cerrarImagen() {
    document.getElementById("imagenGrande").style.display = "none";
}

function descargarImagen() {
    const link = document.createElement('a');
    link.href = currentImageSrc; // Usar la URL de la imagen actual
    link.download = 'imagen.png'; // Nombre de archivo sugerido
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link); // Limpiar el DOM
}

$(document).ready(function () {

    obtenerFierro();

    $("#cancelar").click(function () {
        $('#forminsertFierro').trigger('reset');//limpiar formulario
        indicatorEdit = false;
        document.getElementById("numeroFierro").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = false;
    let indicatorRenovar = "0";
    $('#forminsertFierro').submit(function (e) {
         
        var form = new FormData(this);
        form.append('option', indicatorEdit === false ? 1 : 5);
        form.append('renovar', indicatorRenovar);
        $.ajax({
            url: "../action/fierroAction.php",
            type: "POST",
            data: form,
            contentType: false,
            cache: false,
            processData: false,

            success: function(response){
                //alert(response);
                let result = response.trim();

                if (result == "1") {
                    obtenerFierro();
                    alert("Guardado");
                    $('#forminsertFierro').trigger('reset');//limpiar formulario
                    document.getElementById("numeroFierro").disabled = false;
                    $('.nuevoRegistro').text('Registrar');
                }
                else {
                    alert("Error al realizar solicitud");
                }
                
            }
        });
        e.preventDefault()//Evita el envio del formulario
        
        indicatorEdit = false;
        indicatorRenovar = "0";
    });

    //accion para eliminar Fierro de la tabla
    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement;//accedemos al elemento tr de la tabla
        let codigo = $(element).attr('codigo');//accedemos al atributo del tr para obtener el codigo
        const data = {
            option: 3,
            codigo: codigo
        }

        let url = '../action/fierroAction.php';

        $.post(url, data, function (response) {
            let result = response.trim();
            if (result == "1") {
                obtenerFierro();
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
        let url = '../action/fierroAction.php';
        $.post(url, data, function (response) {
           
            // recivimos la respuesta y la convertimos a formato json
            const fierro = JSON.parse(response);
            
            //asignacion de valores a los inputs del form 
            $('#numeroFierro').val(fierro[0].tbfierronumero);
            $('#numeroFierroHidden').val(fierro[0].tbfierronumero);
            $('#fechaEmisionFierro').val(fierro[0].tbfierrofechaemision);
            $('#fechaVencimientoFierro').val(fierro[0].tbfierrofechavencimiento);
            //cambiamos indicador de editar 
            indicatorEdit = true;
            indicatorRenovar = "0";
            //cambiamos texto del boton submit
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("numeroFierro").disabled = true;
        });
    });

    //accion del boton editar de la tabla
    $(document).on('click', '.btnRenovar', function () {
        let element = $(this)[0].parentElement.parentElement;//accedemos al elemento tr de la tabla
        let codigo = $(element).attr('codigo');//accedemos al atributo del tr para obtener el codigo
        const data = {
            option: 4,
            codigo: codigo
        }
        let url = '../action/fierroAction.php';
        $.post(url, data, function (response) {
           
            // recivimos la respuesta y la convertimos a formato json
            const fierro = JSON.parse(response);
            
            //asignacion de valores a los inputs del form 
            $('#numeroFierro').val(fierro[0].tbfierronumero);
            $('#numeroFierroHidden').val(fierro[0].tbfierronumero);
            $('#fechaEmisionFierro').val(fierro[0].tbfierrofechaemision);
            $('#fechaVencimientoFierro').val(fierro[0].tbfierrofechavencimiento);
            //cambiamos indicador de editar 
            indicatorEdit = true;
            indicatorRenovar = "1";
            //cambiamos texto del boton submit
            $('.nuevoRegistro').text('Renovar');
            document.getElementById("numeroFierro").disabled = true;
        });
    });
});