<?php
include_once("../database/config.php");
session_start();

$idVeiculoGerenciar = $_SESSION['idVeiculoGerenciar'];

$veiculo = $_SESSION['veiculo'];
$kmAtual = $_SESSION['kmAtual'];
$centroCusto = $_SESSION['centroCusto'];
$planoManutencao = $_SESSION['planoManutencao'];
$fornecedor = $_SESSION['fornecedor'];
$modeloContratacao = $_SESSION['modeloContratacao'];

$valorTotalServicos;
$valorTotalPecas;
$valorTotalFinal;
$dataRegistro;

$selectTable = "SELECT * FROM infos_veiculos_aprovados_oficina WHERE id_veiculo_incluso_orgao_publico='$idVeiculoGerenciar'";
$selectTable2 = "SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos='$idVeiculoGerenciar'";

function executaSelectTable($connectionDB, $query)
{
    $stmt = $connectionDB->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
}

$executaConexao = executaSelectTable($connectionDB, $selectTable);
$executaConexao2 = executaSelectTable($connectionDB, $selectTable2);

$user_data2 = mysqli_fetch_assoc($executaConexao2);
$idOrgaoPublico = $user_data2['id_orgao_publico'];

$selectTableNomeOrgaoPublico= "SELECT * FROM usuarios_orgao_publico WHERE id_usuarios_orgao_publico='$idOrgaoPublico'";
$executaConexaoNomeOrgaoPublico = executaSelectTable($connectionDB, $selectTableNomeOrgaoPublico);
$nomeOrgaoPublico = mysqli_fetch_assoc($executaConexaoNomeOrgaoPublico);
$resultNomeOrgaoPublico = $nomeOrgaoPublico['nome_orgao_publico'];

$_SESSION['nomeOrgaoPublico'] = $nomeOrgaoPublico['nome_orgao_publico'];
$cnpjOrgaoPublico = $nomeOrgaoPublico['identificacao_cnpj'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar</title>
    <script src="popup.js"></script>
    <link rel="stylesheet" href="gerenciar.css">
</head>

<body>
    <table>
        <thead>
            <td>N</td>
            <td>Veiculo</td>
            <!-- <td>Modelo</td> -->
            <td>Km atual</td>
            <!-- <td>Placa</td> -->
            <!-- <td>Ano veiculo</td> -->
            <td>Centro custo</td>
            <td>Plano manutenção</td>
            <td>Fornecedor</td>
            <td>Modelo contratação</td>
        </thead>
        <tbody>
            <td><?= $idVeiculoGerenciar ?></td>
            <td><?= $veiculo ?></td>
            <!-- <td><?= $modeloVeiculo ?></td> -->
            <td><?= $kmAtual ?></td>
            <!-- <td><?= $placa ?></td> -->
            <!-- <td><?= $anoVeiculo ?></td> -->
            <td><?= $centroCusto ?></td>
            <td><?= $planoManutencao ?></td>
            <td><?= $fornecedor ?></td>
            <td><?= $modeloContratacao ?></td>
        </tbody>

    </table>

    <p>Nome Órgão Público: <?= $resultNomeOrgaoPublico ?></p>
    <p>CNPJ Órgão Público: <?= $cnpjOrgaoPublico ?></p>

   
    <br>
    <br>
    <h3>Informações de Despesa</h3>
    <table>
        <thead>
            <td>N° orçamento </td>
            <td>Valor mão de obra</td>
            <td>Valor total de peças</td>
            <td>Valor total</td>
            <td>Tempo execução</td>
            <br>
        </thead>

        <tbody>
            <?php
                while ($user_data = mysqli_fetch_assoc($executaConexao)) {
                    // $_SESSION['idVeiculoGerenciado'] = $user_data["modelo_contratacao"];
                    echo "<tr><td> NUM ORCAMENTO API</td>";
                    echo "<td>VAL TOTAL MAO DE OBRA</td>";
                    echo "<td>VAL TOTAL PECAS API</td>";
                    echo "<td> VAL TOTAL FINAL API</td>";
                    echo "<td>".  $user_data["dias_execucao"] . "</td></tr>";
                }
            ?>
        </tbody>
    </table>
    <br><br>
    <div class="btns"> 
    <button onclick="abrirPopUp()" class="incluir-btn">Orçar</button>
    <form method="POST" action="configs_gerenciar.php">
        <button name="confirmaGerenciar">Imprimir</button>
    </form>
    <a href="../cotacoes_andamento/andamento.php"><button>Voltar</button></a>
    </div>
</body>

</html>