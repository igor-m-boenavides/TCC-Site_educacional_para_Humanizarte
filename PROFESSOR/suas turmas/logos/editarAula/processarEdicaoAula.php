<?php
// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se um ID de aula foi enviado
    if (isset($_POST["aula_id"])) {
        $aula_id = $_POST["aula_id"];

        // Conectar ao banco de dados
        $host = 'localhost';
        $db = 'humanizarte';
        $user = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consultar o banco de dados para obter informações da aula com base no ID
            $stmt = $pdo->prepare('SELECT * FROM aula WHERE id_aula = :aula_id');
            $stmt->bindParam(':aula_id', $aula_id, PDO::PARAM_INT);
            $stmt->execute();
            $aula = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($aula) {
                // Obtenha os dados do formulário
                $nome = $_POST["nome"];
                $url_video = $_POST["url_video"];
                $nome_video = $_POST["nome_video"];
                $nome_anexo = $_POST["nome_anexo"]; // Obtenha o nome do anexo do campo "nome_anexo"

                // Verifique se um arquivo de anexo foi enviado
                if ($_FILES["anexo"]["error"] == UPLOAD_ERR_OK) {
                    $anexo_temp_name = $_FILES["anexo"]["tmp_name"];
                    $anexo_name = $_FILES["anexo"]["name"];
                    $anexo_path = "../uploads/" . $anexo_name;

                    // Renomeie o arquivo de anexo para o nome indicado em "nome_anexo"
                    if ($nome_anexo != "") {
                        $anexo_path = "../uploads/" . $nome_anexo;
                        // Certifique-se de que o nome do arquivo é exclusivo para evitar substituições
                        $counter = 1;
                        while (file_exists($anexo_path)) {
                            $anexo_path = "../uploads/" . $nome_anexo . "_" . $counter;
                            $counter++;
                        }
                    }

                    // Movimente o arquivo de anexo para o local desejado
                    move_uploaded_file($anexo_temp_name, $anexo_path);
                } else {
                    // Não houve envio de um novo arquivo de anexo, mantenha o anexo existente
                    $anexo_path = $aula["url_anexo"];
                }

                // Atualize os dados da aula no banco de dados
                $stmt = $pdo->prepare('UPDATE aula SET nome = :nome, url_video = :url_video, nome_video = :nome_video, url_anexo = :url_anexo, nome_anexo = :nome_anexo WHERE id_aula = :aula_id');
                $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
                $stmt->bindParam(':url_video', $url_video, PDO::PARAM_STR);
                $stmt->bindParam(':nome_video', $nome_video, PDO::PARAM_STR);
                $stmt->bindParam(':url_anexo', $anexo_path, PDO::PARAM_STR);
                $stmt->bindParam(':nome_anexo', $nome_anexo, PDO::PARAM_STR); // Vincule o nome do anexo
                $stmt->bindParam(':aula_id', $aula_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    // Aula atualizada com sucesso
                    header("Location: ../logos.php"); // Redirecione para a página de sucesso ou outra página desejada
                    exit();
                } else {
                    echo 'Erro ao atualizar a aula.';
                }
            } else {
                echo 'A aula não foi encontrada.';
            }
        } catch (PDOException $e) {
            echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
        }
    } else {
        echo 'ID da aula não especificado.';
    }
} else {
    echo 'O formulário não foi enviado.';
}
?>
