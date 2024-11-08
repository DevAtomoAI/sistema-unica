<?php
session_start();
include_once('../database/config.php');

$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

function filters($idOrgaoPublicoLogado)
{
    $selectTableAprovadas = "";

    // Verifique se uma das entradas foi enviada
    if (isset($_POST["palavra-chave"]) || isset($_POST["centro-custo"]) || isset($_POST["ordenar-por"])) {

        // Capturar os valores das entradas
        $searchKeyWordInput = isset($_POST["palavra-chave"]) ? $_POST["palavra-chave"] : null;
        $searchInstitutionInput = isset($_POST["centro-custo"]) ? $_POST["centro-custo"] : null;
        $orderByInput = isset($_POST["ordenar-por"]) ? $_POST["ordenar-por"] : null;
        // $idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

        // Usar switch para decidir qual consulta executar
        switch (true) {
            case !empty($searchKeyWordInput):
                $searchKeyWordInput = "%{$searchKeyWordInput}%";
                $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos 
                                        WHERE orcamento_aprovada_reprovada_oficina = 'Faturada Oficina' 
                                        AND id_orgao_publico = :idOrgaoPublico 
                                        AND (veiculo LIKE :searchKeyWordInput 
                                            OR modelo_contratacao LIKE :searchKeyWordInput 
                                            OR tipo_solicitacao LIKE :searchKeyWordInput 
                                            OR DATE_FORMAT(data_abertura, '%Y-%m-%d') = :searchKeyWordInput
                                            OR DATE_FORMAT(data_final, '%Y-%m-%d') = :searchKeyWordInput
                                        )
                                    ";
                break;

            case !empty($searchInstitutionInput):
                $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE id='$searchInstitutionInput' AND orcamento_aprovada_reprovada_oficina='Faturada Oficina' AND id_orgao_publico='$idOrgaoPublicoLogado'";
                break;

            case !empty($orderByInput):
                switch ($orderByInput) {
                    case "numero_veiculo_decrescente":
                        $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE orcamento_aprovada_reprovada_oficina='Faturada Oficina' AND id_orgao_publico='$idOrgaoPublicoLogado' ORDER BY id_infos_veiculos_inclusos DESC";
                        break;

                    case "numero_veiculo_crescente":
                        $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE orcamento_aprovada_reprovada_oficina='Faturada Oficina' AND id_orgao_publico='$idOrgaoPublicoLogado' ORDER BY id_infos_veiculos_inclusos ASC";
                        break;

                    default:
                        $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE orcamento_aprovada_reprovada_oficina='Faturada Oficina' AND id_orgao_publico='$idOrgaoPublicoLogado' ORDER BY $orderByInput ASC";
                        break;
                }
                break;
        }
    }

    $_SESSION['filtrosPesquisaFaturadas'] = $selectTableAprovadas;

    return $selectTableAprovadas;
}

function atualizaEstadoCotacaoOficina($conexao, $estadoCotacao, $idVeiculo, $idOrgaoPublicoLogado)
{   
    $orcamento_aprovado_reprovado = null;

    // Prepare e execute o SELECT
    $stmt = $conexao->prepare("SELECT orcamento_aprovado_reprovado FROM orcamentos_oficinas WHERE id_veiculo_gerenciado = ? AND id_orgao_publico = ?");
    $stmt->bind_param("ii", $idVeiculo, $idOrgaoPublicoLogado);
    $stmt->execute();
    
    // Obter o resultado do SELECT
    $stmt->bind_result($orcamento_aprovado_reprovado);
    $stmt->fetch();

    // Fechar o statement SELECT após uso
    $stmt->close();

    // Prepare e execute o primeiro UPDATE
    $dataFaturaOrgao = date('Y-m-d');
    $stmt2 = $conexao->prepare("UPDATE infos_veiculos_inclusos SET orcamento_aprovada_reprovada_oficina=?, data_faturado_orgao=? WHERE id_infos_veiculos_inclusos=? AND id_orgao_publico=?");
    $stmt2->bind_param("ssii", $estadoCotacao, $dataFaturaOrgao, $idVeiculo, $idOrgaoPublicoLogado);
    $stmt2->execute();
    $stmt2->close(); // Fechar o statement após execução

    // Prepare e execute o segundo UPDATE
    $stmt3 = $conexao->prepare("UPDATE orcamentos_oficinas SET orcamento_aprovado_reprovado=? WHERE id_veiculo_gerenciado=? AND orcamento_aprovado_reprovado=?");
    $stmt3->bind_param("sii", $estadoCotacao, $idVeiculo, $orcamento_aprovado_reprovado);
    $stmt3->execute();
    $stmt3->close(); // Fechar o statement após execução
}

function atualizaCreditoCentroCusto($conexao, $idOrgaoPublicoLogado, $idVeiculo)
{
    $centroCusto = null;
    $creditoCentroCusto = null;
    $valorTotalFinalOrcamentoFaturado = null;

    // Primeiro SELECT: Pegar centro_custo na tabela infos_veiculos_inclusos onde id_orgao_publico = $idOrgaoPublicoLogado e id_infos_veiculos_inclusos = "$idVeiculo"
    $selectNomeCentroCusto = "SELECT nome FROM centros_custos WHERE id_orgao_publico = ?";
    $stmt = $conexao->prepare($selectNomeCentroCusto);
    $stmt->bind_param("i", $idOrgaoPublicoLogado);
    $stmt->execute();
    $stmt->bind_result($centroCusto);
    $stmt->fetch();
    $stmt->close();


    // Segundo SELECT: Pegar valor_credito na tabela centros_custos onde id_orgao_publico = $idOrgaoPublicoLogado
    $selectCreditoCentroCusto = "SELECT valor_credito FROM centros_custos WHERE id_orgao_publico = ? AND nome=?";
    $stmt = $conexao->prepare($selectCreditoCentroCusto);
    $stmt->bind_param("is", $idOrgaoPublicoLogado, $centroCusto);
    $stmt->execute();
    $stmt->bind_result($creditoCentroCusto);
    $stmt->fetch();
    $stmt->close();

    // Terceiro SELECT: Pegar valor_total_final na tabela infos_cotacao_orgao onde id_orgao_publico = $idOrgaoPublicoLogado e id_veiculo_incluso_orgao_publico = $idVeiculo
    $selectValorTotalFinal = "SELECT valor_total_final FROM infos_cotacao_orgao WHERE id_orgao_publico = ? AND id_veiculo_incluso_orgao_publico = ?";
    $stmt = $conexao->prepare($selectValorTotalFinal);
    $stmt->bind_param("ii", $idOrgaoPublicoLogado, $idVeiculo);
    $stmt->execute();
    $stmt->bind_result($valorTotalFinalOrcamentoFaturado);
    $stmt->fetch();
    $stmt->close();


    // // Calculando o novo crédito após a fatura
    $novoCreditoAposFatura = $creditoCentroCusto - $valorTotalFinalOrcamentoFaturado;

    // UPDATE: Atualizar a tabela centros_custos, com o valor_credito recebendo $novoCreditoAposFatura
    $updateCreditoCentroCusto = "UPDATE centros_custos SET valor_credito = ? WHERE id_orgao_publico = ?";
    $stmt = $conexao->prepare($updateCreditoCentroCusto);
    $stmt->bind_param("di", $novoCreditoAposFatura, $idOrgaoPublicoLogado);

    if ($stmt->execute()) {
        echo "Crédito atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o crédito: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_POST['faturarOrcamentoCotacao'])) {
    $idVeiculo = $_POST['faturarOrcamentoCotacao'];
    atualizaEstadoCotacaoOficina($conexao, 'Faturada Órgão Público', $idVeiculo, $idOrgaoPublicoLogado);
    atualizaCreditoCentroCusto($conexao, $idOrgaoPublicoLogado, $idVeiculo);
    header('Location: faturadas.php');
    exit();
}


filters($idOrgaoPublicoLogado);

header('Location: faturadas.php');
exit();
