<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "humanizarte";

// Conectando ao banco de dados usando PDO
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Definindo o modo de erro do PDO como exceção
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  // Verificando se o botão de exclusão foi clicado
  if (isset($_POST['excluir'])) {
    $usuario_id = $_POST['id_aluno'];
    
    // Preparando a consulta SQL para excluir o usuário
    $stmt = $conn->prepare("DELETE FROM aluno WHERE id_aluno = :id_aluno");
    $stmt->bindParam(':id_aluno', $usuario_id);
    
    // Executando a consulta
    $stmt->execute();
    
    echo "Usuário excluído com sucesso.";
  }
} catch(PDOException $e) {
  echo "Erro ao conectar-se ao banco de dados: " . $e->getMessage();
}

// Fechando a conexão com o banco de dados
$conn = null;
?>
