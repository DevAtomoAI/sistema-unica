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

$valores = [
    'responsavelAtual' => $_SESSION['responsavelAtual'],
    'fornecedor' => $_SESSION['fornecedor'],
    'veiculo' => $_SESSION['veiculo'],
    'placa' => $_SESSION['placa'],
    'centroCusto' => $_SESSION['centroCusto'],
    'kmAtual' => intval($_SESSION['kmAtual']),
    'modelo' => $_SESSION['modeloContratacao'],
    'tipoSolicitacao' => $_SESSION['tipoSolicitacao'],
    'planoManutencao' => $_SESSION['planoManutencao'],
    'modeloContratacao' => $_SESSION['modeloContratacao'],
    'dataAbertura' => $_SESSION['dataAbertura'],
    'dataFinal' => $_SESSION['dataFinal']
];

$idOrgaoPublicoVeiculo = $_SESSION['idOrgaoPublico'];

$selectInfosVeiculosCotadoOficina = "SELECT * FROM infos_veiculos_inclusos WHERE id_orgao_publico = ? AND opcao_aprovada_reprovada_oficina= 'Respondida' AND id_infos_veiculos_inclusos = ?";
$stmt = $conexao->prepare($selectInfosVeiculosCotadoOficina);
$stmt->bind_param("ii", $idOrgaoPublicoVeiculo, $idVeiculoEscolhido);
$stmt->execute();
$execConnectionInfosVeiculosCotadoOficina = $stmt->get_result();
$orgaoPublicoCotado = $execConnectionInfosVeiculosCotadoOficina->fetch_assoc();

$id = $orgaoPublicoCotado['id_infos_veiculos_inclusos'] ?? null;

if (!empty($id)) {
    $selectOrgaoPublicoCotado = "SELECT * FROM infos_veiculos_aprovados_oficina WHERE id_veiculo_incluso_orgao_publico = ?";
    $stmt = $conexao->prepare($selectOrgaoPublicoCotado);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $execConnectionOrgaoPublicoCotado = $stmt->get_result();
}

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
                <div class="input-group">
                    <label for="responsavelAtual">Responsável Atual</label>
                    <input type="text" name="responsavelAtual" id="responsavelAtual" value="<?= $valores['responsavelAtual']; ?>" placeholder="Responsável Atual">
                </div>

                <div class="input-group">
                    <label for="fornecedor">Fornecedor</label>
                    <input type="text" name="fornecedor" id="fornecedor" value="<?= $valores['fornecedor']; ?>" placeholder="Fornecedor">
                </div>

                <div class="input-group">
                    <label for="veiculo">Veículo</label>
                    <input type="text" name="veiculo" id="veiculo" value="<?= $valores['veiculo']; ?>" placeholder="Veículo">
                </div>

                <div class="input-group">
                    <label for="placa">Placa</label>
                    <input type="text" name="placa" id="placa" value="<?= $valores['placa']; ?>" placeholder="Placa">
                </div>

                <div class="input-group">
                    <label for="centroCusto">Centro de Custo</label>
                    <input type="text" name="centroCusto" id="centroCusto" value="<?= $valores['centroCusto']; ?>" placeholder="Centro de Custo">
                </div>

                <div class="input-group">
                    <label for="kmAtual">Km Atual</label>
                    <input type="text" name="kmAtual" id="kmAtual" value="<?= $valores['kmAtual']; ?>" placeholder="Km Atual">
                </div>

                <div class="input-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" id="modelo" value="<?= $valores['modelo']; ?>" placeholder="Modelo">
                </div>

                <div class="input-group">
                    <label for="tipoSolicitacao">Tipo de Solicitação</label>
                    <select name="tipoSolicitacao" id="tipoSolicitacao">
                        <option value="Aquisição de Óleos Lubrificantes e Filtros">Aquisição de Óleos Lubrificantes e Filtros</option>
                        <option value="Aquisição de Peças">Aquisição de Peças</option>
                        <option value="Aquisição de Peças + Serviços">Aquisição de Peças + Serviços</option>
                        <option value="Aquisição de Pneus">Aquisição de Pneus</option>
                        <option value="Serviço de Borracharia">Serviço de Borracharia</option>
                        <option value="Serviço de Diagnóstico">Serviço de Diagnóstico</option>
                        <option value="Serviço de Elétrica">Serviço de Elétrica</option>
                        <option value="Serviço de Funilaria e Pintura">Serviço de Funilaria e Pintura</option>
                        <option value="Serviço de Guincho">Serviço de Guincho</option>
                        <option value="Serviço de Para-brisas">Serviço de Para-brisas</option>
                        <option value="Serviço de Portas">Serviço de Portas</option>
                        <option value="Serviço de Radiador">Serviço de Radiador</option>
                        <option value="Serviço de Reforma de Pneus">Serviço de Reforma de Pneus</option>
                        <option value="Serviço de Solda em Geral">Serviço de Solda em Geral</option>
                        <option value="Serviço de Tapeçaria">Serviço de Tapeçaria</option>
                        <option value="Serviço de Tornearia">Serviço de Tornearia</option>
                        <option value="Serviço Geral">Serviço Geral</option>
                        <option value="Inspeção Veicular">Inspeção Veicular</option>
                        <option value="Vistoria Veicular">Vistoria Veicular</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="planoManutencao">Plano de Manutenção</label>
                    <select name="planoManutencao" id="planoManutencao">
                        <option value="Garantia">Garantia</option>
                        <option value="Corretiva">Corretiva</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="modeloContratacao">Modelo de Contratação</label>
                    <input type="text" name="modeloContratacao" id="modeloContratacao" value="<?= $valores['modeloContratacao']; ?>" placeholder="Modelo de Contratação">
                </div>

                <div class="input-group">
                    <label for="dataAbertura">Data Abertura</label>
                    <input type="date" name="dataAbertura" id="dataAbertura" value="<?= $valores['dataAbertura']; ?>">
                </div>

                <div class="input-group">
                    <label for="dataFinal">Data Final</label>
                    <input type="date" name="dataFinal" id="dataFinal" value="<?= $valores['dataFinal']; ?>">
                </div>

                <?php if (!empty($execConnectionOrgaoPublicoCotado)): ?>
                    <h3>Responder orçamentos</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome Oficina</th>
                                <th>Valor total peças</th>
                                <th>Valor total serviços</th>
                                <th>Valor total orçamento</th>
                                <th>Opção</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($cotacao = $execConnectionOrgaoPublicoCotado->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $cotacao["nome_oficina_aprovado"] ?></td>
                                    <td><?= $cotacao["valor_total_pecas"] ?></td>
                                    <td><?= $cotacao["valor_total_servicos"] ?></td>
                                    <td><?= $cotacao["valor_total_servico_pecas"] ?></td>
                                    <td>
                                        <form action="configs_responder.php" method="POST">
                                            <button name="aprovaCotacaoOficina">Aprovar</button>
                                            <input type="hidden" name="id_oficina" value="<?= $cotacao['id_oficina'] ?>">
                                        </form>
                                        <form action="configs_responder.php" method="POST">
                                            <button name="reprovaCotacaoOficina">Reprovar</button>
                                            <input type="hidden" name="id_oficina" value="<?= $cotacao['id_oficina'] ?>">
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="error-message">Nenhum orçamento disponível.</p>
                <?php endif; ?>

                <button type="submit">Salvar</button>
                <button><a href="../cotacoes_andamento/andamento.php">Voltar</a></button>
            </form>
        </div>
    </div>
</body>

</html>