<?php

if(isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['senha']) && !empty($_POST['senha'])) {

    require 'conn.php';
    require 'userClass.php';

    $u = new aluno();

    $nome = addslashes($_POST['nome']);
    $senha = addslashes($_POST['senha']);

    if($u -> login($nome, $senha) == true) {
        if(isset($_SESSION['userID'])) {
            header("Location: ../../CADASTRADO/index/index.php");
            exit(); // Adicione esta linha para evitar que o código continue executando após o redirecionamento.
        }
    }
}

header("Location: login.html");
exit(); // Adicione esta linha para evitar que o código continue executando após o redirecionamento.

?>