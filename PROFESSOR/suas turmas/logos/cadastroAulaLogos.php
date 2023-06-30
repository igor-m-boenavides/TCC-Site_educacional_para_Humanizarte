<?php

// Variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "humanizarte";

// Variáveis do formulário
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$video = $_POST['video'];
$anexo = $_POST['anexo'];
$curso_id = 1;

// ...

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  // Preparar a declaração SQL
  $stmt = $conn->prepare("INSERT INTO aula (nome, descricao, video, anexo, curso_id) VALUES (:nome, :descricao, :video, :anexo, :curso_id)");
  
  // Vincular os valores dos parâmetros
  $stmt->bindParam(':nome', $nome);
  $stmt->bindParam(':descricao', $descricao);
  $stmt->bindParam(':video', $video);
  $stmt->bindParam(':anexo', $anexo);
  $stmt->bindParam(':curso_id', $curso_id);
  
  // Executar a declaração
  $stmt->execute();
  
  echo "Aula cadastrado com sucesso!";
} catch(PDOException $e) {
  echo "Erro: " . $e->getMessage();
}

$conn = null;
