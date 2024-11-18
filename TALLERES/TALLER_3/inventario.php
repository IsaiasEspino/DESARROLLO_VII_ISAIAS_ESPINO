<?php
// Leer el inventario desde el archivo JSON y convertirlo en un array de productos
function leerInventario($archivo) {
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true);
}

// Ordenar el inventario alfabéticamente por nombre del producto
function ordenarInventarioPorNombre(&$inventario) {
    usort($inventario, function($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
}

// Mostrar un resumen del inventario ordenado (nombre, precio, cantidad)
function mostrarResumenInventario($inventario) {
    foreach ($inventario as $producto) {
        echo "Producto: " . $producto['nombre'] . ", Precio: $" . $producto['precio'] . ", Cantidad: " . $producto['cantidad'] . "</br>";
    }
}


function calcularValorTotalInventario($inventario) {
    return array_sum(array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario));
}

// Generar un informe de productos con stock bajo (menos de 5 unidades)
function generarInformeStockBajo($inventario, $umbral = 5) {
    return array_filter($inventario, function($producto) use ($umbral) {
        return $producto['cantidad'] < $umbral;
    });
}

// Nombre del archivo JSON
$archivo = 'inventario.json';

// Leer el inventario
$inventario = leerInventario($archivo);

// Ordenar el inventario por nombre
ordenarInventarioPorNombre($inventario);

// Mostrar el resumen del inventario ordenado
echo "Resumen del Inventario:";
mostrarResumenInventario($inventario);

// Calcular y mostrar el valor total del inventario
$valorTotal = calcularValorTotalInventario($inventario);
echo "Valor Total del Inventario: $" . $valorTotal . ";

// Generar y mostrar el informe de productos con stock bajo
$productosBajoStock = generarInformeStockBajo($inventario);
if (!empty($productosBajoStock)) {
    echo "Productos con Stock Bajo:";
    mostrarResumenInventario($productosBajoStock);
} else {
    echo "No hay productos con stock bajo.";
}
?>
