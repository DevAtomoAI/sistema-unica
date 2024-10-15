<?php
session_start();
include_once("../database/config.php");

function acaoBotoes($conexao)
{
    if (isset($_POST["button-option-aproved"])) {
        $idBotao = $_POST["button-option-aproved"];
        $selectTable = "UPDATE cotacoes_em_andamento SET opcao_aprovada_rejeitada='Aprovada' WHERE id='$idBotao'";
        $execConnection = $conexao->query($selectTable);
    } else {
        $idBotao = $_POST["button-option-rejected"];
        $selectTable = "UPDATE cotacoes_em_andamento SET opcao_aprovada_rejeitada='Rejeitada' WHERE id='$idBotao'";
        $execConnection = $conexao->query($selectTable);
    }

    return $execConnection;
}
acaoBotoes($conexao);

function filters()
{
    $selectTable = "";

    // Verifique se uma das entradas foi enviada
    if (isset($_POST["palavra-chave"]) || isset($_POST["centro-custo"]) || isset($_POST["ordenar-por"])) {

        // Capturar os valores das entradas
        $searchKeyWordInput = isset($_POST["palavra-chave"]) ? $_POST["palavra-chave"] : null;
        $searchInstitutionInput = isset($_POST["centro-custo"]) ? $_POST["centro-custo"] : null;
        $orderByInput = isset($_POST["ordenar-por"]) ? $_POST["ordenar-por"] : null;

        // Usar switch para decidir qual consulta executar
        switch (true) {
            case !empty($searchKeyWordInput):
                $selectTable = "SELECT * FROM cotacoes_em_andamento WHERE 
                opcao_aprovada_rejeitada='' AND 
                (placa LIKE '%$searchKeyWordInput%' OR  
                modelo_contratacao LIKE '%$searchKeyWordInput%' OR 
                tipo_solicitacao LIKE '%$searchKeyWordInput%' OR 
                data_abertura LIKE '%$searchKeyWordInput%')";
                break;

            case !empty($searchInstitutionInput):
                $selectTable = "SELECT * FROM cotacoes_em_andamento WHERE id='$searchInstitutionInput' AND opcao_aprovada_rejeitada=''";
                break;

            case !empty($orderByInput):
                switch ($orderByInput) {
                    case "numero_veiculo_decrescente":
                        $selectTable = "SELECT * FROM cotacoes_em_andamento WHERE opcao_aprovada_rejeitada='' ORDER BY id DESC";
                        break;

                    case "numero_veiculo_crescente":
                        $selectTable = "SELECT * FROM cotacoes_em_andamento WHERE opcao_aprovada_rejeitada='' ORDER BY id ASC";
                        break;

                    default:
                        $selectTable = "SELECT * FROM cotacoes_em_andamento WHERE opcao_aprovada_rejeitada='' ORDER BY $orderByInput ASC";
                        break;
                }
                break;
        }
    }

    $_SESSION['filtrosPesquisa'] = $selectTable;

    return $selectTable;
}

filters();
header('Location: andamento.php');


