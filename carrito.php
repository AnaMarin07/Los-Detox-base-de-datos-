<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DETOX - Carrito</title>
    <link rel="stylesheet" href="CSS/Pagina principal.css">
</head>
<body>

<div class="top-bar">
    <div class="top-links" style="display: flex; justify-content: space-between; width: 100%;">
        <?php if (isset($_SESSION['Nombre'])): ?>
            <span style="color: white; font-weight: bold; font-size: 15px;">Hola, <?php echo $_SESSION['Nombre']; ?>!</span>
            <div style="display: flex; gap: 20px;">
                <a href="informacion.html" style="text-decoration: none; color: white;">
                    <span>Información</span>
                </a>
                <a href="cerrar_sesion_cliente.php" style="text-decoration: none; color: white;">
                    <span>Cerrar sesión</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div style="padding: 50px; max-width: 900px; margin: 0 auto;">
    <h1 style="font-size: 40px; font-weight: 900;">MI CARRITO DETOX</h1>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p style="color: #888; margin-top: 20px;">Tu carrito está vacío.</p>
        <a href="../Pagina%20Principal.php">
            <button style="background: black; color: white; border: none; padding: 12px 30px; margin-top: 15px; cursor: pointer; font-weight: bold;">
                SEGUIR COMPRANDO
            </button>
        </a>

    <?php else: ?>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'stock'): ?>
            <div style="background: #ffebee; color: #c62828; padding: 15px; margin-bottom: 20px; border-radius: 4px; font-weight: bold;">
                ⚠️ No hay más stock disponible para ese talle.
            </div>
        <?php endif; ?>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="border-bottom: 2px solid black;">
                    <th style="text-align: left; padding: 10px;">Producto</th>
                    <th style="padding: 10px;">Talle</th> <th style="padding: 10px;">Precio</th>
                    <th style="padding: 10px;">Cantidad</th>
                    <th style="padding: 10px;">Subtotal</th>
                    <th style="padding: 10px;">Eliminar</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $total = 0;
            foreach ($_SESSION['carrito'] as $item): 
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px; font-weight: bold;"><?php echo $item['marca']; ?> - <?php echo $item['nombre']; ?></td>
                    <td style="padding: 10px; text-align: center; color: #555;"><?php echo $item['talle']; ?></td> <td style="padding: 10px; text-align: center;">$<?php echo number_format($item['precio'], 0, ',', '.'); ?></td>
                    <td style="padding: 10px; text-align: center; white-space: nowrap;">
                        <a href="actualizar_items_carrito.php?id=<?php echo $item['id']; ?>&talle=<?php echo $item['talle']; ?>&accion=restar" 
                           style="background: black; color: white; border: none; padding: 4px 12px; cursor: pointer; text-decoration: none; font-weight: bold;">−</a>
                        
                        <span style="margin: 0 10px; font-weight: bold;"><?php echo $item['cantidad']; ?></span>
                        
                        <a href="actualizar_items_carrito.php?id=<?php echo $item['id']; ?>&talle=<?php echo $item['talle']; ?>&accion=sumar"
                           style="background: black; color: white; border: none; padding: 4px 12px; cursor: pointer; text-decoration: none; font-weight: bold;">+</a>
                    </td>
                    <td style="padding: 10px; text-align: center; font-weight: bold;">$<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    <td style="padding: 10px; text-align: center;">
                        <a href="eliminar_items_carrito.php?id=<?php echo $item['id']; ?>&talle=<?php echo $item['talle']; ?>" style="color: #ff0000; text-decoration: none; font-size: 13px;">✕ Quitar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
       
        <div style="margin-top: 30px;">    
            <h2 style="text-align: right; margin-bottom: 5px;">TOTAL: $<?php echo number_format($total, 0, ',', '.'); ?></h2>
            <p style="text-align: right; color: gray; font-size: 14px;">
                <?php echo ($total >= 100000) ? '¡Tenés envío GRATIS!' : 'Te faltan $' . (100000 - $total) . ' para envío gratis'; ?>
            </p>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 40px; border-top: 1px solid #ddd; padding-top: 20px;">
            <a href="../Pagina%20Principal.php">
                <button style="background: white; color: black; border: 2px solid black; padding: 12px 30px; cursor: pointer; font-weight: bold;">
                    SEGUIR COMPRANDO
                </button>
            </a>
            <a href="finalizar_compra.php"> 
                <button style="background: black; color: white; border: none; padding: 12px 40px; cursor: pointer; font-weight: bold; letter-spacing: 1px;">
                    FINALIZAR COMPRA
                </button>
            </a>
        </div>
        
    <?php endif; ?>
</div> <br> <br> <br>
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
    </footer> <br>
    <p style="text-align:center; background:#111; color:#313131; padding:15px;">
        © 2026 DETOX - Todos los derechos reservados
    </p>
</body>
</html>