<?php
session_start();

$localhost = "localhost";
$user = "root";
$pass = "";
$banco = "humanizarte";

global $pdo;

try {
    $pdo = new PDO("mysql:host=$localhost;dbname=$banco;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura o PDO para lançar exceções em caso de erros
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage()); // Trate erros de conexão adequadamente
}

// Acessar o ID do usuário
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

// Utilize o $userID conforme necessário
?>
