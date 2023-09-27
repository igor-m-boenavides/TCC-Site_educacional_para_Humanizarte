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


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    // Recupere o ID da aula a ser excluída
    $id_aula = $_GET['id'];

    // Conectar ao banco de dados
    $host = 'localhost';
    $db = 'humanizarte';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verifique se o usuário tem permissão para excluir a aula (você pode adicionar essa lógica se necessário)

        // Execute uma consulta SQL para excluir a aula com base no ID
        $stmt = $pdo->prepare('DELETE FROM aula WHERE id_aula = :id_aula');
        $stmt->bindParam(':id_aula', $id_aula, PDO::PARAM_INT);
        $stmt->execute();

        // Redirecione o usuário de volta à página de lista de aulas após a exclusão
        header('Location: cronos.php');
        exit();
    } catch (PDOException $e) {
        echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
    }
} else {
    // Lidar com erros
    echo 'Parâmetros inválidos.';
}
?>
