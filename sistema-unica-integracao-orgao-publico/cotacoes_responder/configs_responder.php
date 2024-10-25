<?php
include_once("../database/config.php");
session_start();

$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];
function mudaEstadoCotacaoOficina($conexao, $idOrgaoPublicoLogado, $condicao) {
    // $numLinhasTotal = $tableInfosVeiculosInclusos->num_rows;
    $mudaEstadoCotacaoOficina = mysqli_query($conexao, "UPDATE infos_veiculos_inclusos SET 
    opcao_aprovada_reprovada_oficina = '$condicao'
    WHERE id_orgao_publico = '$idOrgaoPublicoLogado' AND opcao_aprovada_reprovada_oficina='Respondida'");
}

if(isset($_POST["aprovaCotacaoOficina"])){
    mudaEstadoCotacaoOficina($conexao, $idOrgaoPublicoLogado, 'Aprovada');
    header('Location: ../cotacoes_aprovado/aprovado.php');
    exit();

}

else{
    mudaEstadoCotacaoOficina($conexao, $idOrgaoPublicoLogado, 'Cancelada');
    header('Location: ../cotacoes_cancelado/cancelado.php');
    exit();

}



?>