<?php
require_once '../config/config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar sesión</h2>
            <div class="login-options">
                <a href="<?php echo 'https://accounts.google.com/o/oauth2/v2/auth?scope=email%20profile&redirect_uri=' . urlencode(GOOGLE_REDIRECT_URI) . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID; ?>" class="google-login-btn">Iniciar sesión con Google</a>
            </div>
        </div>
    </div>
</body>
</html>
