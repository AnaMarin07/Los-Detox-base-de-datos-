<?php include('basededatos.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DETOX - Panel de Clientes</title>
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

    <?php
    // --- 1. LÓGICA DE ELIMINAR ---
    if (isset($_GET['eliminar'])) {
        $dni = $_GET['eliminar'];
        $conexion->query("SET FOREIGN_KEY_CHECKS = 0"); 
        
        // Eliminación en cadena
        $conexion->query("DELETE FROM entrega WHERE Id_estado IN (SELECT id_Estado FROM estado_de_pedido WHERE Id_envio IN (SELECT Id_Envio FROM envios WHERE Recibo IN (SELECT Recibo FROM metodos_de_pago WHERE Nro_pedido IN (SELECT Nro_pedido FROM pedidos WHERE Dni='$dni'))))");
        $conexion->query("DELETE FROM estado_de_pedido WHERE Id_envio IN (SELECT Id_Envio FROM envios WHERE Recibo IN (SELECT Recibo FROM metodos_de_pago WHERE Nro_pedido IN (SELECT Nro_pedido FROM pedidos WHERE Dni='$dni')))");
        $conexion->query("DELETE FROM envios WHERE Recibo IN (SELECT Recibo FROM metodos_de_pago WHERE Nro_pedido IN (SELECT Nro_pedido FROM pedidos WHERE Dni='$dni'))");
        $conexion->query("DELETE FROM metodos_de_pago WHERE Nro_pedido IN (SELECT Nro_pedido FROM pedidos WHERE Dni='$dni')");
        $conexion->query("DELETE FROM pedidos WHERE Dni='$dni'");
        $conexion->query("DELETE FROM cliente WHERE Dni='$dni'");
        
        $conexion->query("SET FOREIGN_KEY_CHECKS = 1");
        echo "<script>window.location='ver_clientes.php';</script>";
        exit();
    }

    // --- 2. LÓGICA DE ACTUALIZAR ---
    if (isset($_POST['actualizar'])) {
        $dni        = $_POST['Dni'];
        $nombre     = $_POST['Nombre'];
        $apellido   = $_POST['Apellido'];
        $mail       = $_POST['Mail'];
        $direccion  = $_POST['Direccion'];
        $cod_postal = $_POST['cod_postal'];
        $ciudad     = $_POST['Ciudad'];
        $telefono   = $_POST['Telefono'];

        $sql_update = "UPDATE cliente SET 
            Nombre='$nombre', 
            Apellido='$apellido', 
            Mail='$mail', 
            Direccion='$direccion', 
            cod_postal='$cod_postal', 
            Ciudad='$ciudad', 
            Telefono='$telefono' 
            WHERE Dni='$dni'";
        
        if($conexion->query($sql_update)){
            echo "<script>window.location='ver_clientes.php';</script>";
        } else {
            echo "Error al actualizar: " . $conexion->error;
        }
        exit();
    }
    ?>

    <div class="content-wrapper" style="padding: 20px;">
        
        <?php 
        // --- 3. INTERCAMBIO DE FORMULARIOS ---
        if (isset($_GET['editar'])): 
            $dni_editar = $_GET['editar'];
            $res = $conexion->query("SELECT * FROM cliente WHERE Dni = '$dni_editar'");
            $cli = $res->fetch_assoc();
            if ($cli):
        ?>
            <div class="form-container"; border: 0px solid #28a745; margin-bottom: 40px;">
                <h1 style="font-weight: 900; color: #28a745; letter-spacing: -1px;">EDITANDO CLIENTE DNI: <?php echo $cli['Dni']; ?></h1>
                <form method="POST">
                    <input type="hidden" name="Dni" value="<?php echo $cli['Dni']; ?>">
                    <input type="text" name="Nombre" value="<?php echo $cli['Nombre']; ?>" placeholder="NOMBRE" required>
                    <input type="text" name="Apellido" value="<?php echo $cli['Apellido']; ?>" placeholder="APELLIDO" required>
                    <input type="email" name="Mail" value="<?php echo $cli['Mail']; ?>" placeholder="MAIL" required>
                    <input type="text" name="Direccion" value="<?php echo $cli['Direccion']; ?>" placeholder="DIRECCIÓN" required>
                    <input type="text" name="cod_postal" value="<?php echo $cli['cod_postal']; ?>" placeholder="CÓDIGO POSTAL" required>
                    <input type="text" name="Ciudad" value="<?php echo $cli['Ciudad']; ?>" placeholder="CIUDAD" required>
                    <input type="text" name="Telefono" value="<?php echo $cli['Telefono']; ?>" placeholder="TELÉFONO" required>
                    
                    <button type="submit" name="actualizar" class="btn-negro" style="background: #28a745;">GUARDAR CAMBIOS</button>
                    <a href="ver_clientes.php" style="display:block; text-align:center; margin-top:15px; color: #333; font-weight: bold; text-decoration: none;">← CANCELAR Y VOLVER AL REGISTRO</a>
                </form>
            </div>
        <?php 
            endif;
        else: 
        ?>
            <div class="form-container" style="margin-bottom: 40px;">
                <h1 style="font-weight: 900; letter-spacing: -1px;">REGISTRAR NUEVO CLIENTE</h1>
                <form action="inserta_cliente.php" method="POST">
                    <input type="text" name="Dni" placeholder="DNI" required>
                    <input type="text" name="Nombre" placeholder="NOMBRE" required>
                    <input type="text" name="Apellido" placeholder="APELLIDO" required>
                    <input type="email" name="Mail" placeholder="MAIL" required>
                    <input type="password" name="Contraseña" placeholder="CONTRASEÑA" required>
                    <input type="text" name="Direccion" placeholder="DIRECCIÓN" required>
                    <input type="text" name="Cod_postal" placeholder="CÓDIGO POSTAL" maxlength="8" required>
                    <input type="text" name="Ciudad" placeholder="CIUDAD" required>
                    <input type="text" name="Telefono" placeholder="TELÉFONO" required>
                    <button type="submit" class="btn-negro">GUARDAR CLIENTE</button>
                </form>
            </div>
        <?php endif; ?>

        <h2 style="font-weight: 900; letter-spacing: -1px;">CLIENTES REGISTRADOS</h2>
        <table>
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Mail</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = $conexion->query("SELECT * FROM cliente ORDER BY Apellido ASC");
                while ($row = $resultado->fetch_assoc()) { 
                    // Marcamos la fila que se está editando para que sea fácil de ver
                    $estilo_fila = (isset($_GET['editar']) && $_GET['editar'] == $row['Dni']) ? 'style="background-color: #e8f5e9;"' : '';
                ?>
                    <tr <?php echo $estilo_fila; ?>>
                        <td><?php echo $row['Dni']; ?></td>
                        <td><?php echo $row['Nombre']; ?></td>
                        <td><?php echo $row['Apellido']; ?></td>
                        <td><?php echo $row['Mail']; ?></td>
                        <td><?php echo $row['Direccion']; ?></td>
                        <td><?php echo $row['Ciudad']; ?></td>
                        <td><?php echo $row['Telefono']; ?></td>
                        <td>
                            <a href='ver_clientes.php?editar=<?php echo $row['Dni']; ?>'>✏️</a>
                            <a href='ver_clientes.php?eliminar=<?php echo $row['Dni']; ?>' onclick="return confirm('¿Eliminar cliente?')">❌</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <br><br>
    <section class="main-banner">
        <div class="banner-content">
            <a href="../Pagina%20Principal.php" style="text-decoration: none;">
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