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

// Acessar o ID do usuário
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

// Verificar se o usuário está logado
if ($userID) {
  $sql = "SELECT * FROM aluno_turma WHERE id_aluno = :userID";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(":userID", $userID);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    $result = $stmt->fetchAll();
    $turmas = array_column($result, 'id_turma');
  } else {
    $turmas = [];
  }
} else {
  $turmas = [];
}

// Consulta para obter informações do usuário
$user_id = $userID; // Substitua pelo ID do usuário atual
$sql = "SELECT nome, email, telefone, senha FROM aluno WHERE id_aluno = :user_id";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  // Trate erros de consulta aqui
}

// Página HTML para exibir as informações do usuário
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Humanizarte</title>
  <link rel="stylesheet" href="conta.css">
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

<!-- BARRA DE NAVEGAÇÃO -->

<div class="navbar">
  <a class="navbar-logo" href="conta.php" style="color: black; text-decoration: none; font-size: 15pt;">
    <img src="../alunos/imagens/logo.png" width="50px" height="50px">
    Humanizarte
  </a>
  <nav class="lista-menu">
    <ul class="menu-items">
      <li><a href="../index/index.php">Início</a></li>
      <li><a href="../suas turmas/turmas.php">Turmas</a></li>
      <li><a href="../alunos/alunos.php">Alunos</a></li>
      <li id="atual"><a href="../conta/conta.php">Conta</a></li>
    </ul>
  </nav>
</div>

<!-- FIM DA BARRA DE NAVEGAÇÃO -->

  <!-- CONTA -->

  <div class="center-content">
    <div class="area">
      <h1>Olá, <?php echo htmlspecialchars($user['nome']); ?> </h1>
      <div class="user">
        <h2>Suas informações</h2>
        <div class="campo">
          <p><strong>Nome de usuário</strong></p>
          <p><?php echo htmlspecialchars($user['nome']); ?></p>
        </div>
        <div class="campo">
          <p><strong>Seu endereço de email</strong></p>
          <p><?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <div class="campo">
          <p><strong>Seu telefone</strong></p>
          <p><?php echo htmlspecialchars($user['telefone']); ?></p>
        </div>
        <div class="campo">
          <p><strong>Sua senha</strong></p>
          <p><?php echo htmlspecialchars($user['senha']); ?></p>
        </div>
        <div class="edit">
          <a href="editarUsuario.php">Editar informações</a>
        </div>
      </div>

      <!-- Exiba as turmas do usuário -->
      <div class="turmas">
        <h2>Seu cargo</h2>
        <?php
        // Consulta para obter as turmas do usuário
        $sqlTurmas = "SELECT turma.nome FROM turma
                  INNER JOIN aluno_turma ON turma.id_turma = aluno_turma.id_turma
                  WHERE aluno_turma.id_aluno = :user_id";

        try {
          $stmtTurmas = $pdo->prepare($sqlTurmas);
          $stmtTurmas->bindParam(':user_id', $user_id, PDO::PARAM_INT);
          $stmtTurmas->execute();

          while ($row = $stmtTurmas->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>" . htmlspecialchars($row['nome']) . "</p>";
          }
        } catch (PDOException $e) {
          // Trate erros de consulta aqui
        }
        ?>
      </div>

      <!-- Botão de logout -->
      <div class="logout">
        <a href="logout.php">LOGOUT</a>
      </div>
    </div>
  </div>

  <!-- FIM CONTA -->

  <!-- RODA PÉ -->

  <footer class="rodape">
    <div class="roda-pe">
      <div class="contato">
        <i class="bi bi-instagram" id="ig-icon"></i>
        <i class="bi bi-facebook" id="fb-icon"></i>
        <i class="bi bi-youtube" id="yt-icon"></i>
      </div>
      <img src="../index/imagens/logo.png" alt="Logo da humanizarte" id="logo-roda-pe">
      <h1>Humanizarte</h1>
      <p id="copyright">Copyright <i class="bi bi-c-circle"></i> 2023 Humanizarte, LTDA</p>
      <!-- <p style="font-weight: 600; padding-bottom: 1%;"><a href="#" style="color:black; text-decoration: underline;">Política de Privacidade</a> | <a href="#" style="color:black; text-decoration: underline">Política de Segurança</a></p> -->
    </div>
  </footer>

  <!-- FIM RODA PÉ -->

</body>

</html>