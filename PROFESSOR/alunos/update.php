<?php
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    echo "ID do usuário não fornecido.";
    // ou redirecionar para a página de listagem, por exemplo:
    // header("Location: alunos.php");
    // exit();
}
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
    $host = 'localhost';
    $db = 'humanizarte';
    $user = 'root';
    $password = '';

    try {
        // Connect to the database
        $dsn = "mysql:host=$host;dbname=$db";
        $pdo = new PDO($dsn, $user, $password);

        // Set error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Function to update user information
        function updateUserInfo($user_id, $novo_nome, $novo_email, $novo_telefone, $nova_senha) {
            global $pdo;

            // Prepare the update statement
            $stmt = $pdo->prepare("UPDATE humanizarte.aluno SET nome = COALESCE(?, nome), email = COALESCE(?, email), telefone = COALESCE(?, telefone), senha = COALESCE(?, senha) WHERE id_aluno = ?");

            // Bind parameters
            $stmt->bindParam(1, $novo_nome);
            $stmt->bindParam(2, $novo_email);
            $stmt->bindParam(3, $novo_telefone);
            $stmt->bindParam(4, $nova_senha);
            $stmt->bindParam(5, $user_id);

            // Execute the update statement
            $stmt->execute();

            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                echo "User information updated successfully.";
            } else {
                echo "No rows were updated.";
            }
        }

        if (isset($_POST['submit'])) {
            // Get form data
            $novo_nome = $_POST['novo_nome'];
            $novo_email = $_POST['novo_email'];
            $novo_telefone = $_POST['novo_telefone'];
            $nova_senha = $_POST['nova_senha'];

            // Call the update function with non-empty fields only
            updateUserInfo($user_id, !empty($novo_nome) ? $novo_nome : null, !empty($novo_email) ? $novo_email : null, !empty($novo_telefone) ? $novo_telefone : null, !empty($nova_senha) ? $nova_senha : null);
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

<div class="area">
    <div class="alterar">
        <div class="titulo">
            <h1>Alterar</h1>
        </div>
        <form method="post" action="">
            
            <label for="id" class="form-label" >ID do usuário</label>
            <input type="text" class="form-control" id="id" name="id" aria-describedby="emailHelp" value="<?php echo $user_id; ?>">

            <label for="novo_nome" class="form-label">Novo nome</label>
            <input type="text" class="form-control" id="novo_nome" name="novo_nome" aria-describedby="emailHelp">

            <label for="novo_email" class="form-label">Novo email</label>
            <input type="email" class="form-control" id="novo_email" name="novo_email" aria-describedby="emailHelp">

            <label for="novo_telefone" class="form-label">Novo telefone</label>
            <input type="text" class="form-control" id="novo_telefone" name="novo_telefone" aria-describedby="emailHelp">

            <label for="nova_senha" class="form-label">Nova senha</label>
            <input type="password" class="form-control" id="nova_senha" name="nova_senha" aria-describedby="emailHelp">

            <button type="submit" class="btn btn-primary">ALTERAR</button>
        </form>
    </div>
</div>

<!--  -->

<!-- <div class="login">
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
            <label for="nome">Novo nome</label>
            <input type="text" class="form-control" name="novo_nome" id="novo_nome" placeholder="&#xf007; Digite o novo nome de usuário" style="font-family:Arial, FontAwesome">
        </div>
        <div class="form-group">
            <label for="email">Novo email</label>
            <input type="email" class="form-control" name="novo_email" id="novo_email" placeholder="&#xf0e0; Digite o novo email do usuário" style="font-family:Arial, FontAwesome">
        </div>
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" class="form-control" name="novo_telefone" id="novo_telefone" placeholder="&#xf095; Digite o novo telefone do usuário" style="font-family:Arial, FontAwesome">
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" name="nova_senha" id="nova_senha" placeholder="&#xf023; Digite a nova senha do usuário" style="font-family:Arial, FontAwesome">
        </div>
        <div class="form-check">
        <div class="btn-cadastro">
            <input type="submit" value="ALTERAR" class="btn btn-dark" id="btn-cadastro"></input>
        </div>
        </div>
    </form>
</div> -->

</body>
</html>