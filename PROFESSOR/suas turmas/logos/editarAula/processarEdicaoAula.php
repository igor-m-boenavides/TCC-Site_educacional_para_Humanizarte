<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aula_id'])) {
        $aula_id = $_POST['aula_id'];

        // Conectar ao banco de dados (você pode usar a conexão definida em conn.php)
        include_once('../../conn/conn.php');
        
        $nome = $_POST['nome'];
        $url_video = $_POST['url_video'];
        $nome_video = $_POST['nome_video'];
        $nome_anexo = $_POST['nome_anexo'];

        // Lida com o upload de um novo anexo se fornecido
        if (isset($_FILES['anexo']) && $_FILES['anexo']['tmp_name'] != '') {
            $anexo = $_FILES['anexo']['name'];
            $anexo_tmp = $_FILES['anexo']['tmp_name'];
            $anexo_destino = '../uploads/' . $anexo;
            move_uploaded_file($anexo_tmp, $anexo_destino);
        } else {
            // Se nenhum novo anexo foi fornecido, mantenha o anexo existente
            $stmt = $pdo->prepare('SELECT url_anexo FROM aula WHERE id_aula = :aula_id');
            $stmt->bindParam(':aula_id', $aula_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $anexo_destino = $result['url_anexo'];
        }

        // Atualiza os dados da aula no banco de dados
        $stmt = $pdo->prepare('UPDATE aula SET nome = :nome, url_video = :url_video, nome_video = :nome_video, url_anexo = :url_anexo, nome_anexo = :nome_anexo WHERE id_aula = :aula_id');
        $stmt->bindParam(':aula_id', $aula_id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':url_video', $url_video);
        $stmt->bindParam(':nome_video', $nome_video);
        $stmt->bindParam(':url_anexo', $anexo_destino);
        $stmt->bindParam(':nome_anexo', $nome_anexo);

        if ($stmt->execute()) {
            // Redireciona de volta para a página de edição com uma mensagem de sucesso
            header('Location: ../logos.php');
            exit();
        } else {
            echo 'Erro ao atualizar aula no banco de dados.';
        }
    } else {
        echo 'ID da aula não especificado.';
    }
}
?>