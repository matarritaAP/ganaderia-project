let indicatorEdit = false;

// Función principal que inicializa el formulario
$(document).ready(function () {
    initializeForm();

    if (isLoggedIn && !indicatorEdit) {
        cargarDatosProductorLogueado();
    }
});

// Inicializa el formulario
function initializeForm() {
    $("#cancelar").click(resetForm);
    $('#forminsertProductor').submit(handleSubmit);
}

// Resetea el formulario
function resetForm() {
    $('#forminsertProductor').trigger('reset'); // Limpiar formulario
    indicatorEdit = false;
    document.getElementById("docIdentidadProductor").disabled = false;
    $('.nuevoRegistro').text('Registrar');
    // Mostrar el campo de contraseña
    $("#contrasenaContainer").show();
}

// Maneja el envío del formulario
function handleSubmit(e) {
    e.preventDefault(); // Evita el envío del formulario
    validarFormulario(indicatorEdit).then((valido) => {
        if (valido) {
            submitForm();
        }
    });
}

// Función para validar datos del formulario de registro
function validarFormulario(edit) {
    return new Promise((resolve) => {
        const formData = getFormData();

        // Validar tipos de datos y campos requeridos
        const validationErrors = validateFields(formData);
        if (validationErrors.length > 0) {
            alert(validationErrors.join("\n")); // Muestra todos los errores de validación
            resolve(false);
        } else {
            if (!edit) {
                verificarDocumentoExistente(formData.docIdentidad).then(resolve);
            } else {
                resolve(true);
            }
        }
    });
}

// Obtiene los datos del formulario
function getFormData() {
    return {
        docIdentidad: document.getElementById('docIdentidadProductor').value,
        nombreGanaderia: document.getElementById('nombreGanaderia').value,
        nombre: document.getElementById('nombreProductor').value,
        primerApellido: document.getElementById('primerApellidoProductor').value,
        segundoApellido: document.getElementById('segundoApellidoProductor').value,
        fechaNacimiento: document.getElementById('fechaNacimientoProductor').value,
        email: document.getElementById('emailProductor').value,
        telefono: document.getElementById('telefonoProductor').value,
        direccion: document.getElementById('direccionProductor').value,
        contrasenia: document.getElementById('contraseniaProductor').value
    };
}
// Verifica si el teléfono es válido
function isValidPhone(phone) {
    const regex = /^[0-9]{8,15}$/;
    return regex.test(phone);
}

// Verifica si el documento de identidad ya existe
function verificarDocumentoExistente(docIdentidad) {
    return new Promise((resolve) => {
        const data = { option: 6, docIdentidad };
        let url = '../action/productorAction.php';
        $.post(url, data, function (response) {
            if (response.trim() === "0") {
                resolve(true);
            } else {
                alert("El Documento de identidad ya esta asociado a otro usuario.");
                resolve(false);
            }
        });
    });
}

// Verifica si el correo ya existe
function verificarEmailExistente(email) {
    return new Promise((resolve) => {
        const data = { option: 7, email };
        let url = '../action/productorAction.php';
        $.post(url, data, function (response) {
            if (response.trim() === "0") {
                resolve(true);
            } else {
                alert("El correo ingresado ya esta asociado a otro usuario.");
                resolve(false);
            }
        });
    });
}

// Envía el formulario
function submitForm() {
    const formData = getFormData();
    const opc = indicatorEdit === false ? 1 : 5;
    const url = "../action/productorAction.php";
    const data = { option: opc, ...formData };

    $.post(url, data, function (response) {
        handleResponse(response.trim());
    });
}

// Maneja la respuesta del servidor
function handleResponse(result) {
    if (result == "1") {
        alert("Guardado");
        resetForm();
    } else {
        alert("Error al realizar solicitud: " + result);
    }
}

// Función que obtiene los datos del productor logueado
function cargarDatosProductorLogueado() {
    const data = { option: 4 }; 
    const url = "../action/productorAction.php";
    
    $.post(url, data, function (response) {
        try {
            const productor = JSON.parse(response);
            
            if (productor) {
                indicatorEdit = true;
                
                $("#docIdentidadProductor").val(productor.tbproductordocidentidad || '').attr('placeholder', productor.tbproductordocidentidad ? '' : 'No Disponible');
                $("#nombreGanaderia").val(productor.tbproductornombreganaderia || '').attr('placeholder', productor.tbproductornombreganaderia ? '' : 'No Disponible');
                $("#nombreProductor").val(productor.tbproductornombre || '').attr('placeholder', productor.tbproductornombre ? '' : 'No Disponible');
                $("#primerApellidoProductor").val(productor.tbproductorprimerapellido || '').attr('placeholder', productor.tbproductorprimerapellido ? '' : 'No Disponible');
                $("#segundoApellidoProductor").val(productor.tbproductorsegundoapellido || '').attr('placeholder', productor.tbproductorsegundoapellido ? '' : 'No Disponible');
                $("#fechaNacimientoProductor").val(productor.tbproductorfechanac || '').attr('placeholder', productor.tbproductorfechanac ? '' : 'No Disponible');
                $("#emailProductor").val(productor.tbproductoremail || '').attr('placeholder', productor.tbproductoremail ? '' : 'No Disponible');
                $("#telefonoProductor").val(productor.tbproductorcelular || '').attr('placeholder', productor.tbproductorcelular ? '' : 'No Disponible');
                $("#direccionProductor").val(productor.tbproductordireccion || '').attr('placeholder', productor.tbproductordireccion ? '' : 'No Disponible');
                
                $("#contrasenaContainer").hide();
                document.getElementById("docIdentidadProductor").disabled = true;
                $('.nuevoRegistro').text('Actualizar');
            }
        } catch (e) {
            console.error("Error parsing JSON:", e);
        }
    });
}

// ---------------------------------------------
// VALIDACIONES TIPOS DE DATOS


// Valida los campos y tipos de datos
function validateFields(data) {
    const errors = [];

    const messages = {
        required: (field) => `Error: El campo '${field}' es obligatorio y no puede estar vacío.`,
        invalidType: (field) => `Error: El campo '${field}' debe ser un texto válido.`,
        invalidCharacters: (field) => `Error: El campo '${field}' solo debe contener caracteres alfabéticos.`,
        minLength: (field, length) => `Error: La '${field}' debe tener al menos ${length} caracteres.`,
        invalidEmail: () => "Error: El 'email' debe contener una dirección de correo electrónico válida.",
        invalidDate: () => "Error: La 'fecha de nacimiento' debe estar en formato YYYY-MM-DD.",
        invalidPhone: () => "Error: El 'teléfono' debe tener entre 8 y 15 dígitos.",
        optionalInvalidType: (field) => `Advertencia: Si se proporciona, el '${field}' debe ser un texto válido.`,
    };

    const validateRequiredField = (field, condition, minLength) => {
        if (!condition) errors.push(messages.required(field));
        else if (typeof condition !== 'string') errors.push(messages.invalidType(field));
        else if (minLength && condition.length < minLength) errors.push(messages.minLength(field, minLength));
        else if (field !== 'email' && !/^[a-zA-Z\s]*$/.test(condition)) {
            errors.push(messages.invalidCharacters(field));
        }
    };

    validateRequiredField('nombreGanaderia', data.nombre);
    validateRequiredField('nombre', data.nombre);
    validateRequiredField('email', data.email);

    // Validación específica para la contraseña
    if (data.contrasenia && !isValidPassword(data.contrasenia)) {
        errors.push(messages.minLength('contraseña', 6));
    }

    const optionalFields = ['primerApellido', 'segundoApellido', 'direccion'];
    optionalFields.forEach(field => {
        if (data[field] && typeof data[field] !== 'string') {
            errors.push(messages.optionalInvalidType(field));
        } else if (data[field] && !/^[a-zA-Z\s]*$/.test(data[field])) {
            errors.push(messages.invalidCharacters(field)); // Validación para caracteres alfabéticos
        }
    });

    // Validación para el documento de identidad
    if (data.docIdentidad && typeof data.docIdentidad !== 'string') {
        errors.push(messages.optionalInvalidType('docIdentidad')); // Permite números
    }
    
    // Validación del email
    if (!isValidEmail(data.email)) {
        errors.push(messages.invalidEmail());
    }

    if (data.fechaNacimiento && !isValidDate(data.fechaNacimiento)) errors.push(messages.invalidDate());
    if (data.telefono && !isValidPhone(data.telefono)) errors.push(messages.invalidPhone());

    return errors;
}

// Verifica si la contraseña es válida
function isValidPassword(password) {
    return password.length >= 6; // Al menos 6 caracteres
}

// Verifica si el email es válido
function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// Verifica si la fecha es válida
function isValidDate(dateString) {
    return !isNaN(Date.parse(dateString)); // Verifica si la fecha es válida
}
