<?php

// Inclua a configuração do banco de dados aqui (conexão PDO)
require_once '../../conn/conn.php';
require_once '../../conn/auth.php';

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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humanizarte</title>
    <link rel="stylesheet" href=logos.css>
    <link rel="icon" href="../imagens/logo.png">
    
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

<header>

<!-- BARRA DE NAVEGAÇÃO -->

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">

  <a class="navbar-brand" href="#" id="logo_texto"><img alt="Logo Humanizarte" src="../imagens/logo.png" width="40" height="40">Humanizarte</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="../../index/index.php">Ínicio</span></a>
      </li>
      <li class="nav-item"  style="text-decoration: underline;">
        <a class="nav-link" href="../../suas turmas/turmas.php">Suas turmas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../sobre-nos/sobrenos.html">Sobre nós</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../conta/conta.php">Conta</a>
      </li>
    </ul>

  </div>

</nav>

<!-- FIM BARRA DE NAVEGAÇÃO -->

<!-- CABEÇALHO -->

<h1 class="titulo"><i class="bi bi-book-half"></i>  Turma LOGOS </h1>

</header>

<!-- FIM CABEÇALHO -->

<!-- AULAS -->

<!-- LISTA DE AULAS -->

<div class="aula">
  <?php

  try {
      $pdo = new PDO("mysql:host=$localhost;dbname=$banco", $user, $pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Consultar as aulas da turma "Logos" (id_turma = 1)
      $stmt = $pdo->prepare('SELECT a.nome, a.url_video, a.nome_video, a.url_anexo, a.nome_anexo FROM aula a INNER JOIN aula_turma at ON a.id_aula = at.id_aula WHERE at.id_turma = 1');
      $stmt->execute();
      $aulas = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($aulas as $aula) {
          echo '<details>';
          echo '<summary style="color: black;">' . $aula['nome'] . '</summary>';
          echo '<p><a target="_blank" style="color: black; text-decoration: none;" href="' . $aula['url_video'] . '"> <i class="bi bi-youtube"></i> ' . $aula['nome_video'] . '</a></p>';
          echo '<p><a style="color: black; text-decoration: none;" href="' . $aula['url_anexo'] . '" download><i class="fa fa-file-text-o"></i> ' . $aula['nome_anexo'] . '</a></p>';
          echo '</details>';
      }
  } catch (PDOException $e) {
      echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
  }
  ?>
</div>

<!-- FIM LISTA DE AULAS -->

<!-- FIM AULAS -->

<!-- RODA PÉ -->

<footer class="rodape">
  <div class="roda-pe">
    <div class="contato">
      <i class="bi bi-instagram" id="ig-icon"></i>
      <i class="bi bi-facebook" id="fb-icon"></i>
      <i class="bi bi-youtube" id="yt-icon"></i>
    </div>
    <img src="../imagens/logo.png" alt="Logo da humanizarte" id="logo-roda-pe">
    <h1>Humanizarte</h1>
    <p id="copyright">Copyright <i class="bi bi-c-circle"></i> 2023 Humanizarte, LTDA</p>
    <p style="font-weight: 600; padding-bottom: 1%;"><a href="#" style="color:black; text-decoration: underline;">Política de Privacidade</a> | <a href="#"  style="color:black; text-decoration: underline">Política de Segurança</a></p>
  </div>
</footer>

<!-- FIM RODA PÉ -->

</body>
</html>