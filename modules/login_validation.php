<?php
// ABRIR LA CONEXION
include("connection.php");
session_start();
$nickname = $_SESSION['nickname'];
$password = $_SESSION['password'];
$nickname = $_GET['nickname'];
$password = $_GET['password'];


// Prepara consulta para comprobar que el usuario y la contraseña coinciden
$miConsulta = $miPDO->prepare('SELECT count(*) FROM usuario WHERE nickname =:nickname AND contrasena =:pass;');
// Ejecuta consulta
$miConsulta->execute(['nickname' => $nickname,'pass' => $password]);
$resultado= $miConsulta->fetchColumn();
// Si el usuario exite y la contraseña coincide el resultado
// de la consulta dara mas que 0
if ($resultado >0) {
    header('Location: ../index.php'); //Cambiar por el menu principal
    // Si el usuario no existe o no coinciden
} else{
    header('Location: ../views/loginToRegister.php');
}
?>