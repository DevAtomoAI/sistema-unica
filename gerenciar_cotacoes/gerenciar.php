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
                <button name='atualizaValoresBD'>Enviar</button>
                <button><a href="../cotacoes_andamento/andamento.php">Voltar</a></button>
            </form>
        </div>
    </div>
</body>
</html>
