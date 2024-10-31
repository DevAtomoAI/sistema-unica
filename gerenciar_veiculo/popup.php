<?php
include_once("../database/config.php");
session_start();

$nomeOrgaoPublico = $_SESSION['nomeOrgaoPublico'];
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
$valorTotalServicos = $_SESSION['valorTotalServicos'];
$valorTotalPecas = $_SESSION['valorTotalPecas'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="popup.css">

    <script src="popup.js"></script>
</head>

<body>

    <h2>Orçamento de Manutenção</h2>

    <p>N° ordem de orçamento: <strong><?= $idVeiculoGerenciar ?></strong></p>
    <p>Placa: <strong><?= $placa ?></strong></p>
    <p>Modelo: <strong><?= $modeloVeiculo ?></strong></p>
    <p>Órgão solicitante: <strong><?= $nomeOrgaoPublico ?></strong></p>
    <p>Tipo de solicitação: <strong> <?= $modeloContratacao ?></strong></p>

    <form action="configs_popup.php" method="POST">

        <h3>Peças</h3>
        <table id="tabelaPecas" border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário Máximo Aceitável</th>
                    <th>Valor Total Máximo Aceitável</th>
                    <th>Marca</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                    <th>Valor total final</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>API OP</td>
                    <td>API OP</td>
                    <td>API OP</td>
                    <td>API OP</td>
                    <td>API OP</td>
                    <td> <input type="text" name="marca" id="marca" required></td>
                    <td> <input type="text" name="valorUN" id="valorUN" required></td>
                    <td>API OP</td>
                    <td>API OP</td>
                </tr>
            </tbody>
        </table>

        <h3>Serviços</h3>
        <table id="tabelaServicos" border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Tabela referencial (horas)</th>
                    <th>Valor da mão de obra</th>
                    <th>Valor total máximo aceitável</th>
                    <th>Valor orçado</th>
                    <th>Valor total final</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>API OP</td>
                    <td>API OP</td>
                    <td>API OP</td>
                    <td>API OP</td>
                    <td><input type="text" name="valorOrcado" id="valorOrcado" placeholder="Valor orçado"></td>
                    <td>API OP</td>
                </tr>
            </tbody>
        </table>

        <br>
        <h1>VALOR TOTAL DO ORÇAMENTO</h1>
        <br>
        <p>Prazo para entrega/execução <input name="prazoEntrega" type="text" placeholder="Prazo"></p>
        <br>
        <br>
        <button name="confirmaCotacao">Confirmar</button>
        <button onclick="fechaPopUp()" name="voltarGerenciar">Voltar</button> 
    </form>



</body>

</html>