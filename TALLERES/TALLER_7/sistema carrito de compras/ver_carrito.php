<?php include('config_sesion.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de compras</title>
</head>
<body>
    <h1>Carrito de compras</h1>
    <a href="productos.php">Seguir comprando</a>
    <ul>
        <?php
        $total = 0;
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $id => $producto) {
                $subtotal = $producto['precio'] * $producto['cantidad'];
                echo "<li>{$producto['nombre']} - {$producto['cantidad']} x \${$producto['precio']} = \${$subtotal}";
                echo "<form action='eliminar_del_carrito.php' method='post'>
                        <input type='hidden' name='id' value='$id'>
                        <input type='submit' value='Eliminar'>
                      </form></li>";
                $total += $subtotal;
            }
        } else {
            echo "<p>El carrito está vacío.</p>";
        }
        ?>
    </ul>
    <p>Total: $<?php echo $total; ?></p>
    <form action="checkout.php" method="post">
        <input type="submit" value="Finalizar compra">
    </form>
</body>
</html>
