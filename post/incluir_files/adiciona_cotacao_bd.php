<?php
include_once("../database/config.php");
session_start();

if (isset($_POST["incluir-btn"])) {
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
    $propostas = $_POST['propostas'];
    $placa = $_POST['placa'];

    $insertValuesTable  = mysqli_query($conexao, "INSERT INTO cotacoes_em_andamento (veiculo, km_atual, plano_manutencao, modelo_contratacao, data_abertura, data_final,
    centro_custo, tipo_solicitacao, fornecedor, responsavel, propostas, placa)  
    VALUES ('$veiculo', '$kmAtual' ,'$planoManutencao', '$modeloContratacao', '$dataAbertura', '$dataFinal', '$centroCusto', '$tipoSolicitacao', '$fornecedor', '$responsavel',
    '$propostas', '$placa')");

    header('Location: incluir.php');
}
?>