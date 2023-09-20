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
// Função para conectar ao banco de dados
function conectarBanco() {
    $host = 'localhost';
    $db = 'humanizarte';
    $user = 'root';
    $password = '';

    try {
        $dsn = "mysql:host=$host;dbname=$db";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    echo "ID do usuário não fornecido.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = conectarBanco();
    
    $novo_nome = $_POST['novo_nome'];
    $novo_email = $_POST['novo_email'];
    $novo_telefone = $_POST['novo_telefone'];
    $nova_senha = $_POST['nova_senha'];
    
    // Valide os dados aqui conforme necessário
    
    // Atualize as informações do usuário
    $stmt = $pdo->prepare("UPDATE aluno SET nome = COALESCE(?, nome), email = COALESCE(?, email), telefone = COALESCE(?, telefone), senha = COALESCE(?, senha) WHERE id_aluno = ?");
    $stmt->execute([$novo_nome, $novo_email, $novo_telefone, $nova_senha, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        echo "Informações do usuário atualizadas com sucesso.";
    } else {
        echo "Nenhuma linha foi atualizada.";
    }
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
        <div class="form-check">
        <div class="btn-cadastro">
            <input type="submit" value="ALTERAR" class="btn btn-dark" id="btn-cadastro"></input>
        </div>
        </div>
    </form>
</div>

</body>
</html>