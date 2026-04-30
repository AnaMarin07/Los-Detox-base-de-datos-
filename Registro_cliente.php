<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- pa q entiendan el uff-8 es para q el navegador reconozca los simbolos tipo "´" o "ñ" -->
    <title>DETOX - Registro</title>
    <link rel="stylesheet" href="CSS/Registro_cliente.css">
    <!-- y esto para q tome el estilo del css -->
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
    <h1>CREAR CUENTA</h1>
    <p>Completá tus datos para registrarte</p>

    <form action="inserta_cliente.php" method="POST"><!-- Al tener el form action hace que todo estos datos
        que ingresamos se mande al archivo "inserta_cliente.php", ya luego ese archivo se encargada de
        mandar todo lo ingresado a la base de datos de phpmyadmin y ahi se guarda! Se podria decir que el
        "method="post"" hace que todo estos datos se manden de manera invisible por la url. Y el "FORM" es
        la manera en como se envia estos datos, por ejemplo en un sobre!-->
        <input type="text" name="Dni" placeholder="DNI" 
            oninput="this.value = this.value.replace(/[^0-9]/g, ''); validarDni(this)" 
            onblur="document.getElementById('error_dni').style.display = 'none'"
            maxlength="8"
         required>
<!--Oninput= cuando clickear el cuadrito para ingresar datos. onblur= cuando dejas de precionar-->
        <p id="error_dni" style="color: red; font-size: 12px; display: none;"></p><!--El <p></p> esta vacio pq cuando
        empieza a funcionar el javascript busca doonde colocar ese texto que pusimos mas abajo sino no apareceria-->
        <input type="text" name="Nombre" placeholder="NOMBRE" required>
        <input type="text" name="Apellido" placeholder="APELLIDO" required>
        <input type="email" name="Mail" placeholder="MAIL" required>
        <input type="password" name="Contraseña" placeholder="CONTRASEÑA" required>
        <input type="text" name="Direccion" placeholder="DIRECCIÓN" required>
        <input type="text" name="Codigo_postal" placeholder="CÓDIGO POSTAL" maxlength="8" required>
        <input type="text" name="Ciudad" placeholder="CIUDAD" required>
        <input type="text" name="Telefono" placeholder="TELÉFONO" required>
        <button type="submit">CREAR CUENTA</button><!-- Submit==confirma datos para envia y hacer el proceso! -->
    </form>
    <p style="margin-top: 15px; font-size: 13px;">¿Ya tenés cuenta? <a href="Iniciar_sesion.php">Inicia Sesion</a></p>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'dni_duplicado'): ?>
    <p style="color: red; font-weight: bold;"> Ese DNI ya fue registrado.</p>
    <?php endif; ?>
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
<script>
function validarDni(input) {
        if (input.value.length === 8) {
            document.getElementById("error_dni").style.display = "block";
            document.getElementById("error_dni").innerText = "DNI completo";
            document.getElementById("error_dni").style.color = "black";
        } else if (input.value.length > 0) {
            document.getElementById("error_dni").style.display = "block";
            document.getElementById("error_dni").innerText = "El DNI debe tener 8 dígitos";
            document.getElementById("error_dni").style.color = "gray";
        } else {
            document.getElementById("error_dni").style.display = "none";
        }
    }
</script>
</html>
