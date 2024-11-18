<?php include('config_sesion.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <h1>Productos disponibles</h1>
    <ul>
        <?php
        // Lista de productos (esto podría venir de una base de datos)
        $productos = [
            1 => ['nombre' => 'Producto 1', 'precio' => 10],
            2 => ['nombre' => 'Producto 2', 'precio' => 20],
            3 => ['nombre' => 'Producto 3', 'precio' => 30],
            4 => ['nombre' => 'Producto 4', 'precio' => 40],
            5 => ['nombre' => 'Producto 5', 'precio' => 50],
        ];

        // Mostrar productos, cada producto con su propio formulario
        foreach ($productos as $id => $producto) {
            echo "<li>{$producto['nombre']} - \${$producto['precio']}";
            echo "<form action='agregar_al_carrito.php' method='post'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='submit' value='Añadir al carrito'>
                  </form>";
            echo "</li>";
        }
        ?>
    </ul>
</body>
</html>
