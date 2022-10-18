<?php
include_once('connection.php');
$nickname = $_GET['nickname'];
$password = $_GET['password'];

$query = $miPDO->prepare('SELECT nickname, contrasena FROM usuario WHERE nickname =:nickname;');
$query->execute(['nickname' => $nickname]);
$result = $query->fetch();

    if (password_verify($password, $result['contrasena'])) {
        session_start();
        $_SESSION['nickname'] = $result['nickname'];
        header('Location: ../views/account_status.php');
    } else{
        header('Location: ../views/loginToRegister.php');
    }
?>