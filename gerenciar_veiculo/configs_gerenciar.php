<?php
include_once("../database/config.php");
session_start();

$idVeiculoGerenciar = $_SESSION['idVeiculoGerenciar'];

function acessaDadosVeiculosGerenciar($connectionDB,  $idVeiculoGerenciar)
{

    $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos='$idVeiculoGerenciar'";
    function executeQuery($connectionDB, $query)
    {
        $stmt = $connectionDB->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    $execConnection = executeQuery($connectionDB, $selectTable);

    while ($user_data = mysqli_fetch_assoc($execConnection)) {
        $_SESSION['veiculo'] = $user_data["veiculo"];
        $_SESSION['modeloVeiculo'] = $user_data["modelo_veiculo"];
        $_SESSION['kmAtual'] = $user_data["km_atual"];
        $_SESSION['placa'] = $user_data["placa"];
        $_SESSION['anoVeiculo'] = $user_data["ano_veiculo"];
        $_SESSION['centroCusto'] = $user_data["centro_custo"];
        $_SESSION['planoManutencao'] = $user_data["plano_manutencao"];
        $_SESSION['fornecedor'] = $user_data["fornecedor"];
        $_SESSION['modeloContratacao'] = $user_data["modelo_contratacao"];
    }
}

acessaDadosVeiculosGerenciar($connectionDB, $idVeiculoGerenciar);
header('Location: gerenciar.php');
exit();
