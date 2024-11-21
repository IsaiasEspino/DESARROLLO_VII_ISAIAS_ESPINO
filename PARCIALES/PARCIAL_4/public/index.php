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
$db->close();

// Función para buscar libros en Google Books API
function searchBooks($query) {
    $url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($query);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Función para guardar un libro en la base de datos
function saveBook($nombreUsuario, $googleBookId, $title, $author, $coverImage, $personalReview) {
    $db = connectDB();
    $stmt = $db->prepare("INSERT INTO libros_guardados (nombre_usuario, google_books_id, titulo, autor, imagen_portada, reseña_personal) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombreUsuario, $googleBookId, $title, $author, $coverImage, $personalReview);
    $stmt->execute();
    $stmt->close();
    $db->close();
    echo "<p id='success-message' class='success-message'>¡Libro guardado con éxito!</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_book'])) {
    $googleBookId = $_POST['google_book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $coverImage = $_POST['cover_image'];
    $personalReview = $_POST['personal_review'];
    saveBook($nombreUsuario, $googleBookId, $title, $author, $coverImage, $personalReview);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Libros</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="assets/js/mensaje.js" defer></script>
</head>
<body>
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
        <h1>Buscar Libros</h1>
        <form method="GET" action="">
            <input type="text" name="query" placeholder="Escribe el título o autor del libro">
            <button type="submit">Buscar</button>
        </form>

        <?php if (isset($_GET['query']) && $_GET['query']): ?>
            <?php
            $books = searchBooks($_GET['query']);
            if (!empty($books['items'])):
            ?>
                <h2>Resultados de búsqueda:</h2>
                <ul>
                    <?php foreach ($books['items'] as $book): ?>
                        <?php
                        $volumeInfo = $book['volumeInfo'];
                        $googleBookId = $book['id'];
                        $title = $volumeInfo['title'] ?? 'Sin título';
                        $authors = isset($volumeInfo['authors']) ? implode(', ', $volumeInfo['authors']) : 'Autor desconocido';
                        $coverImage = $volumeInfo['imageLinks']['thumbnail'] ?? '';
                        ?>
                        <li>
                            <h3><?php echo htmlspecialchars($title); ?></h3>
                            <p><?php echo htmlspecialchars($authors); ?></p>
                            <?php if ($coverImage): ?>
                                <img src="<?php echo htmlspecialchars($coverImage); ?>" alt="Portada">
                            <?php endif; ?>
                            <form method="POST" action="">
                                <input type="hidden" name="google_book_id" value="<?php echo htmlspecialchars($googleBookId); ?>">
                                <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                                <input type="hidden" name="author" value="<?php echo htmlspecialchars($authors); ?>">
                                <input type="hidden" name="cover_image" value="<?php echo htmlspecialchars($coverImage); ?>">
                                <textarea name="personal_review" placeholder="Escribe una reseña personal..."></textarea>
                                <button type="submit" name="save_book">Guardar</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No se encontraron resultados.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>
</html>