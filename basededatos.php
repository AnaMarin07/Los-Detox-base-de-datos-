<?php
$ubicacion="localhost";
$usuario="root";
$clave="";
$base="detoxnashei";
$conexion=new mysqli($ubicacion,$usuario,$clave,$base);
if($conexion->connect_error){
    die(" Error".$conexion->connect_error);
}
else{
    
}
?>