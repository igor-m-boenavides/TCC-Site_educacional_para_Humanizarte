<?php
// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'humanizarte';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores enviados pelo formulário
    $username = $_POST['nome'];
    $email = $_POST['email'];
    $phone = $_POST['telefone'];
    $password = $_POST['senha'];
    $turmas = isset($_POST['turma']) ? $_POST['turma'] : [];

    try {
        // Insere os dados do aluno na tabela 'aluno'
        $stmt = $pdo->prepare("INSERT INTO aluno (nome, email, telefone, senha) VALUES (:nome, :email, :telefone, :senha)");
        $stmt->bindParam(':nome', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $phone);
        $stmt->bindParam(':senha', $password);
        $stmt->execute();

        $alunoId = $pdo->lastInsertId();

        // Insere as turmas do aluno na tabela 'aluno_turma'
        if (!empty($turmas)) {
            $stmt = $pdo->prepare("INSERT INTO aluno_turma (id_aluno, id_turma) VALUES (:id_aluno, :id_turma)");

            foreach ($turmas as $turma) {
                $stmt->bindParam(':id_aluno', $alunoId);
                $stmt->bindParam(':id_turma', $turma);
                $stmt->execute();
            }

            // Verifica se o usuário pertence à turma "professor" (id_turma: 4)
            if (in_array(4, $turmas)) {
                header("Location: ../index/index.html");
                exit();
            }
        }

        echo "Cadastro realizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar aluno: " . $e->getMessage();
    }
} else {
    // Redireciona para a página de cadastro se o formulário não foi enviado corretamente
    header('Location: cadastroAluno.html');
    exit;
}
?>