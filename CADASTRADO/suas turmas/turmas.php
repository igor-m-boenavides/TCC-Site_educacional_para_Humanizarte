<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humanizarte</title>
    <link rel="stylesheet" href=turmas.css>
    
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

  <!-- Bootstrap 5 Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <!-- Font awesome -->
  <script src="https://kit.fontawesome.com/99d4636c93.js" crossorigin="anonymous"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

  <!-- Add Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <!-- Add jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Add Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>

<?php
require_once '../conn/conn.php';

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
?>

<!-- BARRA DE NAVEGAÇÃO -->

<div class="navbar">
  <a class="navbar-logo" style="color: black; text-decoration: none; font-size: 15pt;">
    <img src="imagens/logo.png" width="50px" height="50px">
    Humanizarte
  </a>
  <nav class="lista-menu">
    <ul class="menu-items">
      <li><a href="../index/index.php">Ínicio</a></li>
      <li id="atual"><a href="../suas turmas/turmas.php">Suas turmas</a></li>
      <li><a href="../sobre-nos/sobrenos.html">Sobre nós</a></li>
      <li><a href="../conta/conta.html">Conta</a></li>
    </ul>
  </nav>
</div>

<!-- FIM DA BARRA DE NAVEGAÇÃO -->

<!-- TURMAS -->

<h1 class="titulo">Suas turmas</h1>
<div class="area-turmas">
  <?php if (in_array(1, $turmas)) { ?>
    <div class="logos">
      <h1>LOGOS</h1>
      <div class="logos-entrar"><a href="logos/logos.php">ENTRAR</a></div>
      <i class="bi bi-book-half" id="logos-icone"></i>
    </div>
  <?php } ?>

  <?php if (in_array(2, $turmas)) { ?>
    <div class="cronos">
      <h1>CRONOS</h1>
      <div class="cronos-entrar"><a href="cronos/cronos.php">ENTRAR</a></div>
      <i class="bi bi-hourglass-bottom" id="cronos-icone"></i>
    </div>
  <?php } ?>

  <?php if (in_array(3, $turmas)) { ?>
    <div class="suntzu">
      <h1>SUN TZU</h1>
      <div class="suntzu-entrar"><a href="suntzu/suntzu.php">ENTRAR</a></div>
      <i class="bi bi-shield-shaded" id="suntzu-icone"></i>
    </div>
  <?php } ?>
</div>

<footer class="rodape">
  <div class="roda-pe">
    <div class="contato">
      <i class="bi bi-instagram" id="ig-icon"></i>
      <i class="bi bi-facebook" id="fb-icon"></i>
      <i class="bi bi-youtube" id="yt-icon"></i>
    </div>
    <img src="imagens/logo.png" alt="Logo da humanizarte" id="logo-roda-pe">
    <h1>Humanizarte</h1>
    <p id="copyright">Copyright <i class="bi bi-c-circle"></i> 2023 Humanizarte, LTDA</p>
    <p style="font-weight: 600; padding-bottom: 1%;"><a href="#" style="color:black; text-decoration: underline;">Política de Privacidade</a> | <a href="#"  style="color:black; text-decoration: underline">Política de Segurança</a></p>
  </div>
</footer>

<!-- FIM RODA PÉ -->

</body>
</html>