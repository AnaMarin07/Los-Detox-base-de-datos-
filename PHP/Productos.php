<?php include('basededatos.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DETOX - Panel de Productos</title>
    <link rel="stylesheet" href="CSS/Productos.css">
</head>
<body>
    <div class="top-bar">
        <div class="top-links">
            <a href="informacion.html" style="text-decoration: none; color: white;">
                <span>Información</span>
            </a>
            <a href="" style="text-decoration: none; color: white;">
                <span>Registrarme</span>
            </a>
            <a href="" style="text-decoration: none; color: white;">
                <span style="font-weight: bold;">Iniciar sesión</span>
            </a>
        </div>
    </div>
    <div class="form-container">
        <h1 style="font-weight: 900; letter-spacing: -1px;">NUEVO PRODUCTO</h1>
        <form action="inserta_producto.php" method="POST">
            <input type="text" name="talle" placeholder="TALLE (Ej: L, XL, 42)" required>
            <input type="text" name="color" placeholder="COLOR" required>
            <input type="text" name="marca" placeholder="MARCA" required>
            <textarea name="descripcion" placeholder="DESCRIPCIÓN DEL PRODUCTO" rows="3"></textarea>
            <button type="submit" class="btn-negro">GUARDAR PRODUCTO</button>
        </form>
    </div>

    <?php
    if (isset($_GET['eliminar'])) {
        $id = $_GET['eliminar'];

        // 1. entrega
        $conexion->query("DELETE FROM entrega 
            WHERE Id_estado IN (
                SELECT id_Estado FROM estado_de_pedido 
                WHERE Id_envio IN (
                    SELECT Id_Envio FROM envios 
                    WHERE Recibo IN (
                        SELECT Recibo FROM metodos_de_pago 
                        WHERE Nro_pedido IN (
                            SELECT Nro_pedido FROM pedidos WHERE Id_producto='$id'
                        )
                    )
                )
            )");

        // 2. estado_de_pedido
        $conexion->query("DELETE FROM estado_de_pedido 
            WHERE Id_envio IN (
                SELECT Id_Envio FROM envios 
                WHERE Recibo IN (
                    SELECT Recibo FROM metodos_de_pago 
                    WHERE Nro_pedido IN (
                        SELECT Nro_pedido FROM pedidos WHERE Id_producto='$id'
                    )
                )
            )");

        // 3. envios
        $conexion->query("DELETE FROM envios 
            WHERE Recibo IN (
                SELECT Recibo FROM metodos_de_pago 
                WHERE Nro_pedido IN (
                    SELECT Nro_pedido FROM pedidos WHERE Id_producto='$id'
                )
            )");

        // 4. metodos_de_pago
        $conexion->query("DELETE FROM metodos_de_pago 
            WHERE Nro_pedido IN (
                SELECT Nro_pedido FROM pedidos WHERE Id_producto='$id'
            )");

        // 5. pedidos
        $conexion->query("DELETE FROM pedidos WHERE Id_producto='$id'");

        // 6. producto
        $conexion->query("DELETE FROM producto WHERE Id_producto='$id'");

        header("Location: Productos.php");
        exit();
    }
    ?>

    <h2 style="font-weight: 900; letter-spacing: -1px;">PRODUCTOS EN INVENTARIO</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Talle</th>
                <th>Color</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Secciones</th>
            </tr>
        </thead>
        <tbody>
            <?php   
            $query = "SELECT * FROM producto ORDER BY id_producto DESC";
            $resultado = mysqli_query($conexion, $query);

            while($row = mysqli_fetch_array($resultado)) { ?>
                <tr>
                    <td>#<?php echo $row['Id_producto']; ?></td>
                    <td><?php echo $row['Talle']; ?></td>
                    <td><?php echo $row['Color']; ?></td>
                    <td><?php echo $row['Descripcion']; ?></td>
                    <td><?php echo $row['Marca']; ?></td>
                    <td>
                        <a href='Productos.php?editar=<?php echo $row['Id_producto']; ?>'>✏️ Editar</a>
                        <a href='Productos.php?eliminar=<?php echo $row['Id_producto']; ?>'>❌ Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['editar'])) {
        $id = $_GET['editar'];

        $resultado = $conexion->query("SELECT * FROM producto WHERE Id_producto='$id'");
        $producto = $resultado->fetch_assoc();
    ?>
        <h2>Editar Producto</h2>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $producto['Id_producto']; ?>">

            Talle: <input type="text" name="talle" value="<?php echo $producto['Talle']; ?>" required>
            Color: <input type="text" name="color" value="<?php echo $producto['Color']; ?>" required>
            Marca: <input type="text" name="marca" value="<?php echo $producto['Marca']; ?>" required>
            Descripción: <textarea name="descripcion"><?php echo $producto['Descripcion']; ?></textarea>

            <button type="submit" name="actualizar" formnovalidate>Actualizar</button>
        </form>
    <?php } ?>
    
    <?php
    //actualizar
    if (isset($_POST['actualizar'])) {
        $id = $_POST['id'];
        $talle = $_POST['talle'];
        $color = $_POST['color'];
        $marca = $_POST['marca'];
        $descripcion = $_POST['descripcion'];

        $conexion->query("UPDATE producto
            SET Talle='$talle', Color='$color', Marca='$marca', Descripcion='$descripcion'
            WHERE Id_producto='$id'");

        echo "<script>window.location='Productos.php';</script>";
        exit();
    }
    ?>

    <br> <br>
    <section class="main-banner">
        <div class="banner-content">
            <a href="http://localhost/HTML/Pagina Principal.html" style="text-decoration: none;">
                <button class="btn-banner">Volver a la pagina principal</button>
            </a>
        </div>
    </section> 
    <br> <br>

    <pre> <b> Tener en cuenta que el ID no es visual, no va en orden numerico. <b> </pre>
    <br>
    <footer>
        <div class="columna">
            <b>AYUDA</b>
            <p>Libro de quejas online</p>
            <p>Botón de arrepentimiento</p>
            <p>Preguntas frecuentes</p>
            <p>Guía de talles</p>
            <p>Cambios y devoluciones</p>
        </div>

        <div class="columna">
            <b>CONTACTO</b>
            <p>Email: detox@gmail.com</p>
            <p>Tel: +54 11 1234-5678</p>
            <p>WhatsApp: +54 9 11 9876-5432</p>
            <p>Ubicación: Buenos Aires, Argentina</p>
        </div>

        <div class="columna">
            <b>NOVEDADES</b>
            <p>Promociones</p>
            <p>Nuevos ingresos</p>
            <p>Ofertas exclusivas</p>
            <p>Black Friday</p>
        </div>

        <div class="columna">
            <b>SEGUINOS</b>
           <div class="iconos_redes_S">
            <a href="#"><img src="CSS/IMAGENES/download-removebg-preview (1).png" width=35px alt="Instagram"></a>
            <a href="#"><img src="CSS/IMAGENES/tiktok.png" width=40px alt="TikTok"></a>
            <a href="#"><img src="CSS/IMAGENES/X.png" width=30px alt="X"></a>
        </div>

        </div>
    </footer>
    <p style="text-align:center; background:#111; color:#313131; padding:15px;">
        © 2026 DETOX - Todos los derechos reservados
    </p>

</body>
</html>