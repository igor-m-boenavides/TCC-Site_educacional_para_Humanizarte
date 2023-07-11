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
    <title>Update User Info</title>
</head>
<body>
    <h1>Update User Info</h1>

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

    <form method="post" action="">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" value="<?php echo $user_id; ?>" required><br>

        <label for="novo_nome">Novo nome:</label>
        <input type="text" name="novo_nome"><br>

        <label for="novo_email">Novo email:</label>
        <input type="email" name="novo_email"><br>

        <label for="novo_telefone">Novo telefone:</label>
        <input type="text" name="novo_telefone"><br>

        <label for="nova_senha">Nova senha:</label>
        <input type="password" name="nova_senha"><br>

        <input type="submit" name="submit" value="Alterar">
    </form>
</body>
</html>