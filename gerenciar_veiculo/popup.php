<?php
include_once("../database/config.php");
session_start();


$idVeiculoGerenciar = $_SESSION['idVeiculoGerenciar'];
$veiculo = $_SESSION['veiculo'];
$modeloVeiculo = $_SESSION['modeloVeiculo'];
$kmAtual = $_SESSION['kmAtual'];
$placa = $_SESSION['placa'];
$anoVeiculo = $_SESSION['anoVeiculo'];
$centroCusto = $_SESSION['centroCusto'];
$planoManutencao = $_SESSION['planoManutencao'];
$fornecedor = $_SESSION['fornecedor'];
$modeloContratacao = $_SESSION['modeloContratacao'];
$valorTotal;

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="popup.js">

    </script>
</head>

<body>

    <h2>Orçamento de Manutenção</h2>

    <p>N° ordem de orçamento: <strong><?= $idVeiculoGerenciar ?></strong></p>
    <p>Placa: <strong><?= $placa ?></strong></p>
    <p>Modelo: <strong><?= $modeloVeiculo ?></strong></p>
    <p>Órgão solicitante: <strong></strong></p>
    <p>Tipo de solicitação: <strong> <?= $modeloContratacao ?></strong></p>

    <h3>Peças</h3>
    <table id="tabelaPecas" border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Valor UN</th>
                <th>Quantidade</th>
                <th>Marca</th>
                <th>Desconto (36.6%)</th>
                <th>Valor Total</th>
                <th>Adicionar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <tr name="trTeste">
                <!-- <form action="configs_popup.php" method="POST"> -->
                <td><input type="text" id="codigo1"></td>
                <td><input type="text" id="descricao1"></td>
                <td><input type="text" id="valor_un1"></td>
                <td><input type="text" id="quantidade1"></td>
                <td><input type="text" id="marca1"></td>
                <td>36.6</td>
                <td>VALOR SOMA VINDO BANCO</td>
                <td><button onclick="adicionarLinhaPeças()">+</button></td>
                <td></td> <!-- A primeira linha não possui botão "Excluir" -->
                <!-- </form> -->
            </tr>
        </tbody>
    </table>

    <h3>Serviços</h3>
    <table id="tabelaServicos" border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Valor unitário</th>
                <th>Quantidade</th>
                <th>Desconto (36.6%)</th>
                <th>Valor Total</th>
                <th>Adicionar</th>
                <th>Excluir</th>
            </tr>  
        </thead>
        <tbody>
            <tr>
                <form action="">

                </form>
                <td><input type="text" id="descricao_servico1"></td>
                <td><input type="text" id="valor_unitario1"></td>
                <td><input type="text" id="quantidade_servico1"></td>
                <td>36.6</td>
                <td>VALOR SOMA VINDO BANCO</td>
                <td><button onclick="adicionarLinhaServicos()">+</button></td>
                <td></td> <!-- A primeira linha não possui botão "Excluir" -->
            </tr>
        </tbody>
    </table>
    <br>
    <br>

    <button name="confirmaCotacao" onclick="enviaValoresBD()">Confirmar</button>
    <a href="gerenciar.php"><button name="voltarGerenciar">Voltar</button></a>



</body>

</html>