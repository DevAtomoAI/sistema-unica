<?php
include_once('../database/config.php');
session_start();

function applyCotacaoFilters($connectionDB) {
    $searchKeyWordInput = isset($_POST["searchKeyWordInput"]) ? $_POST["searchKeyWordInput"] : null;
    $searchInstitutionInput = $_POST["searchInstitutionInput"] ;
    $orderByInput = isset($_POST["orderByInput"]) ? $_POST["orderByInput"] : null;

    // echo 'vazio?', $searchInstitutionInput;

    $whereClause = "orcamento_aprovada_reprovada_oficina != '' ";
    if (!empty($searchKeyWordInput)) {
        $whereClause .= " AND (id_infos_veiculos_inclusos LIKE '%$searchKeyWordInput%' OR veiculo LIKE '%$searchKeyWordInput%' 
        OR tipo_solicitacao LIKE '%$searchKeyWordInput%')";
    }
    if (!empty($searchInstitutionInput)) {
        $whereClause .= " AND centro_custo='$searchInstitutionInput'";
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
    $_SESSION['filtrosPesquisa'] = $selectTable;
    header('Location: respondidas.php');
}


if(isset($_POST['searchValuesOnGoing'])){
    applyCotacaoFilters($connectionDB);
}





?>