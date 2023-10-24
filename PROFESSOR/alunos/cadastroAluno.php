<?php

// Inclua a configuração do banco de dados aqui (conexão PDO)
include_once("../conn/conn.php");
include_once("../conn/sessao_usuarios.php");
include_once '../conn/auth.php';

verificarSessao($pdo);

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
    $pdo = new PDO("mysql:host=$localhost;dbname=$banco;charset=utf8", $user, $pass);
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
        }

        echo "Cadastro realizado com sucesso!";
        header("Location: ../alunos/alunos.php");
    } catch (PDOException $e) {
        echo "Erro ao cadastrar aluno: " . $e->getMessage();
    }
} else {
    // Redireciona para a página de cadastro se o formulário não foi enviado corretamente
    header('Location: cadastroAluno.html');
    exit;
}
?>