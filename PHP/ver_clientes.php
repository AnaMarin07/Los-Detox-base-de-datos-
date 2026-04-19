<?php include('basededatos.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DETOX - Clientes</title>
    <link rel="stylesheet" href="CSS/Productos.css">
</head>
<body>

<div class="top-bar">
    <div class="top-links">
        <a href="../informacion.html" style="text-decoration: none; color: white;">
            <span>Información</span>
        </a>
    </div>
</div>

<div class="form-container">
    <h1 style="font-weight: 900; letter-spacing: -1px;">CLIENTES REGISTRADOS</h1>
    <form action="inserta_cliente.php" method="POST">
            <input type="text" name="dni" placeholder="DNI" required>
            <input type="text" name="nombre" placeholder="NOMBRE" required>
            <input type="text" name="apellido" placeholder="APELLIDO" required>
            <input type="text" name="telefono" placeholder="TELEFONO" required>
            <button type="submit" class="btn-negro">GUARDAR PRODUCTO</button>
    </form>
</div>

<?php
// ELIMINAR
if (isset($_GET['eliminar'])) {
    $dni = $_GET['eliminar'];

    // 1. entrega
    $conexion->query("DELETE FROM entrega 
                      WHERE Id_estado IN (
                          SELECT id_Estado FROM estado_de_pedido 
                          WHERE Id_envio IN (
                              SELECT Id_Envio FROM envios 
                              WHERE Recibo IN (
                                  SELECT Recibo FROM metodos_de_pago 
                                  WHERE Nro_pedido IN (
                                      SELECT Nro_pedido FROM pedidos WHERE Dni='$dni'
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
                                  SELECT Nro_pedido FROM pedidos WHERE Dni='$dni'
                              )
                          )
                      )");

    // 3. envios
    $conexion->query("DELETE FROM envios 
                      WHERE Recibo IN (
                          SELECT Recibo FROM metodos_de_pago 
                          WHERE Nro_pedido IN (
                              SELECT Nro_pedido FROM pedidos WHERE Dni='$dni'
                          )
                      )");

    // 4. metodos_de_pago
    $conexion->query("DELETE FROM metodos_de_pago 
                      WHERE Nro_pedido IN (
                          SELECT Nro_pedido FROM pedidos WHERE Dni='$dni'
                      )");

    // 5. pedidos
    $conexion->query("DELETE FROM pedidos WHERE Dni='$dni'");

    // 6. cliente
    $conexion->query("DELETE FROM cliente WHERE Dni='$dni'");

    header("Location: ver_clientes.php");
    exit();
}
?>

<h2 style="font-weight: 900; letter-spacing: -1px;">LISTA DE CLIENTES</h2>

<table>
    <thead>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $resultado = $conexion->query("SELECT * FROM cliente ORDER BY Apellido ASC");
    while ($row = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['Dni']; ?></td>
            <td><?php echo $row['Nombre']; ?></td>
            <td><?php echo $row['Apellido']; ?></td>
            <td><?php echo $row['Telefono']; ?></td>
            <td>
                <a href='ver_clientes.php?editar=<?php echo $row['Dni']; ?>'>✏️ Editar</a>
                <a href='ver_clientes.php?eliminar=<?php echo $row['Dni']; ?>'>❌ Eliminar</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php
// FORMULARIO DE EDICIÓN
if (isset($_GET['editar'])) {
    $dni = $_GET['editar'];
    $resultado = $conexion->query("SELECT * FROM Cliente WHERE Dni=$dni");
    $cliente = $resultado->fetch_assoc();
?>
    <h2>Editar Cliente</h2>
    <form method="POST" novalidate>
        <input type="hidden" name="dni" value="<?php echo $cliente['Dni']; ?>">
        Nombre:   <input type="text"   name="nombre"   value="<?php echo $cliente['Nombre'];   ?>" required>
        Apellido: <input type="text"   name="apellido" value="<?php echo $cliente['Apellido']; ?>" required>
        Teléfono: <input type="number" name="telefono" value="<?php echo $cliente['Telefono']; ?>" required>
        <button type="submit" name="actualizar">Actualizar</button>
    </form>
<?php } ?>

<?php
// ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $dni      = $_POST['dni'];
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];

    $conexion->query("UPDATE Cliente
        SET Nombre='$nombre', Apellido='$apellido', Telefono='$telefono'
        WHERE Dni=$dni");
    echo "<script>window.location='ver_clientes.php';</script>";
    exit();
}
?>

<br><br>
<section class="main-banner">
    <div class="banner-content">
        <a href="http://172.16.15.203/detox/HTML/Pagina%20Principal.html" style="text-decoration: none;">
            <button class="btn-banner">Volver a la página principal</button>
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