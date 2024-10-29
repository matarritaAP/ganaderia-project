<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: login.php');
    exit();
}
?>

<hr>
<h3>Administrar mis servicios específicos</h3>

<div class="insertarServicio" id="insertarServicio">
    <div class="container">
        <form class="insertarServicio" novalidate id="forminsertServicio">
            <div>
                <input type="hidden" id="codigoservicio" requiered>
            </div>
            <div>
                <label for="nombre">
                    Nombre
                </label>
                <input type="text" id="nombreservicio" requiered>
            </div>
            <div>
                <label for="descripcion">
                    Descripcion
                </label>
                <input type="text" id="descripcionservicio" requiered>
            </div>
            <br>
            <div id="btnRegistrar">
                <button type="submit" class="nuevoRegistro">
                    Registrar
                </button>
                <button id="cancelar" type="button">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
<hr><br>
<div class="container" id="container">
    <!--Tabla para mostrar los datos-->
    <table>
        <thead>
            <tr>
                <th>Código generado por el sistema</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Actualizar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody id="listaServicio"></tbody>
    </table>
</div>
<hr>
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/servicio.js"></script>