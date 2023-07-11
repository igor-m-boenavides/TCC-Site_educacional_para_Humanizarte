<?php

session_start();

$localhost = "localhost";
$user = "root";
$pass = "";
$banco = "humanizarte";

try {
    $pdo = new PDO("mysql:host=$localhost;dbname=$banco;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}

?>