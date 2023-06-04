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
  
  echo "Aluno cadastrado com sucesso!";
} catch(PDOException $e) {
  echo "Erro: " . $e->getMessage();
}

$conn = null;
