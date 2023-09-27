<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humanizarte</title>
    <link rel="stylesheet" href="alunos.css">
    <link rel="icon" href="../../NÃO CADASTRADO/index/imagens/logo.png">
    
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
      <li><a href="../index/index.html">Ínicio</a></li>
      <li><a href="../suas turmas/turmas.html">Turmas</a></li>
      <li id="atual"><a href="../alunos/alunos.php">Alunos</a></li>
      <li><a href="../conta/conta.php">Conta</a></li>
    </ul>
  </nav>
</div>

<!-- FIM DA BARRA DE NAVEGAÇÃO -->

<!-- INICIO ALUNOS -->

<div class="area-alunos">

    <h1>Alunos</h1>

<!-- INICIO CADASTRO -->

<div class="botao-cadastro">
    <p><a href="cadastroAluno.html"><i class="bi bi-plus-circle-fill" id="add-aluno"></i> Cadastrar aluno</a></p>
</div>

<!-- FIM CADASTRO -->

<!-- INICIO LISTAGEM DE ALUNOS -->

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

// Consulta SQL com JOIN para obter informações da turma
$sql = "SELECT aluno.id_aluno, aluno.nome, aluno.email, aluno.telefone, GROUP_CONCAT(turma.nome ORDER BY turma.nome ASC) AS nome_turmas
        FROM aluno
        LEFT JOIN aluno_turma ON aluno.id_aluno = aluno_turma.id_aluno
        LEFT JOIN turma ON aluno_turma.id_turma = turma.id_turma
        GROUP BY aluno.id_aluno";

try {
  $pdo = new PDO($dsn, $username, $password);
  $stmt = $pdo->query($sql);

  if ($stmt === false) {
      die("Error");
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>

<table class="table">
<tbody>
<tr>
  <th>ID</th>
  <th>Nome de Usuário</th>
  <th>Email</th>
  <th>Telefone</th>
  <th>Turmas</th>
  <th>Editar</th>
  <th>Excluir</th>
</tr>

<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
<tr>
  <td><?php echo htmlspecialchars($row['id_aluno']); ?></td>
  <td><?php echo htmlspecialchars($row['nome']); ?></td>
  <td><?php echo htmlspecialchars($row['email']); ?></td>
  <td><?php echo htmlspecialchars($row['telefone']); ?></td>
  <td><?php echo htmlspecialchars($row['nome_turmas']); ?></td> <!-- Nova coluna para as turmas -->
  <td>
    <p style="padding: 0; margin: 0;">
      <a href="update.php?id=<?php echo $row['id_aluno']; ?>" style="color: blue;">
        <i class="bi bi-pen-fill"></i>
      </a>
    </p>
  </td>
  <td>
    <form method="post" action="delete.php" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
      <input type="hidden" name="id_aluno" value="<?php echo $row['id_aluno']; ?>">
      <button type="submit" name="excluir" style="border: none; background: none; color: red;">
        <i class="bi bi-trash-fill"></i>
      </button>
    </form>
  </td>
</tr>
<?php endwhile; ?>

</tbody>
</table>


<!-- FIM LISTAGEM DE ALUNOS -->

<!-- FIM ALUNOS -->

</div>

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