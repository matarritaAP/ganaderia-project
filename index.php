<?php
include_once './business/sessionManager.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Integral de Gestión de Fincas</title>
    <style>
        body {
            margin: 20px;
            font-family: Arial, sans-serif;
        }

        header {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: black;
            padding: 5px;
            display: block;
        }

        a:hover {
            text-decoration: underline;
        }

        hr {
            border: none;
            border-top: 2px solid #ccc;
            margin: 20px 0;
        }

        .container {
            margin: 20px auto;
        }

        .section {
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .sub-section {
            padding-left: 20px;
        }

        h3 {
            margin-top: 15px;
            color: #555;
        }
    </style>
</head>

<body>
    <header>
        <hr>
        <h1>Sistema Integral de Gestión de Fincas</h1>
        <hr>
    </header>

    <nav>
        <a href="./view/logout.php">Cerrar Sesión</a>
    </nav>

    <div class="container">
        <?php if (isAdmin()) : ?>
            <div class="section">
                <h2>Administración General</h2>
                <a href="./view/razaView.php">Raza de Ganado</a>
                <a href="./view/estadoView.php">Estado de Ganado</a>
                <a href="./view/herramientaView.php">Herramientas de la Finca</a>
                <a href="./view/naturalezaView.php">Naturaleza de la Finca</a>
                <a href="./view/servicioView.php">Servicios de la Finca</a>
                <a href="./view/tipoProductoAlimenticioView.php">Tipo Producto Alimenticio</a>
                <a href="./view/unidadMedidaView.php">Unidades de Medida</a>
                <a href="./view/tipoMedicamentoView.php">Tipos de Medicamentos</a>
            </div>
        <?php endif; ?>

        <?php if (isProductor()) : ?>
            <div class="section">
                <h2>Gestión de Finca</h2>
                <a href="./view/productorView.php">Información del Productor</a>
                <a href="./view/cvoView.php">Información del CVO</a>
                <a href="./view/fierroView.php">Información del Fierro</a>
                <a href="./view/fincaView.php">Información de la(s) Finca</a>
                <a href="./view/fincaServicioView.php">Servicios en la Finca</a>
                <a href="./view/fincaHerramientaView.php">Herramientas de la Finca</a>
                <a href="./view/fincaNaturalezaView.php">Naturaleza de la Finca</a>
            </div>

            <div class="section">
                <h2>Gestión de Bovinos</h2>
                <a href="./view/razaProductorView.php">Raza de Bovinos</a>
                <a href="./view/estadoProductorView.php">Estados del Bovino</a>
                <a href="./view/bovinoCompraView.php">Gestión de compra de Bovinos</a>
                <a href="#">Gestión de eventos de Bovinos (Venta, Robo, Muerte)</a>
                <div class="sub-section">
                    <h3>Reproducción</h3>
                    <a href="./view/bovinoPartoView.php">Gestión de parto de Bovinos</a>
                </div>
                <div class="sub-section">
                    <h3>Reportes</h3>
                    <a href="./view/bovinoReporteCompraView.php">Reportes de Ganado (Sección Compras)</a>
                    <a href="./view/bovinoReportePartoView.php">Reportes de Ganado (Sección Partos)</a>
                </div>
            </div>

            <div class="section">
                <h2>Gestión de Proveedores y Productos</h2>
                <a href="./view/proveedorView.php">Proveedores</a>
                <a href="./view/herbicidasView.php">Herbicidas</a>
                <a href="./view/fertilizantesView.php">Fertilizantes</a>
                <a href="./view/productoAlimenticioView.php">Productos Alimenticios</a>
                <a href="./view/productoVeterinarioView.php">Producto Veterinario</a>
            </div>

            <div class="section">
                <h2>Gestión de Compras</h2>
                <a href="./view/compraProductoAlimenticioView.php">Compras de Productos Alimenticios</a>
                <a href="./view/compraHerbicidasView.php">Compras de Herbicidas</a>
                <a href="./view/compraFertilizantesView.php">Compras de Fertilizantes</a>
                <a href="./view/compraProductoVeterinarioView.php">Compras producto Veterinario</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>