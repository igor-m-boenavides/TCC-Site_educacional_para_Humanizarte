<?php

// Variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "humanizarte";

// Variáveis do formulário
$id = $_POST['id'];
$nome = $_POST['nome'];
$desc = $_POST['desc'];
$quantidade = $_POST['quantidade'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT INTO curso (id, nome, descricao, quantidade) VALUES ('$id', '$nome', '$desc', '$quantidade')";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Curso cadastrado com sucesso!";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>