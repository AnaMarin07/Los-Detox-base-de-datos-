<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id     = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $marca  = $_POST['marca'];
    // Capturamos el talle enviado desde el formulario
    $talle  = isset($_POST['talle']) ? $_POST['talle'] : 'Único'; 

    // Si el carrito no existe todavía, lo creamos vacío
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificamos si el producto CON EL MISMO TALLE ya está en el carrito
    $existe = false;
    foreach ($_SESSION['carrito'] as &$item) {
        // Ahora comparamos ID Y TALLE (porque puedo querer dos talles distintos del mismo modelo)
        if ($item['id'] == $id && $item['talle'] == $talle) {
            $item['cantidad']++; 
            $existe = true;
            break;
        }
    }

    // Si no existe esa combinación de ID y Talle, lo agregamos como item nuevo
    if (!$existe) {
        $_SESSION['carrito'][] = [
            'id'       => $id,
            'nombre'   => $nombre,
            'precio'   => $precio,
            'marca'    => $marca,
            'talle'    => $talle, // <--- GUARDAMOS EL TALLE AQUÍ
            'cantidad' => 1
        ];
    }

    // Volvemos a la página anterior
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>