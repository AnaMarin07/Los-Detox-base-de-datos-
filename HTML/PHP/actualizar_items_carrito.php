<?php
session_start();
include('basededatos.php');

if (isset($_GET['id']) && isset($_GET['accion'])) {
    $id = $_GET['id'];
    $accion = $_GET['accion'];
    
    // Limpiamos el talle que viene por URL
    $talle_url = isset($_GET['talle']) ? trim($_GET['talle']) : '';

    foreach ($_SESSION['carrito'] as $key => &$item) {
        
        // Comparamos ID y Talle (limpiando ambos para evitar errores de espacios)
        if ($item['id'] == $id && trim($item['talle']) === $talle_url) {
            
            if ($accion == 'sumar') {
                $talle_db = $item['talle']; 
                
                // Consultamos el stock real
                $sql = "SELECT stock FROM stock WHERE Id_producto = '$id' AND Talle = '$talle_db'";
                $resultado = $conexion->query($sql);
                
                if ($resultado && $resultado->num_rows > 0) {
                    $fila = $resultado->fetch_assoc();
                    $stock_disponible = $fila['stock'];

                    // Si la cantidad actual es menor al stock, sumamos
                    if ($item['cantidad'] < $stock_disponible) {
                        $item['cantidad']++;
                    } else {
                        header("Location: carrito.php?error=stock");
                        exit();
                    }
                }

            } elseif ($accion == 'restar') {
                if ($item['cantidad'] > 1) {
                    $item['cantidad']--;
                } else {
                    // Si es 1 y resta, eliminamos el producto
                    unset($_SESSION['carrito'][$key]);
                }
            }
            // Una vez que encontramos el producto y operamos, salimos del bucle
            break; 
        }
    }
    // Reindexamos por si se eliminó algún item
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

// Redirigimos siempre al carrito para ver los cambios
header("Location: carrito.php");
exit();