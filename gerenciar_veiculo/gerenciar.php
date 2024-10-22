
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="popup.js"></script>
</head>
<body>
    <table>
        <thead>
            <tr>N</tr>
            <tr>Veiculo</tr>
            <tr>Modelo</tr>
            <tr>Km atual</tr>
            <tr>Placa</tr>
            <tr>Ano veiculo</tr>
            <tr>Centro custo</tr>
            <tr>Plano manutenção</tr>
            <tr>Fornecedor</tr>
            <tr>Modelo contratação</tr>
        </thead>
        <tbody>
            <td><?= $idVeiculoGerenciar ?></td>
            <td><?= $veiculo ?></td>
            <td><?= $modeloVeiculo ?></td>
            <td><?= $kmAtual ?></td>
            <td><?= $placa ?></td>
            <td><?= $anoVeiculo ?></td>
            <td><?= $centroCusto ?></td>
            <td><?= $planoManutencao ?></td>
            <td><?= $fornecedor ?></td>
            <td><?= $modeloContratacao ?></td>
        </tbody>
        
    </table>
    <br>
    <br>
    <h3>Descrição</h3>
    <input type="text" name="descricaoProblema" id="descricaoProblema">
    <br>
    <br>
    <br>
    <br>
    <h3>Informações para emissão de nota fiscal</h3>
    <p>NOME ORGAO PUBLICO</p>
    <table>
        <thead>
            <tr>Dados para emissão de notas fiscais de peças. Destaque destes impostos</tr>
            <td>IR</td>
            <td>PIS</td>
            <td>COFINS</td>
            <td>CSLL</td>
        </thead>
        <tbody>
            <td>1,20 %</td>
            <td>0,65 %</td>
            <td>3,00 %</td>
            <td>1,00 %</td>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>Dados para emissão de notas fiscais de serviços. Destaque destes impostos</tr>
            <td>IR</td>
            <td>PIS</td>
            <td>COFINS</td>
            <td>CSLL</td>
        </thead>
        <tbody>
            <td>4,80 %</td>
            <td>0,65 %</td>
            <td>3,00 %</td>
            <td>1,00 %</td>
        </tbody>
    </table>
    <p>*O DESTQUE DOS IMPOSTOS É APENAS PARA EMPRESAS NÃO OPTANTE PELO SIMPLES NACIONAL</p>
    <br>
    <br>
    <h3>Informações de Despesa</h3>
    <table>
        <thead>
            <tr>N° orçamento </tr>
            <!-- N° orçamento = id nova tabela criada no mysql -->
            <tr>Fornecedor</tr>
            <tr>Valor mão de obra</tr>
            <tr>Valor total de peças</tr>
            <tr>Valor total</tr>
            <tr>Status orçamento</tr>
            <tr>Data registro</tr>
            <tr><button onclick="abrirPopUp()">Incluir orçamento</button></tr>
        </thead>
    </table>
    <br>
    <br>
    <button>Confirmar</button>
    <button>Voltar</button>
</body>
</html>