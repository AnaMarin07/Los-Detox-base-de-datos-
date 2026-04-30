<?php
include('basededatos.php');
/* Se incluye la base de datos para conectarla con el Mysql */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Dni      = $_POST['Dni'];
    $Nombre   = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Mail = $_POST['Mail'];
    $Contraseña = password_hash($_POST['Contraseña'], PASSWORD_DEFAULT);
    /*Encriptamos la contraseña con password_hash asi el usuario tiene mayor seguridad :3*/
    $Direccion = $_POST['Direccion'];
    $Codigo_postal = $_POST['Codigo_postal'];
    $Ciudad = $_POST['Ciudad'];
    $Telefono = $_POST['Telefono'];
      /* Con esto abrimos ese "sobre" y capturamos todos los datos recolectados del registro del usuario
    para luego enviarlo al mysql*/
    $verificar = $conexion->query("SELECT Dni FROM cliente WHERE Dni='$Dni'");
    /*Con esto chequeamos de q no haya ningun otro cliente con el mismo dni, el "Num_rows lanza que
    es mayor a 0 osea que ya hay alguien con esos mismo numeros lanza alerta, de lo contrario no.
    El num_rows es una fila de numeros. */
    
        if ($verificar->num_rows > 0) {
        header("Location: Registro_cliente.php?error=dni_duplicado");
    exit();
    }
    /*Crea una consulta SQL para ingresar los datos y guardarlos*/
    $sql = "INSERT INTO cliente (Dni, Nombre, Apellido, Mail, Contraseña, Direccion, cod_postal, Ciudad, Telefono)
            VALUES ('$Dni', '$Nombre', '$Apellido', '$Mail', '$Contraseña', '$Direccion', '$Codigo_postal', '$Ciudad', '$Telefono')";
    
    /*Si los datos estan correctos mandamos al usuario a la a que inicie sesion para confirmar datos pos sino error */
    if ($conexion->query($sql)) {
       header("Location: Iniciar_sesion.php?exito=1");
        exit();
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>