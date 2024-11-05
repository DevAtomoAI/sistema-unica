<?php
include_once("../database/config.php");
session_start();

function checkUserLoggedIn()
{
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: ../index.php');
        exit;
    }
}

checkUserLoggedIn();

$usuarioLogado = $_SESSION['nameLoggedUser'];
$idVeiculoEscolhido = $_SESSION['idVeiculoEscolhido'];
$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

// Prepara os valores para exibição no formulário
$valores = [
    'responsavelAtual' => $_SESSION['responsavelAtual'] ?? '',
    'fornecedor' => $_SESSION['fornecedor'] ?? '',
    'veiculo' => $_SESSION['veiculo'] ?? '',
    'centroCusto' => $_SESSION['centroCusto'] ?? '',
    'kmAtual' => intval($_SESSION['kmAtual'] ?? 0),
    'modeloContratacao' => $_SESSION['modeloContratacao'] ?? '',
    'tipoSolicitacao' => $_SESSION['tipoSolicitacao'] ?? '',
    'planoManutencao' => $_SESSION['planoManutencao'] ?? '',
    'dataAbertura' => $_SESSION['dataAbertura'] ?? '',
    'dataFinal' => $_SESSION['dataFinal'] ?? ''
];

// Consulta para buscar fornecedores que já estão associados ao veículo
$fornecedoresAtribuidos = [];
$queryFornecedoresAtribuidos = "SELECT nome FROM dados_fornecedores WHERE id_orgao_publico='$idOrgaoPublicoLogado' AND nome IN (
    SELECT fornecedor FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhido'
)";
$resultAtribuidos = $conexao->query($queryFornecedoresAtribuidos);
while ($row = mysqli_fetch_assoc($resultAtribuidos)) {
    $fornecedoresAtribuidos[] = $row['nome'];
}

// Consulta para buscar centros de custo que já estão associados ao veículo
$centrosCustoAtribuidos = [];
$queryCentrosCustoAtribuidos = "SELECT nome FROM centros_custos WHERE id_orgao_publico='$idOrgaoPublicoLogado' AND nome IN (
    SELECT centro_custo FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhido'
)";
$resultCentrosCustoAtribuidos = $conexao->query($queryCentrosCustoAtribuidos);
while ($row = mysqli_fetch_assoc($resultCentrosCustoAtribuidos)) {
    $centrosCustoAtribuidos[] = $row['nome'];
}
// Consulta para buscar todos os fornecedores
$selectFornecedores = "SELECT nome FROM dados_fornecedores WHERE id_orgao_publico='$idOrgaoPublicoLogado'";
$execConnectionFornecedores = $conexao->query($selectFornecedores);

// Consulta para buscar todos os centros de custo
$selectCentrosCusto = "SELECT nome FROM centros_custos WHERE id_orgao_publico='$idOrgaoPublicoLogado'";
$execConnectionCentrosCusto = $conexao->query($selectCentrosCusto);

$selectOrcamentosVeiculoEscolhido = "SELECT nome_oficina, valor_un_pecas, valor_orcado_servicos FROM orcamentos_oficinas WHERE id_orgao_publico='$idOrgaoPublicoLogado' 
AND id_veiculo_gerenciado='$idVeiculoEscolhido' AND orcamento_aprovado_reprovado=' '";
$execConnectionOrcamentos = $conexao->query($selectOrcamentosVeiculoEscolhido);

$selectInfosCotacaoOP = "SELECT numero_orcamento, valor_total_final, dias_execucao FROM infos_cotacao_orgao WHERE id_orgao_publico='$idOrgaoPublicoLogado' AND id_veiculo_incluso_orgao_publico='$idVeiculoEscolhido'";
$execConnectionInfosCotacaoOP = $conexao->query($selectInfosCotacaoOP);
$user_data2 = mysqli_fetch_assoc($execConnectionInfosCotacaoOP);
$numOrcamento = $user_data2["numero_orcamento"];
$valTotalFinal = $user_data2["valor_total_final"];
$diasExec = $user_data2["dias_execucao"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar</title>
    <link rel="stylesheet" href="gerenciar.css">
</head>

<body>
    <div class="container">
        <div class="section">
            <h3 class="section-title">Área Administrativa</h3>
            <form action="configs_gerenciar.php" method="POST" class="form">
                <label for="responsavelAtual">Responsável</label>
                <input type="text" name='responsavelAtual' value="<?= $valores['responsavelAtual'] ?>">
                <br>
                <label for="fornecedor">Fornecedor</label>
                <select name="fornecedor">
                    <?php
                    while ($user_data = mysqli_fetch_assoc($execConnectionFornecedores)) {
                        $nome = $user_data['nome'];
                        $selected = in_array($nome, $fornecedoresAtribuidos) ? "selected" : "";
                        echo "<option value='$nome' $selected>$nome</option>";
                    }
                    ?>
                </select>
                <br>
                <label for="veiculo">Veiculo</label>
                <input type="text" name='veiculo' value="<?= $valores['veiculo'] ?>">
                <br>
                <label for="centroCusto">Centro custo</label>
                <select name="centroCusto">
                    <?php
                    while ($user_data = mysqli_fetch_assoc($execConnectionCentrosCusto)) {
                        $nome = $user_data['nome'];
                        $selected = in_array($nome, $centrosCustoAtribuidos) ? "selected" : "";
                        echo "<option value='$nome' $selected>$nome</option>";
                    }
                    ?>
                </select>
                <br>
                <label for="kmAtual">Km Atual</label>
                <input type="text" name='kmAtual' value="<?= $valores['kmAtual'] ?>">
                <br>
                <label for="modeloContratacao">Modelo Contratação</label>
                <input type="text" name='modeloContratacao' value="<?= $valores['modeloContratacao'] ?>">
                <br>
                <label for="tipoSolicitacao">Tipo Solicitação</label>
                <input type="text" name='tipoSolicitacao' value="<?= $valores['tipoSolicitacao'] ?>">
                <br>
                <label for="planoManutencao">Plano manutenção</label>
                <input type="text" name='planoManutencao' value="<?= $valores['planoManutencao'] ?>">
                <br>
                <label for="dataAbertura">Data abertura</label>
                <input type="date" name='dataAbertura' value="<?= $valores['dataAbertura'] ?>">
                <br>
                <label for="dataFinal">Data final</label>
                <input type="date" name='dataFinal' value="<?= $valores['dataFinal'] ?>">
                <br>
                <br>
                <h1>Orçamentos</h1>
                <table>
                    <table>
                        <thead>
                            <tr>
                                <?php
                                if ($execConnectionOrcamentos && mysqli_num_rows($execConnectionOrcamentos) > 0) {
                                    echo "<th>Numero orcamento</th>
                                    <th>Nome Oficina</th>
                                    <th>Valor unitario pecas</th>
                                    <th>Valor orcado servicos</th>
                                    <th>Valor total final</th>
                                    <th>Dias execucao</th>";
                                }

                                ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($execConnectionOrcamentos && mysqli_num_rows($execConnectionOrcamentos) > 0) {
                                while ($user_data = mysqli_fetch_assoc($execConnectionOrcamentos)) {
                                    echo "<tr>";
                                    echo "<td>" . $numOrcamento . "</td>";
                                    echo "<td>" . $user_data['nome_oficina'] . "</td>";
                                    echo "<td>" . $user_data['valor_un_pecas'] . "</td>";
                                    echo "<td>" . $user_data['valor_orcado_servicos'] . "</td>";
                                    echo "<td>" . $valTotalFinal . "</td>";
                                    echo "<td>" . $diasExec . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "Não existe cotações";
                            }

                            ?>
                        </tbody>
                    </table>

                    <!-- Coloque o botão "Aprovar" aqui, fora do loop e da tabela -->
                    <?php
                    if ($execConnectionOrcamentos && mysqli_num_rows($execConnectionOrcamentos) > 0) {
                        echo "<button name='aprovaOrcamentoOficina' value='$idVeiculoEscolhido'>Aprovar</button><button name='reprovaOrcamentoOficina' value='$idVeiculoEscolhido'>Reprovar</button>";
                    }

                    ?>

                    <br>
                    <br>
                    <button name='atualizaValoresBD'>Enviar</button>
                    <button><a href="../cotacoes_andamento/andamento.php">Voltar</a></button>
            </form>
        </div>
    </div>
</body>

</html>