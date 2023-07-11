<?php
// Conexão com o banco de dados
$host = 'localhost';
$db = 'teste';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores enviados pelo formulário
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $turmas = isset($_POST['turmas']) ? $_POST['turmas'] : [];

    try {
        // Insere os dados do aluno na tabela 'aluno'
        $stmt = $pdo->prepare("INSERT INTO aluno (username, email, phone, password) VALUES (:username, :email, :phone, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $password);
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
        }

        echo "Cadastro realizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar aluno: " . $e->getMessage();
    }
} else {
    // Redireciona para a página de cadastro se o formulário não foi enviado corretamente
    header('Location: cadastro.php');
    exit;
}
?>
