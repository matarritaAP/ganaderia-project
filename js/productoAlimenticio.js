// Variables globales para almacenar datos de tipo de producto y proveedores
let tiposProducto = {};
let proveedores = {};
let productoID = '';

// Cargar tipos de producto en el select
function cargarTiposProductoAlimenticio() {
    let option = 2;

    $.ajax({
        url: '../action/tipoProductoAlimenticioAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '<option value="" data-descripcion="">Seleccione un tipo</option>';
            list.forEach(tipoProducto => {
                tiposProducto[tipoProducto.nombre] = tipoProducto.descripcion; // Guardar descripción en el objeto
                template += `<option value="${tipoProducto.nombre}" data-descripcion="${tipoProducto.descripcion}">${tipoProducto.nombre}</option>`;
            });
            $('#tipo').html(template);
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar tipos de producto:', error);
        }
    });
}

// Cargar proveedores en el select
function cargarProveedores() {
    let option = 2;

    $.ajax({
        url: '../action/proveedorAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '<option value="">Seleccione un proveedor</option>';
            list.forEach(proveedor => {
                proveedores[proveedor.tbproveedornombrecomercial] = proveedor.tbproveedorcorreo; // Guardar correo en el objeto
                template += `<option value="${proveedor.tbproveedornombrecomercial}">${proveedor.tbproveedornombrecomercial}</option>`;
            });
            $('#proveedor').html(template);
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar proveedores:', error);
        }
    });
}

// Manejar la inserción de un producto alimenticio
$('#forminsertProductoAlimenticio').on('submit', function (e) {
    e.preventDefault();

    let selectedTipo = $('#tipo option:selected');
    let nuevoProducto = {
        nombre: $('#nombre').val(),
        tipoNombre: selectedTipo.val(),
        tipoDescripcion: selectedTipo.data('descripcion'),
        cantidad: $('#cantidad').val(),
        fechaVencimiento: $('#fechaVencimiento').val(),
        proveedor: $('#proveedor').val(),
    };

    $.ajax({
        url: '../action/productoAlimenticioAction.php',
        data: {
            option: 1, // Opción para insertar producto alimenticio
            nombre: nuevoProducto.nombre,
            tipoNombre: nuevoProducto.tipoNombre,
            tipoDescripcion: nuevoProducto.tipoDescripcion,
            cantidad: nuevoProducto.cantidad,
            fechaVencimiento: nuevoProducto.fechaVencimiento,
            proveedorCorreo: proveedores[nuevoProducto.proveedor] // Usar el correo del proveedor
        },
        type: 'POST',
        success: function (response) {
            if (response === "Producto alimenticio insertado correctamente.") {
                alert(response);
                setTimeout(cargarProductosAlimenticios, 500);
            } else {
                alert('Respuesta inesperada: ' + response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error al insertar producto alimenticio:', error);
        }
    });
});

// Manejar la eliminación de un producto alimenticio
$(document).on('click', '.btnEliminar', function () {
    let element = $(this).closest('tr'); // Encuentra el elemento tr más cercano
    let nombre = $(element).find('.productoNombre').text();
    let tipoNombre = $(element).find('.productoTipo').text();
    let tipoDescripcion = tiposProducto[tipoNombre]; // Obtener la descripción del tipo
    let cantidad = $(element).find('.productoCantidad').text();
    let fechaVencimiento = $(element).find('.productoFechaVencimiento').text();
    let proveedorNombre = $(element).find('.productoProveedor').text();
    let proveedorCorreo = proveedores[proveedorNombre]; // Obtener el correo del proveedor

    let datosProducto = {
        nombre: nombre,
        tipoNombre: tipoNombre,
        tipoDescripcion: tipoDescripcion,
        cantidad: cantidad,
        fechaVencimiento: fechaVencimiento,
        proveedorCorreo: proveedorCorreo // Usar el correo del proveedor
    };

    // Mostrar los datos del producto en la consola
    console.log('Datos del producto:', JSON.stringify(datosProducto, null, 2));

    if (confirm('¿Está seguro de que desea eliminar este producto?')) {
        $.ajax({
            url: '../action/productoAlimenticioAction.php',
            data: {
                option: 3, // Opción para eliminar producto alimenticio
                ...datosProducto // Usa el operador spread para enviar todos los datos del producto
            },
            type: 'POST',
            success: function (response) {
                if (response === "Producto alimenticio eliminado correctamente.") {
                    alert(response);
                    setTimeout(cargarProductosAlimenticios, 500);
                } else {
                    alert('Respuesta inesperada: ' + response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar producto alimenticio:', error);
            }
        });
    }
});

function mostrarProductosInactivos() {
    let option = 6;

    $.ajax({
        url: '../action/productoAlimenticioAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            let list = JSON.parse(response);
            let template = '';
            list.forEach(producto => {
                template += `
                    <tr correo="${producto.nombre}">
                    <td class="productoNombre">${producto.nombre}</td>
                    <td class="productoTipo">${producto.tipo}</td>
                    <td class="productoCantidad">${producto.cantidad}</td>
                    <td class="productoFechaVencimiento">${producto.fechavencimiento}</td>
                    <td class="productoProveedor">${producto.proveedor}</td>
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
            mostrarProductosInactivos(); // Mostrar razas inactivas al abrir
        }
    });
};

$(document).on('click', '.btnEditar', function () {
    let element = $(this).closest('tr'); // Encuentra el elemento tr más cercano

    let nombre = $(element).find('.productoNombre').text();
    let tipoNombre = $(element).find('.productoTipo').text();
    let tipoDescripcion = tiposProducto[tipoNombre]; // Obtener la descripción del tipo
    let cantidad = $(element).find('.productoCantidad').text();
    let fechaVencimiento = $(element).find('.productoFechaVencimiento').text();
    let proveedorNombre = $(element).find('.productoProveedor').text();
    let proveedorCorreo = proveedores[proveedorNombre]; // Obtener el correo del proveedor

    let datosProducto = {
        nombre: nombre,
        tipoNombre: tipoNombre,
        tipoDescripcion: tipoDescripcion,
        cantidad: cantidad,
        fechaVencimiento: fechaVencimiento,
        proveedorCorreo: proveedorCorreo // Usar el correo del proveedor
    };

    // Mostrar los datos del producto en la consola
    console.log('Datos del producto:', JSON.stringify(datosProducto, null, 2));

    // Enviar datos al action para obtener el ID del producto
    $.ajax({
        url: '../action/productoAlimenticioAction.php',
        data: {
            option: 4, // Opción para obtener el ID del producto alimenticio
            ...datosProducto // Enviar los datos del producto
        },
        type: 'POST',
        success: function (productoID) {
            if (productoID) {
                // Cargar los datos en los inputs y selects correspondientes
                $('#nombre').val(nombre);
                $('#tipo').val(tipoNombre).change(); // Change trigger para cargar descripción si es necesario
                $('#cantidad').val(cantidad);
                $('#fechaVencimiento').val(fechaVencimiento);
                $('#proveedor').val(proveedorNombre).change();

                // Cambiar el texto del botón de 'Guardar' a 'Actualizar'
                $('#forminsertProductoAlimenticio button[type="submit"]').text('Actualizar');

                // Remover cualquier submit handler anterior para evitar duplicaciones
                $('#forminsertProductoAlimenticio').off('submit');

                // Manejar la actualización del producto alimenticio en el submit
                $('#forminsertProductoAlimenticio').on('submit', function (e) {
                    e.preventDefault();

                    let selectedTipo = $('#tipo option:selected');
                    let nuevoProducto = {
                        nombre: $('#nombre').val(),
                        tipoNombre: selectedTipo.val(),
                        tipoDescripcion: selectedTipo.data('descripcion'),
                        cantidad: $('#cantidad').val(),
                        fechaVencimiento: $('#fechaVencimiento').val(),
                        proveedor: $('#proveedor').val(),
                    };

                    $.ajax({
                        url: '../action/productoAlimenticioAction.php',
                        data: {
                            option: 5, // Opción para actualizar producto alimenticio
                            productoID: productoID, // El ID obtenido anteriormente
                            nombre: nuevoProducto.nombre,
                            tipoNombre: nuevoProducto.tipoNombre,
                            tipoDescripcion: nuevoProducto.tipoDescripcion,
                            cantidad: nuevoProducto.cantidad,
                            fechaVencimiento: nuevoProducto.fechaVencimiento,
                            proveedorCorreo: proveedores[nuevoProducto.proveedor] // Usar el correo del proveedor
                        },
                        type: 'POST',
                        success: function (response) {
                            if (response === "Producto alimenticio modificado correctamente.") {
                                alert(response);
                                setTimeout(cargarProductosAlimenticios, 500);
                            } else {
                                alert('Respuesta inesperada: ' + response);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error al modificar producto alimenticio:', error);
                        }
                    });
                });
            } else {
                alert('Producto alimenticio no encontrado.');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener el ID del producto alimenticio:', error);
        }
    });
});


// Cargar productos alimenticios en la tabla
function cargarProductosAlimenticios() {
    let option = 2; // Ajusta según tu backend

    $.ajax({
        url: '../action/productoAlimenticioAction.php',
        data: { option: option },
        type: 'POST',
        success: function (response) {
            console.log(response);
            let list = JSON.parse(response);
            let template = '';
            list.forEach(producto => {
                template += `
                    <tr>
                        <td class="productoNombre">${producto.nombre}</td>
                        <td class="productoTipo">${producto.tipo}</td>
                        <td class="productoCantidad">${producto.cantidad}</td>
                        <td class="productoFechaVencimiento">${producto.fechavencimiento}</td>
                        <td class="productoProveedor">${producto.proveedor}</td>
                        <td><button class="btnEditar">Editar</button></td>
                        <td><button class="btnEliminar">Eliminar</button></td>
                    </tr>
                `;
            });
            $('#listaProductoAlimenticio').html(template);
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar productos alimenticios:', error);
        }
    });
}

$(document).on('click', '.btnReactivar', function () {
    let element = $(this)[0].parentElement.parentElement; // Accede al elemento tr de la tabla
    //let element = $(this).closest('tr'); // Encuentra el elemento tr más cercano
    let nombre = $(element).find('.productoNombre').text();
    
    let proveedorNombre = $(element).find('.productoProveedor').text();
    let proveedorCorreo = proveedores[proveedorNombre]; // Obtener el correo del proveedor

    if (confirm('¿Está seguro de que desea reactivar este producto?')) {
        $.ajax({
            url: '../action/productoAlimenticioAction.php',
            data: {
                option: 7,
                nombre: nombre,
                proveedorCorreo: proveedorCorreo
            },
            type: 'POST',
            success: function (response) {
                if (response === "1") {
                    alert("Producto reactivado");
                    mostrarProductosInactivos();
                    setTimeout(cargarProductosAlimenticios, 500);
                } else {
                    console.log(response)
                    alert('Respuesta inesperada: ' + response);
                }
            }
        });
    }
});

// Cargar tipos de producto y proveedores al inicio
$(document).ready(function () {
    comportamientoListaInactivos();
    cargarTiposProductoAlimenticio();
    cargarProveedores();
    cargarProductosAlimenticios();
});
