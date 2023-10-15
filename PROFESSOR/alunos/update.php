<?php
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    echo "ID do usuário não fornecido.";
    // ou redirecionar para a página de listagem, por exemplo:
    // header("Location: alunos.php");
    // exit();
}

error_reporting(E_ALL);
ini_set('display_errors', '1');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Humanizarte</title>
    <link rel="stylesheet" href="update.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/99d4636c93.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

</head>
<body>

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

?>

<div class="login">
    <div class="entrar">
        <h2><b>Alterar</b></h2>
    </div>
    <div class="logo">
        <img src="imagens/logo.png" alt="Logo da Humanizarte" width="20%" height="20%">
    </div>
    <form action="" method="POST">
        <div class="form-group">
            <label for="id">ID do usuário</label>
            <input type="text" class="form-control" name="user_id" id="id" placeholder="&#xf007; ID do usuário" style="font-family:Arial, FontAwesome" value="<?php echo $user_id; ?>">
        </div>
        <div class="form-group">
            <label for="novo_nome">Novo nome</label>
            <input type="text" class="form-control" name="novo_nome" id="novo_nome" placeholder="&#xf007; Digite o novo nome de usuário" style="font-family:Arial, FontAwesome">
        </div>
        <div class="form-group">
            <label for="novo_email">Novo email</label>
            <input type="email" class="form-control" name="novo_email" id="novo_email" placeholder="&#xf0e0; Digite o novo email do usuário" style="font-family:Arial, FontAwesome">
        </div>
        <div class="form-group">
            <label for="novo_telefone">Telefone</label>
            <input type="text" class="form-control" name="novo_telefone" id="novo_telefone" placeholder="&#xf095; Digite o novo telefone do usuário" style="font-family:Arial, FontAwesome">
        </div>
        <div class="form-group">
            <label for="nova_senha">Senha</label>
            <input type="password" class="form-control" name="nova_senha" id="nova_senha" placeholder="&#xf023; Digite a nova senha do usuário" style="font-family:Arial, FontAwesome">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="ativado">Ativado</option>
                <option value="desativado">Desativado</option>
            </select>
        </div>


        <div class="form-check">
        <div class="btn-cadastro">
            <input type="submit" value="ALTERAR" class="btn btn-dark" id="btn-cadastro"></input>
        </div>
        </div>
    </form>
</div>

</body>
</html>