<?php
// Inclua a configuração do banco de dados aqui (conexão PDO)
require_once '../conn/conn.php';
require_once '../conn/auth.php';

// Check if session variables nome and senha are set
if (isset($_SESSION['nome']) && !empty($_SESSION['nome']) && isset($_SESSION['senha']) && !empty($_SESSION['senha'])) {
    // These variables are now available for use
    $nome = $_SESSION['nome'];
    $senha = $_SESSION['senha'];
    
    // Verificar o papel do usuário após o login
    if (login($nome, $senha)) {
        $papeis = obterPapeisUsuarioAutenticado(); // Implemente esta função para obter os papéis do usuário
        $eProfessor = in_array('professor', $papeis);

        if ($eProfessor) {
            // O usuário é um professor, redirecione para a página de professor
            header("Location: ../professor/../professor/index/index.html");
            exit;
        } else {
            // O usuário não é um professor, verifique se ele pertence a outras turmas
            if (in_array('cronos', $papeis) || in_array('logos', $papeis) || in_array('sunztu', $papeis)) {
                // O usuário é membro de pelo menos uma das turmas Cronos, Logos ou Sun Tzu
                header("Location: conta.php");
                exit;
            } else {
                // O usuário não tem permissão para acessar outras páginas
                // Redirecione para uma página de acesso não autorizado ou mostre uma mensagem de erro
            }
        }
    } else {
        $erro_login = "Credenciais inválidas. Por favor, tente novamente.";
    }
} else {
    $erro_login = "Credenciais inválidas. Por favor, tente novamente.";
}

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
    $stmt = $pdo->prepare('INSERT INTO aula (nome, descricao, url_video, nome_video, url_anexo, nome_anexo) VALUES (:nome, :descricao, :url_video, :nome_video, :url_anexo, :nome_anexo)');
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':url_video', $url_video);
    $stmt->bindParam(':nome_video', $nome_video); // Corrected parameter name
    $stmt->bindParam(':url_anexo', $caminho_anexo);
    $stmt->bindParam(':nome_anexo', $nome_anexo); // Corrected parameter name
    $stmt->execute();

    $id_aula = $pdo->lastInsertId(); // Obter o ID da última aula inserida

    // Obter a turma "Cronos" (id_turma = 2)
    $id_turma = 2;

    // Inserir os dados na tabela "aula_turma"
    $stmt = $pdo->prepare('INSERT INTO aula_turma (id_aula, id_turma) VALUES (:id_aula, :id_turma)');
    $stmt->bindParam(':id_aula', $id_aula);
    $stmt->bindParam(':id_turma', $id_turma);
    $stmt->execute();

    // redirecionar para a página "cronos.php"
    header('Location: cronos.php');
    exit;
}
?>