<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humanizarte</title>
    <link rel="stylesheet" href="alunos.css">
    
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

<!-- BARRA DE NAVEGAÇÃO -->

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">

  <a class="navbar-brand" href="#" id="logo_texto"><img alt="Logo Humanizarte" src="imagens/logo.png" width="40" height="40">Humanizarte</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">

    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="../suas turmas/turmas.html">Suas turmas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="alunos.html" id="atual">Alunos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../estatisticas/stats.html">Estatísticas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../conta/conta.html">Conta</a>
      </li>
    </ul>

  </div>

</nav>

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

$servername = 'localhost';
$dbname = 'humanizarte';
$username = 'root';
$password = '';

$dsn = "mysql:host=$servername;dbname=$dbname"; 

$sql = "SELECT * FROM aluno";

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
  <th>Nome de usuário</th>
  <th>Email</th>
  <th>Telefone</th>
  <th>Turma</th>
  <th>Editar</th>
  <th>Excluir</th>
</tr>
<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
<tr>
  <td><?php echo htmlspecialchars($row['id_aluno']); ?></td>
  <td><?php echo htmlspecialchars($row['nome']); ?></td>
  <td><?php echo htmlspecialchars($row['email']); ?></td>
  <td><?php echo htmlspecialchars($row['telefone']); ?></td>
  <td>Turma</td>
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

</body>
</html>