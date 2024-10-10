<?php
include_once('../database/config.php');
session_start();

$selectTable = "UPDATE cotacoes_veiculos SET opcao_orcar_rejeitar='Orçar' WHERE ";


if(isset($_POST['botaoOrcar'])){
    $idValorOrcar = $_POST['botaoOrcar'];
    $selectTable = "UPDATE cotacoes_veiculos SET opcao_orcar_rejeitar='Orçar' WHERE id_cotacoes_veiculos='$idValorOrcar'";
    $execConnection = $connectionDB->query($selectTable);
    header('Location: ../index.php');

}
else{
    $idValorRejeitar = $_POST['botaoRejeitar'];
    $selectTable = "UPDATE cotacoes_veiculos SET opcao_orcar_rejeitar='Rejeitar' WHERE id_cotacoes_veiculos='$idValorRejeitar'";
    $execConnection = $connectionDB->query($selectTable);
    header('Location: ../index.php');
}


?>