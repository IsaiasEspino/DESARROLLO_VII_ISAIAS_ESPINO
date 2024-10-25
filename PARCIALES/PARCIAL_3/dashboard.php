<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$tareas = $_SESSION['tareas'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>

    <h3>Tareas</h3>
    <ul>
        <?php foreach ($tareas as $tarea): ?>
            <li><?php echo $tarea['titulo'] . ' - Fecha límite: ' . $tarea['fecha']; ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Agregar Tarea</h3>
    <form method="POST" action="agregar_tarea.php">
        <label>Título de la tarea:</label>
        <input type="text" name="titulo" required><br>
        <label>Fecha límite:</label>
        <input type="date" name="fecha" required><br>
        <button type="submit">Agregar</button>
    </form>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
