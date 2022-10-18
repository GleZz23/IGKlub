<?php
include_once('connection.php');
$nickname = $_GET['nickname'];
$password = $_GET['password'];
$group_code = $_GET['group_code'];

$query = $miPDO->prepare('SELECT nickname, contrasena, codigo FROM usuario, grupo WHERE nickname =:nickname; AND codigo =:group_code;');
$query->execute(['nickname' => $nickname, 'group_code' => $group_code]);
$result = $query->fetch();

    if (!password_verify($password, $result['contrasena']) || $result['codigo'] !== $group_code) {
        header('Location: ../views/loginToRegister.php');
    } else {
        $query = $miPDO->prepare('SELECT centro.id_centro FROM centro, grupo WHERE centro.id_centro = grupo.id_centro AND grupo.codigo =:group_code;');
        $query->execute(['group_code' => $group_code]);
        $result = $query->fetch();

        $query = $miPDO->prepare('UPDATE usuario SET id_centro = :id_centro, cod_grupo = :group_code WHERE nickname = :nickname;');
        $query->execute(['id_centro' =>  $result['id_centro'], 'group_code' => $group_code, 'nickname' => $nickname]);
        header('Location: ../views/account_status.php');
    }
?>