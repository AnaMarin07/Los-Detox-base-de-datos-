<?php include('basededatos.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DETOX - Panel de Productos</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; padding: 40px; }
        .form-container { max-width: 500px; margin-bottom: 50px; }
        input, textarea { width: 100%; padding: 12px; margin: 8px 0; border: 1px solid #ddd; outline: none; }
        .btn-negro { background: black; color: white; border: none; padding: 15px 30px; font-weight: bold; cursor: pointer; width: 100%; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #000; color: #fff; text-align: left; padding: 15px; text-transform: uppercase; font-size: 13px; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; }
        tr:hover { background: #f9f9f9; }
    </style>
</head>
<body>

    <div class="form-container">
        <h1 style="font-weight: 900; letter-spacing: -1px;">NUEVO PRODUCTO</h1>
        <form action="insertar_producto.php" method="POST">
            <input type="text" name="talle" placeholder="TALLE (Ej: L, XL, 42)" required>
            <input type="text" name="color" placeholder="COLOR" required>
            <input type="text" name="marca" placeholder="MARCA" required>
            <textarea name="descripcion" placeholder="DESCRIPCIÓN DEL PRODUCTO" rows="3"></textarea>
            <button type="submit" class="btn-negro">GUARDAR PRODUCTO</button>
        </form>
    </div>

    <h2 style="font-weight: 900; letter-spacing: -1px;">PRODUCTOS EN INVENTARIO</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Talle</th>
                <th>Color</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM productos ORDER BY id_producto DESC";
            $resultado = mysqli_query($conexion, $query);

            while($row = mysqli_fetch_array($resultado)) { ?>
                <tr>
                    <td>#<?php echo $row['id_producto']; ?></td>
                    <td><?php echo $row['marca']; ?></td>
                    <td><?php echo $row['talle']; ?></td>
                    <td><?php echo $row['color']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>