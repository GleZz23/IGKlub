<?php
// ABRIR LA CONEXION
include("connection.php");

$nickname = $_GET['nickname'];
$password = $_GET['password'];

session_start();
$nick = $_SESSION['nickname'];
$pass = $_SESSION['password'];


// Prepara SELECT
$miConsulta = $miPDO->prepare('SELECT count(*) FROM usuario WHERE nickname =:nickname AND contrasena =:pass;');
// Ejecuta consulta
$miConsulta->execute(['nickname' => $nick,'pass' => $pass]);

$resultado= $miConsulta->fetchColumn();
if ($resultado >0) {
    // $miConsulta = $miPDO->prepare('SELECT rol FROM usuario where nickname =:nickname;');
    // $miConsulta->execute(
    //     ['nickname' => $nickname]
    // );
    // $rol =$miConsulta->fetch();
    header('Location: index.php');
} else echo("Pasahitza edo nickname desegokia")
?>