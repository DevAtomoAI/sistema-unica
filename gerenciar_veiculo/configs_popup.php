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

    $selectInfosPecasXML = "SELECT * FROM infos_cotacao_orgao WHERE id_veiculo_incluso_orgao_publico = '$idVeiculoGerenciado' AND id_orgao_publico = '$idOrgaoPublico'";
    $result2 = $connectionDB->query($selectInfosPecasXML);

    $selectInfosServicosXML = "SELECT * FROM infos_cotacao_orgao WHERE id_veiculo_incluso_orgao_publico = '$idVeiculoGerenciado' AND id_orgao_publico = '$idOrgaoPublico' AND quantidade_pecas = 0";
    $result3 = $connectionDB->query($selectInfosServicosXML);

    $valores = []; // Inicializa o array para armazenar os valores
    $contador = 1;
    $contador2 = 1;

    while ($resultados2 = $result2->fetch_assoc()) {
        // Coleta dados de peças
        $idInfosCotacaoOrgao = $resultados2['id_infos_cotacao_orgao'];
        $marcaPecas = $_POST['marcaPecas' . $contador];
        $valorUNPecas = (float)$_POST['valorUNPecas' . $contador];
        $prazoEntrega = (int)$_POST['prazoEntrega'];

        if($valorUNPecas == 0){
            break;
        }
        // Adiciona os valores ao array sem valorOrcadoServicos
        $valores[] = "('$idOrgaoPublico', '$idVeiculoGerenciado', '$idInfosCotacaoOrgao', '$nomeOficina', '$marcaPecas', '$valorUNPecas', NULL, '$prazoEntrega', true)";
    
        $contador++; // Incrementa o contador
    }

    while ($resultados3 = $result3->fetch_assoc()) {
        // Coleta dados de peças
        $valorOrcadoServicos = (float)$_POST['valorOrcadoServico' . $contador2]; 
        // Adiciona os valores ao array sem valorOrcadoServicos
        $valores[] = "('$idOrgaoPublico', '$idVeiculoGerenciado', '$idInfosCotacaoOrgao', '$nomeOficina', '$marcaPecas', '$valorUNPecas', '$valorOrcadoServicos', '$prazoEntrega', true)";
    
        $contador2++; // Incrementa o contador
    }


    print_r($valores);
    
    // Monta a consulta de INSERT única
    if (!empty($valores)) {
        $sqlInsert = "
        INSERT INTO orcamentos_oficinas (
            id_orgao_publico, id_veiculo_gerenciado, id_infos_cotacao_orgao, nome_oficina, marca_pecas, valor_un_pecas, valor_orcado_servicos, dias_execucao, orcado_oficina
        ) VALUES " . implode(", ", $valores);
    
        // Executa a consulta
        $connectionDB->query($sqlInsert);
    }
    
}

if (isset($_POST['confirmaCotacao'])) {
    adicionaValoresCotacaoOficina($connectionDB, $idVeiculoGerenciado, $nomeOficina);
    header('Location: popup.php');
    exit();
}
