<?php
include_once("../database/config.php");
session_start();



if(isset($_POST["aprovaCotacaoOficina"])){
    //function para aprovar cotacao da oficina
}

else{
    //function para cancelar cotacao oficina
}

// selecionaValoresRespondidosOficina($conexao, $idOrgaoPublicoVeiculo);
header('Location: responder.php');


?>