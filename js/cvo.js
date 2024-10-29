function validarFormulario(indicatorEdit) {
    return new Promise((resolve) => {
        const numeroCVO = $('#numeroCVO').val().trim();
        const fechaEmision = new Date($('#fechaEmisionCVO').val());
        const fechaVencimiento = new Date($('#fechaVencimientoCVO').val());

        // Validar campos vacíos
        if (!validarCamposCVO()) {
            alert("Debe completar todos los campos.");
            resolve(false);
            return;
        }

        // Validar fecha de emisión y vencimiento
        if (fechaEmision > fechaVencimiento) {
            alert("La fecha de emisión no puede ser más reciente que la fecha de vencimiento.");
            resolve(false);
            return;
        }

        // Validar número de CVO repetido solo si no estamos en modo de edición
        if (!indicatorEdit) {
            verificarNumeroRepetido(numeroCVO).then((numeroRepetidoValido) => {
                if (!numeroRepetidoValido) {
                    resolve(false);
                } else {
                    resolve(true);
                }
            });
        } else {
            resolve(true);
        }
    });
}

function verificarNumeroRepetido(numeroCVO) {
    return new Promise((resolve) => {
        const data = { option: 6, numeroCVO: numeroCVO };
        let url = '../action/cvoAction.php';
        $.post(url, data, function (response) {
            if (response.trim() === "0") {
                resolve(true);
            } else {
                alert("El número de CVO ya existe, intente con otro.");
                resolve(false);
            }
        });
    });
}

function validarCamposCVO() {
    const numeroCVO = $('#numeroCVO').val().trim();
    const fechaEmisionCVO = $('#fechaEmisionCVO').val();
    const fechaVencimientoCVO = $('#fechaVencimientoCVO').val();
    const imagenCVO = $('#imagenCVO').val();

    if (numeroCVO === "" || fechaEmisionCVO === "" || fechaVencimientoCVO === "" || imagenCVO === "") {
        return false;
    }
    return true;
}

function obtenerCVO() {
    let option = 2;

    $.ajax({
        url: '../action/cvoAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            console.log(response);
            let list = JSON.parse(response);
            let template = '';
            list.forEach(CVO => {

                let timestamp = new Date().getTime(); // Obtiene la cantidad de milisegundos desde el epoch
                let imagenUrl = `${CVO.tbcvoimagen}?v=${timestamp}`;

                template += `
                    <tr codigo="${CVO.tbcvonumero}">
                    <td>${CVO.tbcvonumero}</td>
                    <td>${CVO.tbcvofechaEmision}</td>
                    <td>${CVO.tbcvofechaVencimiento}</td>
                    <td><img src="${imagenUrl}" alt="Imagen" style="max-width: 100px; max-height: 100px;"></td>
                    
                    <td>
                        <button class="btnEdit">Editar</button>
                    </td>
                    <td>
                        <button class="btnRenovar">Renovar</button>
                    </td>
                    <td>
                        <button class="btndelete">Eliminar</button>
                    </td> 
                    </tr>
                `;
            });
            $('#listaCVO').html(template);
        }
    });
}

$(document).ready(function () {
    obtenerCVO();

    $("#cancelar").click(function () {
        $('#forminsertCVO').trigger('reset'); // Limpiar formulario
        indicatorEdit.isEditing = false;
        indicatorEdit.isRenewing = false;
        document.getElementById("numeroCVO").disabled = false;
        $('.nuevoRegistro').text('Registrar');
    });

    let indicatorEdit = { isEditing: false, isRenewing: false };
    $('#forminsertCVO').submit(function (e) {
        e.preventDefault(); // Prevenir el envío del formulario para validaciones

        validarFormulario(indicatorEdit).then((valido) => {
            if (valido) {
                var form = new FormData(this);

                
                // Si estamos renovando, no deshabilitamos el número de CVO para la nueva inserción
                if (indicatorEdit.isRenewing) {
                    form.append('numeroCVO', $('#numeroCVO').val());
                    indicatorEdit.isRenewing = false; // Después de renovación, vuelve a estado normal
                }

                // Si estamos editando, añade el valor del campo oculto
                if (indicatorEdit.isEditing) {
                    form.append('numeroCVO', $('#numeroCVOHidden').val());
                }

                form.append('option', indicatorEdit.isEditing === false ? 1 : 5);
                $.ajax({
                    url: "../action/cvoAction.php",
                    type: "POST",
                    data: form,
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function (response) {
                        let result = response.trim();

                        if (result == "1") {
                            obtenerCVO();
                            alert("Guardado");
                            $('#forminsertCVO').trigger('reset');
                            indicatorEdit.isEditing = false; // Resetear indicador después de guardado
                            indicatorEdit.isRenewing = false; 
                        } else {
                            alert("Error: " + result);
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '.btnEdit', function () {
        let element = $(this)[0].parentElement.parentElement; // Accedemos al elemento tr de la tabla
        let codigo = $(element).attr('codigo'); // Accedemos al atributo del tr para obtener el código
        console.log("Código CVO seleccionado para editar:", codigo);
    
        const data = {
            option: 4,
            codigo: codigo
        };
        
        let url = '../action/cvoAction.php'; // Mantén la URL de la acción correspondiente
        $.post(url, data, function (response) {
            // Recibimos la respuesta y la convertimos a formato JSON
            const cvo = JSON.parse(response);
            
            // Asignación de valores a los inputs del formulario
            $('#numeroCVO').val(cvo[0].tbcvonumero);
            $('#numeroCVOHidden').val(cvo[0].tbcvonumero);
            $('#fechaEmisionCVO').val(cvo[0].tbcvofechaEmision);
            $('#fechaVencimientoCVO').val(cvo[0].tbcvofechaVencimiento);
            
            // Cambiamos indicador de editar
            indicatorEdit = true;
            // Cambiamos texto del botón submit
            $('.nuevoRegistro').text('Actualizar');
            document.getElementById("numeroCVO").disabled = true; // Deshabilitamos el campo del número de CVO
        });
    });

    $(document).on('click', '.btnRenovar', function () {
        let element = $(this)[0].parentElement.parentElement;
        let codigo = $(element).attr('codigo');
        console.log("Código CVO seleccionado para renovar:", codigo);
        
        const data = {
            option: 4,
            codigo: codigo
        };
        
        let url = '../action/cvoAction.php';
        $.post(url, data, function (response) {
            const cvo = JSON.parse(response);

            // Cargamos los datos del CVO a renovar
            $('#numeroCVO').val(cvo[0].tbcvonumero);
            $('#fechaEmisionCVO').val(cvo[0].tbcvofechaEmision);
            $('#fechaVencimientoCVO').val(cvo[0].tbcvofechaVencimiento);

            // Cambiamos indicador de renovación
            indicatorEdit.isRenewing = true;
            // Cambiamos texto del botón submit a 'Renovar'
            $('.nuevoRegistro').text('Renovar');
            document.getElementById("numeroCVO").disabled = false; // Habilitamos el campo para un nuevo CVO
        });
    });
    

    $(document).on('click', '.btndelete', function () {
        let element = $(this)[0].parentElement.parentElement;
        let codigo = $(element).attr('codigo');
        let option = 3;

        const confirmacion = confirm("¿Seguro de eliminar el CVO " + codigo + " ?");
        if (confirmacion) {
            $.post('../action/cvoAction.php', { codigo, option }, function (response) {
                obtenerCVO();
            });
        }
    });
});
