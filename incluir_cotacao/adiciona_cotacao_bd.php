<?php
include_once("../database/config.php");
session_start();

function adicionarValoresBD($conexao){

}

    $veiculo = $_POST['veiculo'];
    $kmAtual = $_POST['km-atual'];
    $centroCusto = $_POST['centro-custo'];
    $tipoSolicitacao = $_POST['tipo-solicitacao'];
    $planoManutencao = $_POST['plano-manutencao'];
    $modeloContratacao = $_POST['modelo-contratacao'];
    $fornecedor = $_POST['fornecedor'];
    $responsavel = $_POST['responsavel'];
    $dataAbertura = $_POST['data-abertura'];
    $dataFinal = $_POST['data-fim'];
    $modelo = $_POST['modelo'];
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $anoVeiculo = $_POST['anoVeiculo'];

    echo $dataAbertura;

    $insertValuesTable  = mysqli_query($conexao, "INSERT INTO infos_veiculos_inclusos 
    (veiculo, modelo, km_atual, ano_veiculo, plano_manutencao, modelo_contratacao, data_abertura, data_final, centro_custo, tipo_solicitacao, fornecedor, responsavel, quantidade_propostas_oficinas, placa)  
    VALUES 
    ('$veiculo', '$modelo', '$kmAtual', '$anoVeiculo', '$planoManutencao', '$modeloContratacao', '$dataAbertura', '$dataFinal', '$centroCusto', '$tipoSolicitacao', '$fornecedor', '$responsavel', '', '$placa')");

    header('Location: incluir.php');


if (isset($_POST["incluir-btn"])) {
    adicionarValoresBD($conexao);
}
?>