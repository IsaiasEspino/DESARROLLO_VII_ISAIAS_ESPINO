<?php
session_start();
require_once '../config/config.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['google_id'])) {
    echo "<p>Error: Usuario no autenticado.</p>";
    exit();
}

$googleId = $_SESSION['google_id'];

// Obtén el nombre del usuario desde la base de datos usando google_id
$db = connectDB();
$query = $db->prepare("SELECT nombre FROM usuarios WHERE google_id = ?");
$query->bind_param("s", $googleId);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<p>Error: Usuario no encontrado en la base de datos.</p>";
    exit();
}

$nombreUsuario = $user['nombre'];
$query->close();

// Función para obtener los libros guardados del usuario
function getSavedBooks($nombreUsuario) {
    $db = connectDB();
    $stmt = $db->prepare("SELECT google_books_id, titulo, autor, imagen_portada, reseña_personal FROM libros_guardados WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $nombreUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $books = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $books;
}

// Obtener los libros guardados del usuario
$savedBooks = getSavedBooks($nombreUsuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Libros Guardados</title>
    <link rel="stylesheet" href="assets/css/lista.css">
    <script src="assets/js/mensaje.js" defer></script>
</head>
<body>
    <!-- Mensaje de éxito de eliminación -->
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] === 'success'): ?>
            <div id="success-message" class="success-message">
                El libro ha sido eliminado de la lista con éxito.
            </div>
        <?php endif; ?>
        
    <!-- Menú de navegación -->
    <div class="menu">
        <ul>
            <li><a href="index.php">Buscar</a></li>
            <li><a href="lista.php">Lista</a></li>
            <li><a href="javascript:void(0);" onclick="confirmLogout()">Cerrar sesión</a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="container">
        <h1>Libros Guardados</h1>

        <?php if (!empty($savedBooks)): ?>
            <ul>
                <?php foreach ($savedBooks as $book): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($book['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($book['autor']); ?></p>
                        <?php if (!empty($book['imagen_portada'])): ?>
                            <img src="<?php echo htmlspecialchars($book['imagen_portada']); ?>" alt="Portada">
                        <?php endif; ?>
                        <p><strong>Reseña personal:</strong> <?php echo htmlspecialchars($book['reseña_personal']); ?></p>

                        <!-- Formulario para eliminar el libro -->
                        <form method="POST" action="eliminar_libro.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este libro?');">
                            <input type="hidden" name="google_books_id" value="<?php echo htmlspecialchars($book['google_books_id']); ?>">
                            <button type="submit" name="delete_book" class="delete-button">Eliminar</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No has guardado ningún libro.</p>
        <?php endif; ?>
    </div>

</body>
</html>