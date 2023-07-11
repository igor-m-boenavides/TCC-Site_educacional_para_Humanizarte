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
}

?>