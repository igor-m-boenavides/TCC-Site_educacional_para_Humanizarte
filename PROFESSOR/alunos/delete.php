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

// Conectando ao banco de dados usando PDO
try {
  $conn = new PDO("mysql:host=$localhost;dbname=$banco", $user, $pass);
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
    
    header('Location: alunos.php');
  }
} catch(PDOException $e) {
  echo "Erro ao conectar-se ao banco de dados: " . $e->getMessage();
}

// Fechando a conexão com o banco de dados
$conn = null;
?>
