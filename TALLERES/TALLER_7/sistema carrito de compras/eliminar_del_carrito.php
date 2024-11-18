<?php
include('config_sesion.php');

// Validación y sanitización
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id && isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
}

header('Location: ver_carrito.php');
exit();
