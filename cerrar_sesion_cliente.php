<?php
session_start();
session_destroy();
header("Location: ../Pagina%20Principal.php");
exit();
?>