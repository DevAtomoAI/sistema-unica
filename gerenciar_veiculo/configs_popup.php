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

    $selectInfosPecasXML = "SELECT * FROM infos_veiculos_aprovados_oficina WHERE id_veiculo_incluso_orgao_publico = '$idVeiculoGerenciado' AND id_orgao_publico = '$idOrgaoPublico' AND quantidade_pecas != 0";
    $result2 = $connectionDB->query($selectInfosPecasXML);

    $selectInfosServicosXML = "SELECT * FROM infos_veiculos_aprovados_oficina WHERE id_veiculo_incluso_orgao_publico = '$idVeiculoGerenciado' AND id_orgao_publico = '$idOrgaoPublico' AND quantidade_pecas = 0";
    $result3 = $connectionDB->query($selectInfosServicosXML);

    $contadorPecas = 1;
    while ($resultados2 = $result2->fetch_assoc()) {
        $idVeiculoAprovadoOficina = $resultados2['id_veiculo_aprovado_oficina'];
        $marcaPecas = $_POST['marcaPecas' . $contadorPecas];
        $valorUNPecas = (float)$_POST['valorUNPecas']; // decimal (float)
        $prazoEntrega = (int)$_POST['prazoEntrega']; // inteiro

        // echo "<br>";
        echo $idVeiculoAprovadoOficina, $marcaPecas;
        echo "<br>";

        $sql = "
        UPDATE infos_veiculos_aprovados_oficina 
        SET marca_pecas = '$marcaPecas', valor_un_pecas = '$valorUNPecas', 
            dias_execucao = '$prazoEntrega' 
        WHERE id_veiculo_incluso_orgao_publico = '$idVeiculoGerenciado' 
        AND id_orgao_publico = '$idOrgaoPublico' 
        AND id_veiculo_aprovado_oficina = '$idVeiculoAprovadoOficina' 
        AND quantidade_pecas != 0";

        $connectionDB->query($sql);

        $contadorPecas++;
    }
    $contadorServicos = 1;
    while ($resultados3 = $result3->fetch_assoc()) {
        $idVeiculoAprovadoOficina = $resultados3['id_veiculo_aprovado_oficina'];
        $valorOrcadoServicos = (float)$_POST['valorOrcadoServico'.$contadorServicos ]; // decimal
        $prazoEntrega = (int)$_POST['prazoEntrega']; 

        $sql = "
        UPDATE infos_veiculos_aprovados_oficina 
        SET valor_orcado_servicos = '$valorOrcadoServicos', dias_execucao= '$prazoEntrega'
        WHERE id_veiculo_incluso_orgao_publico = '$idVeiculoGerenciado'
        AND id_orgao_publico = '$idOrgaoPublico' 
        AND id_veiculo_aprovado_oficina = '$idVeiculoAprovadoOficina' 
        AND quantidade_pecas = 0";

        $connectionDB->query($sql);

        $contadorServicos++;

    }

}

if (isset($_POST['confirmaCotacao'])) {
    adicionaValoresCotacaoOficina($connectionDB, $idVeiculoGerenciado, $nomeOficina);
    // header('Location: popup.php');
    exit();
}
