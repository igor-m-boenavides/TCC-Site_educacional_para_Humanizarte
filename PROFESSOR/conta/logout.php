<?php
// Inclua a configuração do banco de dados aqui (conexão PDO) se necessário
require_once '../conn/conn.php';

// Inicie ou retome a sessão
session_start();

// Destrua a sessão (deslogar o usuário)
session_destroy();

// Redirecione o usuário para a página de índice
header("Location: ../../index.html");
exit(); // Certifique-se de encerrar o script após o redirecionamento
?>
