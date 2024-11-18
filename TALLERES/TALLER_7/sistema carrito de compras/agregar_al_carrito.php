<?php
include('config_sesion.php');

// Validación y sanitización de la entrada
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id) {
    // Simulación de una lista de productos
    $productos = [
        1 => ['nombre' => 'Producto 1', 'precio' => 10],
        2 => ['nombre' => 'Producto 2', 'precio' => 20],
        3 => ['nombre' => 'Producto 3', 'precio' => 30],
        4 => ['nombre' => 'Producto 4', 'precio' => 40],
        5 => ['nombre' => 'Producto 5', 'precio' => 50],
    ];

    // Verifica si el producto existe
    if (isset($productos[$id])) {
        // Añadir al carrito
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si el producto ya está en el carrito, aumentar la cantidad
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id] = ['nombre' => $productos[$id]['nombre'], 'precio' => $productos[$id]['precio'], 'cantidad' => 1];
        }
    }
}

header('Location: ver_carrito.php');
exit();
