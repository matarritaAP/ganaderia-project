<?php
include_once '../business/sessionManager.php';

if (!isLoggedIn() || !isProductor()) {
    header('Location: login.php');
    exit();
}
?>

<hr>
<h3>Administrar mis naturalezas específicas</h3>

<div class="insertNaturaleza" id="insertNaturaleza"><!--Registro de naturaleza-->
    <div class="container">
        <form class="insertNaturaleza" novalidate id="forminsertNaturaleza">
            <div>
                <input type="hidden" id="codigonaturaleza" requiered>
            </div>
            <div>
                <label for="nombre">
                    Nombre
                </label>
                <input type="text" id="nombrenaturaleza" requiered>
            </div>
            <div>
                <label for="descripcion">
                    Descripción
                </label>
                <input type="text" id="descripcionnaturaleza" requiered>
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
                    Nombre
                </th>
                <th>
                    Descripción
                </th>
            </tr>
        </thead>
        <tbody id="listaNaturaleza"></tbody>
    </table>
</div>

<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/naturaleza.js"></script>