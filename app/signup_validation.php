<?php
include_once('connection.php');

$nickname = $_GET["nickname"];
$email = $_GET["email"];

$query = $miPDO->prepare('SELECT COUNT(*) FROM usuario WHERE nickname=:nickname OR email=:email');
$query->execute(['nickname' => $nickname,
                  'email' => $email]);
$results = $query->fetchColumn();

if ($results > 0) {
  echo 'Nickname o Email en uso';
} else {
  $query = $miPDO->prepare('INSERT INTO usuario (nickname, email, nombre, apellidos, fecha_nacimiento, contrasena, rol)
                          VALUES (:nickname, :email, :name, :surnames, :date, :password, "ikasle")');

  $name = $_GET["name"];
  $surnames = $_GET["surnames"];
  $date = $_GET["date"];
  $password = $_GET["password"];
  $password = password_hash($password, PASSWORD_DEFAULT);

  $query->execute(['nickname' => $nickname,
                  'email' => $email,
                  'name' => $name,
                  'surnames' => $surnames,
                  'date' => $date,
                  'password' => $password]);
}