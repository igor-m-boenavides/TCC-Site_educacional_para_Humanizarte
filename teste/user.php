<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "humanizarte";

// Conectando ao banco de dados usando PDO
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Definindo o modo de erro do PDO como exceção
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  // Consulta SQL para obter a lista de usuários
  $stmt = $conn->query("SELECT id, nome, email FROM usuarios");
  $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Erro ao conectar-se ao banco de dados: " . $e->getMessage();
}

// Fechando a conexão com o banco de dados
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Listagem de Usuários</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    .btn {
      padding: 5px 10px;
      border: none;
      cursor: pointer;
      font-size: 14px;
      margin-right: 5px;
    }

    .btn-edit {
      background-color: #4CAF50;
      color: white;
    }

    .btn-delete {
      background-color: #f44336;
      color: white;
    }
  </style>
</head>
<body>
  <h1>Listagem de Usuários</h1>
  <table>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Ações</th>
    </tr>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
      <td><?php echo $usuario['id']; ?></td>
      <td><?php echo $usuario['nome']; ?></td>
      <td><?php echo $usuario['email']; ?></td>
      <td>
        <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-edit">Editar</a>
        <a href="excluir_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-delete">Excluir</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
