// variables globales
let indicatorEdit = false;
let areaTotalFinca = 0;
let areaDisponible = 0;
let map, marker;

const originalAreas = {
    areaPastoreo: 0,
    areaConstruccion: 0,
    areaForestal: 0,
    areaCamino: 0
};

// Función para inicializar el módulo
$(document).ready(() => {
    initMap();
    obtenerFincas();
    agregarListenersFormulario();
    agregarListenersAcciones();
});

// Función para validar los criterios
function validarCriterios() {
    const criteriosValores = document.querySelectorAll('.criterioValor');
    for (let input of criteriosValores) {
        if (input.value.trim() === '') {
            mostrarAlerta("No se pueden dejar valores en blanco en los criterios personalizados.");
            return false;
        }
    }
    return true;
}

// Función para validar formulario
async function validarFormulario(edit) {
    const numPlano = obtenerValorElemento('numPlanoFinca');
    const latitud = obtenerValorElemento('latitudFinca');
    const longitud = obtenerValorElemento('longitudFinca');
    const areaPastoreo = obtenerValorElemento('areaPastoreoFinca');
    const areaConstruccion = obtenerValorElemento('areaConstruccionFinca');
    const areaForestal = obtenerValorElemento('areaForestalFinca');
    const areaCamino = obtenerValorElemento('areaCaminoFinca');

    if (!validarCampos(numPlano, latitud, longitud, areaPastoreo, areaConstruccion, areaForestal, areaCamino)) { return false; }
    if (!validarCriterios()) return false;
    return edit || await verificarDocumentoExistente(numPlano);
}

// Validación de campos del formulario
function validarCampos(numPlano, latitud, longitud, areaPastoreo, areaConstruccion, areaForestal, areaCamino) {
    const numeroRegex = /^-?\d+(\.\d+)?$/;

    if (!numPlano.trim()) return mostrarAlerta("Debe ingresar el número de plano.");
    if (!validarCoordenada(latitud, -90, 90, "latitud")) return false;
    if (!validarCoordenada(longitud, -180, 180, "longitud")) return false;

    if (!validarNumero(areaPastoreo, "área de pastoreo", numeroRegex)) return false;
    if (!validarNumero(areaConstruccion, "área de construcción", numeroRegex)) return false;
    if (!validarNumero(areaForestal, "área forestal", numeroRegex)) return false;
    if (!validarNumero(areaCamino, "área de camino", numeroRegex)) return false;

    return true;
}

// Función auxiliar para validación de coordenadas
function validarCoordenada(valor, min, max, tipo) {
    if (valor.trim()) {
        const numero = parseFloat(valor);
        if (isNaN(numero) || numero < min || numero > max) {
            return mostrarAlerta(`Por favor, ingrese un valor numérico válido para la ${tipo} entre ${min} y ${max}.`);
        }
    }
    return true;
}

// Validación de números en áreas
function validarNumero(valor, campo, regex) {
    if (valor.trim() && !regex.test(valor)) {
        return mostrarAlerta(`Por favor, ingrese un valor numérico válido para el ${campo}.`);
    }
    return true;
}

// Mostrar alerta de validación
function mostrarAlerta(mensaje) {
    alert(mensaje);
    return false;
}

// Verificar si el documento ya existe
function verificarDocumentoExistente(numPlano) {
    const url = '../action/fincaAction.php';
    const data = { option: 6, numPlano };

    return $.post(url, data).then(response => {
        if (response.trim() !== "0") {
            mostrarAlerta("El número de plano ya existe");
            return false;
        }
        return true;
    });
}

// Obtener lista de fincas
function obtenerFincas() {
    const url = '../action/fincaAction.php';
    const data = { option: 2 };

    $.post(url, data, response => {
        try {
            const fincas = JSON.parse(response);
            //console.log(response);
            renderizarFincas(fincas);
        } catch (e) {
            console.error("Error al parsear el JSON:", e, response); // Verifica si el JSON de respuesta está correcto
        }
    });
}

// Renderizar fincas en la tabla
function renderizarFincas(fincas) {
    // Limpiar contenido previo
    $('#listaFinca').html('');

    let template = fincas.map(finca => `
        <tr numPlano="${finca.tbfincanumplano}">
            <td>${finca.tbfincanumplano}</td>
            <td>${finca.tbfincalatitud || 'No disponible'}</td>
            <td>${finca.tbfincalongitud || 'No disponible'}</td>
            <td>${finca.tbfincaareatotal || 'No disponible'}</td>
            <td>${finca.tbfincaareapastoreo || 'No disponible'}</td>
            <td>${finca.tbfincaareaconstruccion || 'No disponible'}</td>
            <td>${finca.tbfincaareaforestal || 'No disponible'}</td>
            <td>${finca.tbfincaareacamino || 'No disponible'}</td>
            <td><button class="btnEdit">Editar</button></td>
            <td><button class="btndelete">Eliminar</button></td>
        </tr>
    `).join('');

    $('#listaFinca').html(template);
}


// Cargar datos de criterios de personalizados de la finca
function cargarCriterios(finca) {
    // Obtener el contenedor para los criterios
    const criteriosContainer = document.getElementById('customCriteriaContainer');

    // Verificar si el contenedor existe
    if (criteriosContainer) {
        // Limpiar criterios existentes
        criteriosContainer.innerHTML = '';

        // Obtener los criterios (en este caso, areaOtraCriterio)
        const criterios = finca.areaOtraCriterio || {};  // Si no existe, asignar un objeto vacío

        // Verificar si hay criterios
        if (Object.keys(criterios).length > 0) {
            // Iterar sobre los criterios (que están en formato clave-valor)
            Object.entries(criterios).forEach(([nombre, valor]) => {
                const criterioContainer = document.createElement('div');
                criterioContainer.className = 'custom-criterion';

                const labelCriterio = document.createElement('label');
                labelCriterio.innerText = nombre;

                const inputValor = document.createElement('input');
                inputValor.type = 'number';
                inputValor.value = valor;
                inputValor.className = 'criterioValor';
                inputValor.step = "0.1";
                inputValor.min = "0";

                const removeButton = document.createElement('button');
                removeButton.innerText = 'Eliminar';
                removeButton.type = 'button';
                removeButton.addEventListener('click', () => {
                    criterioContainer.remove();
                });

                criterioContainer.appendChild(labelCriterio);
                criterioContainer.appendChild(inputValor);
                criterioContainer.appendChild(removeButton);

                criteriosContainer.appendChild(criterioContainer);
            });
        } else {
            // Si no hay criterios, mostrar mensaje
            criteriosContainer.innerHTML = '<p>No hay criterios asociados a esta finca.</p>';
        }
    } else {
        console.error('No se encontró el contenedor de criterios');
    }
}

// Cargar datos de finca seleccionada en el formulario
function cargarDatosFinca(finca) {
    cargarCriterios(finca);

    areaTotalFinca = parseFloat(finca.areaTotal) || 0;
    originalAreas.areaPastoreo = parseFloat(finca.areaPastoreo) || 0;
    originalAreas.areaConstruccion = parseFloat(finca.areaConstruccion) || 0;
    originalAreas.areaForestal = parseFloat(finca.areaForestal) || 0;
    originalAreas.areaCamino = parseFloat(finca.areaCamino) || 0;

    $('#numPlanoFinca').val(finca.numPlano);
    $('#latitudFinca').val(finca.latitud);
    $('#longitudFinca').val(finca.longitud);
    $('#areaTotalFinca').val(finca.areaTotal);
    $('#areaPastoreoFinca').val(finca.areaPastoreo);
    $('#areaConstruccionFinca').val(finca.areaConstruccion);
    $('#areaForestalFinca').val(finca.areaForestal);
    $('#areaCaminoFinca').val(finca.areaCamino);

    // Mover el marcador a la ubicación de la finca seleccionada
    const lat = parseFloat(finca.latitud);
    const lng = parseFloat(finca.longitud);
    if (!isNaN(lat) && !isNaN(lng)) {
        marker.setLatLng([lat, lng]);  // Mueve el marcador
        map.setView([lat, lng], 16);   // Centra el mapa en la nueva posición
    }

    actualizarAreaTotalYDisponible();
}

// Actualizar el área total y disponible
function actualizarAreaTotalYDisponible(event) {
    const areaPastoreo = obtenerValorNumerico('areaPastoreoFinca');
    const areaConstruccion = obtenerValorNumerico('areaConstruccionFinca');
    const areaForestal = obtenerValorNumerico('areaForestalFinca');
    const areaCamino = obtenerValorNumerico('areaCaminoFinca');

    const sumaAreas = areaPastoreo + areaConstruccion + areaForestal + areaCamino;

    areaTotalFinca = sumaAreas;

    const areaTotalInput = document.getElementById('areaTotalFinca');
    areaTotalInput.disabled = indicatorEdit; // Desactivar si se está editando

    if (!indicatorEdit) {
        areaTotalInput.value = areaTotalFinca.toFixed(1); // Mostrar el valor actualizado
    }

    if (indicatorEdit && sumaAreas > areaTotalFinca) {
        mostrarAlerta('La suma de las áreas excede el área total de la finca.');
        restablecerValorCampo(event.target.id);
        return;
    }

    areaDisponible = areaTotalFinca - sumaAreas;
    actualizarCamposDeArea();
}

// Restablecer valor original de un campo de área
function restablecerValorCampo(campoModificado) {
    const areas = {
        'areaPastoreoFinca': originalAreas.areaPastoreo,
        'areaConstruccionFinca': originalAreas.areaConstruccion,
        'areaForestalFinca': originalAreas.areaForestal,
        'areaCaminoFinca': originalAreas.areaCamino
    };
    if (campoModificado && areas[campoModificado]) {
        document.getElementById(campoModificado).value = areas[campoModificado];
    }
}

// Actualizar los valores de los campos de área total y disponible
function actualizarCamposDeArea() {
    document.getElementById('areaTotalFinca').value = areaTotalFinca.toFixed(1);
    document.getElementById('areaDisponibleFinca').value = Math.max(areaDisponible, 0).toFixed(1);
}

// Inicializar mapa
function initMap() {
    console.log('initMap');
    map = L.map('map').setView([9.7489, -83.7534], 8);
    configurarCapasMapa();
    inicializarMarcador();
    // Agregar buscador al mapa
    L.Control.geocoder({
        defaultMarkGeocode: false
    })
        .on('markgeocode', function (e) {
            const bbox = e.geocode.bbox;
            const latlng = e.geocode.center;

            // Mover el marcador al lugar buscado
            marker.setLatLng(latlng);
            map.fitBounds([
                [bbox.getSouthEast().lat, bbox.getSouthEast().lng],
                [bbox.getNorthWest().lat, bbox.getNorthWest().lng]
            ]);
            actualizarCoordenadasMarker(); // Actualiza las coordenadas en los inputs
        })
        .addTo(map);
}

// Configuración de las capas del mapa
function configurarCapasMapa() {
    const streets = crearCapaMapa('streets', 'png');
    const satellite = crearCapaMapa('satellite', 'jpg');
    const terrain = crearCapaMapa('topo', 'png');

    streets.addTo(map);

    const baseMaps = { "Calles": streets, "Satélite": satellite, "Terreno": terrain };
    L.control.layers(baseMaps).addTo(map);
}

// Función genérica para crear capas del mapa
function crearCapaMapa(tipo, formato) {
    return L.tileLayer(`https://api.maptiler.com/maps/${tipo}/{z}/{x}/{y}.${formato}?key=0HSlYnj6lybFzzxftH62`, {
        attribution: '&copy; <a href="https://www.maptiler.com/copyright/">MapTiler</a> | <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | contributors'
    });
}

// Inicializar marcador en el mapa
function inicializarMarcador() {
    marker = L.marker([9.7489, -83.7534], { draggable: true }).addTo(map);
    marker.on('dragend', actualizarCoordenadasMarker);
    map.on('click', function (e) {
        const latlng = e.latlng;
        marker.setLatLng(latlng);  // Mueve el marcador al lugar clickeado
        actualizarCoordenadasMarker(); // Actualiza las coordenadas en los inputs
    });
}

// Actualizar coordenadas del marcador
function actualizarCoordenadasMarker() {
    const lat = marker.getLatLng().lat;
    const lng = marker.getLatLng().lng;
    document.getElementById('latitudFinca').value = lat;
    document.getElementById('longitudFinca').value = lng;
}

// Obtener valor de un input HTML por ID
function obtenerValorElemento(id) {
    return document.getElementById(id).value || '';
}

// Obtener valor numérico de un input HTML
function obtenerValorNumerico(id) {
    return parseFloat(obtenerValorElemento(id)) || 0;
}

// Restablecer formulario y mapa
function resetMap() {
    $('#forminsertFinca').trigger('reset');
    marker.setLatLng([9.7489, -83.7534]);
    map.setView([9.7489, -83.7534], 8);
}

// Agregar listeners al formulario
function agregarListenersFormulario() {
    document.getElementById('addCriteriaButton').addEventListener('click', agregarCriterio);
    ['areaPastoreoFinca', 'areaConstruccionFinca', 'areaForestalFinca', 'areaCaminoFinca']
        .forEach(id => {
            document.getElementById(id).addEventListener('input', actualizarAreaTotalYDisponible);
        });

    document.getElementById('areaTotalFinca').addEventListener('input', (event) => {
        if (indicatorEdit) {
            event.target.disabled = true; // Desactivar si se está editando
        }
    });

    $('#forminsertFinca').submit(event => {
        event.preventDefault();
        procesarFormulario();
    });

    $("#cancelar").click(() => {
        indicatorEdit = false;
        resetMap();
        resetFormulario();
    });
}

// Procesar el envío del formulario
function procesarFormulario() {
    validarFormulario(indicatorEdit).then(valido => {
        if (!valido) return;

        const data = obtenerDatosFormulario();
        enviarFormulario(data).then(() => {

            obtenerFincas();
            resetFormulario();
            location.reload();
        });
    });
}

// Obtener los datos de los criterios
function obtenerCriteriosFormulario() {
    const criterios = {};
    const criterioDivs = document.querySelectorAll('.custom-criterion');

    criterioDivs.forEach(div => {
        const nombreInput = div.querySelector('.criterioNombre') || div.querySelector('label');
        const valorInput = div.querySelector('.criterioValor');

        if (nombreInput && valorInput) {
            const nombre = nombreInput.tagName === 'INPUT' ? nombreInput.value.trim() : nombreInput.textContent.trim();
            const valor = parseFloat(valorInput.value);
            if (nombre && !isNaN(valor)) {
                criterios[nombre] = valor;
            }
        } else {
            console.error('No se encontró el campo de nombre o valor en el criterio:', div);
        }
    });
    return criterios;
}



// Obtener datos del formulario
function obtenerDatosFormulario() {
    const areaPastoreo = obtenerValorNumerico('areaPastoreoFinca');
    const areaConstruccion = obtenerValorNumerico('areaConstruccionFinca');
    const areaForestal = obtenerValorNumerico('areaForestalFinca');
    const areaCamino = obtenerValorNumerico('areaCaminoFinca');
    const areaTotal = areaPastoreo + areaConstruccion + areaForestal + areaCamino;

    const criterios = obtenerCriteriosFormulario();
    console.log(criterios);

    return {
        option: indicatorEdit ? 5 : 1,
        numPlano: obtenerValorElemento('numPlanoFinca'),
        latitud: obtenerValorElemento('latitudFinca'),
        longitud: obtenerValorElemento('longitudFinca'),
        areaTotal: areaTotal,
        areaPastoreo: areaPastoreo,
        areaConstruccion: areaConstruccion,
        areaForestal: areaForestal,
        areaCamino: areaCamino,
        criterios: criterios
    };
}

// Enviar el formulario a través de AJAX
function enviarFormulario(data) {
    const url = "../action/fincaAction.php";
    return $.post(url, data).then(response => {

        const result = response.trim();
        if (result === "1") {
            if (data.option === 5) {
                alert("Finca Modificada correctamente.");
            }else{
                alert("Finca Agregada correctamente.");
            }
        } else {
            mostrarAlerta("Error al realizar la solicitud.");
            console.error("Error al realizar la solicitud:", result);
        }
    });
}

// Restablecer formulario y UI
function resetFormulario() {
    $('#customCriteriaContainer').text('reset');
    $('#forminsertFinca').trigger('reset');
    $('.nuevoRegistro').text('Registrar');
    $('#areaDisponibleContainer').hide();
    $('#customCriteriaContainer').hide();
    document.getElementById("numPlanoFinca").disabled = false;
}

// Agregar listeners a las acciones de edición y eliminación
function agregarListenersAcciones() {
    $(document).on('click', '.btndelete', eliminarFinca);
    $(document).on('click', '.btnEdit', editarFinca);
}

// Eliminar finca seleccionada
function eliminarFinca() {
    const numPlano = obtenerNumPlano(this);
    const url = "../action/fincaAction.php";
    const data = { option: 3, numPlano };

    $.post(url, data).then(response => {
        if (response.trim() === "1") {
            obtenerFincas();
            alert("Finca eliminada correctamente.");
        } else {
            mostrarAlerta("Error al eliminar la finca seleccionada.");
        }
    });
}

// Editar finca seleccionada
function editarFinca() {
    const numPlano = obtenerNumPlano(this);
    const url = "../action/fincaAction.php";
    const data = { option: 4, numPlano };

    $.post(url, data, response => {
        try {
            const finca = JSON.parse(response);
            if (finca && finca.numPlano) {
                cargarDatosFinca(finca);
                activarEdicion();
            }
        } catch (e) {
            console.error("Error al parsear el JSON:", e, response);
        }
    });
}

// Función para agregar un nuevo criterio
function agregarCriterio() {
    const criterioContainer = document.createElement('div');
    criterioContainer.className = 'custom-criterion';

    const inputCriterio = document.createElement('input');
    inputCriterio.type = 'text';
    inputCriterio.placeholder = 'Nombre del criterio';
    inputCriterio.className = 'criterioNombre';

    const inputValor = document.createElement('input');
    inputValor.type = 'number';
    inputValor.placeholder = 'Valor (m²)';
    inputValor.className = 'criterioValor';
    inputValor.step = "0.1";
    inputValor.min = "0";

    const removeButton = document.createElement('button');
    removeButton.innerText = 'Eliminar';
    removeButton.type = 'button';
    removeButton.addEventListener('click', () => {
        criterioContainer.remove(); // Eliminar el criterio
        actualizarAreaTotalYDisponible(); // Actualizar áreas después de eliminar
    });

    criterioContainer.appendChild(inputCriterio);
    criterioContainer.appendChild(inputValor);
    criterioContainer.appendChild(removeButton);

    document.getElementById('customCriteriaList').appendChild(criterioContainer);

    // Agregar listener para actualizar áreas cuando se cambie el valor
    inputValor.addEventListener('input', actualizarAreaTotalYDisponible);
}

// Obtener número de plano del elemento seleccionado
function obtenerNumPlano(elemento) {
    return $(elemento).closest('tr').attr('numPlano');
}

// Activar el modo de edición
function activarEdicion() {
    indicatorEdit = true;
    $('.nuevoRegistro').text('Actualizar');
    document.getElementById("numPlanoFinca").disabled = true;
    $('#areaTotalContainer').show(); // Mostrar el campo de área total
    $('#areaDisponibleContainer').show(); // Mostrar el campo de área disponible
}
