<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Recorremos el carrito y sacamos el producto con ese id
    foreach ($_SESSION['carrito'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['carrito'][$key]);
            break;
        }
    }
}

// Volvemos al carrito
header("Location: carrito.php");
exit();
?>