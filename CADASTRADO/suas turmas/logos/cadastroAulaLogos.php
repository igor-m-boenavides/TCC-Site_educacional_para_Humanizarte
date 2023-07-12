<?php
// Conectar ao banco de dados
$host = 'localhost';
$db = 'humanizarte';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro ao conectar com o banco de dados: ' . $e->getMessage());
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $url_video = $_POST['url_video'];
    $nome_video = $_POST['nome_video'];

    $nome_anexo = $_POST['nome_anexo'];

    // Upload do arquivo anexo
    $arquivo_anexo = $_FILES['url_anexo']['name'];
    $caminho_anexo = 'uploads/' . $arquivo_anexo;
    move_uploaded_file($_FILES['url_anexo']['tmp_name'], $caminho_anexo);

    // Inserir os dados na tabela "aula"
    $stmt = $pdo->prepare('INSERT INTO aula (nome, descricao, url_video, nome_video, url_anexo, nome_anexo) VALUES (:nome, :descricao, :url_video, :nome_anexo, :url_anexo, :nome_anexo)');
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':url_video', $url_video);
    $stmt->bindParam(':nome_video', $nome_video);
    $stmt->bindParam(':url_anexo', $caminho_anexo);
    $stmt->bindParam(':nome_anexo', $nome_anexo);
    $stmt->execute();

    $id_aula = $pdo->lastInsertId(); // Obter o ID da última aula inserida

    // Obter a turma "Cronos" (id_turma = 1)
    $id_turma = 1;

    // Inserir os dados na tabela "aula_turma"
    $stmt = $pdo->prepare('INSERT INTO aula_turma (id_aula, id_turma) VALUES (:id_aula, :id_turma)');
    $stmt->bindParam(':id_aula', $id_aula);
    $stmt->bindParam(':id_turma', $id_turma);
    $stmt->execute();

    echo 'Aula cadastrada com sucesso!';
}
?>