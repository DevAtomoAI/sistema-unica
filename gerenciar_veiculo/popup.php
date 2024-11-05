<?php
include_once("../database/config.php");
session_start();

$nomeOrgaoPublico = $_SESSION['nomeOrgaoPublico'];
// $idOrgaoPublico = $_SESSION['idOrgaoPublico'];
$idVeiculoGerenciar = $_SESSION['idVeiculoGerenciar'];
$veiculo = $_SESSION['veiculo'];
$kmAtual = $_SESSION['kmAtual'];
$anoVeiculo = $_SESSION['anoVeiculo'];
$centroCusto = $_SESSION['centroCusto'];
$planoManutencao = $_SESSION['planoManutencao'];
$fornecedor = $_SESSION['fornecedor'];
$modeloContratacao = $_SESSION['modeloContratacao'];

$selectIdOrgaoPublico = "SELECT id_usuarios_orgao_publico FROM usuarios_orgao_publico WHERE nome_orgao_publico='$nomeOrgaoPublico'";
$result = $connectionDB->query($selectIdOrgaoPublico);
$resultados = $result->fetch_assoc();
$idOrgaoPublico = $resultados['id_usuarios_orgao_publico'];

$selectInfosPecasXML = "SELECT * FROM infos_cotacao_orgao WHERE id_veiculo_incluso_orgao_publico = '$idVeiculoGerenciar' AND id_orgao_publico = '$idOrgaoPublico'";
$result2 = $connectionDB->query($selectInfosPecasXML);

$selectInfosServicosXML = "SELECT * FROM infos_cotacao_orgao WHERE id_veiculo_incluso_orgao_publico = '$idVeiculoGerenciar' AND id_orgao_publico = '$idOrgaoPublico'";
$result3= $connectionDB->query($selectInfosServicosXML);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="popup.css">

    <script src="popup.js"></script>
</head>

<body>

    <h2>Orçamento de Manutenção</h2>

    <p>N° ordem de orçamento: <strong><?= $idVeiculoGerenciar ?></strong></p>
    <p>Órgão solicitante: <strong><?= $nomeOrgaoPublico ?></strong></p>
    <p>Tipo de solicitação: <strong> <?= $modeloContratacao ?></strong></p>

    <form action="configs_popup.php" method="POST">
        <h3>Código orçamento</h3>
        <!-- mostar codigo do orcamento geral -->
        <h3>Peças</h3>
        <table id="tabelaPecas" border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <!-- <th>Valor Unitário Máximo Aceitável</th> -->
                    <!-- <th>Valor Total Máximo Aceitável</th> ==== é dado por Valor Unitário Máximo Aceitável * quantidade-->
                    <th>Marca</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                    <th>Valor total final</th>

                </tr>
            </thead>
            <tbody>
                <!-- <tr> -->
                <?php
                $contadorPecas = 1;
                while ($resultados2 = $result2->fetch_assoc()) {
                    // Verifica se algum dos campos que deseja exibir está vazio
                    if (
                        !empty($resultados2['codigo_pecas']) &&
                        !empty($resultados2['descricao_pecas']) &&
                        !empty($resultados2['quantidade_pecas']) &&
                        !empty($resultados2['valor_orcado_pecas']) &&
                        !empty($resultados2['valor_total_final_pecas'])
                    ) {

                        echo "<tr>";
                        echo "<td>" . $resultados2['codigo_pecas'] . "</td>";
                        echo "<td>" . $resultados2['descricao_pecas'] . "</td>";
                        echo "<td>" . $resultados2['quantidade_pecas'] . "</td>";
                        echo "<td><input name='marcaPecas".$contadorPecas."' type='text' placeholder='marca'></td>";
                        echo "<td><input name='valorUNPecas".$contadorPecas."' type='float' placeholder='valor unitario'></td>";
                        echo "<td>" . $resultados2['valor_orcado_pecas'] . "</td>";
                        echo "<td>" . $resultados2['valor_total_final_pecas'] . "</td>";
                        echo "</tr>";

                        $contadorPecas+=1;
                    }
                }
                ?>
            </tbody>
        </table>

        <h3>Serviços</h3>
        <table id="tabelaServicos" border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor da mão de obra</th>
                    <th>Valor orçado</th>
                    <th>Valor total final</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                $contadorServico = 1;
                while ($resultados3 = $result3->fetch_assoc()) {
                    // Verifica se algum dos campos que deseja exibir está vazio
                    if (
                        !empty($resultados3['descricao_servicos']) &&
                        !empty($resultados3['valor_mao_obra']) &&
                        !empty($resultados3['valor_total_servicos'])
                    ) {

                        echo "<tr>";
                        echo "<td>" . $resultados3['descricao_servicos'] . "</td>";
                        echo "<td>" . $resultados3['valor_mao_obra'] . "</td>";
                        echo "<td><input name='valorOrcadoServico".$contadorServico."' type='float' placeholder='valor orcado'></td>";
                        echo "<td>" . $resultados3['valor_total_servicos'] . "</td>";
                        echo "</tr>";

                        $contadorServico +=1;
                    }
                }
                ?>
                </tr>
            </tbody>
        </table>

        <br>
        <h1>VALOR TOTAL DO ORÇAMENTO</h1>
        <br>
        <p>Prazo para entrega/execução <input name="prazoEntrega" type="text" placeholder="Prazo"></p>
        <br>
        <br>
        <button name="confirmaCotacao">Confirmar</button>
        <button onclick="fechaPopUp()" name="voltarGerenciar">Voltar</button>
    </form>



</body>

</html>