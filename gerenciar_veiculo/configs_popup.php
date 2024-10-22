<?php
include_once("../database/config.php");
session_start();

// //gerais
$idVeiculoGerenciado = $_SESSION['idVeiculoGerenciar'];
$nomeOficina = $_SESSION['nomeOficina'];


function insereValoresBD($connectionDB, $quantidadePecas, $quantidadeServicos, $nomeOficina, $idVeiculoGerenciado, $maiorValor)
{
    // Inserir dados das peças
    $codigoPecas = $_POST['codigoPecas'];
    $descricaoPecas = $_POST['descricaoPecas']; 
    $valorUNPecas = $_POST['valorUNPecas'];
    $quantidadePecas = $_POST['quantidadePecas']; 
    $marcaPecas = $_POST['marcaPecas'];
    $valorTotalPecas = $_POST['valorTotalPecas']; 
    
    $descricaoServico = $_POST['descricaoServico']; 
    $valorUNServicos = $_POST['valorUNServicos'];
    $quantidadeServicos = $_POST['quantidadeServicos'];
    $valorTotalServicos = $_POST['valorTotalServicos'];

    // Preparar a inserção
    $stmtInsert = $connectionDB->prepare("INSERT INTO infos_veiculos_aprovados_oficina 
            (id_veiculo_incluso_orgao_publico, nome_oficina_aprovado, codigo_pecas, descricao_pecas, 
            valor_un_pecas, quantidade_pecas, marca_pecas, valor_total_pecas, 
            descricao_servicos, valor_un_servicos, quantidade_servicos, valor_total_servicos) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind dos parâmetros
    $stmtInsert->bind_param(
        "isisiisisiii",
        $idVeiculoGerenciado,
        $nomeOficina,
        $codigoPecas,
        $descricaoPecas,
        $valorUNPecas,
        $quantidadePecas,
        $marcaPecas,
        $valorTotalPecas,
        $descricaoServico,
        $valorUNServicos,
        $quantidadeServicos,
        $valorTotalServicos
    );
    
    if ($stmtInsert->execute()) {
        echo "Inserção realizada com sucesso.";
    } else {
        echo "Erro na inserção: " . $stmtInsert->error;
    }
}


insereValoresBD($connectionDB, $quantidadePecas, $quantidadeServicos, $nomeOficina, $idVeiculoGerenciado, $maiorValor);
header('Location: popup.php');
// exit();
