<?php
include 'funciones_tienda.php';

// Array asociativo con 5 productos y sus precios
$productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

// Array asociativo que simula un carrito de compras
$carrito = [
    'camisa' => 2,
    'pantalon' => 1,
    'zapatos' => 1,
    'calcetines' => 3,
    'gorra' => 0
];

// Calcular el subtotal de la compra
$subtotal = 0;
foreach ($carrito as $producto => $cantidad) {
    if ($cantidad > 0) {
        $subtotal += $productos[$producto] * $cantidad;
    }
}

// Calcular el descuento
$descuento = calcular_descuento($subtotal);

// Calcular el impuesto
$impuesto = aplicar_impuesto($subtotal);

// Calcular el total a pagar
$total = calcular_total($subtotal, $descuento, $impuesto);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de la Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            font-size: 1.2em;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resumen de la Compra</h1>
        <h2>Productos Comprados:</h2>
        <ul>
            <?php foreach ($carrito as $producto => $cantidad): ?>
                <?php if ($cantidad > 0): ?>
                    <li><?php echo $producto; ?>: <?php echo $cantidad; ?> x $<?php echo $productos[$producto]; ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        <div class="details">
            <h2>Detalles de la Compra:</h2>
            <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
            <p>Descuento aplicado: $<?php echo number_format($descuento, 2); ?></p>
            <p>Impuesto: $<?php echo number_format($impuesto, 2); ?></p>
            <p>Total a pagar: $<?php echo number_format($total, 2); ?></p>
        </div>
    </div>
</body>
</html>
