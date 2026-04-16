<?php
include('basededatos.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Dni      = $_POST['dni'];
    $Nombre   = $_POST['nombre'];
    $Apellido = $_POST['apellido'];
    $Telefono = $_POST['telefono'];

    $sql = "INSERT INTO cliente (Dni, Nombre, Apellido, Telefono)
            VALUES ('$Dni', '$Nombre', '$Apellido', '$Telefono')";

    if ($conexion->query($sql)) {
        header("Location: ver_clientes.php");
        exit();
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>