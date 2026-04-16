<?php include("menu.php");?>
<?php include("conexion.php"); ?>

<h2>Registrar Venta</h2>

<form method="POST">

    Cliente:
    <select name="idCliente">
        <?php
        $clientes = $conexion->query("SELECT * FROM Cliente");
        while ($c = $clientes->fetch_assoc()) {
            echo "<option value='{$c['id']}'>{$c['nombre']}</option>";
        }
        ?>
    </select>

    Producto:
    <select name="idProducto">
        <?php
        $productos = $conexion->query("SELECT * FROM Producto");
        while ($p = $productos->fetch_assoc()) {
            echo "<option value='{$p['id']}'>{$p['nombre']}</option>";
        }
        ?>
    </select>

    Cantidad:
    <input type="number" name="cantidad" required>

    <button type="submit">Guardar</button>
</form>

<?php
if ($_POST) {
    $idCliente = $_POST['idCliente'];
    $idProducto = $_POST['idProducto'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO Venta(idCliente, idProducto, cantidad)
            VALUES ('$idCliente','$idProducto','$cantidad')";
    $conexion->query($sql);
}
?>

<h2>Listado de Ventas</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Producto</th>
    <th>Cantidad</th>
</tr>

<?php
$sql = "SELECT v.id, c.nombre as cliente, p.nombre as producto, v.cantidad
        FROM Venta v
        JOIN Cliente c ON v.idCliente = c.id
        JOIN Producto p ON v.idProducto = p.id";

$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['cliente']}</td>
            <td>{$fila['producto']}</td>
            <td>{$fila['cantidad']}</td>
          </tr>";
}
?>
</table>