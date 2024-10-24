<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("../database/config.php");
session_start();

// Variáveis gerais
$idVeiculoGerenciado = $_SESSION['idVeiculoGerenciar'];
$nomeOficina = $_SESSION['nomeOficina'];
$count = 0;

function insereValoresBD($connectionDB, $nomeOficina, $idVeiculoGerenciado) {
    // Verifique se os dados POST estão chegando
    if (!isset($_POST['pecas']) && !isset($_POST['servicos'])) {
        echo 'Nenhum dado recebido.';
        return;
    }

    // Decodificar JSON recebido
    $pecas = json_decode($_POST['pecas'], true);
    $servicos = json_decode($_POST['servicos'], true);

    // Debugging - Exibir valores decodificados
    echo '<pre>'; print_r($pecas); echo '</pre>';
    echo '<pre>'; print_r($servicos); echo '</pre>';
    exit;

    $stmt = $connectionDB->prepare("SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos=?");
    $stmt->bind_param("i", $idVeiculoGerenciado);
    $stmt->execute();
    $result = $stmt->get_result();
    $valuesTable = $result->fetch_assoc();
    $idOrgaoPublico = $valuesTable['id_orgao_publico'];

    $stmtInsert = $connectionDB->prepare("
        INSERT INTO infos_veiculos_aprovados_oficina 
        (id_veiculo_incluso_orgao_publico, id_orgao_publico, nome_oficina_aprovado, codigo_pecas, descricao_pecas, 
        valor_un_pecas, quantidade_pecas, marca_pecas, valor_total_pecas, 
        descricao_servicos, valor_un_servicos, quantidade_servicos, valor_total_servicos, valor_total_servico_pecas, data_registro)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if ($stmtInsert === false) {
        die('Erro ao preparar a query: ' . $connectionDB->error);
    }

    $maxItems = max(count($pecas), count($servicos));

    for ($i = 0; $i < $maxItems; $i++) {
        $peca = isset($pecas[$i]) ? $pecas[$i] : null;
        
        $descricaoServico = isset($servicos[$i]) ? $servicos[$i]['descricaoServico'] : '';
        $valorUNServicos = isset($servicos[$i]) ? floatval($servicos[$i]['valorUNServicos']) : 0.0;
        $quantidadeServicos = isset($servicos[$i]) ? intval($servicos[$i]['quantidadeServicos']) : 0;

        $valorTotalServicos = $valorUNServicos * $quantidadeServicos * (36.6 / 100);

        $codigoPecas = $peca ? $peca['codigoPecas'] : '';
        $descricaoPecas = $peca ? $peca['descricaoPecas'] : '';
        $valorUNPecas = $peca ? floatval($peca['valorUNPecas']) : 0.0;
        $quantidadePecas = $peca ? intval($peca['quantidadePecas']) : 0;

        $valorTotalPecas = $valorUNPecas * $quantidadePecas * (36.6 / 100);
        $marcaPecas = $peca ? $peca['marcaPecas'] : '';

        $valorTotalFinal = $valorTotalServicos + $valorTotalPecas;
        $_SESSION['valorTotalServicos'] = $valorTotalServicos;
        $_SESSION['valorTotalPecas'] = $valorTotalPecas;

        $dataRegistro = date('Y-m-d');

        // Debugging - Verificar valores antes da inserção
        echo "Debug - Dados para inserir: ";
        echo "valorUNPecas: $valorUNPecas, valorTotalPecas: $valorTotalPecas, valorUNServicos: $valorUNServicos, valorTotalServicos: $valorTotalServicos, valorTotalFinal: $valorTotalFinal <br>";

        $stmtInsert->bind_param(
            "iisdsisdsidsdss",
            $idVeiculoGerenciado,
            $idOrgaoPublico,
            $nomeOficina,
            $codigoPecas,
            $valorUNPecas,
            $quantidadePecas,
            $marcaPecas,
            $valorTotalPecas,
            $descricaoServico,
            $valorUNServicos,
            $quantidadeServicos,
            $valorTotalServicos,
            $valorTotalFinal,
            $dataRegistro
        );

        if (!$stmtInsert->execute()) {
            echo "Erro ao inserir o item $i: " . $stmtInsert->error;
        } else {
            echo "Item $i inserido com sucesso.<br>";
        }
    }

    $stmtInsert->close();
}

// Chamar a função se os dados foram recebidos via POST
if (isset($_POST['pecas']) || isset($_POST['servicos'])) {
    insereValoresBD($connectionDB, $nomeOficina, $idVeiculoGerenciado);
} else {
    echo "Nenhum dado recebido.";
}
?>

