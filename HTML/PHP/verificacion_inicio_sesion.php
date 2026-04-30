<?php
/*incluimos base de datos*/
include('basededatos.php');

/* verificamos que llegaron datos por POST (sobrecito) */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /*ocupamos unicamente del mail y contraseña del formulario*/
    $Mail = $_POST['Mail'];
    $Contraseña = $_POST['Contraseña'];

    /*Buscamos en la Base de datos a ver si hay un cliente con ese mail*/ 
    $resultado = $conexion->query("SELECT * FROM cliente WHERE Mail='$Mail'");

    if ($resultado->num_rows > 0) {
        /*si encontró un cliente con ese "mail", agarramos sus datos*/ 
        $cliente = $resultado->fetch_assoc();

        /*Dsp verificamos que la contraseña ingresada coincida con el hash guardado*/ 
        if (password_verify($Contraseña, $cliente['Contraseña'])) {
            session_start();
            /* inicia una sesión para recordar que el usuario está logueado */
            $_SESSION['Dni'] = $cliente['Dni'];
            $_SESSION['Nombre'] = $cliente['Nombre'];

            /*Si tdo sale bn lo mandamos a la pagina principal*/
            header("Location: ../Pagina%20Principal.php");
            exit();
        } else {
            /*contraseña incorrecta*/
            header("Location: Iniciar_sesion.php?error=1");
            exit();
        }
    } else {
        /*No existe ese mail */ 
        header("Location: Iniciar_sesion.php?error=1");
        exit();
    }
}
?>