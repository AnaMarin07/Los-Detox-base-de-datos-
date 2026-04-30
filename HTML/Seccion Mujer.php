<?php 
session_start(); 
include('PHP/basededatos.php'); 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detox Project - Mujer </title>
    <link rel="stylesheet" href="PHP/CSS/Pagina principal.css">
    <style>
        /* Estilos idénticos a tu página principal para mantener la estética */
        .card-producto:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .btn-ver-mas:hover {
            background-color: #333 !important;
        }
    </style>
</head>

<body>
    <div id="side-menu" style="position: fixed; top: 0; left: -250px; width: 250px; height: 100%; background: white; z-index: 1000; transition: 0.3s; box-shadow: 2px 0 10px rgba(0,0,0,0.1); padding: 20px;">
        <button onclick="menu()" style="background: none; border: none; font-size: 25px; cursor: pointer; float: right;">✕</button>
        <ul style="list-style: none; margin-top: 60px;">
            <a href="Pagina Principal.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Destacados</li></a>
            <a href="Seccion Hombre.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Hombre</li></a>
            <a href="Seccion Mujer.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Mujer</li></a>
            <a href="Seccion Niños.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Niños</li></a>
            <a href="Seccion Unisex.php" style="text-decoration: none; color: black;"><li style="padding: 15px 0; font-weight: bold; border-bottom: 1px solid #eee;">Unisex</li></a>
        </ul>
    </div>

    <div id="overlay" onclick="menu()" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;"></div>

    <div class="top-bar">
        <div class="top-links" style="display: flex; justify-content: space-between; width: 100%;">
            <?php if (isset($_SESSION['Nombre'])): ?>
                <span style="color: white; font-weight: bold; font-size: 15px;">Hola, <?php echo $_SESSION['Nombre']; ?>!</span>
                <div style="display: flex; gap: 20px;">
                    <a href="informacion.html" style="text-decoration: none; color: white;">Información</a>
                    <a href="PHP/cerrar_sesion_cliente.php" style="text-decoration: none; color: white;">Cerrar sesión</a>
                </div>
            <?php else: ?>
                <div style="display: flex; justify-content: flex-end; gap: 20px; width: 100%;">
                    <a href="informacion.html" style="text-decoration: none; color: white;">Información</a>
                    <a href="PHP/registro_cliente.php" style="text-decoration: none; color: white;">Registrarme</a>
                    <a href="PHP/Iniciar_sesion.php" style="text-decoration: none; color: white; font-weight: bold;">Iniciar sesión</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <nav class="navbar">
        <div class="logo"><a href="Pagina Principal.php" style="text-decoration: none; color: black;">DETOX</a></div>
        <ul class="nav-links">
            <li><a href="Seccion Hombre.php" style="text-decoration: none; color: black;">Hombre</a></li>
            <li><a href="Seccion Mujer.php" style="text-decoration: none; color: black;">Mujer</a></li>
            <li><a href="Seccion Niños.php" style="text-decoration: none; color: black;">Niños</a></li>
            <li><a href="Seccion Unisex.php" style="text-decoration: none; color: black;">Unisex</a></li>
        </ul>
        <div class="nav-icons">
            <svg class="icon" onclick="lupa()" viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="2" fill="none" style="cursor:pointer;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <svg class="icon" onclick="menu()" viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="2" fill="none" style="cursor:pointer;"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </div>
    </nav>

    <div id="search-bar" style="display: none; background: white; padding: 20px 40px; border-bottom: 1px solid #ddd;">
        <form action="PHP/buscar.php" method="GET" style="max-width: 1000px; margin: 0 auto; display: flex; align-items: center; gap: 15px;">
            <input type="text" name="query" placeholder="Buscar productos..." style="width: 100%; border: none; font-size: 20px; outline: none;">
            <button type="submit" style="background: none; border: none; font-size: 20px; cursor: pointer;">🔍</button>
            <button type="button" onclick="lupa()" style="background: none; border: none; font-size: 24px; cursor: pointer;">✕</button>
        </form>
    </div>

    <div style="padding: 60px 20px; text-align: center; background-color: #fcfcfc;">
        <h1 style="font-size: 45px; font-weight: 900; letter-spacing: -2px; margin-bottom: 10px; text-transform: uppercase;">MUJER</h1>
        <p style="color: #888; margin-bottom: 40px;">Colección exclusiva para ellas</p>
        
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">
            <?php 
            // Query con GROUP_CONCAT para traer todos los talles en una sola fila
            $query = "SELECT p.*, GROUP_CONCAT(s.Talle SEPARATOR ', ') as talles_disponibles 
                      FROM producto p 
                      LEFT JOIN stock s ON p.Id_producto = s.Id_producto 
                      WHERE p.Genero = 'Femenino' 
                      GROUP BY p.Id_producto 
                      ORDER BY p.Id_producto DESC";
            
            $resultado = mysqli_query($conexion, $query);
            
            while($row = mysqli_fetch_array($resultado)) { ?>
                <div class="card-producto" style="border: 1px solid #eee; width: 280px; border-radius: 15px; overflow: hidden; background: white; transition: 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.02); text-align: left;">
                    <div style="height: 320px; overflow: hidden;">
                        <img src="PHP/<?php echo $row['Visualizacion']; ?>" alt="Producto" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 20px;">
                        <span style="font-size: 12px; color: #bbb; text-transform: uppercase; font-weight: 700;"><?php echo $row['Marca']; ?></span>
                        <h2 style="font-size: 18px; margin: 5px 0; font-weight: 700; color: #111;"><?php echo $row['Nombre_producto']; ?></h2>
                        
                        <div style="margin-top: 10px;">
                            <p style="font-size: 10px; font-weight: 800; color: #ddd; margin-bottom: 5px; text-transform: uppercase;">Talles Disponibles</p>
                            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                <?php 
                                if (!empty($row['talles_disponibles'])) {
                                    $talles = explode(', ', $row['talles_disponibles']);
                                    foreach($talles as $t) {
                                        echo "<span style='font-size: 10px; border: 1px solid #f0f0f0; padding: 2px 6px; border-radius: 3px; background: #fafafa; font-weight: bold;'>$t</span>";
                                    }
                                } else {
                                    echo "<span style='font-size: 10px; color: red;'>Sin Stock</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                            <span style="font-size: 20px; font-weight: 900;">$<?php echo number_format($row['Precio_unitario'], 0, ',', '.'); ?></span>
                            <a href="PHP/detalle_producto.php?id=<?php echo $row['Id_producto']; ?>" style="text-decoration: none;">
                                <button class="btn-ver-mas" style="background: black; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 11px;">VER MÁS</button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
            <a href="#"><img src="PHP/CSS/IMAGENES/download-removebg-preview (1).png" width=35px alt="Instagram"></a>
            <a href="#"><img src="PHP/CSS/IMAGENES/tiktok.png" width=40px alt="TikTok"></a>
            <a href="#"><img src="PHP/CSS/IMAGENES/X.png" width=30px alt="X"></a>
        </div>

        </div>
    </footer>
    <p style="text-align:center; background:#111; color:#313131; padding:15px;">
        © 2026 DETOX - Todos los derechos reservados
    </p>
    <script>
        function lupa() {
            var x = document.getElementById("search-bar");
            x.style.display = (x.style.display === "none") ? "block" : "none";
        }
        function menu() {
            var menu = document.getElementById("side-menu");
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