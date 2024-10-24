<?php
session_start();
include_once("../database/config.php");

function filters()
{
    $selectTableAprovadas = "";

    // Verifique se uma das entradas foi enviada
    if (isset($_POST["palavra-chave"]) || isset($_POST["centro-custo"]) || isset($_POST["ordenar-por"])) {

        // Capturar os valores das entradas
        $searchKeyWordInput = isset($_POST["palavra-chave"]) ? $_POST["palavra-chave"] : null;
        $searchInstitutionInput = isset($_POST["centro-custo"]) ? $_POST["centro-custo"] : null;
        $orderByInput = isset($_POST["ordenar-por"]) ? $_POST["ordenar-por"] : null;
        $idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

        // Usar switch para decidir qual consulta executar
        switch (true) {
            case !empty($searchKeyWordInput):
                $searchKeyWordInput = "%{$searchKeyWordInput}%";
                $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos 
                                        WHERE opcao_aprovada_reprovada_oficina = 'Aprovada' 
                                        AND id_orgao_publico = :idOrgaoPublico 
                                        AND (placa LIKE :searchKeyWordInput 
                                            OR modelo_contratacao LIKE :searchKeyWordInput 
                                            OR tipo_solicitacao LIKE :searchKeyWordInput 
                                            OR DATE_FORMAT(data_abertura, '%Y-%m-%d') = :searchKeyWordInput
                                            OR DATE_FORMAT(data_final, '%Y-%m-%d') = :searchKeyWordInput
                                        )
                                    ";
                break;

            case !empty($searchInstitutionInput):
                $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE id='$searchInstitutionInput' AND opcao_aprovada_reprovada_oficina='Respondida' AND id_orgao_publico='$idOrgaoPublicoLogado'";
                break;

            case !empty($orderByInput):
                switch ($orderByInput) {
                    case "numero_veiculo_decrescente":
                        $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Aprovada' AND id_orgao_publico='$idOrgaoPublicoLogado' ORDER BY id_infos_veiculos_inclusos DESC";
                        break;

                    case "numero_veiculo_crescente":
                        $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Aprovada' AND id_orgao_publico='$idOrgaoPublicoLogado' ORDER BY id_infos_veiculos_inclusos ASC";
                        break;

                    default:
                        $selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Aprovada' AND id_orgao_publico='$idOrgaoPublicoLogado' ORDER BY $orderByInput ASC";
                        break;
                }
                break;
        }
    }

    $_SESSION['filtrosPesquisaAprovada'] = $selectTableAprovadas;

    return $selectTableAprovadas;
}

filters();
header('Location: aprovado.php');
