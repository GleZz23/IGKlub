<?php
include_once('connection.php');
$nickname = $_GET['nickname'];
$password = $_GET['password'];
$group_code = $_GET['group_code'];

$query = $miPDO->prepare('SELECT nickname, contrasena FROM usuario WHERE nickname =:nickname;');
$query->execute(['nickname' => $nickname]);
$result = $query->fetch();

    if (password_verify($password, $result['contrasena'])) {
        header('Location: ../views/account_status.php');
    } else{
        header('Location: ../views/loginToRegister.php');
    }
?>