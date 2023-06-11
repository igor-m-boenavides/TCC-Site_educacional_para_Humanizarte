<?php

// session_start();

if(isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['senha']) && !empty($_POST['senha'])) {

    require 'conn.php';
    require 'userClass.php';

    $u = new aluno();

    $nome = addslashes($_POST['nome']);
    $senha = addslashes($_POST['senha']);

    if($u -> login($nome, $senha) == true) {
        if(isset($_SESSION['userID'])) {
            header("Location: ../index/index.html");
        } else {
            header("Location: login.html");
        };
    };

} else {
    header("Location: login.php");
}

?>