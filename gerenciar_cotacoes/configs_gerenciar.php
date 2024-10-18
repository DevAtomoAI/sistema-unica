<?php

include_once('../database/config.php');
session_start();

$idVeiculoEscolhido = $_SESSION['idVeiculoEscolhido'];

function acessaValoresBD($conexao, $idVeiculoEscolhido){
    // echo "aqui";
    $selectTabelaInfos = "SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhido'";
    $execConnectionInfos = $conexao->query($selectTabelaInfos);
    while ($user_data = mysqli_fetch_assoc($execConnectionInfos)) {
        $_SESSION['responsavelAtual'] = $user_data['responsavel'];
        $_SESSION['fornecedor'] = $user_data['fornecedor'];
        $_SESSION['veiculo'] = $user_data['veiculo'];
        // $_SESSION['placa'] = $user_data['placa'];
        // $_SESSION['centroCusto'] = $user_data['centro_custo'];
        // $_SESSION['kmAtual'] = $user_data['km_atual'];
        // $_SESSION['modelo'] = $user_data['modelo'];
        // $_SESSION['tipoSolicitacao'] = $user_data['tipo_solicitacao'];
        // $_SESSION['planoManutencao'] = $user_data['plano_manutencao'];
        // $_SESSION['modeloContratacao'] = $user_data['modelo_contratacao'];
        // $_SESSION['dataAbertura'] = $user_data['data_abertura'];
        // $_SESSION['dataFinal'] = $user_data['data_final'];
    }
    
}


if($_SESSION['button-option-aproved']){
    acessaValoresBD($conexao, $idVeiculoEscolhido);
}

header('Location: gerenciar.php');

?>