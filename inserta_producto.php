<?php
include('basededatos.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Recibimos los datos generales del producto
    $Descripcion     = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $Marca           = mysqli_real_escape_string($conexion, $_POST['marca']);
    $Precio_unitario = $_POST['precio_unidad'];
    $Genero          = $_POST['genero'];
    $Nombre_producto = mysqli_real_escape_string($conexion, $_POST['nombre_producto']);
    $Prioridad       = $_POST['prioridad'];

    // 2. Recibimos los arreglos de talles y stocks
    $talles = $_POST['talles']; // Es un array
    $stocks = $_POST['stocks']; // Es un array

    // 3. Manejo de la imagen
    $nombre_foto     = $_FILES['Imagen']['name']; 
    $ruta_temporal   = $_FILES['Imagen']['tmp_name']; 
    $carpeta_destino = "CSS/IMAGENES/"; 
    $Visualizacion   = $carpeta_destino . $nombre_foto;

    if (move_uploaded_file($ruta_temporal, $Visualizacion)) {

        // 4. Insertamos en la tabla principal: Producto (una sola vez)
        $sql_producto = "INSERT INTO Producto (Descripcion, Marca, Precio_unitario, Visualizacion, Genero, Nombre_producto, Prioridad)
                         VALUES ('$Descripcion', '$Marca', '$Precio_unitario', '$Visualizacion', '$Genero', '$Nombre_producto', '$Prioridad')";

        if ($conexion->query($sql_producto)) {
            
            // 5. Obtenemos el ID del producto que se acaba de crear
            $ultimo_id = $conexion->insert_id;

            // 6. Recorremos los talles recibidos e insertamos cada uno en la tabla stock
            foreach ($talles as $indice => $talle_valor) {
                // Solo insertamos si el talle no está vacío
                if (!empty($talle_valor)) {
                    $talle_limpio = mysqli_real_escape_string($conexion, $talle_valor);
                    $stock_limpio = (int)$stocks[$indice];

                    $sql_variante = "INSERT INTO stock (Id_producto, Talle, Stock)
                                     VALUES ('$ultimo_id', '$talle_limpio', '$stock_limpio')";
                    
                    // Ejecutamos la inserción de cada variante
                    if (!$conexion->query($sql_variante)) {
                        echo "Error al insertar variante: " . $conexion->error;
                    }
                }
            }

            // Si todo salió bien, volvemos al panel
            header("Location: Productos.php");
            exit();

        } else {
            echo "Error al insertar producto: " . $conexion->error;
        }

    } else {
        echo "Error: No se pudo subir la imagen. Revisá los permisos de la carpeta $carpeta_destino";
    }
}
?>