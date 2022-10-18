<?php
include_once('connection.php');
// Recoger en variables los datos introducidos en el formulario
$nickname = $_GET["nickname"];
$email = $_GET["email"];
$name = $_GET["name"];
$surnames = $_GET["surnames"];
$date = $_GET["date"];
$password = $_GET["password"];
$password = password_hash($password, PASSWORD_DEFAULT);
$role = $_GET["role"];

// Comprobar que el nickname no existe en la base de datos
$query = $miPDO->prepare('SELECT COUNT(*) FROM usuario WHERE nickname=:nickname');
$query->execute(['nickname' => $nickname]);
$results = $query->fetchColumn();

if ($results > 0) {
  $nickname_error = 'Nickname en uso';
  header('Location: ../views/signup.php');
  // Mostrar error en el formulario
} else {
  // Comprobar que el email no existe en la base de datos
  $query = $miPDO->prepare('SELECT COUNT(*) FROM usuario WHERE email=:email');
  $query->execute(['email' => $email]);
  $results = $query->fetchColumn();

  if ($results > 0) {
    echo 'Email en uso';
    header('Location: ../views/signup.php');
    // Mostrar error en el formulario
  } else {
    // Inserto el usuario en la base de datos
    $query = $miPDO->prepare('INSERT INTO usuario (nickname, email, nombre, apellidos, fecha_nacimiento, contrasena, rol) VALUES (:nickname, :email, :name, :surnames, :date, :password, :role)');
    $query->execute(['nickname' => $nickname, 'email' => $email, 'name' => $name, 'surnames' => $surnames, 'date' => $date, 'password' => $password, 'role' => $role]);
    // Comprobar el rol con el que se esta registrando el usuario
    if ($role === 'irakasle') {
      $school = $_GET["school"];
      $phone = $_GET["phone"];

      $query = $miPDO->prepare('UPDATE usuario SET telefono = :phone, id_centro = :school WHERE nickname = :nickname;');
      $query->execute(['phone' => $phone, 'school' => $school, 'nickname' => $nickname]);

      // Enviar notificacion de que un nuevo profesor se ha registrado por email
    }
    header('Location: ../views/login.php');
  }
}