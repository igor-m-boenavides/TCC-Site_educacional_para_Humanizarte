<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processamento de Pagamento - Humanizarte</title>
    <!-- Adicione aqui os links para os estilos e scripts necessários -->
</head>
<body>

<?php
// Função para estabelecer a conexão com o banco de dados
function conectarBancoDeDados()
{
    $host = "localhost"; // Insira o nome do host do seu banco de dados
    $usuario = "root"; // Insira o nome do usuário do banco de dados
    $senha = ""; // Insira a senha do banco de dados
    $bancoDeDados = "humanizarte"; // Insira o nome do banco de dados

    $conexao = new mysqli($host, $usuario, $senha, $bancoDeDados);

    // Verifica se ocorreu algum erro na conexão
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    return $conexao;
}

// Função para registrar o pedido no banco de dados
function registrarPedido($conexao, $cursos)
{
    // Prepara os dados para a inserção no banco de dados
    $cursosFormatados = array_map(function ($curso) use ($conexao) {
        return $conexao->real_escape_string($curso);
    }, $cursos);

    // Monta a consulta SQL com prepared statement para inserir os cursos no banco de dados
    $consultaSQL = "INSERT INTO pedidos (curso) VALUES (?)";

    // Prepara a consulta com o prepared statement
    $stmt = $conexao->prepare($consultaSQL);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    // Binda o parâmetro do curso ao prepared statement
    $stmt->bind_param("s", $cursos);

    // Itera sobre os cursos e insere-os um a um
    foreach ($cursosFormatados as $curso) {
        $stmt->execute();
    }

    // Fecha o prepared statement
    $stmt->close();
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se foram enviados os cursos selecionados
    if (isset($_POST["cursos"])) {
        $cursosSelecionados = $_POST["cursos"];
        $cursosArray = explode(",", $cursosSelecionados);
    } else {
        // Caso não tenha sido enviado, redireciona para a página de compra com mensagem de erro
        header("Location: compra.php?error=1");
        exit;
    }

    // Aqui você pode realizar o processamento do pagamento com base nas informações recebidas do formulário
    // Por exemplo, você pode verificar os dados do cartão de crédito e verificar a validade do pagamento
    // Simulação de processamento de pagamento bem-sucedido
    $pagamentoAprovado = true;

    if ($pagamentoAprovado) {
        // Estabelece a conexão com o banco de dados
        $conexao = conectarBancoDeDados();

        // Registra o pedido no banco de dados
        registrarPedido($conexao, $cursosArray);

        // Fecha a conexão com o banco de dados
        $conexao->close();

        // Exibir mensagem de sucesso
        echo "<h1>Pagamento Aprovado!</h1>";
        echo "<p>Seu pagamento foi processado com sucesso.</p>";
        echo "<p>Os seguintes cursos foram adquiridos:</p>";
        echo "<ul>";
        foreach ($cursosArray as $curso) {
            echo "<li>$curso</li>";
        }
        echo "</ul>";
    } else {
        // Exibir mensagem de erro
        echo "<h1>Pagamento Recusado!</h1>";
        echo "<p>O pagamento não pôde ser processado.</p>";
    }
} else {
    // Caso a página seja acessada diretamente sem o envio do formulário, redireciona para a página de compra
    header("Location: compra.php");
    exit;
}

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se todos os dados do pagamento foram enviados
    if (isset($_POST["valorTotal"], $_POST["cardToken"], $_POST["buyerToken"], $_POST["cursos"])) {
        $valorTotal = $_POST["valorTotal"];
        $cardToken = $_POST["cardToken"];
        $buyerToken = $_POST["buyerToken"];
        $cursosSelecionados = $_POST["cursos"];

        // Substitua aqui pela sua implementação de processamento do pagamento com o PagSeguro
        // Essa parte do código deve enviar os dados para o PagSeguro e tratar a resposta para saber se o pagamento foi bem-sucedido
        // Por se tratar de uma integração real com um serviço de pagamento, envolverá a comunicação com a API do PagSeguro e a manipulação de respostas XML ou JSON

        // Exemplo de resposta fictícia para fins de demonstração
        $resposta = array(
            'status' => 'success',
            'mensagem' => 'Pagamento processado com sucesso!',
            'cod_transacao' => '123456789'
        );

        // Retorna a resposta em formato JSON
        echo json_encode($resposta);
    } else {
        // Retorna uma mensagem de erro caso algum dado do pagamento esteja faltando
        echo 'Dados do pagamento incompletos';
    }
}

?>

</body>
</html>
