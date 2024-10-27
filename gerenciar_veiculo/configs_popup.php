<?php


include_once("../database/config.php");
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Variáveis gerais
$idVeiculoGerenciado = $_SESSION['idVeiculoGerenciar'];
$nomeOficina = $_SESSION['nomeOficina'];
$count = 0;
function insereValoresBD($connectionDB, $nomeOficina, $idVeiculoGerenciado)
{
    // Receber arrays de peças e serviços do POST
    $pecas = isset($_POST['pecas']) ? $_POST['pecas'] : [];
    $servicos = isset($_POST['servicos']) ? $_POST['servicos'] : [];

    $stmt = $connectionDB->prepare("SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos=?");
    $stmt->bind_param("i", $idVeiculoGerenciado); // "s" para string
    $stmt->execute();
    $result = $stmt->get_result();
    $valuesTable = $result->fetch_assoc();
    $idOrgaoPublico = $valuesTable['id_orgao_publico'];

    // Preparar a inserção
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

    // Itera sobre os arrays para inserir os valores
    $maxItems = max(count($pecas), count($servicos));
    for ($i = 0; $i < $maxItems; $i++) {
        // Obter dados da peça se existir
        $peca = isset($pecas[$i]) ? $pecas[$i] : null;

        // Obter dados do serviço correspondente se existir
        $descricaoServico = isset($servicos[$i]) ? $servicos[$i]['descricaoServico'] : '';
        $valorUNServicos = isset($servicos[$i]) ? floatval($servicos[$i]['valorUNServicos']) : 0; // Convertendo para float
        $quantidadeServicos = isset($servicos[$i]) ? ($servicos[$i]['quantidadeServicos']) : 0; // Convertendo para int
        echo "<scritp> console.log('.$valorUNServicos.')</script>";

        // Calcular o valor total dos serviços
        $valorTotalServicos = floatval(($valorUNServicos * $quantidadeServicos) + (36.6/100)); // Corrigido para calcular o valor total dos serviços

        // Variáveis temporárias para bind_param
        $codigoPecas = $peca ? $peca['codigoPecas'] : ''; 
        $descricaoPecas = $peca ? $peca['descricaoPecas'] : ''; 
        $valorUNPecas = $peca ? floatval($peca['valorUNPecas']) : 0; // Convertendo para float
        $quantidadePecas = $peca ? $peca['quantidadePecas'] : 0; 

        // Calcular o valor total das peças
        $valorTotalPecas = floatval(($valorUNPecas * $quantidadePecas) + (36.6/100)); // Corrigido para calcular o valor total das peças

        $marcaPecas = $peca ? $peca['marcaPecas'] : ''; // Usar string vazia em vez de null

        // Calcular o valor total final
        $valorTotalFinal = $valorTotalServicos + $valorTotalPecas;
        $_SESSION['valorTotalServicos'] = $valorTotalServicos; 
        $_SESSION['valorTotalPecas'] = $valorTotalPecas;

        // Obter a data atual
        $dataRegistro = date('Y-m-d'); // Altere para o formato padrão 'YYYY-MM-DD'

        // Vincular os parâmetros
        $stmtInsert->bind_param(
            "iisdsidsdsdddss",
            $idVeiculoGerenciado,
            $idOrgaoPublico,
            $nomeOficina,
            $codigoPecas,
            $descricaoPecas,
            $valorUNPecas, // 'd' para float
            $quantidadePecas,
            $marcaPecas,
            $valorTotalPecas, // 'd' para float
            $descricaoServico,
            $valorUNServicos, // 'd' para float
            $quantidadeServicos,
            $valorTotalServicos, // 'd' para float
            $valorTotalFinal,
            $dataRegistro
        );
        // Executa e verifica se houve erro
        $stmtInsert->execute();
    }

    // Fechar o statement
    $stmtInsert->close();
}


// Chamar a função se os dados foram recebidos via POST
if (isset($_POST['pecas']) || isset($_POST['servicos'])) {
    insereValoresBD($connectionDB, $nomeOficina, $idVeiculoGerenciado);
}
?>

