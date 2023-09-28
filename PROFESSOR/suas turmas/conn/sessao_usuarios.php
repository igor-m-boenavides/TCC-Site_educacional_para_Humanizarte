<?php
include_once("conn.php");

function verificarSessao($pdo) {
    // session_start();
    $logado = $_SESSION['logado'] ?? false;

    if (!$logado) {
        header("Location: ../../NÃO CADASTRADO/login/login.html");
        exit();
    }

    // Check if the user belongs to the "PROFESSOR" turma (id = 4)
    $userID = $_SESSION['userID'];
    $turmaID = 4; // Adjust this to match the "PROFESSOR" turma ID

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM aluno_turma WHERE id_aluno = ? AND id_turma = ?");
    $stmt->execute([$userID, $turmaID]);
    $count = $stmt->fetchColumn();

    if ($count === 0) {
        header("Location: ../../../NÃO CADASTRADO/login/login.html"); // Redirect if not in the "PROFESSOR" turma
        exit();
    }
}
