<?php
if (isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['senha']) && !empty($_POST['senha'])) {
    require 'conn.php';
    require 'userClass.php';

    $u = new aluno();

    $nome = addslashes($_POST['nome']);
    $senha = addslashes($_POST['senha']);

    if ($u->login($nome, $senha) == true) {
        // Verifica se o usuário pertence à turma "professor" (id_turma: 4)
        if ($u->isProfessor($nome)) {
            header("Location: ../../PROFESSOR/index/index.html");
        } else {
            header("Location: ../../CADASTRADO/index/index.php");
        }
        exit();
    }
}

header("Location: login.html");
exit();
?>
