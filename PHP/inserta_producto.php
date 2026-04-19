<?php
include('basededatos.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Talle       = $_POST['talle'];
    $Color       = $_POST['color'];
    $Marca       = $_POST['marca'];
    $Descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO Producto (Talle, Color, Marca, Descripcion)
            VALUES ('$Talle', '$Color', '$Marca', '$Descripcion')";

    if ($conexion->query($sql)) {
        header("Location: Productos.php");
        exit();
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>