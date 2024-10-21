<?php
session_start();
include_once('../database/config.php');

function atribuiFaturas($conexao){
     
}

if(isset($_POST['gerenciarFaturas'])){
    atribuiFaturas($conexao); 
}

?>