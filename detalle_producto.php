<?php
session_start();
include('basededatos.php');

// 1. Validar que el ID llegue por la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../Pagina%20Principal.php");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

// 2. Obtener info general del producto
$query_prod = "SELECT * FROM producto WHERE Id_producto = '$id'";
$res_prod = mysqli_query($conexion, $query_prod);

if (!$res_prod || mysqli_num_rows($res_prod) == 0) {
    header("Location: ../Pagina%20Principal.php");
    exit();
}

$producto = mysqli_fetch_assoc($res_prod);

// 3. Obtener talles y cantidades desde la tabla STOCK
$query_stock = "SELECT * FROM stock WHERE Id_producto = '$id' AND Stock > 0 ORDER BY Talle ASC";
$res_stock = mysqli_query($conexion, $query_stock);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DETOX - <?php echo $producto['Nombre_producto']; ?></title>
    <link rel="stylesheet" href="CSS/Pagina principal.css">
    <style>
        /* Estilos específicos para esta página */
        .contenedor-detalle {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }

        .imagen-producto img {
            width: 100%;
            height: 650px;
            object-fit: cover;
            border-radius: 4px;
        }

        .info-producto {
            padding: 20px 0;
        }

        .marca-tag {
            font-size: 14px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            display: block;
        }

        .precio-producto {
            font-size: 30px;
            font-weight: 700;
            margin: 20px 0;
            color: #000;
        }

        .talle-selector {
            width: 100%;
            padding: 15px;
            border: 2px solid #000;
            font-family: inherit;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            cursor: pointer;
            outline: none;
            appearance: none;
            background-color: #fff;
        }

        .btn-comprar {
            background: #000;
            color: #fff;
            border: none;
            padding: 18px;
            width: 100%;
            font-weight: 900;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .btn-comprar:hover { background: #333; }

        .btn-ahora {
            background: #fff;
            color: #000;
            border: 2px solid #000;
            padding: 16px;
            width: 100%;
            font-weight: 900;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .btn-ahora:hover { background: #000; color: #fff; }

        @media (max-width: 768px) {
            .contenedor-detalle { grid-template-columns: 1fr; }
            .imagen-producto img { height: 450px; }
        }
    </style>
</head>
<body>

    <div id="menu_visual" style="position: fixed; top: 0; left: -250px; width: 250px; height: 100%; background: white; z-index: 1000; transition: 0.3s; box-shadow: 2px 0 10px rgba(0,0,0,0.1); padding: 20px;">
        <button onclick="menu()" style="background: none; border: none; font-size: 25px; cursor: pointer; float: right;">✕</button>
        <ul style="list-style: none; margin-top: 60px;">
            <li><a href="../Pagina Principal.php" style="text-decoration: none; color: #000; display: block; padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Destacados</a></li>
            <li><a href="../Seccion Hombre.php" style="text-decoration: none; color: #000; display: block; padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Hombre</a></li>
            <li><a href="../Seccion Mujer.php" style="text-decoration: none; color: #000; display: block; padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Mujer</a></li>
            <li><a href="../Seccion Niños.php" style="text-decoration: none; color: #000; display: block; padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Niños</a></li>
            <li><a href="../Seccion Unisex.php" style="text-decoration: none; color: #000; display: block; padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Unisex</a></li>
        </ul>
    </div>

    <div id="overlay" onclick="menu()" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;"></div>

    <div class="top-bar" style="background: #000; padding: 10px 40px;">
        <div class="top-links" style="display: flex; justify-content: space-between; align-items: center;">
            <?php if (isset($_SESSION['Nombre'])): ?>
                <span style="color: white; font-weight: bold;">Hola, <?php echo $_SESSION['Nombre']; ?>!</span>
                <div style="display: flex; gap: 20px;">
                    <a href="cerrar_sesion_cliente.php" style="text-decoration: none; color: white; font-size: 14px;">Cerrar sesión</a>
                </div>
            <?php else: ?>
                <div style="display: flex; justify-content: flex-end; gap: 20px; width: 100%;">
                    <a href="registro_cliente.php" style="text-decoration: none; color: white; font-size: 14px;">Registrarme</a>
                    <a href="Iniciar_sesion.php" style="text-decoration: none; color: white; font-weight: bold; font-size: 14px;">Iniciar sesión</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <nav class="navbar">
        <div class="logo"><a href="../Pagina Principal.php" style="text-decoration: none; color: #000; font-weight: 900; font-size: 24px;">DETOX</a></div>
        <div class="nav-icons">
            <svg onclick="toggleCarrito()" class="icon" viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="2" fill="none" style="cursor: pointer; margin-right: 15px;">
                <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <svg class="icon" onclick="menu()" viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="2" fill="none" style="cursor: pointer;">
                <line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </div>
    </nav>

    <main class="contenedor-detalle">
        <div class="imagen-producto">
            <img src="<?php echo $producto['Visualizacion']; ?>" alt="<?php echo $producto['Nombre_producto']; ?>">
        </div>

        <div class="info-producto">
            <span class="marca-tag"><?php echo $producto['Marca']; ?> | <?php echo $producto['Genero']; ?></span>
            <h1 style="font-size: 38px; text-transform: uppercase; margin: 0;"><?php echo $producto['Nombre_producto']; ?></h1>
            <p class="precio-producto">$<?php echo number_format($producto['Precio_unitario'], 0, ',', '.'); ?></p>
            
            <div style="margin-bottom: 30px; line-height: 1.6; color: #444;">
                <?php echo $producto['Descripcion']; ?>
            </div>

            <form action="agregar_items_carrito.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $producto['Id_producto']; ?>">
                <input type="hidden" name="nombre" value="<?php echo $producto['Nombre_producto']; ?>">
                <input type="hidden" name="precio" value="<?php echo $producto['Precio_unitario']; ?>">
                <input type="hidden" name="marca" value="<?php echo $producto['Marca']; ?>">
                <input type="hidden" name="cantidad" value="1">

                <label style="display: block; font-weight: bold; margin-bottom: 10px; font-size: 14px;">SELECCIONAR TALLE:</label>
                
                <?php if (mysqli_num_rows($res_stock) > 0): ?>
                    <select name="talle" class="talle-selector" required>
                        <option value="" disabled selected>ELIGE TU TALLE...</option>
                        <?php while($s = mysqli_fetch_assoc($res_stock)) { ?>
                            <option value="<?php echo $s['Talle']; ?>">
                                TALLE <?php echo $s['Talle']; ?> (<?php echo $s['Stock']; ?> DISPONIBLES)
                            </option>
                        <?php } ?>
                    </select>

                    <button type="submit" class="btn-comprar">Agregar al Carrito</button>
                    <button formaction="comprar_ahora.php" class="btn-ahora">Comprar Ahora</button>
                <?php else: ?>
                    <div style="background: #fdf2f2; color: #d03e3e; padding: 20px; text-align: center; font-weight: bold; border: 1px solid #f8d7da;">
                        LO SENTIMOS, ESTE PRODUCTO NO TIENE STOCK.
                    </div>
                <?php endif; ?>
            </form>

            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; font-size: 13px; color: #888;">
                <p>✓ Envío a todo el país.</p>
                <p>✓ 30 días para cambios y devoluciones.</p>
            </div>
        </div>
    </main>

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
    <script>
        function menu() {
            var menu = document.getElementById("menu_visual");
            var overlay = document.getElementById("overlay");
            if (menu.style.left === "-250px") {
                menu.style.left = "0";
                overlay.style.display = "block";
            } else {
                menu.style.left = "-250px";
                overlay.style.display = "none";
            }
        }
        function toggleCarrito() {
            // Aquí iría tu lógica de abrir el carrito visual
            window.location.href = "carrito.php";
        }
    </script>
    
</body>
</html>