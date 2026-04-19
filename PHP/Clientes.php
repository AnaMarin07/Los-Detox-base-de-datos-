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
        <h1 style="font-weight: 900; letter-spacing: -1px;">CLIENTES</h1>
        <form action="inserta_productos.php" method="POST">
            <input type="text" name="nombre" placeholder="NOMBRE" required>
            <input type="text" name="apellido" placeholder="APELLIDO" required>
            <input type="text" name="telefono" placeholder="TELEFONO" required>
            <button type="submit" class="btn-negro">GUARDAR CLIENTE</button>
        </form>
    </div>

    <h2 style="font-weight: 900; letter-spacing: -1px;">CLIENTE EN INVENTARIO</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
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
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br> <br>
    <section class="main-banner">
        <div class="banner-content">
            <a href="http://172.16.15.203/detox/HTML/Pagina%20Principal.html" style="text-decoration: none;">
                <button class="btn-banner">Volver a la pagina principal</button>
            </a>
        </div>
    </section> 
    <br> <br>
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
            <p>Instagram <a href=""> detox shop </a> </p>
            <p>Facebook: <a href=""> dex shop </a> </p>
            <p>TikTok: <a href=""> Detox-Shop</a> </p>
            <p>Twitter (X): <b> en proceso...<b> </p>
        </div>
    </footer>

<p style="text-align:center; background:#111; color:#aaa; padding:15px;">
    © 2026 DETOX - Todos los derechos reservados
</p>

</body>
</html>