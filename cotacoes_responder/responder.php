<?php

include_once("../database/config.php");
session_start();

$idOrgaoPublicoVeiculo = $_SESSION['idOrgaoPublico'];
echo $idOrgaoPublicoVeiculo;
$selectOrgaoPublicoCotado = "SELECT * FROM infos_veiculos_aprovados_oficina WHERE id_veiculo_incluso_orgao_publico='$idOrgaoPublicoVeiculo' ";
$execConnectionOrgaoPublicoCotado = $conexao->query($selectOrgaoPublicoCotado);

$selectInfosVeiculosCotadoOficina = "SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos = '$idOrgaoPublicoVeiculo' AND opcao_aprovada_reprovada_oficina= 'Aprovada'";
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
            <tr> Opção </tr>
        </thead>
        <tbody>
            <?php
            while($orgaoPublicoCotado = mysqli_fetch_assoc($execConnectionOrgaoPublicoCotado) ){
                // echo $orgaoPublicoCotado['id_veiculo_aprovado_oficina'];
                while ($valoresSelectInfosVeiculosCotadoOficina = mysqli_fetch_assoc($execConnectionInfosVeiculosCotadoOficina)) {
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["id_infos_veiculos_inclusos"] . "</td>";
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["veiculo"] . "</td>";
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["modelo_veiculo"] . "</td>";
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["ano_veiculo"] . "</td>";
                    echo "<td>" . $valoresSelectInfosVeiculosCotadoOficina["propostas"] . "</td>";
                }
            
            }

            ?>
            <!-- Aqui serão os valores vindos do BD -->
            <form action="">
                <td> <button name="aprovaCotacaoOficina">Aprovar</button> <button name="cancelaCotacaoOficina">Cancelar</button></td>
            </form>

        </tbody>
    </table>

    <a href="../cotacoes_andamento/andamento.php"><button>Voltar</button></a>
</body>

</html>