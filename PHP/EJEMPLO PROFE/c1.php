<?php include("menu1.php");?>
<?php include("basededatos.php");?>
<h2> Bienvenido a Clientes </h2>
   
<?php
echo date("j/n/y");
?>

<hr>
<form method="POST">
    Nombre <input type="text" name="nombre" required>
    Telefono <input type="number" name="telefono" required>
    <button type="submit">Guardar</button>
</form>
<?php
    if($_POST){
       $nombre=$_POST['nombre'];
       $telefono=$_POST['telefono'];
       $sql="INSERT INTO CLIENTE(nombre, telefono)VALUES ('$nombre','$telefono')";
       $BD->query($sql);   
       }
?> 
<hr>
<h2>Lista de Clientes </h2>
<table border="2">
    <tr>
        <th>ID</td>
        <th>NOMBRE</td>
        <th>TELEFONO</td>  
    </tr> 
<?php
$lista=$BD->query("SELECT *  FROM CLIENTE ORDER BY nombre ASC");
while($fila=$lista->fetch_assoc()){
    echo"<tr>
         <td>{$fila['id']}</td>
         <td>{$fila['nombre']}</td>
         <td>{$fila['telefono']}</td>
     </tr>";
}
?>
</table>