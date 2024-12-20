<?php
include_once('../database/config.php');
session_start();

//
function botaoOrcarRejeitar($connectionDB){
    if (isset($_POST['botaoRejeitado'])) {
        $idButton = $_POST['botaoRejeitado'];
        $status = 'Rejeitada';
        header('Location: andamento.php');
    }
     elseif (isset($_POST['botaoGerenciar'])) {
        $idVeiculoGerenciar = $_POST['botaoGerenciar'];
        $_SESSION['idVeiculoGerenciar'] = $idVeiculoGerenciar;
        header('Location: ../gerenciar_veiculo/configs_gerenciar.php');
        exit();
    } 
    else {
        return;
    }

    // Usando prepared statements para evitar sql injection
    $stmt = $connectionDB->prepare("UPDATE infos_veiculos_inclusos SET opcao_aprovada_reprovada_oficina=? WHERE id_infos_veiculos_inclusos=? ");
    $stmt->bind_param("si", $status, $idButton); // 'si' indica string e inteiro

    try {
        $stmt->execute();
        // header('Location: ../index.php');
        exit;
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function applyCotacaoFilters($connectionDB) {
    $searchKeyWordInput = isset($_POST["searchKeyWordInput"]) ? $_POST["searchKeyWordInput"] : null;
    $searchInstitutionInput = isset($_POST["searchInstitutionInput"]) ? $_POST["searchInstitutionInput"] : null;
    $orderByInput = isset($_POST["orderByInput"]) ? $_POST["orderByInput"] : null;

    $whereClause = "opcao_aprovada_reprovada_oficina=' '";
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
    $_SESSION['filtrosPesquisaEmAndamento'] = $selectTable;
    header('Location: andamento.php');
}

botaoOrcarRejeitar($connectionDB);

if(isset($_POST['pesquisaValoresEmAndamento'])){
    applyCotacaoFilters($connectionDB);
}



?>