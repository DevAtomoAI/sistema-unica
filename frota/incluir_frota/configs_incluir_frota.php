<?php
include_once("../../database/config.php");
session_start();
$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

function adicionaValoresFrotas($conexao, $idOrgaoPublicoLogado)
{

    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $renavam = $_POST['renavam'];
    $anoFabricacao = $_POST['ano'];
    $planoManutencao = $_POST['plano-manutencao'];
    $orgaoSolicitante = $_POST['orgao'];
    $combustivel = $_POST['combustivel'];
    $estado = $_POST['estado'];
    $chassi = $_POST['chassi'];
    $marca = $_POST['marca'];
    $centroCusto = $_POST['centro-custo'];
    $anoModelo = $_POST['ano-modelo'];

    $sql = "INSERT INTO dados_frotas (id_orgao_publico, placa, renavam, modelo, ano_fabricacao, categoria, combustivel, orgao_solicitante, estado, chassi, centro_custo, marca, ano_modelo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param(
        "issssssssssss",
        $idOrgaoPublicoLogado,
        $placa,
        $renavam,
        $modelo,
        $anoFabricacao,
        $planoManutencao,
        $combustivel,
        $orgaoSolicitante,
        $estado,
        $chassi,
        $centroCusto,
        $marca,
        $anoModelo
    );

    // Executando a consulta
    $stmt->execute();

    // Fechando a conexão
    $stmt->close();
    $conexao->close();
}


if (isset($_POST['confirmar-btn'])) {
    echo "funcionou";
    adicionaValoresFrotas($conexao, $idOrgaoPublicoLogado);
    header('Location: ../frota.php');
}
