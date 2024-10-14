<?php
include_once('../database/config.php');
session_start();

//
function botaoOrcarRejeitar($connectionDB){
    if (isset($_POST['botaoOrcar'])) {
        $idButton = $_POST['botaoOrcar'];
        $status = 'Orçar';
    } else if (isset($_POST['botaoRejeitar'])) {
        $idButton = $_POST['botaoRejeitar'];
        $status = 'Rejeitar';
    } else {
        return;
    }

    // Usando prepared statements para evitar sql injection
    $stmt = $connectionDB->prepare("UPDATE cotacoes_veiculos SET opcao_orcar_rejeitar=? WHERE id_cotacoes_veiculos=?");
    $stmt->bind_param("si", $status, $idButton); // 'si' indica string e inteiro

    try {
        $stmt->execute();
        header('Location: ../index.php');
        exit;
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function applyCotacaoFilters($connectionDB) {
    $searchKeyWordInput = isset($_POST["searchKeyWordInput"]) ? $_POST["searchKeyWordInput"] : null;
    $searchInstitutionInput = isset($_POST["searchInstitutionInput"]) ? $_POST["searchInstitutionInput"] : null;
    $orderByInput = isset($_POST["orderByInput"]) ? $_POST["orderByInput"] : null;

    $whereClause = "opcao_orcar_rejeitar=''";
    if (!empty($searchKeyWordInput)) {
        $whereClause .= " AND (numero_veiculo LIKE '%$searchKeyWordInput%' OR placa_veiculo LIKE '%$searchKeyWordInput%' OR marca_veiculo LIKE '%$searchKeyWordInput%' 
        OR modelo_veiculo LIKE '%$searchKeyWordInput%' OR tipo_solicitacao LIKE '%$searchKeyWordInput%' OR ano_veiculo LIKE '%$searchKeyWordInput%')";
    }
    if (!empty($searchInstitutionInput)) {
        $whereClause .= " AND id_cotacoes_veiculos='$searchInstitutionInput'";
    }

    $orderByClause = "";
    if (!empty($orderByInput)) {
        switch ($orderByInput) {
            case "numero_veiculo_decrescente":
                $orderByClause = "ORDER BY numero_veiculo DESC";
                break;
            case "numero_veiculo_crescente":
                $orderByClause = "ORDER BY numero_veiculo ASC";
                break;
            default:
                $orderByClause = "ORDER BY $orderByInput ASC";
                break;
        }
    }

    $selectTable = "SELECT * FROM cotacoes_veiculos WHERE $whereClause $orderByClause";
    $_SESSION['filtrosPesquisa'] = $selectTable;
    header('Location: ../index.php');
}

botaoOrcarRejeitar($connectionDB);
applyCotacaoFilters($connectionDB);




?>