<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humanizarte</title>
    <link rel="icon" href="imagens/logo.png">
    <link rel="stylesheet" href=index.css>
    
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

<!-- BARRA DE NAVEGAÇÃO -->

<div class="navbar">
  <a class="navbar-logo" href="index.php" style="color: black; text-decoration: none; font-size: 15pt;">
    <img src="imagens/logo.png" width="50px" height="50px">
    Humanizarte
  </a>
  <nav class="lista-menu">
    <ul class="menu-items">
      <li id="atual"><a href="../index/index.php">Início</a></li>
      <li><a href="../suas turmas/turmas.php">Suas turmas</a></li>
      <li><a href="../sobre-nos/sobrenos.php">Sobre nós</a></li>
      <li><a href="../conta/conta.php">Conta</a></li>
    </ul>
  </nav>
</div>

<!-- FIM DA BARRA DE NAVEGAÇÃO -->

<!-- CARROSSEL -->

<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Slides -->
  <div class="carousel-inner">
      <div class="item active">
          <a href="https://www.youtube.com/@HumanizArteProfDionathas" target="_blank"><img src="imagens/1.png" alt="Image 1"></a>
          <div class="carousel-caption">
          </div>
      </div>

      <div class="item">
          <a href="https://www.instagram.com/humanizarteoficial/" target="_blank"><img src="imagens/2.png" alt="Image 2"></a>
          <div class="carousel-caption">
          </div>
      </div>

      <div class="item">
          <a href="https://wa.me/message/KVTNXX6M3XKYC1" target="_blank"><img src="imagens/3.png" alt="Image 3"></a>
          <div class="carousel-caption">
          </div>
      </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>

<!-- FIM DO CARROSSEL -->

<!-- CARTÕES DE PREÇO -->

<h1 id="h1-cursos">CURSOS</h1>

<div class="area-cartoes">
  <div class="cartao-logos">

    <h1><sup>R$</sup>300<p>/mês</p><h1 id="h1-logos">LOGOS</h1></h1>
    <span class="logos-cntd">
      <p>Filosofia e Sociologia</p>
      <p>Foco ENEM e Vestibulares</p>
      <p>Material completo de conteúdo e questões</p>
      <p>Modalidades online ao vivo e presencial</p>
      <button type="button" class="btn btn-danger" id="comprar-btn">COMPRAR</button>
    </span>

  </div>

  <div class="cartao-cronos">
    <h1><sup>R$</sup>300<p>/mês</p><h1 id="h1-cronos" id="comprar-btn">CRONOS</h1></h1>
    <span class="cronos-cntd">
      <p>História Geral e do Brasil</p>
      <p>Foco ENEM e Vestibulares</p>
      <p>Material completo de conteúdo e questões</p>
      <p>Modalidades online ao vivo e presencial</p>
      <button type="button" class="btn btn-danger" id="comprar-btn">COMPRAR</button>
    </span>

</div>

  <div class="cartao-suntzu">
    <h1><sup>R$</sup>100<p>/mês</p><h1 id="h1-suntzu">SUNTZU</h1></h1>
    <span class="suntzu-cntd">
      <p>Estratégia e Prática ENEM</p>
      <p>Aulas ao vivo a partir de junho</p>
      <p>Formação sobre Habilidades e Competências ENEM</p>
      <p>Material completo de conteúdo e questões</p>
      <button type="button" class="btn btn-danger" id="comprar-btn">COMPRAR</button>
    </span>
  </div>
</div>

<!-- FIM DE CARTÕES DE PREÇO -->

<!-- RODA PÉ -->

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
    <!-- <p style="font-weight: 600; padding-bottom: 1%;"><a href="#" style="color:black; text-decoration: underline;">Política de Privacidade</a> | <a href="#"  style="color:black; text-decoration: underline">Política de Segurança</a></p> -->
  </div>
</footer>

<!-- FIM RODA PÉ -->

</body>
</html>