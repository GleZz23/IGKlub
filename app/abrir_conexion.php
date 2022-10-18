<?php
    // Variables
$hostDB = '127.0.0.1';
$nombreDB = 'igklub_database';
$usuarioDB = 'root';
$contrasenyaDB = '';
$nickname = $_GET['nickname'];
$password = $_GET['password'];

// Conecta con base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenyaDB);
?>