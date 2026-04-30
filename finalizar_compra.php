<?php
session_start();
include('basededatos.php');

if (!isset($_SESSION['Dni'])) {
    header("Location: Iniciar_sesion.php");
    exit();
}

if (empty($_SESSION['carrito'])) {
    header("Location: ../Pagina%20Principal.php");
    exit();
}

$Dni = $_SESSION['Dni'];

$res_cli = mysqli_query($conexion, "SELECT * FROM cliente WHERE Dni='$Dni'");
$cliente = mysqli_fetch_assoc($res_cli);

// Calculamos el total del carrito
$subtotal = 0;
foreach ($_SESSION['carrito'] as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}
$costo_envio = ($subtotal > 100000) ? 0 : 20000;
$total_con_envio = $subtotal + $costo_envio;

$mensaje_ok    = "";
$mensaje_error = "";

if (isset($_POST['confirmar'])) {
    $metodo_pago = $_POST['metodo_pago'];
    $fecha_hoy   = date('Y-m-d');

    // Iniciamos una transacción para asegurarnos de que todo se guarde bien
    mysqli_begin_transaction($conexion);

    try {
        // 1. Insertamos el pedido
        $sql_pedido = "INSERT INTO Pedidos (Fecha, Total, Dni)
                       VALUES ('$fecha_hoy', '$total_con_envio', '$Dni')";
        
        if (!mysqli_query($conexion, $sql_pedido)) throw new Exception("Error al crear pedido");
        
        $nro_pedido = mysqli_insert_id($conexion);

        // 2. Procesamos cada producto del carrito
        foreach ($_SESSION['carrito'] as $item) {
            $id_prod = $item['id'];
            $talle   = $item['talle'];
            
            // ASEGURAMOS QUE LA CANTIDAD EXISTA
            // Si en tu carrito usas 'cantidad', usamos esa. Si no, 1 por defecto.
            $cant = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;

            // Insertamos en la tabla Contiene
            mysqli_query($conexion, "INSERT INTO Contiene (Nro_pedido, Id_producto)
                                     VALUES ('$nro_pedido', '$id_prod')");

            // ACTUALIZACIÓN DE STOCK
            // La variable $cant DEBE ser un número para que no dé error de sintaxis
            $sql_update_stock = "UPDATE stock 
                                 SET stock = stock - $cant 
                                 WHERE Id_producto = '$id_prod' AND Talle = '$talle'";
            
            if (!mysqli_query($conexion, $sql_update_stock)) {
                // Si falla, capturamos el error específico de SQL para saber qué pasó
                throw new Exception("Error SQL: " . mysqli_error($conexion));
            }
        }

        // 3. Insertamos método de pago
        mysqli_query($conexion, "INSERT INTO Metodos_De_Pago (Metodo, Precio, Nro_pedido)
                                 VALUES ('$metodo_pago', '$total_con_envio', '$nro_pedido')");

        mysqli_commit($conexion);
        
        $_SESSION['carrito'] = [];
        $mensaje_ok = "¡Compra realizada con éxito! Tu número de pedido es: #$nro_pedido";

    } catch (Exception $e) {
        mysqli_rollback($conexion);
        $mensaje_error = "Error al procesar el pedido: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DETOX - Finalizar Compra</title>
    <link rel="stylesheet" href="CSS/Pagina principal.css">
</head>
<body>

<div class="top-bar">
    <div class="top-links" style="display: flex; justify-content: space-between; width: 100%;">
        <span style="color: white; font-weight: bold; font-size: 15px;">
            Hola, <?php echo $_SESSION['Nombre']; ?>!
        </span>
        <div style="display: flex; gap: 20px;">
            <a href="../Informacion.html" style="text-decoration: none; color: white;"><span>Información</span></a>
            <a href="cerrar_sesion_cliente.php" style="text-decoration: none; color: white;"><span>Cerrar sesión</span></a>
        </div>
    </div>
</div>

<nav class="navbar">
    <div class="logo">
        <a href="../Pagina%20Principal.php" style="text-decoration: none; color: rgb(0, 0, 0);">DETOX</a>
    </div>
    <ul class="nav-links">
        <a href="../Seccion%20Hombre.php" style="text-decoration: none; color: rgb(0, 0, 0);"><li>Hombre</li></a>
        <a href="../Seccion%20Mujer.php" style="text-decoration: none; color: rgb(0, 0, 0);"><li>Mujer</li></a>
        <a href="../Seccion%20Niños.php" style="text-decoration: none; color: rgb(0, 0, 0);"><li>Niños</li></a>
        <a href="../Seccion%20Unisex.php" style="text-decoration: none; color: rgb(0, 0, 0);"><li>Unisex</li></a>
    </ul>
</nav>

<?php if ($mensaje_ok != ""): ?>
<div style="max-width: 600px; margin: 80px auto; text-align: center; padding: 0 40px;">
    <h1 style="font-size: 48px; font-weight: 900; letter-spacing: -2px;">¡LISTO!</h1>
    <p style="font-size: 18px; color: #444; margin: 20px 0;"><?php echo $mensaje_ok; ?></p>
    <p style="font-size: 14px; color: #999; margin-bottom: 40px;">
        Recibirás tu pedido en: <b><?php echo $cliente['Direccion']; ?>, <?php echo $cliente['Ciudad']; ?></b>
    </p>
    <a href="../Pagina%20Principal.php" style="text-decoration: none;">
        <button style="background: black; color: white; border: none; padding: 16px 40px;
                        font-size: 16px; font-weight: bold; cursor: pointer; letter-spacing: 1px;">
            VOLVER AL INICIO
        </button>
    </a>
</div>

<?php else: ?>
<div style="max-width: 1000px; margin: 60px auto; padding: 0 40px; display: flex; gap: 60px; align-items: flex-start; flex-wrap: wrap;">

    <div style="flex: 1; min-width: 280px;">
        <h2 style="font-size: 28px; font-weight: 900; letter-spacing: -1px; margin-bottom: 30px;">TU PEDIDO</h2>

        <?php foreach ($_SESSION['carrito'] as $item): 
            $res_subtotal = $item['precio'] * $item['cantidad'];
        ?>
        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; font-size: 14px;">
            <span><?php echo $item['marca']; ?> - <?php echo $item['nombre']; ?> (Talle: <?php echo $item['talle']; ?>) x<?php echo $item['cantidad']; ?></span>
            <span style="font-weight: bold;">$<?php echo number_format($res_subtotal, 0, ',', '.'); ?></span>
        </div>
        <?php endforeach; ?>

        <div style="display: flex; justify-content: space-between; font-size: 13px; color: #888; margin-top: 15px;">
            <span>Envío</span><span><?php echo $subtotal > 100000 ? '<span style="font-weight: bold;">GRATIS</span>' : '<span style="font-weight: bold;">$20.000</span>'; ?></span>
        </div>     
        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 20px; border-top: 2px solid #111; padding-top: 15px; margin-top: 10px;">
            <span>TOTAL</span>
            <span>$<?php echo number_format($total_con_envio, 0, ',', '.'); ?></span>
        </div>
    </div>

    <div style="flex: 1; min-width: 280px;">
        <h2 style="font-size: 28px; font-weight: 900; letter-spacing: -1px; margin-bottom: 30px;">TUS DATOS</h2>

        <?php if ($mensaje_error != ""): ?>
            <p style="color: red; font-weight: bold; margin-bottom: 15px;"><?php echo $mensaje_error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <p style="font-size: 13px; color: #888; margin-bottom: 5px;">NOMBRE</p>
            <input type="text" value="<?php echo $cliente['Nombre'] . ' ' . $cliente['Apellido']; ?>"
                   disabled style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; background: #f9f9f9; font-size: 14px;">

            <p style="font-size: 13px; color: #888; margin-bottom: 5px;">DIRECCIÓN DE ENTREGA</p>
            <input type="text" value="<?php echo $cliente['Direccion'] . ', ' . $cliente['Ciudad'] . ' (' . $cliente['cod_postal'] . ')'; ?>"
                   disabled style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; background: #f9f9f9; font-size: 14px;">

            <p style="font-size: 13px; color: #888; margin-bottom: 5px;">TELÉFONO</p>
            <input type="text" value="<?php echo $cliente['Telefono']; ?>"
                   disabled style="width: 100%; padding: 12px; margin-bottom: 25px; border: 1px solid #ddd; background: #f9f9f9; font-size: 14px;">

            <p style="font-size: 13px; color: #888; margin-bottom: 8px;">MÉTODO DE PAGO</p>
            <select name="metodo_pago" id="metodo_pago" required onchange="mostrarFormPago(this.value)"
                    style="width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; font-size: 14px; background: white;">
                <option value="" disabled selected>Seleccioná un método</option>
                <option value="Tarjeta">Tarjeta de crédito/débito</option>
                <option value="Efectivo">Efectivo (contra entrega)</option>
                <option value="Transferencia">Transferencia bancaria</option>
            </select>

            <div id="form-tarjeta" style="display: none; margin-bottom: 20px;">
                <p style="font-size: 13px; color: #888; margin-bottom: 8px;">NÚMERO DE TARJETA</p>
                <input type="text" name="nro_tarjeta" maxlength="19" placeholder="0000 0000 0000 0000"
                        oninput="formatearTarjeta(this)"
                        style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; font-size: 14px; letter-spacing: 2px;">
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <p style="font-size: 13px; color: #888; margin-bottom: 8px;">VENCIMIENTO</p>
                        <input type="text" name="vencimiento" placeholder="MM/AA" maxlength="5"
                               oninput="formatearVencimiento(this)"
                               style="width: 100%; padding: 12px; border: 1px solid #ddd; font-size: 14px;">
                    </div>
                    <div style="flex: 1;">
                        <p style="font-size: 13px; color: #888; margin-bottom: 8px;">CVV</p>
                        <input type="password" name="cvv" placeholder="•••" maxlength="4"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px; border: 1px solid #ddd; font-size: 14px;">
                    </div>
                </div>
                <p style="font-size: 13px; color: #888; margin-bottom: 8px; margin-top: 15px;">NOMBRE EN LA TARJETA</p>
                <input type="text" name="nombre_tarjeta" placeholder="TAL COMO FIGURA EN LA TARJETA"
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; font-size: 14px; text-transform: uppercase;">
            </div>

            <div id="form-efectivo" style="display: none; margin-bottom: 20px; padding: 20px; background: #f9f9f9; border-left: 3px solid #111;">
                <p style="font-weight: bold; font-size: 14px; margin-bottom: 8px;">Pago contra entrega</p>
                <p style="font-size: 13px; color: #666;">Se paga al recibir el paquete.</p>
            </div>

            <div id="form-transferencia" style="display: none; margin-bottom: 20px; padding: 20px; background: #f9f9f9; border-left: 3px solid #111;">
                <p style="font-weight: bold; font-size: 14px; margin-bottom: 12px;">Datos bancarios</p>
                <p style="font-size: 13px; color: #555;">CBU: 0070999520000001234567</p>
                <input type="text" name="nro_comprobante" placeholder="Número de comprobante"
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; font-size: 14px; margin-top: 10px;">
            </div>

            <button type="button" onclick="validarYEnviar()"
                    style="background: black; color: white; border: none; padding: 16px; width: 100%;
                    font-size: 16px; font-weight: bold; cursor: pointer; letter-spacing: 1px;">
                CONFIRMAR COMPRA
            </button>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function mostrarFormPago(metodo) {
    document.getElementById('form-tarjeta').style.display = (metodo === 'Tarjeta') ? 'block' : 'none';
    document.getElementById('form-efectivo').style.display = (metodo === 'Efectivo') ? 'block' : 'none';
    document.getElementById('form-transferencia').style.display = (metodo === 'Transferencia') ? 'block' : 'none';
}
function validarYEnviar() {
    var metodo = document.getElementById('metodo_pago').value;
    if (!metodo) { alert('Por favor seleccioná un método de pago.'); return; }
    
    var form = document.querySelector('form');
    var input = document.createElement('input');
    input.type = 'hidden'; input.name = 'confirmar'; input.value = '1';
    form.appendChild(input);
    form.submit();
}
</script> 
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