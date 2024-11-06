<?php
include_once('../database/config.php');
session_start();
function salvaValoresFornecedores($conexao){
    $idOrgaoPublico = $_SESSION['idOrgaoPublico'];
    $nomeFornecedor = $_POST['nomeFornecedor'];
    $tipoFornecedor = $_POST['tipoFornecedor'];
    $enderecoFornecedor = $_POST['enderecoFornecedor'];
    $cidadeFornecedor = $_POST['cidadeFornecedor'];
    $estadoFornecedor = $_POST['estadoFornecedor'];
    $contatoFornecedor = $_POST['contatoFornecedor'];

    $stmt = $conexao->prepare("INSERT INTO dados_fornecedores 
    (id_orgao_publico, nome, tipo, endereco, cidade, estado, contato)  
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Vincula os parâmetros
    $stmt->bind_param("issssss", $idOrgaoPublico, $nomeFornecedor, $tipoFornecedor, $enderecoFornecedor, $cidadeFornecedor, $estadoFornecedor, $contatoFornecedor);

    $stmt->execute();
    $stmt->close();
}

if(isset($_POST['salvaValoresFornecedores'])){
    salvaValoresFornecedores($conexao);
    header('Location: fornecedores.php');
}