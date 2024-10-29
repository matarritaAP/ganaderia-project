<?php
include_once '../business/sesionBusiness.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sesionBusiness = new SesionBusiness();
    $resultado = $sesionBusiness->autenticarUsuario($username, $password);

    if ($resultado) {  // Si el resultado no es null, las credenciales son correctas
        // Guardar el rol y el ID en la sesión si las credenciales son correctas
        $_SESSION['user_role'] = $resultado['tbsesionrol'];
        $_SESSION['user_id'] = $resultado['tbsesionid'];
        $_SESSION['productor_id'] = $resultado['tbsesionproductorid'];
        header('Location: ../index.php');
        // exit();
    } else {
        $error = "Credenciales inválidas o usuario inactivo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            text-align: center;
        }
        input {
            margin-bottom: 10px;
        }
        a {
            display: inline-block;
        }
        hr {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Inicio de Sesión</h2>
        <hr>
        <?php if (isset($error)): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label for="username">Usuario:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        <hr>
        <a href="productorView.php">Registrarse</a>
    </div>
</body>
</html>
