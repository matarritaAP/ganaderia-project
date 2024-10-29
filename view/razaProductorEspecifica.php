<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: login.php');
    exit();
}
?>

<hr>
<h3>Administrar mis razas específicas</h3>

<div class="insertRaza" id="insertRaza"><!--Registro de raza-->
    <div class="container">
        <form class="insertRaza" novalidate id="forminsertRaza">
            <div>
                <input type="hidden" id="codigoraza" requiered>
            </div>
            <div>
                <label for="nombre">
                    Nombre
                </label>
                <input type="text" id="nombreraza" requiered>
            </div>
            <div>
                <label for="descripcion">
                    Descripción
                </label>
                <input type="text" id="descripcionraza" requiered>
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
        <tbody id="listaRaza"></tbody>
    </table>
</div>

<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/raza.js"></script>