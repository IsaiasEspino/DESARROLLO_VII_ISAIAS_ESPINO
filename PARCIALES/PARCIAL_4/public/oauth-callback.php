<?php
require_once '../config/config.php';
session_start();

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $tokenURL = 'https://oauth2.googleapis.com/token';
    $data = [
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'grant_type' => 'authorization_code',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenURL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $tokenInfo = json_decode($response, true);
    $accessToken = $tokenInfo['access_token'];

    // Obtener información del usuario
    $userInfoURL = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken;
    $userInfo = json_decode(file_get_contents($userInfoURL), true);

    $db = connectDB();
    
    // Insertar o actualizar usuario
    $stmt = $db->prepare("INSERT INTO usuarios (email, nombre, google_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE email=email");
    $stmt->bind_param("sss", $userInfo['email'], $userInfo['name'], $userInfo['id']);
    $stmt->execute();

    // Guardar google_id en la sesión
    $_SESSION['google_id'] = $userInfo['id'];

    $stmt->close();
    $db->close();

    header('Location: index.php');
    exit();
} else {
    echo 'Error en la autenticación con Google';
}
