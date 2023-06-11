<?php

session_start();

$localhost = "localhost";
$user = "root";
$pass = "";
$banco = "humanizarte";

global $pdo;

try {
    $pdo = new PDO("mysql:host=$localhost; dbname=$banco; charset=utf8", $user, $pass);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e -> getMessage();
}

?>