<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'biblioteca_db');

// Configuración de Google OAuth
define('GOOGLE_CLIENT_ID', ''); 
define('GOOGLE_CLIENT_SECRET', '');
define('GOOGLE_REDIRECT_URI', 'http://localhost/DESARROLLO_VII_DAVID_ALVAREZ/PARCIALES/PARCIAL_4/public/oauth-callback.php');

// Función para conectar a la base de datos
function connectDB() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }
    return $mysqli;
}
?>


