<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Humanizarte</title>
    <!-- Adicione aqui os links para os estilos e scripts necessários -->
</head>
<body>

<!-- Adicione aqui o conteúdo da página de checkout, por exemplo: -->

<h1>Checkout - Resumo da Compra</h1>
<div id="resumoCompra">
    <div id="resumoCompra">
        <?php
          // Verifica se foi recebido o parâmetro "cursos" na URL
          if (isset($_GET['cursos'])) {
            $cursosSelecionados = $_GET['cursos'];
            $cursosArray = explode(",", $cursosSelecionados);
            echo "<h2>Itens Selecionados:</h2>";
            echo "<ul>";
            foreach ($cursosArray as $curso) {
              echo "<li>$curso</li>";
            }
            echo "</ul>";
          } else {
            echo "<p>Nenhum item foi selecionado para compra.</p>";
          }
        ?>
      </div>
</div>

<!-- Adicione aqui os formulários e botões para a conclusão da compra, por exemplo: -->
<form id="formPagamento" action="processar_pagamento.php" method="post">
  <!-- Adicione campos necessários para a transação de pagamento, como informações do cartão de crédito, endereço, etc. -->
  <!-- Aqui você pode adicionar campos para receber informações adicionais do usuário, como endereço de entrega, etc. -->
  <button type="submit" class="btn btn-primary">Finalizar Pagamento</button>
</form>

<!-- Adicione um botão para iniciar o pagamento -->
<form id="formPagamento" method="post">
        <input type="hidden" id="cursos" name="cursos" value="<?php echo implode(",", $cursosArray); ?>">
        <button type="button" id="iniciarPagamentoBtn" class="btn btn-primary">Iniciar Pagamento</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script>
        $(document).ready(function () {
            // Obtém a chave de acesso do PagSeguro (sandbox ou produção)
            var pagSeguroKey = 'INSIRA_SUA_CHAVE_DE_ACESSO_AQUI';

            // Obtém o token do comprador (gerado pelo PagSeguro SDK)
            var buyerToken;

            // Função para iniciar o pagamento
            function iniciarPagamento() {
                // Recupera o valor total da compra (pode ser calculado dinamicamente)
                var valorTotal = 100.00;

                // Cria uma sessão no servidor para obter o token do comprador
                $.ajax({
                    url: 'obter_token.php',
                    method: 'POST',
                    data: {
                        pagSeguroKey: pagSeguroKey
                    },
                    success: function (response) {
                        // Obtém o token do comprador do servidor
                        buyerToken = response;

                        // Inicia o pagamento com o PagSeguro
                        PagSeguroDirectPayment.setSessionId(pagSeguroKey);
                        PagSeguroDirectPayment.createCardToken({
                            cardNumber: '4111111111111111',
                            brand: 'visa',
                            cvv: '123',
                            expirationMonth: '12',
                            expirationYear: '2030',
                            success: function (response) {
                                // Obtém o token do cartão de crédito do PagSeguro
                                var cardToken = response.card.token;

                                // Envia os dados para o servidor processar o pagamento
                                processarPagamento(valorTotal, cardToken, buyerToken);
                            },
                            error: function (response) {
                                console.log('Erro ao obter o token do cartão: ' + JSON.stringify(response));
                            }
                        });
                    },
                    error: function (response) {
                        console.log('Erro ao obter o token do comprador: ' + JSON.stringify(response));
                    }
                });
            }

            // Função para enviar os dados do pagamento para o servidor
            function processarPagamento(valorTotal, cardToken, buyerToken) {
                $.ajax({
                    url: 'processar_pagamento.php',
                    method: 'POST',
                    data: {
                        valorTotal: valorTotal,
                        cardToken: cardToken,
                        buyerToken: buyerToken,
                        cursos: '<?php echo implode(",", $cursosArray); ?>'
                    },
                    success: function (response) {
                        console.log('Resposta do servidor: ' + JSON.stringify(response));
                        // Exiba uma mensagem de sucesso ou redirecione para uma página de sucesso
                    },
                    error: function (response) {
                        console.log('Erro no servidor: ' + JSON.stringify(response));
                        // Exiba uma mensagem de erro ou redirecione para uma página de erro
                    }
                });
            }

            // Adiciona o ouvinte de clique para o botão de iniciar pagamento
            $('#iniciarPagamentoBtn').click(function () {
                iniciarPagamento();
            });
        });
    </script>

</body>
</html>
