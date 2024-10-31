<?php
include_once("../database/config.php");
session_start();

function adicionarValoresBD($conexao){

}

    $veiculo = $_POST['veiculo'];
    $modeloVeiculo = $_POST['modeloVeiculo'];
    $kmAtual = $_POST['km-atual'];
    $centroCusto = $_POST['centro-custo'];
    $tipoSolicitacao = $_POST['tipo-solicitacao'];
    $planoManutencao = $_POST['plano-manutencao'];
    $modeloContratacao = $_POST['modelo-contratacao'];
    $fornecedor = $_POST['fornecedor'];
    $responsavel = $_POST['responsavel'];
    $dataAbertura = $_POST['data-abertura'];
    $dataFinal = $_POST['data-fim'];
    $modeloContratacao = $_POST['modelo-contratacao'];
    $placa = $_POST['placa'];
    $anoVeiculo = $_POST['anoVeiculo'];
    $justificativa = $_POST['justificativa'];
    $idOrgaoPublico = $_SESSION['idOrgaoPublico'];


    $insertValuesTable  = mysqli_query($conexao, "INSERT INTO infos_veiculos_inclusos 
    (id_orgao_publico, veiculo, modelo_veiculo, km_atual, ano_veiculo, plano_manutencao, modelo_contratacao, data_abertura, data_final, centro_custo, tipo_solicitacao, fornecedor, responsavel, placa, justificativa)  
    VALUES 
    ('$idOrgaoPublico', '$veiculo', '$modeloVeiculo', '$kmAtual', '$anoVeiculo', '$planoManutencao', '$modeloContratacao', '$dataAbertura', '$dataFinal', '$centroCusto', '$tipoSolicitacao', '$fornecedor', '$responsavel', '$placa', '$justificativa')");

    header('Location: incluir.php');


if (isset($_POST["incluir-btn"])) {
    adicionarValoresBD($conexao);
}
?>