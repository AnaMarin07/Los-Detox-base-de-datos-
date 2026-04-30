<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DETOX - Iniciar Sesión</title>
    <link rel="stylesheet" href="CSS/Registro_cliente.css">
<!--usamos la misma estetica que registro.clientes-->
</head>
<body>
    <div class="top-bar">
        <div class="top-links" style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                <a href="../Pagina%20Principal.php" style="text-decoration: none; color: white; font-size: 25px; font-weight: 900; letter-spacing: -1px;">
                    DETOX
                </a>
                <a href="../Informacion.html" style="text-decoration: none; color: white;">INFORMACION</a>
                <!--lo que hace los ../ es q se abra la carpeta completa y busque el archivo Pagina principal.php
                si no usamos el ../ buscaria ese archivo desde la carpeta php y pos no lo encontraria :3
                PERO UNICAMENTE CUANDO ES POR FUERA DE LA CARPETA es decir fuera de php, en el caso que este dentro de 
                php por ejemplo css no es necesario-->
            </div>
    </div>
    <div class="form-container">
        <h1>INICIAR SESIÓN</h1>
        <p>Ingresá tu mail y contraseña</p>

        <?php if (isset($_GET['error'])): ?>
         <!--Si ingreso algun dato incorrecto al iniciar sesion me nevia este meanje-->
            <p style="color: red; font-weight: bold;">Mail o contraseña incorrectos...</p>
        <?php endif; ?>
        <!--Si de insertar_cliente me manda a iniciar_sesion.php y todo fue correcto me aparece este mensaje-->
        <?php if (isset($_GET['exito'])): ?>
            <p style="color: green; font-weight: bold;">Cuenta creada exitosamente. Iniciá sesión!.</p>
        <?php endif; ?>
        

        <form action="verificacion_inicio_sesion.php" method="POST"><!-- Los que hace el action="verificacion_inicio_sesion" 
            confirma tu mail y contraseña a ver si posta existen-->
            <input type="email" name="Mail" placeholder="MAIL" required>
            <input type="password" name="Contraseña" placeholder="CONTRASEÑA" required>
            <button type="submit">INGRESAR</button>
        </form>

        <p style="margin-top: 15px; font-size: 13px;">¿No tenés cuenta? <a href="Registro_cliente.php">Registrate</a></p>
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
</body>
</html>