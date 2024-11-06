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
$idOficinaLogada = $_SESSION['idOficinaLogada'];

function executeQuery($connectionDB, $query)
{
    $stmt = $connectionDB->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
}

$selectTable = "SELECT * FROM orcamentos_oficinas WHERE orcamento_aprovado_reprovado='Faturada Órgão Público' AND id_oficina='$idOficinaLogada' ORDER BY id_orcamentos_oficinas ASC";

if (isset($_SESSION['filtrosPesquisaAprovadas']) || !empty($_SESSION['filtrosPesquisaAprovadas'])) {
    $selectTable = $_SESSION['filtrosPesquisaAprovadas'];
}

$_SESSION['filtrosPesquisaAprovadas'] = null;

$execConnection = executeQuery($connectionDB, $selectTable);
$numLinhasTotal = $execConnection->num_rows;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Orçamento faturado</h1>
    <?php
    while ($user_data = mysqli_fetch_assoc($execConnection)) {
        echo "num ". $user_data['id_infos_veiculos_inclusos'];
        echo "<br>";
        echo "veiculo ".$user_data['veiculo'];
        echo "<br>";
        echo "fornecedor ".$user_data['fornecedor'];
        echo "<br>";
        echo "estado orcamento". $user_data['orcamento_aprovada_reprovada_oficina'];
        echo "<br>";
    }
    ?>

</body>

</html>