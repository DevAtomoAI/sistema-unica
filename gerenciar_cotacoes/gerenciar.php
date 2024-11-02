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
    'placa' => $_SESSION['placa'] ?? '',
    'centroCusto' => $_SESSION['centroCusto'] ?? '',
    'kmAtual' => intval($_SESSION['kmAtual'] ?? 0),
    'modelo' => $_SESSION['modeloContratacao'] ?? '',
    'tipoSolicitacao' => $_SESSION['tipoSolicitacao'] ?? '',
    'planoManutencao' => $_SESSION['planoManutencao'] ?? '',
    'modeloContratacao' => $_SESSION['modeloContratacao'] ?? '',
    'dataAbertura' => $_SESSION['dataAbertura'] ?? '',
    'dataFinal' => $_SESSION['dataFinal'] ?? ''
];
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
                <?php foreach ($valores as $campo => $valor): ?>
                    <div class="input-group">
                        <label for="<?= htmlspecialchars($campo) ?>"><?= ucwords(str_replace('_', ' ', htmlspecialchars($campo))) ?></label>
                        <input type="text" name="<?= htmlspecialchars($campo) ?>" id="<?= htmlspecialchars($campo) ?>" value="<?= htmlspecialchars($valor) ?>" placeholder="<?= ucwords(str_replace('_', ' ', htmlspecialchars($campo))) ?>">
                    </div>
                <?php endforeach; ?>

                <div class="input-group">
                    <label for="tipoSolicitacao">Tipo de solicitação</label>
                    <select name="tipoSolicitacao" id="tipoSolicitacao">
                        <option value="Aquisição de Óleos Lubrificantes e Filtros" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Aquisição de Óleos Lubrificantes e Filtros") ? 'selected' : '' ?>>Aquisição de Óleos Lubrificantes e Filtros</option>
                        <option value="Aquisição de Peças" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Aquisição de Peças") ? 'selected' : '' ?>>Aquisição de Peças</option>
                        <option value="Aquisição de Peças + Serviços" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Aquisição de Peças + Serviços") ? 'selected' : '' ?>>Aquisição de Peças + Serviços</option>
                        <option value="Aquisição de Pneus" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Aquisição de Pneus") ? 'selected' : '' ?>>Aquisição de Pneus</option>
                        <option value="Serviço de Borracharia" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Borracharia") ? 'selected' : '' ?>>Serviço de Borracharia</option>
                        <option value="Serviço de Diagnóstico" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Diagnóstico") ? 'selected' : '' ?>>Serviço de Diagnóstico</option>
                        <option value="Serviço de Elétrica" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Elétrica") ? 'selected' : '' ?>>Serviço de Elétrica</option>
                        <option value="Serviço de Funilaria e Pintura" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Funilaria e Pintura") ? 'selected' : '' ?>>Serviço de Funilaria e Pintura</option>
                        <option value="Serviço de Guincho" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Guincho") ? 'selected' : '' ?>>Serviço de Guincho</option>
                        <option value="Serviço de Para-brisas" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Para-brisas") ? 'selected' : '' ?>>Serviço de Para-brisas</option>
                        <option value="Serviço de Portas" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Portas") ? 'selected' : '' ?>>Serviço de Portas</option>
                        <option value="Serviço de Radiador" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Radiador") ? 'selected' : '' ?>>Serviço de Radiador</option>
                        <option value="Serviço de Reforma de Pneus" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Reforma de Pneus") ? 'selected' : '' ?>>Serviço de Reforma de Pneus</option>
                        <option value="Serviço de Solda em Geral" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Solda em Geral") ? 'selected' : '' ?>>Serviço de Solda em Geral</option>
                        <option value="Serviço de Tapeçaria" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Tapeçaria") ? 'selected' : '' ?>>Serviço de Tapeçaria</option>
                        <option value="Serviço de Tornearia" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço de Tornearia") ? 'selected' : '' ?>>Serviço de Tornearia</option>
                        <option value="Serviço Geral" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Serviço Geral") ? 'selected' : '' ?>>Serviço Geral</option>
                        <option value="Inspeção Veicular" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Inspeção Veicular") ? 'selected' : '' ?>>Inspeção Veicular</option>
                        <option value="Vistoria Veicular" <?= (isset($_SESSION['tipoSolicitacao']) && $_SESSION['tipoSolicitacao'] === "Vistoria Veicular") ? 'selected' : '' ?>>Vistoria Veicular</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="planoManutencao">Plano de manutenção</label>
                    <select name="planoManutencao" id="planoManutencao">
                        <option value="Manutenção Corretiva" <?= (isset($_SESSION['planoManutencao']) && $_SESSION['planoManutencao'] === "Manutenção Corretiva") ? 'selected' : '' ?>>Manutenção Corretiva</option>
                        <option value="Manutenção Preventiva" <?= (isset($_SESSION['planoManutencao']) && $_SESSION['planoManutencao'] === "Manutenção Preventiva") ? 'selected' : '' ?>>Manutenção Preventiva</option>
                        <option value="Manutenção Preditiva" <?= (isset($_SESSION['planoManutencao']) && $_SESSION['planoManutencao'] === "Manutenção Preditiva") ? 'selected' : '' ?>>Manutenção Preditiva</option>
                    </select>
                </div>

        </div>

        <div class="section">
            <h3 class="section-title">Cotações Respondidas</h3>
            <table>
                <thead>
                    <tr>
                        <th>Oficina</th>
                        <th>Valor Total Peças</th>
                        <th>Valor Total Serviços</th>
                        <th>Valor Total Final</th>
                        <th>Dias execucao</th>
                        <th>Opcoes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $selectOrgaoPublicoCotado = "SELECT * FROM infos_veiculos_aprovados_oficina WHERE id_veiculo_incluso_orgao_publico = ? 
                    AND orcamento_aprovado_reprovado != 'Aprovada' AND orcamento_aprovado_reprovado != 'Cancelada' AND id_orgao_publico=?";
                    $stmt = $conexao->prepare($selectOrgaoPublicoCotado);
                    $stmt->bind_param("ii", $idVeiculoEscolhido, $idOrgaoPublicoLogado);
                    $stmt->execute();
                    $execConnectionOrgaoPublicoCotado = $stmt->get_result(); // Isso deve retornar um objeto de resultado.

                    // Verifique se a consulta retornou resultados
                    if ($execConnectionOrgaoPublicoCotado && $execConnectionOrgaoPublicoCotado->num_rows > 0) {
                        // Enquanto houver resultados, exiba-os
                        while ($row = $execConnectionOrgaoPublicoCotado->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['nome_oficina_aprovado']) . '</td>';
                            echo '<td>R$ ' . number_format($row['valor_total_final_pecas'], 2, ',', '.') . '</td>';
                            echo '<td>' . htmlspecialchars($row['valor_total_servicos']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['valor_total_final']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['dias_execucao']) . '</td>';
                            echo '<td>
                                    <button name="aprovaCotacaoOficina" value='.$row['id_veiculo_aprovado_oficina'].'> Aprovar </button>
                                    <button name="cancelaCotacaoOficina" value='.$row['id_veiculo_aprovado_oficina'].'> Cancelar </button>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        // Caso não haja resultados
                        echo '<tr><td colspan="4">Nenhuma cotação respondida encontrada.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <button name='atualizaValoresBD'>Enviar</button>
            <button><a href="../cotacoes_andamento/andamento.php">Voltar</a></button>
            </form>

        </div>
    </div>

</body>

</html>