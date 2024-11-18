<?php

session_start();

// Configuraciones de seguridad de las sesiones
ini_set('session.cookie_lifetime', 0);  // La cookie expira al cerrar el navegador
ini_set('session.cookie_httponly', 1);  // Protección contra JavaScript
ini_set('session.use_strict_mode', 1);  // Protección contra secuestro de sesión

?>