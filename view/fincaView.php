<?php

include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: ./login.php'); // !Productor -> Ir a login
    exit();
}
$script = str_replace('/view/', '/', $_SERVER['PHP_SELF']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($script) . '/index.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <title>Sección Finca</title>
    <link href="./css/estilo-simple.css" rel="stylesheet">
</head>

<body>
    <header>
        <li><button onclick="window.location.href = '<?php echo $base_url; ?>'">Volver</button></li>
        <hr>
        <h1>Administración de mi Finca</h1>
        <hr>
    </header>
    <div class="insertFinca" id="insertFinca">
        <div class="container">
            <form class="insertFinca" novalidate id="forminsertFinca">
                <div>
                    <label for="numPlano">Numero de Plano</label>
                    <input type="text" id="numPlanoFinca">
                </div>
                <div>
                    <h3>Coordenadas</h3>
                    <label for="latitud">Latitud</label>
                    <input type="number" id="latitudFinca" step="0.000001" min="-90" max="90" placeholder="Latitud">
                    <label for="longitud">Longitud</label>
                    <input type="number" id="longitudFinca" step="0.000001" min="-180" max="180" placeholder="Longitud">
                </div>

                <br>
                <div>
                    <label for="areaPastoreo">Área de Pastoreo en metros cuadrados (m²)</label>
                    <input type="number" id="areaPastoreoFinca" step="0.1" min="0" placeholder="opcional">
                </div>
                <div>
                    <label for="areaConstruccion">Área de Construcción en metros cuadrados (m²)</label>
                    <input type="number" id="areaConstruccionFinca" step="0.1" min="0" placeholder="opcional">
                </div>
                <div>
                    <label for="areaForestal">Área Forestal en metros cuadrados (m²)</label>
                    <input type="number" id="areaForestalFinca" step="0.1" min="0" placeholder="opcional">
                </div>
                <div>
                    <label for="areaCamino">Área de Camino en metros cuadrados (m²)</label>
                    <input type="number" id="areaCaminoFinca" step="0.1" min="0" placeholder="opcional">
                </div>
                <div id="customCriteriaContainer">
                    <h3>Criterios Personalizados</h3>
                    <div id="customCriteriaList"></div>
                    <button id="addCriteriaButton" type="button">Agregar Criterio</button>
                </div>

                <br />
                <div id="areaTotalContainer" style="display: true">
                    <label for="areaTotal">Área Total en metros cuadrados (m²)</label>
                    <input type="number" id="areaTotalFinca" step="0.1" min="0" placeholder="Total">
                </div>
                <div id="areaDisponibleContainer" style="display: none">
                    <label for="areaDisponible">Área Disponible en metros cuadrados (m²)</label>
                    <input type="number" id="areaDisponibleFinca" step="0.1" min="0" placeholder="Área Disponible" readonly>
                </div>
                <br>
                <!-- Contenedor para el mapa -->
                <div id="map"></div>
                <br>
                <div id="btnRegistrar">
                    <button type="submit" class="nuevoRegistro">Registrar</button>
                    <button id="cancelar" type="button">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <hr><br>
    <div class="container" id="container">
        <table>
            <thead>
                <tr>
                    <th>Número de Plano</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Área de Total</th>
                    <th>Área de Patosreo</th>
                    <th>Área de Construcción</th>
                    <th>Área Forestal</th>
                    <th>Área de Camino</th>
                </tr>
            </thead>
            <tbody id="listaFinca"></tbody>
        </table>
    </div>
    <hr>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/finca.js"></script>
</body>

</html>