<?php
session_start();
include_once("../database/config.php");

function acaoBotoes($conexao)
{
    if (isset($_POST["button-option-aproved"])) {
        $idVeiculoEscolhido = $_POST["button-option-aproved"];
        $_SESSION['idVeiculoEscolhido'] = $idVeiculoEscolhido;
        header("Location: ../gerenciar_cotacoes/configs_gerenciar.php");
    }

    if(isset($_POST["button-option-rejected"])){
        $idVeiculoEscolhidoCancelado = $_POST["button-option-rejected"];
        $atualizaInfosVeiculos = mysqli_query($conexao, "UPDATE infos_veiculos_inclusos SET 
                                 opcao_aprovada_reprovada_oficina = 'Cancelada'
                                 WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhidoCancelado'");
        header('Location: andamento.php');
    }
}
acaoBotoes($conexao);
function filters() {
    global $conexao; // Assegure-se de que a conexão com o banco de dados esteja disponível
    $selectTable = "";

    // Capturar os valores das entradas
    $searchKeyWordInput = isset($_POST["palavra-chave"]) ? mysqli_real_escape_string($conexao, $_POST["palavra-chave"]) : null;
    $searchInstitutionInput = isset($_POST["centro-custo"]) ? mysqli_real_escape_string($conexao, $_POST["centro-custo"]) : null;
    $orderByInput = isset($_POST["ordenar-por"]) ? mysqli_real_escape_string($conexao, $_POST["ordenar-por"]) : null;
    $idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

    echo $searchKeyWordInput;

    // Usar switch para decidir qual consulta executar
    switch (true) {
        case !empty($searchKeyWordInput):
            $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE 
                (orcamento_aprovada_reprovada_oficina='' OR orcamento_aprovada_reprovada_oficina='Respondida') 
                AND id_orgao_publico = '$idOrgaoPublicoLogado' 
                AND (veiculo LIKE '%$searchKeyWordInput%' OR
                modelo_contratacao LIKE '%$searchKeyWordInput%' OR 
                tipo_solicitacao LIKE '%$searchKeyWordInput%' OR 
                data_abertura LIKE '%$searchKeyWordInput%')";
            break;

        case !empty($searchInstitutionInput):
            $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE 
                id_infos_veiculos_inclusos='$searchInstitutionInput' 
                AND (orcamento_aprovada_reprovada_oficina='' OR orcamento_aprovada_reprovada_oficina='Respondida') 
                AND id_orgao_publico = '$idOrgaoPublicoLogado'";
            break;

        case !empty($orderByInput):
            switch ($orderByInput) {
                case "numero_veiculo_decrescente":
                    $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE 
                        (orcamento_aprovada_reprovada_oficina='' OR orcamento_aprovada_reprovada_oficina='Respondida') 
                        AND id_orgao_publico = '$idOrgaoPublicoLogado' 
                        ORDER BY id_infos_veiculos_inclusos DESC";
                    break;

                case "numero_veiculo_crescente":
                    $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE 
                        (orcamento_aprovada_reprovada_oficina='' OR orcamento_aprovada_reprovada_oficina='Respondida') 
                        AND id_orgao_publico = '$idOrgaoPublicoLogado' 
                        ORDER BY id_infos_veiculos_inclusos ASC";
                    break;

                default:
                    $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE 
                        (orcamento_aprovada_reprovada_oficina='' OR orcamento_aprovada_reprovada_oficina='Respondida') 
                        AND id_orgao_publico = '$idOrgaoPublicoLogado' 
                        ORDER BY $orderByInput ASC";
                    break;
            }
            break;

        default:
            $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE 
                (orcamento_aprovada_reprovada_oficina='' OR orcamento_aprovada_reprovada_oficina='Respondida') 
                AND id_orgao_publico = '$idOrgaoPublicoLogado'";
            break;
    }

    $_SESSION['filtrosPesquisa'] = $selectTable;

    return $selectTable;
}


if (isset($_POST["palavra-chave"]) || isset($_POST["centro-custo"]) || isset($_POST["ordenar-por"])) {
    filters();
    header('Location: andamento.php');
}
