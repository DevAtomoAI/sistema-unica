<?php
include_once("../database/config.php");
session_start();

if(isset($_POST['submitPdf'])){
    $faturaPecas = file_get_contents($_FILES['pdfPecas']['tmp_name']);
    $faturaServicos = file_get_contents($_FILES['pdfServicos']['tmp_name']);
    
    $stmt = $connectionDB->prepare( "UPDATE infos_veiculos_aprovados_oficina SET fatura_pecas=?, fatura_servicos=?");
    $stmt->bind_param("ss",$faturaPecas, $faturaServicos);
    if($stmt->execute()){
        echo "certo";
    }
    else{
        echo "erro". $stmt->error;
    }
    $stmt->close();
    $connectionDB->close();
}

?>