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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humanizarte</title>
    <link rel="stylesheet" href=sobrenos.css>
    <link rel="icon" href="imagens/logo.png">
    
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

<!-- BARRA DE NAVEGAÇÃO -->

<div class="navbar">
  <a class="navbar-logo" style="color: black; text-decoration: none; font-size: 15pt;">
    <img src="imagens/logo.png" width="50px" height="50px">
    Humanizarte
  </a>
  <nav class="lista-menu">
    <ul class="menu-items">
      <li><a href="../index/index.php">Início</a></li>
      <li><a href="../suas turmas/turmas.php">Suas turmas</a></li>
      <li id="atual"><a href="../sobre-nos/sobrenos.html">Sobre nós</a></li>
      <li><a href="../conta/conta.php">Conta</a></li>
    </ul>
  </nav>
</div>

<!-- FIM DA BARRA DE NAVEGAÇÃO -->

<!-- SOBRE NÓS -->

<!-- :Humanizarte -->

<div class="area">
  <div class="area-sobre-nos">
      <div class="texto">
      <h1>Bem-vindo a <br> Humanizarte</h1>
      <p>O nome é Dionathas, mas sou conhecido como Dion. Sou natural de Viamão, Rio Grande do Sul, mas atualmente moro em uma praia no Sul de Santa Catarina. Após criar a Humanizarte, decidi buscar mais tranquilidade. Tenho formação e mestrado pela UFRGS, e atualmente estou concluindo meu doutorado. Desde 2012, trabalho com ENEM e Vestibulares, especializando-me em preparar estudantes para alto desempenho nessas provas. Minha missão é ajudar o maior número possível de alunos a ingressar na graduação de seus sonhos. A Humanizarte, criada há 3 anos, tem alcançado cada vez mais aprovações, focando não apenas no conteúdo, mas também na estratégia.</p>
      </div>

      <div class="imagem">
          <img src="imagens/1.jpg" alt="" width="300px" height="100%">
      </div>
  </div>
</div>

<!-- :Sobre nós -->

<div class="sobre_nos">
  <div class="titulo"><h1>Sobre nós</h1></div>
  <div class="texto">
    É um prazer imenso te receber na Humanizarte. A Humanizarte nasceu em 2020. O professor Dionathas trabalhava há 9 anos em Cursos Pré-Vestibulares preparando estudantes para o ENEM e Vestibulares do Sul do Brasil. Em 2020 veio a pandemia. Muita gente ficou sem acesso a ensino de qualidade. A Humanizarte nasceu como uma página de Instagram que desejava levar o estudo das Humanas e das Artes para pessoas que, naquele contexto, não estavam conseguindo sair de casa para estudar. De lá pra cá formamos centenas de estudantes. Batemos recorde de aprovação em 2023. Estamos conseguindo levar o estudo de alto desempenho em Humanas mais longe. É gratificante saber que nossa mensagem chegou até você.
  </div>
</div>

<!-- :Fim Sobre nós -->

<!-- :Equipe -->

<div class="equipe">
  <div class="mary">
    <div class="nome">Dionathas</div>
    <div class="sub_nome">Professor e mentor</div>
  </div>
  <div class="mary">
    <div class="nome">Jéssica</div>
    <div class="sub_nome">Assistente</div>
  </div>
  <div class="mary">
    <div class="nome">Thomaz</div>
    <div class="sub_nome">Gestor de tráfego</div>
  </div>
  <div class="mary">
    <div class="nome">Samuel</div>
    <div class="sub_nome">Professor</div>
  </div>
</div>

<!-- :Fim Equipe -->

<!-- FIM SOBRE NÓS -->

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
    <p style="font-weight: 600; padding-bottom: 1%;"><a href="#" style="color:black; text-decoration: underline;">Política de Privacidade</a> | <a href="#"  style="color:black; text-decoration: underline">Política de Segurança</a></p>
  </div>
</footer>

<!-- FIM RODA PÉ -->

</body>
</html>