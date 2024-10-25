<?php

include_once("../database/config.php");
session_start();

$idOrgaoPublicoVeiculo = $_SESSION['idOrgaoPublico'];
$selectOrgaoPublicoCotado = "SELECT * FROM infos_veiculos_aprovados_oficina WHERE id_orgao_publico='$idOrgaoPublicoVeiculo' ";
$execConnectionOrgaoPublicoCotado = $conexao->query($selectOrgaoPublicoCotado);

$selectInfosVeiculosCotadoOficina = "SELECT * FROM infos_veiculos_inclusos WHERE id_orgao_publico = '$idOrgaoPublicoVeiculo' AND opcao_aprovada_reprovada_oficina= 'Respondida'";
$execConnectionInfosVeiculosCotadoOficina = $conexao->query($selectInfosVeiculosCotadoOficina);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <table>
        <thead>
            <tr> N veiculo </tr>
            <tr> Veiculo </tr>
            <tr> Modelo </tr>
            <tr> Ano veiculo </tr>
            <tr> Justificativa </tr>

            <tr>Valor total peças</tr>
            <tr>Valor total serviços</tr>
            <tr>Valor total orçamento</tr>
            <tr> Opção </tr>
        </thead>
        <tbody>
            <?php
                // echo $orgaoPublicoCotado['id_veiculo_aprovado_oficina'];
                while ($valoresSelectInfosVeiculosCotadoOficina = mysqli_fetch_assoc($execConnectionInfosVeiculosCotadoOficina)) {
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["id_infos_veiculos_inclusos"] . "</td>";
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["veiculo"] . "</td>";
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["modelo_veiculo"] . "</td>";
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["ano_veiculo"] . "</td>";
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["propostas"] . "</td>";


                    while($orgaoPublicoCotado = mysqli_fetch_assoc($execConnectionOrgaoPublicoCotado) ){
                        echo "<td>" .$orgaoPublicoCotado["valor_total_pecas"]."</td>";
                        echo "<td>" .$orgaoPublicoCotado["valor_total_servicos"]. "</td>";
                        echo "<td>" .$orgaoPublicoCotado["valor_total_servico_pecas"]. "</td>";
                    }
                    
                    echo "<form action='configs_responder.php' method='POST'>
                            <td> <button name='aprovaCotacaoOficina'>Aprovar</button> <button name='cancelaCotacaoOficina'>Cancelar</button></td>
                        </form>";
                }
            
            // }

            ?>
            <!-- Aqui serão os valores vindos do BD -->
 
        </tbody>
    </table>
    <table>

    <a href="../cotacoes_andamento/andamento.php"><button>Voltar</button></a>
</body>

</html>