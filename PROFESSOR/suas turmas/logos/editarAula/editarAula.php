<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humanizarte</title>
    <link rel="icon" href="../../imagens/logo.png">
    <link rel="stylesheet" href="editarAula.css">

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
    <main>
        <div class="container">
            <?php
            // Verifique se um ID de aula foi fornecido na URL
            if (isset($_GET['id'])) {
                $aula_id = $_GET['id'];

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
                        // Exiba um formulário para editar as informações da aula
                        ?>
                        <div class="center-form">
                            <div class="form">
                                <h2>Editar Aula</h2>
                                <div class="image-container">
                                    <img src="../../imagens/logo.png" alt="" class="center-image" style="width: 15%; height: 15%">
                                </div>
                                <form method="post" action="processarEdicaoAula.php" enctype="multipart/form-data">
                                    <input type="hidden" name="aula_id" value="<?php echo $aula_id; ?>">
                                    
                                    <div class="mb-3">
                                        <label for="nome" class="form-label">Título da aula:</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $aula['nome']; ?>">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="url_video" class="form-label">URL do vídeo:</label>
                                        <input type="text" class="form-control" id="url_video" name="url_video" value="<?php echo $aula['url_video']; ?>">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="nome_video" class="form-label">Título do vídeo:</label>
                                        <input type="text" class="form-control" id="nome_video" name="nome_video" value="<?php echo $aula['nome_video']; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="anexo" class="form-label">Anexo:</label>
                                        <input type="file" class="form-control" id="anexo" name="anexo">
                                    </div>

                                    <div class="mb-3">
                                        <label for="nome_anexo" class="form-label">Título do anexo:</label>
                                        <input type="text" class="form-control" id="nome_anexo" name="nome_anexo" value="<?php echo $aula['nome_anexo']; ?>">
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-dark">SALVAR</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<p>A aula não foi encontrada.</p>';
                    }
                } catch (PDOException $e) {
                    echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
                }
            } else {
                echo '<p>ID da aula não especificado.</p>';
            }
            ?>
        </div>
    </main>
</body>
</html>
