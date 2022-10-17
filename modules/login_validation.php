<?php
include_once('connection.php');

// Recoger en variables los datos introducidos en el formulario
$nickname = $_GET["nickname"];
$password = $_GET["password"];

// Comprobar que el nickname no existe en la base de datos
$query = $miPDO->prepare('SELECT COUNT(*) FROM usuario WHERE nickname=:nickname AND contrasena=:password');
$query->execute(['nickname' => $nickname, 'password' => $password]);
$results = $query->fetchColumn();

if ($results > 0) {
  $nickname_error = 'Nickname o contrasena incorrectos';
  header('Location: ../login.php');
  // Mostrar error en el formulario
} else {
  header('Location: session.php');
}