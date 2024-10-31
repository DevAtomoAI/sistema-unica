<?php


include_once("../database/config.php");
session_start();

// Variáveis gerais
$idVeiculoGerenciado = $_SESSION['idVeiculoGerenciar'];
$nomeOficina = $_SESSION['nomeOficina'];
$count = 0;

function adicionaValoresCotacaoOficina($connectionDB, $idVeiculoGerenciado, $nomeOficina)
{
    $stmt = $connectionDB->prepare("SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos=?");
    $stmt->bind_param("i", $idVeiculoGerenciado); 
    $stmt->execute();
    $result = $stmt->get_result();
    $valuesTable = $result->fetch_assoc();

    $idOrgaoPublico = $valuesTable['id_orgao_publico'];
    $idVeiculoGerenciado;


    $marcaPecas = $_POST['marca'];
    $valorUNPecas = $_POST['valorUN'];
    $valorOrcadoServicos = $_POST['valorOrcado'];
    $prazoEntrega = $_POST['prazoEntrega'];

    $stmtInsert = $connectionDB->prepare("
        INSERT INTO infos_veiculos_aprovados_oficina 
        (id_veiculo_incluso_orgao_publico, id_orgao_publico, nome_oficina_aprovado, marca_pecas, valor_un_pecas, valor_orcado_servicos, dias_execucao) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

    $stmtInsert->bind_param(
        "iissdds",
        $idVeiculoGerenciado,
        $idOrgaoPublico,
        $nomeOficina,
        $marcaPecas,
        $valorUNPecas,
        $valorOrcadoServicos,
        $prazoEntrega
    );

    $stmtInsert->execute();
}

if (isset($_POST['confirmaCotacao'])) {
    adicionaValoresCotacaoOficina($connectionDB, $idVeiculoGerenciado, $nomeOficina);
    header('Location: popup.php');
    exit();
}

// function insereValoresBD($connectionDB, $nomeOficina, $idVeiculoGerenciado)
// {
//     // Receber arrays de peças e serviços do POST
//     $pecas = isset($_POST['pecas']) ? $_POST['pecas'] : [];
//     $servicos = isset($_POST['servicos']) ? $_POST['servicos'] : [];

//     $stmt = $connectionDB->prepare("SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos=?");
//     $stmt->bind_param("i", $idVeiculoGerenciado); // "s" para string
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $valuesTable = $result->fetch_assoc();
//     $idOrgaoPublico = $valuesTable['id_orgao_publico'];

//     // Preparar a inserção
//     $stmtInsert = $connectionDB->prepare("
//         INSERT INTO infos_veiculos_aprovados_oficina 
//         (id_veiculo_incluso_orgao_publico, id_orgao_publico, nome_oficina_aprovado, marca_pecas, valor_un_pecas, valor_orcado_servicos) 
//         VALUES (?, ?, ?, ?, ?, ?)
//     ");

//     // Itera sobre os arrays para inserir os valores
//     $maxItems = max(count($pecas), count($servicos));
//     for ($i = 0; $i < $maxItems; $i++) {
//         // Obter dados da peça se existir
//         $peca = isset($pecas[$i]) ? $pecas[$i] : null;
//         $valorUNServicos = isset($servicos[$i]) ? (float)$servicos[$i]['valorUNServicos'] : 0; // Convertendo para float
//         $valorUNPecas = $peca ? (float)$peca['valorUNPecas'] : 0; // Convertendo para float
//         $marcaPecas = $peca ? $peca['marcaPecas'] : ''; // Usar string vazia em vez de null



//         // Obter dados do serviço correspondente se existir
//         // $quantidadeServicos = isset($servicos[$i]) ? (int)$servicos[$i]['quantidadeServicos'] : 0; // Convertendo para int

//         // Calcular o valor total dos serviços

//         // $quantidadePecas = $peca ? (int)$peca['quantidadePecas'] : 0; 

//         // Calcular o valor total das peças
//         // $valorTotalPecas = ($valorUNPecas * $quantidadePecas); // Corrigido para calcular o valor total das peças
//         // $valorTotalServicos = ($valorUNServicos * $quantidadeServicos); // Corrigido para calcular o valor total dos serviços



//         // Calcular o valor total final
//         // $valorTotalFinal = $valorTotalServicos + $valorTotalPecas;
//         // $_SESSION['valorTotalServicos'] = $valorTotalServicos; 
//         // $_SESSION['valorTotalPecas'] = $valorTotalPecas;
//         // Obter a data atual
//         // Vincular os parâmetros
//         $stmtInsert->bind_param(
//             "iivvff",
//             $idVeiculoGerenciado,
//             $idOrgaoPublico,
//             $nomeOficina,
//             $marcaPecas,
//             $valorUNPecas,
//             $valorUNServicos
//         );

//         // Executa e verifica se houve erro
//         if (!$stmtInsert->execute()) {
//             echo "Erro ao inserir o item $i: " . $stmtInsert->error;
//         } else {
//             echo "Item $i inserido com sucesso.<br>";
//         }
//     }

//     // Fechar o statement
//     $stmtInsert->close();
// }


// // Chamar a função se os dados foram recebidos via POST
// if (isset($_POST['pecas']) || isset($_POST['servicos'])) {
//     insereValoresBD($connectionDB, $nomeOficina, $idVeiculoGerenciado);
// } else {
//     echo "Nenhum dado recebido.";
// }
