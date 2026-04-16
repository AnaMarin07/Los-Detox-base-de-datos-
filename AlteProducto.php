<?php include("menu.php");?>
<?php include("conexion.php"); ?>

<h2>Alta de Producto</h2>

<form method="POST">
    Nombre: <input type="text" name="nombre" required>
    Valor: <input type="number" step="0.01" name="valor" required>
    <button type="submit" name="guardar">Guardar</button>
</form>

<?php
// INSERTAR
if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $valor = $_POST['valor'];

    $sql = "INSERT INTO Producto(nombre, valor) VALUES ('$nombre','$valor')";
    $conexion->query($sql);
}
?>

<hr>

<h2>Buscar Producto</h2>

<form method="GET">
    Nombre: <input type="text" name="buscar">
    <button type="submit">Buscar</button>
</form>

<hr>

<h2>Listado de Productos</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Valor</th>
    <th>Acciones</th>
</tr>

<?php
// BUSCAR o LISTAR
if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
    $sql = "SELECT * FROM Producto WHERE nombre LIKE '%$buscar%'";
} else {
    $sql = "SELECT * FROM Producto";
}

$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['valor']}</td>
            <td>
                <a href='productos.php?editar={$fila['id']}'>✏️ Editar</a>
                <a href='productos.php?eliminar={$fila['id']}'>❌ Eliminar</a>
            </td>
          </tr>";
}
?>
</table>

<?php
// ELIMINAR
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM Producto WHERE id=$id");
    header("Location: productos.php");
}
?>

<hr>

<?php
// FORMULARIO DE EDICIÓN
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $resultado = $conexion->query("SELECT * FROM Producto WHERE id=$id");
    $producto = $resultado->fetch_assoc();
?>

<h2>Editar Producto</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
    Nombre: <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
    Valor: <input type="number" step="0.01" name="valor" value="<?php echo $producto['valor']; ?>" required>
    <button type="submit" name="actualizar">Actualizar</button>
</form>

<?php
}

// ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $valor = $_POST['valor'];

    $conexion->query("UPDATE Producto
                      SET nombre='$nombre', valor='$valor'
                      WHERE id=$id");

    header("Location: productos.php");
}
?>