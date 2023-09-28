<?php
include_once("conn.php");

function verificarSessao($pdo) {
    // session_start();
    $logado = $_SESSION['logado'] ?? false;

    if(!$logado) {
        header("Location: ../../NÃO CADASTRADO/login/login.html");
        exit();
    }
}