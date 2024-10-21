<?php

include_once("../database/config.php");
session_start();

$usuarioLogado = $_SESSION['nameLoggedUser'];

$valores = [
    'responsavelAtual' => $_SESSION['responsavelAtual'],
    'fornecedor' => $_SESSION['fornecedor'],
    'veiculo' => $_SESSION['veiculo'],
    'placa' => $_SESSION['placa'],
    'centroCusto' => $_SESSION['centroCusto'],
    'kmAtual' => intval($_SESSION['kmAtual']),
    'modelo' => $_SESSION['modeloContratacao'],
    'tipoSolicitacao' =>  $_SESSION['tipoSolicitacao'],
    'planoManutencao' => $_SESSION['planoManutencao'],
    'modeloContratacao' => $_SESSION['modeloContratacao'],
    'dataAbertura' => $_SESSION['dataAbertura'],
    'dataFinal' => $_SESSION['dataFinal'],
];

$stmt = $conexao->prepare("SELECT * FROM usuarios_orgao_publico WHERE nome = ?");
$stmt->bind_param("s", $usuarioLogado); // "s" para string
$stmt->execute();
$result = $stmt->get_result();
$valuesTable = $result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>

<body>
    <h3>Área administrativa</h3>

    <p>Empresa</p>

    <form action="configs_gerenciar.php" method="POST">
        <p>Nome do responsável atual</p>
        <input type="text" name="responsavelAtual" id="responsavelAtual" value="<?= $valores['responsavelAtual']; ?>" placeholder="Responsável atual">

        <p>Nome do fornecedor</p>
        <input type="text" name="fornecedor" id="fornecedor" value="<?= $valores['fornecedor']; ?>" placeholder="Nome do fornecedor">

        <p>Veiculo</p>
        <input type="text" name="veiculo" id="veiculo" value="<?= $valores['veiculo']; ?>" placeholder="Veiculo">

        <p>Placa</p>
        <input type="text" name="placa" id="placa" value="<?= $valores['placa']; ?>" placeholder="Placa">

        <p>Centro custo</p>
        <input type="text" name="centroCusto" id="centroCusto" value="<?= $valores['centroCusto']; ?>" placeholder="Centro custo">

        <p>Km atual</p>
        <input type="text" name="kmAtual" id="kmAtual" value="<?= $valores['kmAtual']; ?>" placeholder="Km atual">

        <p>Modelo</p>
        <input type="text" name="modelo" id="modelo" value="<?= $valores['modelo']; ?>" placeholder="Modelo">

        <p>Tipo solicitação</p>
        <input type="text" name="tipoSolicitacao" id="tipoSolicitacao" value="<?= $valores['tipoSolicitacao']; ?>" placeholder="Tipo solicitação">

        <p>Plano manutenção</p>
        <input type="text" name="planoManutencao" id="planoManutencao" value="<?= $valores['planoManutencao']; ?>" placeholder="Plano manutenção">

        <p>Modelo de contratação</p>
        <input type="text" name="modeloContratacao" id="modeloContratacao" value="<?= $valores['modeloContratacao']; ?>" placeholder="Modelo de contratação">

        <p>Data abertura</p>
        <input type="date" name="dataAbertura" id="dataAbertura" value="<?= $valores['dataAbertura']; ?>" placeholder="Data abertura">

        <p>Data Final</p>
        <input type="date" name="dataFinal" id="dataFinal" value="<?= $valores['dataFinal']; ?>" placeholder="Data final">

        <br><br><br><br><br>


        <h3>Proprietário</h3>

        <p>CPF / CNPJ</p>
        <input type="text" name="identificacaoCPF_CNPJ" id="identificacaoCPF_CNPJ" value="<?= $valuesTable['identificacao_cpf_cnpj'] ?>" placeholder="CPF / CNPJ">

        <p>Arrendatário</p>
        <input type="text" name="arrendatario" id="arrendatario" value="<?= $valuesTable['arrendatario'] ?>" placeholder="Arrendatário">

        <p>Inscrição Estadual</p>
        <input type="text" name="inscricaoEstadual" id="inscricaoEstadual" value="<?= $valuesTable['inscricao_estadual'] ?>" placeholder="Inscrição Estadual">

        <p>Subunidade</p>
        <input type="text" name="subunidade" id="subunidade" value="<?= $valuesTable['subunidade'] ?>" placeholder="Subunidade">

        <br><br>

        <button name="atualizaValoresBD" id="atualizaValoresBD">Concluir</button>
        <button name="naoAtualizaValoresBD" id="naoAtualizaValoresBD">Voltar</button>
    </form>

    <script src="gerenciar.js"></script>

</body>

</html>