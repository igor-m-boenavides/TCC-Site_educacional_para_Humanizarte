<?php

// Variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "humanizarte";

// Variáveis do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
$turma = $_POST['turma'];

// ...

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar a declaração SQL
    $stmt = $conn->prepare("INSERT INTO aluno (nome, email, senha, telefone) VALUES (:nome, :email, :senha, :telefone)");

    // Vincular os valores dos parâmetros
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':telefone', $telefone);

    // Executar a declaração
    $stmt->execute();

    // Get the ID of the last inserted record
    $aluno_id = $conn->lastInsertId();

    // Insert turma data into a separate table
    foreach ($turma as $t) {
        $stmt = $conn->prepare("INSERT INTO aluno_turma (aluno_id, turma_id) VALUES (:aluno_id, :turma_id)");
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->bindParam(':turma_id', $t);
        $stmt->execute();
    }

    echo "Aluno cadastrado com sucesso!";
} catch (PDOException $e) {
    if ($e->getCode() == '23000') {
        $errorInfo = $e->errorInfo;
        if ($errorInfo[1] == 1452) {
            echo "Foreign key constraint violation: " . $errorInfo[2];
        } else {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "General error: " . $e->getMessage();
    }
}

$conn = null;
