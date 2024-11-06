<?php
include_once('../database/config.php');
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function applyCotacaoFilters($connectionDB)
{
    $searchKeyWordInput = isset($_POST["searchKeyWordInput"]) ? $_POST["searchKeyWordInput"] : null;
    $searchInstitutionInput = isset($_POST["searchInstitutionInput"]) ? $_POST["searchInstitutionInput"] : null;
    $orderByInput = isset($_POST["orderByInput"]) ? $_POST["orderByInput"] : null;

    $whereClause = "opcao_aprovada_reprovada_oficina='Aprovadas'";
    if (!empty($searchKeyWordInput)) {
        $whereClause .= " AND (id_infos_veiculos_inclusos LIKE '%$searchKeyWordInput%' OR placa LIKE '%$searchKeyWordInput%' OR veiculo LIKE '%$searchKeyWordInput%' 
        OR modelo_veiculo LIKE '%$searchKeyWordInput%' OR tipo_solicitacao LIKE '%$searchKeyWordInput%')";
    }
    if (!empty($searchInstitutionInput)) {
        $whereClause .= " AND id_infos_veiculos_inclusos='$searchInstitutionInput'";
    }

    $orderByClause = "";
    if (!empty($orderByInput)) {
        switch ($orderByInput) {
            case "numero_veiculo_decrescente":
                $orderByClause = "ORDER BY id_infos_veiculos_inclusos DESC";
                break;
            case "numero_veiculo_crescente":
                $orderByClause = "ORDER BY id_infos_veiculos_inclusos ASC";
                break;
            default:
                $orderByClause = "ORDER BY $orderByInput ASC";
                break;
        }
    }

    $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE $whereClause $orderByClause";
    $_SESSION['filtrosPesquisaAprovadas'] = $selectTable;
}

function insereFaturasBD($connectionDB)
{
    $estadoVeiculo = 'Faturada Oficina';
    $idVeiculoInclusoOrgaoPublico = $_POST['enviaFaturas'];
    $idOficinaLogada = $_SESSION['idOficinaLogada'];

    $faturaPecas = file_get_contents($_FILES['faturaPecas']['tmp_name']);
    $faturaServicos = file_get_contents($_FILES['faturaServicos']['tmp_name']);

    // Prepare o statement para atualizar as faturas
    $stmtFatura = $connectionDB->prepare("UPDATE infos_veiculos_inclusos SET fatura_pecas=?, fatura_servicos=? WHERE id_infos_veiculos_inclusos=? ");
    $stmtFatura->bind_param("ssi", $faturaPecas, $faturaServicos, $idVeiculoInclusoOrgaoPublico);

    // Prepare o statement para atualizar o estado do veículo
    $stmtEstadoVeiculo = $connectionDB->prepare("UPDATE infos_veiculos_inclusos SET orcamento_aprovada_reprovada_oficina=? WHERE id_infos_veiculos_inclusos=?");
    $stmtEstadoVeiculo->bind_param("si", $estadoVeiculo, $idVeiculoInclusoOrgaoPublico);

    // Prepare o statement para atualizar o estado do orçamento na tabela orcamentos_oficinas
    $stmtEstadoVeiculoOrcamentoOficina = $connectionDB->prepare("UPDATE orcamentos_oficinas SET orcamento_aprovado_reprovado=? WHERE id_veiculo_gerenciado=? AND id_oficina = ?");
    $stmtEstadoVeiculoOrcamentoOficina->bind_param("sii", $estadoVeiculo, $idVeiculoInclusoOrgaoPublico, $idOficinaLogada);

    // Execute as queries na ordem correta
    $stmtEstadoVeiculoOrcamentoOficina->execute();  // Atualiza o estado na tabela orcamentos_oficinas
    $stmtEstadoVeiculo->execute();  // Atualiza o estado do veículo
    $stmtFatura->execute();  // Atualiza as faturas

    // Fechar as declarações
    $stmtEstadoVeiculoOrcamentoOficina->close();
    $stmtFatura->close();
    $stmtEstadoVeiculo->close();

    // Fechar a conexão com o banco de dados
    $connectionDB->close();
}





if (isset($_POST['pesquisaValoresAprovadas'])) {
    applyCotacaoFilters($connectionDB);
    header('Location: aprovadas.php');
    exit();
}

if (isset($_POST['enviaFaturas'])) {
    insereFaturasBD($connectionDB);
    header('Location: aprovadas.php');
    exit();
}
