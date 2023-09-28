<?php

// auth.php

function login($nome, $senha) {
    // Conexão com o banco de dados
    global $pdo;

    // Consulta SQL para verificar as credenciais do usuário
    $sql = "SELECT id_aluno, senha FROM aluno WHERE nome = :nome";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            // As credenciais são válidas, faça login do usuário
            $_SESSION['userID'] = $user['id_aluno'];
            return true;
        } else {
            // Credenciais inválidas
            return false;
        }
    } catch (PDOException $e) {
        // Trate erros de consulta aqui
        return false;
    }
}

function obterPapeisUsuarioAutenticado() {
    // Conexão com o banco de dados
    global $pdo;

    // Obter informações do usuário autenticado
    $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

    if (!$userID) {
        return [];
    }

    // Consulta SQL para obter as turmas do usuário
    $sql = "SELECT turma.nome FROM turma
            INNER JOIN aluno_turma ON turma.id_turma = aluno_turma.id_turma
            WHERE aluno_turma.id_aluno = :user_id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $turmas = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Adicione o papel "professor" se o usuário for professor
        if (in_array('Professor', $turmas)) {
            $turmas[] = 'professor';
        }

        return $turmas;
    } catch (PDOException $e) {
        // Trate erros de consulta aqui
        return [];
    }
}


?>
