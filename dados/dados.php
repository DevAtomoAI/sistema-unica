<?php
session_start();
include_once("../database/config.php");
function checkUserLoggedIn()
{
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: ../index.php');
        exit;
    }
}
checkUserLoggedIn();

$nomeUsuario = $_SESSION["nameLoggedUser"];
$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];
$idVeiculosInclusosOrgaoPublico = $_SESSION['idVeiculosInclusosOrgaoPublico'];

$selectTable = "SELECT * FROM usuarios_orgao_publico WHERE nome='$nomeUsuario' AND id_usuarios_orgao_publico='$idOrgaoPublicoLogado'";
$execConnection = $conexao->query($selectTable);
$user_data = mysqli_fetch_assoc($execConnection);

echo $user_data['email'];

$selectTable3 = "SELECT * FROM infos_veiculos_aprovados_oficina 
                     WHERE orcamento_aprovado_reprovado = '' AND
                     id_veiculo_incluso_orgao_publico = $idVeiculosInclusosOrgaoPublico 
                     AND id_orgao_publico = '$idOrgaoPublicoLogado'";
$numLinhasTotal3 = $conexao->query($selectTable3)->num_rows;

$selectTable4 = "SELECT veiculo FROM infos_veiculos_inclusos 
                WHERE id_orgao_publico = '$idOrgaoPublicoLogado' 
                AND id_infos_veiculos_inclusos = '$idVeiculosInclusosOrgaoPublico'";
$nomeVeiculo = $conexao->query($selectTable4)->fetch_assoc()['veiculo'] ?? '';

$selectTable5 = "SELECT * FROM infos_veiculos_aprovados_oficina 
                 WHERE orcamento_aprovado_reprovado = '' 
                 AND id_orgao_publico = '$idOrgaoPublicoLogado'";
$numLinhasTotal5 = $conexao->query($selectTable5)->num_rows;

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus dados</title>
    <link rel="stylesheet" href="dados.css">
</head>

<body>

    <div class="overlay" id="overlay"></div>


    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
        </div>
        <ul class="nav-options">

            <li>
                <a href="dados.php">
                    <img src="../imgs/dados.svg"> Meus dados
                </a>
            </li>

            <li>
                <a href="../incluir_cotacao/incluir.php">
                    <img src="../imgs/time.svg"> Incluir
                </a>
            </li>
            <li>
                <a href="../cotacoes_andamento/andamento.php">
                    <img src="../imgs/clock.svg"> Em andamento
                </a>
            </li>
            <li>
                <a href="../cotacoes_aprovado/aprovado.php">
                    <img src="../imgs/check.svg"> Aprovado
                </a>
            </li>
            <li>
                <a href="#faturado">
                    <img src="../imgs/paper.svg"> Faturado
                </a>
            </li>
            <li>
                <a href="../cotacoes_rejeitado/rejeitado.php">
                    <img src="../imgs/cancel.svg"> Cancelado
                </a>
            </li>

            <div class="logotype"> <img src="../imgs/biglogo.svg"></div>

        </ul>
    </div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a> <img src="../imgs/menu.svg"> </a>
            </div>
            <div class="logo">
                <img src="../imgs/minilogo.svg">
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
                <img src="../imgs/Doorbell.svg">
            </div>

            <div class="user-name">
                <p><?php echo $nomeUsuario; ?></p>
            </div>

            <div class="user-icon">
                <img src="../imgs/user.svg">
            </div>
        </div>
    </header>
    <br><br><br>
    <!-- Conteudo Principal -->

    <div class="main-content">
        <h1>Meus Dados</h1>

        <h2>Dados do Órgão:</h2>
        <div class="table-responsive">
            <table id="tabela-orgao">
                <tr>
                    <th>Nº do Contrato</th>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Responsável</th>
                    <th>Contato</th>
                    <th>E-mail</th>
                </tr>
                <tr>
                    <td><input type="text" id="contrato_orgao"></td>
                    <td><input type="text" id="razao_social"></td>
                    <td><input type="text" id="cnpj"></td>
                    <td><input type="text" id="responsavel"></td>
                    <td><input type="text" id="contato"></td>
                    <td><input type="email" id="email"></td>
                </tr>
            </table>
            <button class="button" onclick="salvarDadosOrgao()">Enviar Dados do Órgão</button>
        </div>

        <h2>Dados dos Centros de Custo:</h2>
        <div class="table-responsive">
            <table id="tabela-centro">
                <tr>
                    <th>Nome</th>
                    <th>Valor do Contrato</th>
                    <th>Fonte de Recurso</th>
                    <th>Data do Crédito</th>
                    <th>Nº Ordem Bancária</th>
                    <th>Valor do Crédito</th>
                </tr>
                <tr>
                    <td><input type="text" id="nome_centro"></td>
                    <td><input type="text" id="valor_contrato"></td>
                    <td><input type="text" id="fonte_recurso"></td>
                    <td><input type="date" id="data_credito"></td>
                    <td><input type="text" id="ordem_bancaria"></td>
                    <td><input type="text" id="valor_credito"></td>
                </tr>
            </table>
            <button class="button" onclick="salvarDadosOrgao()">Enviar Dados do Centro de Custo</button>
        </div>

    </div>
    <script src="dados.js"></script>
</body>

</html>