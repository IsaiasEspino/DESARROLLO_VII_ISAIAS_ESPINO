<?php
session_start();
require_once '../config/config.php';

// Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION['google_id'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

// Verifica que se haya enviado el ID del libro para eliminar
if (isset($_POST['google_books_id'])) {
    $googleBooksId = $_POST['google_books_id'];

    // Conectar a la base de datos y eliminar el libro
    $db = connectDB();
    $stmt = $db->prepare("DELETE FROM libros_guardados WHERE google_books_id = ?");
    $stmt->bind_param("s", $googleBooksId);

    // Ejecuta la consulta y verifica si se eliminó el libro correctamente
    if ($stmt->execute()) {
        // Redirige a lista.php con el parámetro de éxito
        header("Location: lista.php?deleted=success");
        exit();
    } else {
        echo "Error: No se pudo eliminar el libro.";
    }

    $stmt->close();
    $db->close();
} else {
    echo "Error: No se proporcionó un ID de libro válido.";
}
