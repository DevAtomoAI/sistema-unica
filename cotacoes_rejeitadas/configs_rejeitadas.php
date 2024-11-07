<?php
include_once('../database/config.php');
session_start();


function applyCotacaoFilters($connectionDB) {
    $searchKeyWordInput = isset($_POST["searchKeyWordInput"]) ? $_POST["searchKeyWordInput"] : null;
    $searchInstitutionInput = isset($_POST["searchInstitutionInput"]) ? $_POST["searchInstitutionInput"] : null;
    $orderByInput = isset($_POST["orderByInput"]) ? $_POST["orderByInput"] : null;

    $whereClause = "orcamento_aprovado_reprovado='Rejeitado' ";
    if (!empty($searchKeyWordInput)) {
        $whereClause .= " AND (id_veiculo_gerenciado LIKE '%$searchKeyWordInput%' OR veiculo LIKE '%$searchKeyWordInput%' 
        OR modelo_veiculo LIKE '%$searchKeyWordInput%' OR tipo_solicitacao LIKE '%$searchKeyWordInput%')";
    }
    if (!empty($searchInstitutionInput)) {
        $whereClause .= " AND id_veiculo_gerenciado='$searchInstitutionInput'";
    }

    $orderByClause = "";
    if (!empty($orderByInput)) {
        switch ($orderByInput) {
            case "numero_veiculo_decrescente":
                $orderByClause = "ORDER BY id_orcamentos_oficinas DESC";
                break;
            case "numero_veiculo_crescente":
                $orderByClause = "ORDER BY id_orcamentos_oficinas ASC";
                break;
            default:
                $orderByClause = "ORDER BY $orderByInput ASC";
                break;
        }
    }

    $selectTable = "SELECT * FROM orcamentos_oficinas WHERE $whereClause $orderByClause";
    $_SESSION['filtrosPesquisa'] = $selectTable;
    header('Location: rejeitadas.php');
}


if(isset($_POST['searchValuesOnGoing'])){
    applyCotacaoFilters($connectionDB);
}





?>