<?php
session_start();
include_once("database/config.php");

$searchKeyWordInput = $_POST["searchKeyWordInput"];
$searchOpenInput = $_POST["searchOpenInput"];
$searchCloseInput = $_POST["searchCloseInput"];
$searchInstitutionInput = $_POST["searchInstitutionInput"];
$orderByInput = $_POST["orderByInput"];

//primeira: pela palavra chave

// Inicializar a variável para a consulta
$selectTable = "";

// Verifique se uma das entradas foi enviada
if (isset($_POST["searchKeyWordInput"]) || isset($_POST["searchInstitutionInput"]) || isset($_POST["orderByInput"])) {
    
    // Capturar os valores das entradas
    $searchKeyWordInput = isset($_POST["searchKeyWordInput"]) ? $_POST["searchKeyWordInput"] : null;
    $searchInstitutionInput = isset($_POST["searchInstitutionInput"]) ? $_POST["searchInstitutionInput"] : null;
    $orderByInput = isset($_POST["orderByInput"]) ? $_POST["orderByInput"] : null;

    // Usar switch para decidir qual consulta executar
    switch (true) {
        case !empty($searchKeyWordInput):
            $selectTable = "SELECT * FROM cotacoes_veiculos WHERE 
                opcao_orcar_rejeitar='' AND 
                (numero_veiculo LIKE '%$searchKeyWordInput%' OR 
                placa_veiculo LIKE '%$searchKeyWordInput%' OR 
                marca_veiculo LIKE '%$searchKeyWordInput%' OR 
                modelo_veiculo LIKE '%$searchKeyWordInput%' OR 
                tipo_solicitacao LIKE '%$searchKeyWordInput%' OR 
                ano_veiculo LIKE '%$searchKeyWordInput%')";
            break;

        case !empty($searchInstitutionInput):
            $selectTable = "SELECT * FROM cotacoes_veiculos WHERE id_cotacoes_veiculos='$searchInstitutionInput' AND opcao_orcar_rejeitar=''";
            break;

        case !empty($orderByInput):
            switch ($orderByInput) {
                case "numero_veiculo_decrescente":
                    $selectTable = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar='' ORDER BY numero_veiculo DESC";
                    break;

                case "numero_veiculo_crescente":
                    $selectTable = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar='' ORDER BY numero_veiculo ASC";
                    break;

                default:
                    $selectTable = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar='' ORDER BY $orderByInput ASC";
                    break;
            }
            break;
    }
}

$_SESSION['filtrosPesquisa'] = $selectTable;
header('Location: ../index.php');


?>