<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    // Recupere o ID da aula a ser excluída
    $id_aula = $_GET['id'];

    // Conectar ao banco de dados
    $host = 'localhost';
    $db = 'humanizarte';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verifique se o usuário tem permissão para excluir a aula (você pode adicionar essa lógica se necessário)

        // Execute uma consulta SQL para excluir a aula com base no ID
        $stmt = $pdo->prepare('DELETE FROM aula WHERE id_aula = :id_aula');
        $stmt->bindParam(':id_aula', $id_aula, PDO::PARAM_INT);
        $stmt->execute();

        // Redirecione o usuário de volta à página de lista de aulas após a exclusão
        header('Location: suntzu.php');
        exit();
    } catch (PDOException $e) {
        echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
    }
} else {
    // Lidar com erros
    echo 'Parâmetros inválidos.';
}
?>
