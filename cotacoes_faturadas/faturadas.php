<?php
session_start();
include_once('../database/config.php');

function checkUserLoggedIn()
{
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: ../index.php');
        exit;
    }
}
checkUserLoggedIn();
$nameUser = $_SESSION['nameLoggedUser'];

function executeQuery($connectionDB, $query)
{
    $stmt = $connectionDB->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
}

$selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE orcamento_aprovada_reprovada_oficina='Aprovada' ORDER BY id_infos_veiculos_inclusos ASC";

if (isset($_SESSION['filtrosPesquisaAprovadas']) || !empty($_SESSION['filtrosPesquisaAprovadas'])) {
    $selectTable = $_SESSION['filtrosPesquisaAprovadas'];
}

$_SESSION['filtrosPesquisaAprovadas'] = null;

$execConnection = executeQuery($connectionDB, $selectTable);
$numLinhasTotal = $execConnection->num_rows;
$execCentroCusto = executeQuery($connectionDB, $selectTable);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>