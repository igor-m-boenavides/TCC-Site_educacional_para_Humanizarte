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

// Verificar se o usuário está logado
if (!isset($_SESSION['userID'])) {
    // Se o usuário não estiver logado, redirecione para a página de login ou exiba uma mensagem de erro
    header("Location: login.php"); // Redirecionar para a página de login (substitua login.php pelo seu caminho real)
    exit(); // Certifique-se de encerrar o script após o redirecionamento
}

// Consulta para obter informações do usuário
$sql = "SELECT nome, email, telefone, senha FROM aluno WHERE id_aluno = :user_id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Trate erros de consulta aqui
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aqui você pode processar os dados enviados pelo formulário e atualizar o banco de dados
    // Certifique-se de validar e sanitizar os dados do formulário antes de atualizar o banco de dados

    // Exemplo de atualização do nome
    $novoNome = $_POST['novo_nome'];
    $novoEmail = $_POST['novo_email'];
    $novoTelefone = $_POST['novo_telefone'];
    $novaSenha = $_POST['nova_senha'];
    
    // Atualize o banco de dados com os novos dados
    $sqlUpdate = "UPDATE aluno SET nome = :novo_nome, email = :novo_email, telefone = :novo_telefone, senha = :nova_senha WHERE id_aluno = :user_id";

    try {
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':novo_nome', $novoNome, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':novo_email', $novoEmail, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':novo_telefone', $novoTelefone, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':nova_senha', $novaSenha, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmtUpdate->execute();

        // Redirecione o usuário de volta para a página de conta após a atualização
        header("Location: conta.php");
        exit();
    } catch (PDOException $e) {
        // Trate erros de atualização aqui
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Humanizarte</title>
  <link rel="stylesheet" href="editarUsuario.css">
  <link rel="icon" href="../index/imagens/logo.png">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

  <!-- Bootstrap 5 Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <!-- Font awesome -->
  <script src="https://kit.fontawesome.com/99d4636c93.js" crossorigin="anonymous"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

  <!-- Add Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <!-- Add jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Add Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>

<!-- Formulário de edição de informações -->
<div class="area">
    <div class="editar-form">
        <h2>Editar informações</h2>
        <div class="center-image">
            <img src="../index/imagens/logo.png" class="image-container" style="width: 20%; height: 20%">
        </div>
        <form method="POST" action="">
            <div class="campo">
                <label for="novo_nome"><strong>Novo nome de usuário</strong></label>
                <input type="text" id="novo_nome" name="novo_nome" value="<?php echo htmlspecialchars($user['nome']); ?>">
            </div>

            <!-- Adicione campos para editar o email, telefone e senha aqui -->
            <div class="campo">
                <label for="novo_email"><strong>Novo endereço de email</strong></label>
                <input type="email" id="novo_email" name="novo_email" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>

            <div class="campo">
                <label for="novo_telefone"><strong>Novo telefone</strong></label>
                <input type="text" id="novo_telefone" name="novo_telefone" value="<?php echo htmlspecialchars($user['telefone']); ?>">
            </div>

            <div class="campo">
                <label for="nova_senha"><strong>Nova senha</strong></label>
                <input type="password" id="nova_senha" name="nova_senha">
            </div>
            <!-- Fim dos campos adicionais -->

            <div class="editar-button">
                <input type="submit" value="ALTERAR">
            </div>
        </form>
    </div>
</div>

</body>
</html>
