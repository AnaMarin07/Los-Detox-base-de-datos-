<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id     = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $marca  = $_POST['marca'];
    $cant   = $_POST['cantidad'];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id) {
            $item['cantidad'] += $cant;
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        $_SESSION['carrito'][] = [
            'id'       => $id,
            'nombre'   => $nombre,
            'precio'   => $precio,
            'marca'    => $marca,
            'cantidad' => $cant
        ];
    }

    // SI EL ERROR PERSISTE AQUÍ:
    // Asegurate que el archivo "finalizar_compra.php" exista en la misma carpeta.
    header("Location: finalizar_compra.php");
    exit();
} else {
    // Si falla, volvemos a la principal. 
    // Si tu archivo está en la raíz, quita el "../"
    header("Location: ../Pagina Principal.php"); 
    exit();
}
?>