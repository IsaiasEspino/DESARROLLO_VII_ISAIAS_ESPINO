<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha'];
    $fecha_actual = date('Y-m-d');

    if (empty($titulo) || empty($fecha)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif ($fecha < $fecha_actual) {
        $error = 'La fecha límite debe ser una fecha futura.';
    } else {
        $nueva_tarea = ['titulo' => $titulo, 'fecha' => $fecha];
        $_SESSION['tareas'][] = $nueva_tarea;
        header('Location: dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Tarea</title>
</head>
<body>
    <h3>Agregar Tarea</h3>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="agregar_tarea.php">
        <label>Título de la tarea:</label>
        <input type="text" name="titulo" required><br>
        <label>Fecha límite:</label>
        <input type="date" name="fecha" required><br>
        <button type="submit">Agregar</button>
    </form>
    <a href="dashboard.php">Regresar</a>
</body>
</html>
