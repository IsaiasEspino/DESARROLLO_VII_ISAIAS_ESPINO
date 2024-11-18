<?php
include('config_sesion.php');

// Limpiar el carrito
if (isset($_SESSION['carrito'])) {
    unset($_SESSION['carrito']);
}

// Recordar al usuario por 24 horas con una cookie
setcookie('usuario', 'Carlos', time() + 86400, '/', '', true, true);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h1>Gracias por su compra</h1>
    <p>Se ha completado el proceso de compra. Su carrito está vacío.</p>
    <a href="productos.php">Volver a productos</a>
</body>
</html>
