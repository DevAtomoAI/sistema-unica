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
    <title>Gerenciar</title>
    <link rel="stylesheet" href="gerenciar.css">
</head>
<body>

<div class="container">
        <div class="section">
            <h3 class="section-title">Área Administrativa</h3>

            <form action="configs_gerenciar.php" method="POST" class="form">
                <div class="input-group">
                    <label for="responsavelAtual">Nome do responsável atual</label>
                    <input type="text" name="responsavelAtual" id="responsavelAtual" value="<?= $valores['responsavelAtual']; ?>" placeholder="Responsável atual">
                </div>

                <div class="input-group">
                    <label for="fornecedor">Nome do fornecedor</label>
                    <input type="text" name="fornecedor" id="fornecedor" value="<?= $valores['fornecedor']; ?>" placeholder="Nome do fornecedor">
                </div>

                <div class="input-group">
                    <label for="veiculo">Veículo</label>
                    <input type="text" name="veiculo" id="veiculo" value="<?= $valores['veiculo']; ?>" placeholder="Veículo">
                </div>

                <div class="input-group">
                    <label for="placa">Placa</label>
                    <input type="text" name="placa" id="placa" value="<?= $valores['placa']; ?>" placeholder="Placa">
                </div>

                <div class="input-group">
                    <label for="centroCusto">Centro de custo</label>
                    <input type="text" name="centroCusto" id="centroCusto" value="<?= $valores['centroCusto']; ?>" placeholder="Centro de custo">
                </div>

                <div class="input-group">
                    <label for="kmAtual">Km atual</label>
                    <input type="text" name="kmAtual" id="kmAtual" value="<?= $valores['kmAtual']; ?>" placeholder="Km atual">
                </div>

                <div class="input-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" id="modelo" value="<?= $valores['modelo']; ?>" placeholder="Modelo">
                </div>

                <div class="input-group">
                    <label for="tipoSolicitacao">Tipo de solicitação</label>
                    <select name="tipoSolicitacao" id="tipoSolicitacao" value="<?= $valores['tipoSolicitacao']; ?>"  > ;
                        <option value="Aquisição de Óleos Lubrificantes e Filtros"> Aquisição de Óleos Lubrificantes e Filtros </option>
                        <option value="Aquisição de Peças"> Aquisição de Peças</option>
                        <option value="Aquisição de Peças + Serviços"> Aquisição de Peças + Serviços </option>
                        <option value="Aquisição de Pneus"> Aquisição de Pneus </option>
                        <option value="Serviço de Borracharia"> Serviço de Borracharia </option>
                        <option value="Serviço de Diagnóstico"> Serviço de Diagnóstico </option>
                        <option value="Serviço de Elétrica"> Serviço de Elétrica </option>
                        <option value="Serviço de Funilaria e Pintura"> Serviço de Funilaria e Pintura </option>
                        <option value="Serviço de Guincho"> Serviço de Guincho </option>
                        <option value="Serviço de Para-brisas"> Serviço de Para-brisas </option>
                        <option value="Serviço de Portas"> Serviço de Portas</option>
                        <option value="Serviço de Radiador"> Serviço de Radiador </option>
                        <option value="Serviço de Reforma de Pneus"> Serviço de Reforma de Pneus </option>
                        <option value="Serviço de Solda em Geral"> Serviço de Solda em Geral </option>
                        <option value="Serviço de Tapeçaria"> Serviço de Tapeçaria </option>
                        <option value="Serviço de Tornearia"> Serviço de Tornearia </option>
                        <option value="Serviço Geral"> Serviço Geral </option>
                        <option value="Inspeção Veícular"> Inspeção Veícular </option>
                        <option value="Vistoria Veícular"> Vistoria Veícular </option>
                
                </select>
                    
                </div>

                <div class="input-group">
                    <label for="planoManutencao">Plano de manutenção</label>
                    <select name="planoManutencao" id="planoManutencao" value="<?= $valores['planoManutencao']; ?>">
                        <option>Garantia</option>
                        <option>Corretiva</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="modeloContratacao">Modelo de contratação</label>
                    <input type="text" name="modeloContratacao" id="modeloContratacao" value="<?= $valores['modeloContratacao']; ?>" placeholder="Modelo de contratação">
                </div>

                <div class="input-group">
                    <label for="dataAbertura">Data de abertura</label>
                    <input type="date" name="dataAbertura" id="dataAbertura" value="<?= $valores['dataAbertura']; ?>">
                </div>

                <div class="input-group">
                    <label for="dataFinal">Data final</label>
                    <input type="date" name="dataFinal" id="dataFinal" value="<?= $valores['dataFinal']; ?>">
                </div>

                <h3 class="section-title">Proprietário</h3>

                <div class="input-group">
                    <label for="identificacaoCPF_CNPJ">CPF / CNPJ</label>
                    <input type="text" name="identificacaoCPF_CNPJ" id="identificacaoCPF_CNPJ" value="<?= $valuesTable['identificacao_cpf_cnpj'] ?>" placeholder="CPF / CNPJ">
                </div>

                <div class="input-group">
                    <label for="arrendatario">Arrendatário</label>
                    <input type="text" name="arrendatario" id="arrendatario" value="<?= $valuesTable['arrendatario'] ?>" placeholder="Arrendatário">
                </div>

                <div class="input-group">
                    <label for="inscricaoEstadual">Inscrição Estadual</label>
                    <input type="text" name="inscricaoEstadual" id="inscricaoEstadual" value="<?= $valuesTable['inscricao_estadual'] ?>" placeholder="Inscrição Estadual">
                </div>

                <div class="input-group">
                    <label for="subunidade">Subunidade</label>
                    <input type="text" name="subunidade" id="subunidade" value="<?= $valuesTable['subunidade'] ?>" placeholder="Subunidade">
                </div>

                <div class="button-group">
                    <button name="atualizaValoresBD" id="atualizaValoresBD" class="button">Concluir</button>
                    <button name="naoAtualizaValoresBD" id="naoAtualizaValoresBD" class="button secondary">Voltar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="gerenciar.js"></script>

</body>

</html>