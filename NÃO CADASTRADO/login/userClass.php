<?php

class aluno {

    public function login($nome, $senha) {
        require 'conn.php';

        $sql = "SELECT * FROM aluno WHERE nome = :nome AND senha = :senha";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dado = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['userID'] = $dado['id_aluno'];

            return true;
        } else {
            return false;
        }
    }

    public function isProfessor($nome) {
        require 'conn.php';

        $sql = "SELECT COUNT(*) FROM aluno_turma WHERE id_aluno = :id_aluno AND id_turma = 4";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id_aluno", $_SESSION['userID']);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}

?>