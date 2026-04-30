<?php 
session_start();
include('basededatos.php'); 

$busqueda = "";
if (isset($_GET['query'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['query']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultados: <?php echo htmlspecialchars($busqueda); ?> - Detox</title>
    <link rel="stylesheet" href="CSS/Pagina principal.css">
</head>

<body>
    <div id="menu_visual" style="position: fixed; top: 0; left: -250px; width: 250px; height: 100%; background: white; z-index: 1000; transition: 0.3s; box-shadow: 2px 0 10px rgba(0,0,0,0.1); padding: 20px;">
        <button onclick="menu()" style="background: none; border: none; font-size: 25px; cursor: pointer; float: right;">✕</button>
        <ul style="list-style: none; margin-top: 60px;">
            <a href="../Pagina Principal.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Destacados</li></a>
            <a href="../Seccion Hombre.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Hombre</li></a>
            <a href="../Seccion Mujer.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Mujer</li></a>
            <a href="../Seccion Niños.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Niños</li></a>
            <a href="../Seccion Unisex.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Unisex</li></a>
        </ul>
    </div>

    <div id="overlay" onclick="menu()" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;"></div>

    <div class="top-bar">
        <div class="top-links" style="display: flex; justify-content: space-between; width: 100%;">
            <?php if (isset($_SESSION['Nombre'])): ?>
                <span style="color: white; font-weight: bold;">Hola, <?php echo $_SESSION['Nombre']; ?>!</span>
                <div style="display: flex; gap: 20px;">
                    <a href="../informacion.html" style="text-decoration: none; color: white;">Información</a>
                    <a href="cerrar_sesion_cliente.php" style="text-decoration: none; color: white;">Cerrar sesión</a>
                </div>
            <?php else: ?>
                <div style="display: flex; justify-content: flex-end; gap: 20px; width: 100%;">
                    <a href="../informacion.html" style="text-decoration: none; color: white;">Información</a>
                    <a href="registro_cliente.php" style="text-decoration: none; color: white;">Registrarme</a>
                    <a href="Iniciar_sesion.php" style="text-decoration: none; color: white; font-weight: bold;">Iniciar sesión</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <nav class="navbar">
        <div class="logo"><a href="../Pagina%20Principal.php" style="text-decoration: none; color: black;">DETOX</a></div>
        <ul class="nav-links">
            <li><a href="../Seccion Hombre.php" style="text-decoration: none; color: black;">Hombre</a></li>
            <li><a href="../Seccion Mujer.php" style="text-decoration: none; color: black;">Mujer</a></li>
            <li><a href="../Seccion Niños.php" style="text-decoration: none; color: black;">Niños</a></li>
            <li><a href="../Seccion Unisex.php" style="text-decoration: none; color: black;">Unisex</a></li>
        </ul>
        <div class="nav-icons">
            <svg class="icon" onclick="lupa()" viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="2" fill="none"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <svg class="icon" onclick="menu()" viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="2" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </div>
    </nav>

    <div id="barrita_de_busqueda" style="display: none; background: white; padding: 20px 40px; border-bottom: 1px solid #ddd;">
        <form action="buscar.php" method="GET" style="max-width: 1000px; margin: 0 auto; display: flex; align-items: center; gap: 15px;">
            <input type="text" name="query" placeholder="Buscar productos..." style="width: 100%; border: none; font-size: 20px; outline: none;">
            <button type="submit" style="background:none; border:none; cursor:pointer; font-size:20px;">🔍</button>
            <button type="button" onclick="lupa()" style="background: none; border: none; font-size: 24px; cursor: pointer;">✕</button>
        </form>
    </div>

    <div style="padding: 50px; text-align: center; min-height: 60vh;">
        <h1 style="font-size: 40px; font-weight: 900; text-transform: uppercase;">
            Resultados para: "<?php echo htmlspecialchars($busqueda); ?>"
        </h1>
        
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 30px;">
            <?php 
            $query = "SELECT * FROM producto WHERE Nombre_producto LIKE '%$busqueda%' OR Marca LIKE '%$busqueda%' ORDER BY Id_producto DESC";
            $resultado = mysqli_query($conexion, $query);

            if (mysqli_num_rows($resultado) > 0) {
                while($row = mysqli_fetch_array($resultado)) { ?>
                    <div style="border: 1px solid #eee; padding: 15px; width: 250px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: white;">
                        <img src="<?php echo $row['Visualizacion']; ?>" alt="Producto" style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                        <h3 style="margin: 15px 0 5px; font-size: 18px; text-transform: uppercase;"><?php echo $row['Marca']; ?></h3>
                        <p style="color: #666; font-size: 14px; margin-bottom: 5px;"><?php echo $row['Nombre_producto']; ?></p>
                        <p style="font-weight: bold; font-size: 20px;">$<?php echo $row['Precio_unitario']; ?></p>
                        <a href="detalle_producto.php?id=<?php echo $row['Id_producto']; ?>" style="text-decoration: none;">
                            <button style="background: black; color: white; border: none; padding: 10px 20px; width: 100%; cursor: pointer; margin-top: 10px; font-weight: bold;">VER DETALLES</button>
                        </a>
                    </div>
                <?php } 
            } else {
                echo "<div style='margin-top: 50px;'><p style='font-size: 18px; color: #888;'>No encontramos productos que coincidan con tu búsqueda.</p><br><a href='../Pagina Principal.php' style='color: black; font-weight: bold;'>Ver todos los productos</a></div>";
            }
            ?>
        </div>
    </div>

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
        function lupa() {
            var x = document.getElementById("barrita_de_busqueda");
            x.style.display = (x.style.display === "none") ? "block" : "none";
        }
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
    </script>
</body>
</html>