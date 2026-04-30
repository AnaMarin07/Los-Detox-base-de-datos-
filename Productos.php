<?php include('basededatos.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DETOX - Panel de Productos</title>
    <link rel="stylesheet" href="CSS/Productos.css">
    <style>
        /* Ajuste para pegar la tabla al formulario */
        .form-container { margin-bottom: 0px !important; padding-bottom: 15px; }
        h2 { margin-top: 10px !important; margin-bottom: 10px; }
        .variante-row { display: flex; gap: 10px; margin-bottom: 8px; }
        .variante-row input { margin-bottom: 0 !important; }
    </style>
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
        $id_eliminar = $_GET['eliminar'];
        $conexion->query("SET FOREIGN_KEY_CHECKS = 0"); 
        $conexion->query("DELETE FROM stock WHERE Id_producto = '$id_eliminar'");
        $conexion->query("DELETE FROM Producto WHERE Id_producto = '$id_eliminar'");
        $conexion->query("SET FOREIGN_KEY_CHECKS = 1");
        echo "<script>window.location='Productos.php';</script>";
        exit();
    }

    // --- 2. LÓGICA DE ACTUALIZAR ---
    if (isset($_POST['actualizar'])) {
        $id = $_POST['id'];
        $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
        $marca = mysqli_real_escape_string($conexion, $_POST['marca']);
        $precio_unitario = $_POST['precio_unitario'];
        $genero = $_POST['genero'];
        $nombre_p = mysqli_real_escape_string($conexion, $_POST['nombre_producto']);
        $prio = $_POST['prioridad'];

        // Update Producto
        $sql_update = "UPDATE Producto SET 
            Descripcion='$descripcion', Marca='$marca', Precio_unitario='$precio_unitario', 
            Genero='$genero', Nombre_producto='$nombre_p', Prioridad='$prio' 
            WHERE Id_producto='$id'";
        $conexion->query($sql_update);

        // Update Stock: Borramos los anteriores e insertamos los nuevos
        $conexion->query("DELETE FROM stock WHERE Id_producto = '$id'");
        $talles = $_POST['talles'];
        $stocks = $_POST['stocks'];

        foreach ($talles as $i => $t_valor) {
            if (!empty($t_valor)) {
                $s_valor = (int)$stocks[$i];
                $conexion->query("INSERT INTO stock (Id_producto, Talle, Stock) VALUES ('$id', '$t_valor', '$s_valor')");
            }
        }

        echo "<script>window.location='Productos.php';</script>";
        exit();
    }
    ?>

    <div class="content-wrapper" style="padding: 20px;">
        
        <?php 
        // --- 3. SELECCIÓN DE FORMULARIO ---
        if (isset($_GET['editar'])): 
            $id_editar = $_GET['editar'];
            $res = $conexion->query("SELECT * FROM Producto WHERE Id_producto = '$id_editar'");
            $prod = $res->fetch_assoc();
            if ($prod):
        ?>
            <div class="form-container" style="background-color: #f9f9f9; border: 2px solid #28a745;">
                <h1 style="font-weight: 900; color: #28a745; letter-spacing: -1px;">EDITANDO PRODUCTO #<?php echo $prod['Id_producto']; ?></h1>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $prod['Id_producto']; ?>">
                    <input type="text" name="nombre_producto" value="<?php echo $prod['Nombre_producto']; ?>" required>
                    <input type="text" name="marca" value="<?php echo $prod['Marca']; ?>" required>
                    <input type="text" name="precio_unitario" value="<?php echo $prod['Precio_unitario']; ?>" required>
                    
                    <select name="genero" required>
                        <option value="Masculino" <?php if($prod['Genero'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
                        <option value="Femenino" <?php if($prod['Genero'] == 'Femenino') echo 'selected'; ?>>Femenino</option>
                        <option value="Niños" <?php if($prod['Genero'] == 'Niños') echo 'selected'; ?>>Niños</option>
                        <option value="Unisex" <?php if($prod['Genero'] == 'Unisex') echo 'selected'; ?>>Unisex</option>
                    </select>

                    <div style="background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                        <p style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">EDITAR VARIANTES:</p>
                        <?php
                        $stk_res = $conexion->query("SELECT * FROM stock WHERE Id_producto = '$id_editar'");
                        for($i=0; $i<3; $i++): 
                            $s_data = $stk_res->fetch_assoc();
                        ?>
                            <div class="variante-row">
                                <input type="text" name="talles[]" value="<?php echo $s_data['Talle'] ?? ''; ?>" placeholder="Talle">
                                <input type="number" name="stocks[]" value="<?php echo $s_data['Stock'] ?? ''; ?>" placeholder="Stock">
                            </div>
                        <?php endfor; ?>
                    </div>

                    <input type="number" name="prioridad" value="<?php echo $prod['Prioridad']; ?>" min="0" max="1">
                    <textarea name="descripcion" rows="2"><?php echo $prod['Descripcion']; ?></textarea>
                    
                    <button type="submit" name="actualizar" class="btn-negro" style="background: #28a745;">GUARDAR CAMBIOS</button>
                    <a href="Productos.php" style="display:block; text-align:center; margin-top:10px; color: #333; text-decoration: none; font-size: 13px;">← CANCELAR</a>
                </form>
            </div>
        <?php 
            endif;
        else: 
        ?>
            <div class="form-container">
                <h1 style="font-weight: 900; letter-spacing: -1px;">NUEVO PRODUCTO</h1>
                <form action="inserta_producto.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nombre_producto" placeholder="NOMBRE DEL PRODUCTO" required>
                    <input type="text" name="marca" placeholder="MARCA" required>
                    <input type="text" name="precio_unitario" placeholder="PRECIO UNIDAD" required>
                    
                    <select name="genero" required>
                        <option value="" disabled selected>GÉNERO</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Niños">Niños</option>
                        <option value="Unisex">Unisex</option>
                    </select>

                    <div style="background: #eee; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                        <p style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">Talles y Stock (Múltiples):</p>
                        <div class="variante-row"><input type="text" name="talles[]" placeholder="Talle 1"><input type="number" name="stocks[]" placeholder="Stock"></div>
                        <div class="variante-row"><input type="text" name="talles[]" placeholder="Talle 2"><input type="number" name="stocks[]" placeholder="Stock"></div>
                        <div class="variante-row"><input type="text" name="talles[]" placeholder="Talle 3"><input type="number" name="stocks[]" placeholder="Stock"></div>
                    </div>

                    <input type="number" name="prioridad" placeholder="PRIORIDAD (0 o 1)" min="0" max="1" value="0">
                    <input type="file" name="Imagen" accept="image/*" required>
                    <textarea name="descripcion" placeholder="DESCRIPCIÓN" rows="2"></textarea>
                    
                    <button type="submit" class="btn-negro">GUARDAR PRODUCTO</button>
                </form>
            </div>
        <?php endif; ?>

        <h2 style="font-weight: 900; letter-spacing: -1px;">PRODUCTOS EN INVENTARIO</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Talles y Stock</th> 
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php   
                $query = "SELECT * FROM Producto ORDER BY Id_producto DESC";
                $resultado = mysqli_query($conexion, $query);
                while($row = mysqli_fetch_array($resultado)) { 
                    $id_p = $row['Id_producto'];
                ?>
                    <tr>
                        <td>#<?php echo $id_p; ?></td>
                        <td><?php echo $row['Nombre_producto']; ?></td>
                        <td>$<?php echo $row['Precio_unitario']; ?></td>
                        <td style="font-size: 12px;">
                            <?php 
                            $stk_res = $conexion->query("SELECT * FROM stock WHERE Id_producto = '$id_p'");
                            while($stk = $stk_res->fetch_assoc()){
                                echo "<b>".$stk['Talle'].":</b> ".$stk['Stock']."<br>";
                            }
                            ?>
                        </td>
                        <td><img src="<?php echo $row['Visualizacion']; ?>" width="40"></td>
                        <td>
                            <a href='Productos.php?editar=<?php echo $id_p; ?>'>✏️</a>
                            <a href='Productos.php?eliminar=<?php echo $id_p; ?>' onclick="return confirm('¿Eliminar?')">❌</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <br><br>
    <section class="main-banner">
        <div class="banner-content">
            <a href="http://localhost/HTML/Pagina Principal.php"  style="text-decoration: none;">
                <button class="btn-banner">Volver a la página principal</button>
            </a>
        </div>
    </section> 
    <br> <br>

    <pre style="text-align: center;"> <b> Tener en cuenta que el ID no es visual, no va en orden numerico. <b> </pre>
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