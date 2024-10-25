<?php
session_start();

$usuarios = [
    'Admi' => 'root',
    'Usuario' => '12345678'
];

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if (isset($usuarios[$usuario]) && $usuarios[$usuario] == $password) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tareas'] = []; // Inicializamos el array de tareas
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Credenciales incorrectas';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
</head>
<body>
    <div>
        <h2>Iniciar Sesión</h2>
            <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
        <form method="POST" action="login.php">
            <label>Usuario:</label>
            <input type="text" name="usuario" required><br>
            <label>Contraseña:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Ingresar</button>
        </form>   
    </div>

</body>
</html>

