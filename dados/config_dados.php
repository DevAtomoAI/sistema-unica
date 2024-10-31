<?php
include_once("../database/config.php");
session_start();

function atualizaValoresOrgao($conexao)
{
    $idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

    $numContrato = $_POST['num_contrato'];
    $razaoSocial = $_POST['razao_social'];
    $identificacaoCNPJ = $_POST['cnpj'];
    $responsavel = $_POST['responsavel'];
    $contato = $_POST['contato'];
    $email = $_POST['email'];

    // Preparando a declaração para atualização
    $updateValoresTable = "
            UPDATE usuarios_orgao_publico 
            SET num_contrato = ?, 
                razao_social = ?, 
                identificacao_cnpj = ?, 
                responsavel = ?, 
                contato = ?, 
                email = ? 
            WHERE id_usuarios_orgao_publico = ?"; // Ajuste o ID conforme necessário

    // Preparando a declaração
    $stmt = $conexao->prepare($updateValoresTable);

    // Substitua as variáveis com os valores que deseja atualizar
    $stmt->bind_param("ssssssi", $numContrato, $razaoSocial, $identificacaoCNPJ, $responsavel, $contato, $email, $idOrgaoPublicoLogado);

    // Executa o UPDATE
    if ($stmt->execute()) {
        // Se a atualização foi bem-sucedida
        $response = ["mensagem" => "Atualização bem-sucedida!"];
    } else {
        // Se houve erro na atualização
        $response = ["mensagem" => "Erro na atualização: " . $stmt->error];
    }

    $stmt->close();
}


// Fechar a declaração (opcional)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    atualizaValoresOrgao($conexao);
    header('Location: dados.php');
}
