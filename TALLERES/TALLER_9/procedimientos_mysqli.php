<?php
require_once "config_mysqli.php";

// Función para registrar una venta
function registrarVenta($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_registrar_venta(?, ?, ?, @venta_id)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Obtener el ID de la venta
        $result = mysqli_query($conn, "SELECT @venta_id as venta_id");
        $row = mysqli_fetch_assoc($result);
        
        echo "Venta registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($conn, $cliente_id) {
    $query = "CALL sp_estadisticas_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $estadisticas = mysqli_fetch_assoc($result);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}

function procesarDevolucion($conn, $venta_id, $producto_id, $cantidad) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $venta_id, $producto_id, $cantidad);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Devolución procesada con éxito.";
    } else {
        echo "Error al procesar la devolución.";
    }
    
    mysqli_stmt_close($stmt);
}

function aplicarDescuento($conn, $cliente_id) {
    $query = "CALL sp_aplicar_descuento(?, @descuento)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_query($conn, "SELECT @descuento as descuento");
    $row = mysqli_fetch_assoc($result);
    
    echo "Descuento aplicado: " . $row['descuento'] . "%";
    
    mysqli_stmt_close($stmt);
}

function reporteBajoStock($conn) {
    $query = "CALL sp_reporte_bajo_stock()";
    $result = mysqli_query($conn, $query);
    
    echo "<h3>Productos con Bajo Stock</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: " . $row['nombre'] . " | Stock: " . $row['stock'] . " | Sugerido: " . $row['sugerido_reposicion'] . "<br>";
    }
}

function calcularComision($conn, $vendedor_id) {
    $query = "CALL sp_calcular_comision(?, @comision)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $vendedor_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_query($conn, "SELECT @comision as comision");
    $row = mysqli_fetch_assoc($result);
    
    echo "Comisión calculada: $" . $row['comision'];
    
    mysqli_stmt_close($stmt);
}

// Ejemplos de uso
registrarVenta($conn, 1, 1, 2);
obtenerEstadisticasCliente($conn, 1);

mysqli_close($conn);
?>