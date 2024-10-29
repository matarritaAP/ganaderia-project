<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: login.php');
    exit();
}
?>

<hr>
<h3>Administrar mis estados específicos</h3>

<div class="insertEstado" id="insertEstado"><!--Registro de raza-->
    <div class="container">
        <form class="insertEstado" novalidate id="forminsertEstado">
            <div>
                <input type="hidden" id="codigoestado" requiered>
            </div>
            <div>
                <label for="nombre">
                    Nombre
                </label>
                <input type="text" id="nombreestado" requiered>
            </div>
            <div>
                <label for="descripcion">
                    Descripción
                </label>
                <input type="text" id="descripcionestado" requiered>
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
<div class="container" id="container"><!--Tabla para mostrar los datos-->
    <table>
        <thead>
            <tr>
                <th>
                    Codigo
                </th>
                <th>
                    Nombre
                </th>
                <th>
                    Descripción
                </th>
            </tr>
        </thead>
        <tbody id="listaEstado"></tbody>
    </table>
</div>

<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/estado.js"></script>