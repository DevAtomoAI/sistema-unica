<?php
include_once("../database/config.php");
session_start();

function adicionarValoresBD($conexao) {
    // Verifica se o arquivo foi enviado
    if (!isset($_FILES['anexo']) || $_FILES['anexo']['error'] !== UPLOAD_ERR_OK) {
        echo "Erro no upload do arquivo.";
        return; // Interrompe a execução se o arquivo não foi enviado corretamente
    }

    // Lê o conteúdo do arquivo
    $anexo = file_get_contents($_FILES['anexo']['tmp_name']);
    
    // Obtém os dados do formulário
    $veiculo = $_POST['veiculo'];
    $kmAtual = $_POST['km-atual'];
    $centroCusto = $_POST['centro-custo'];
    $tipoSolicitacao = $_POST['tipo-solicitacao'];
    $planoManutencao = $_POST['plano-manutencao'];
    $responsavel = $_POST['responsavel'];
    $dataAbertura = $_POST['data-abertura'];
    $dataFinal = $_POST['data-fim'];
    $modeloContratacao = $_POST['modelo-contratacao'];
    $justificativa = $_POST['justificativa'];
    $idOrgaoPublico = $_SESSION['idOrgaoPublico'];

    // Prepara a consulta
    $stmt = $conexao->prepare("INSERT INTO infos_veiculos_inclusos 
    (id_orgao_publico, veiculo, km_atual, plano_manutencao, modelo_contratacao, data_abertura, data_final, centro_custo, tipo_solicitacao, responsavel, justificativa, anexo)  
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        echo "Erro na preparação da consulta: " . $conexao->error;
        return;
    }

    // Vincula os parâmetros
    $stmt->bind_param("isisssssssss", $idOrgaoPublico, $veiculo, $kmAtual, $planoManutencao, $modeloContratacao, $dataAbertura, $dataFinal, $centroCusto, $tipoSolicitacao, 
    $responsavel, $justificativa, $anexo);

    // Executa a consulta
    if ($stmt->execute()) {
        header('Location: incluir.php');
        exit; // Para garantir que o script pare após o redirecionamento
    } else {
        echo "Erro ao inserir dados: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
}

// Chama a função ao clicar no botão de incluir
if (isset($_POST["incluir-btn"])) {
    adicionarValoresBD($conexao);
}

// Fecha a conexão
$conexao->close();
?>